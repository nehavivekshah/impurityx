<style>
    @media(max-width: 767px){
       .form-control{
        padding: .375rem 3px;
    }
    }
</style>
<div class="dashboard-area box--shadow">
    <div class="row gy-4 mt-0 mb-4">
        
        <div class="col-md-12 px-4">
            <form method="POST" action="/my-account/my-orders/export" class="row bg-light border py-3">
                <?php echo csrf_field(); ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col">
                            <h4>Export Orders</h4>
                        </div>
                        <div class="col" style="text-align:right;">
                            <button type="submit" class="btn btn-success">Export</button>
                        </div>
                    </div>
                </div>
        
                <div class="mb-3 col-md-4">
                    <label>Date Range</label>
                    <div class="d-flex">
                        <input type="date" name="from_date" class="form-control me-2" required>
                        <input type="date" name="to_date" class="form-control" required>
                    </div>
                </div>
        
                <div class="mb-3 col-md-4">
                    <label>Include Attachments?</label>
                    <select name="with_attachments" class="form-control">
                        <option value="yes">Yes</option>
                        <option value="no" selected>No</option>
                    </select>
                </div>
                
                <div class="mb-3 col-md-4">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="all">All</option>
                        <option value="pending">Initiate</option>
                        <option value="active">Active</option>
                        <option value="selected">Selected</option>
                        <option value="awarded">Awarded</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </form>
        </div>
        
        <div class="col-md-12 px-3 bg-white">
            <table id="example" class="table table-striped border rounded" style="width:100%;font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center" style="min-width:50px!important;">#</th>
                        <th style="min-width:70px!important;">OrderID</th>
                        <th style="min-width:170px!important;">Product Details</th>
                        <th style="min-width:170px!important;">Order Details</th>
                        <!--<th>Requirements</th>-->
                        <th class="text-center">Attachments</th>
                        <th class="text-center" style="min-width:70px!important;">L1 Rate</th>
                        <th class="text-center" style="min-width:120px!important;">Award Date</th>
                        <th class="text-center" style="min-width:120px!important;">Offer End by</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="min-width:120px!important;">Created On</th>
                        <th class="text-center sticky-column" style="min-width:90px!important;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $now = \Carbon\Carbon::now();
                        
                    ?>
                    <?php $__currentLoopData = $myorders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php
                    
                    $month = date('m', strtotime($order->created_at));
                    $year = date('Y', strtotime($order->created_at));
                    
                    if ($month >= 3) {
                        // March to Dec
                        $fy_start = date('y', strtotime($order->created_at));
                        $fy_end = date('y', strtotime('+1 year', strtotime($order->created_at)));
                    } else {
                        // Jan-Feb
                        $fy_start = date('y', strtotime('-1 year', strtotime($order->created_at)));
                        $fy_end = date('y', strtotime($order->created_at));
                    }
                    
                    $financialYear = $fy_start . '' . $fy_end;
                    
                    ?>
                    <tr>
                        <td class="text-center" style="min-width:50px!important;"><?php echo e($key + 1); ?></td>
                        <td style="min-width:70px!important;"><strong><?php echo e($financialYear . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)); ?></strong></td>
                        <td style="min-width:170px!important;">
                            <?php echo $order->sku ?? ''; ?><br>
                            <?php echo e($order->name ?? ''); ?><br>
                            <b>CAS No.:</b> <?php echo e($order->cas_no ?? ''); ?>

                        </td>
                        <td style="min-width:170px!important;">
                            Qty: <?php echo e($order->quantity); ?> <?php echo e($order->uom); ?><br>
                            Delivery: <?php echo e(\Carbon\Carbon::parse($order->delivery_date)->format('d M, Y')); ?>

                        </td>
                        <!--<td><?php echo e($order->specific_requirements ?? 'N/A'); ?></td>-->
                        <td class="text-center">
                            <?php $attachments = json_decode($order->attachments, true); ?>
                            <?php if(!empty($attachments)): ?>
                                <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(asset('public/' . $file)); ?>" class="btn btn-primary btn-sm" target="_blank" style="font-size:12px;font-weight:600;">View</a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td class="text-center" style="min-width:70px!important;"><?php if(!empty($order->l1_rate) && ($order->l1_rate > 0)): ?> Rs. <?php echo e($order->l1_rate); ?> <?php else: ?> -- <?php endif; ?></td>
                        <td class="text-center" style="min-width:120px!important;"><?php if($order->status == 'awarded'): ?><?php echo e(\Carbon\Carbon::parse($order->awarded_date)->format('d M, Y')); ?><?php endif; ?></td>
                        <td class="text-center" style="min-width:120px!important;"><?php if(!empty($order->auction_end)): ?> <?php echo e(\Carbon\Carbon::parse($order->auction_end)->format('d M, Y H:i')); ?> <?php else: ?> -- <?php endif; ?></td>
                        <td class="text-center">
                            <?php if($order->status == 'pending'): ?>
                                <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Initiate</a>
                            <?php elseif($order->status == 'active'): ?>
                                <?php if($order->auction_end > $now): ?>
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Active</a>
                                <?php else: ?>
                                
                                    <?php if($order->display_status === 'No Offer Recd'): ?>
                                        <a href="javascript:void(0)" class="badge bg-secondary td-none">No Offer Recd</a>
                                    <?php else: ?>
                                    <a href="javascript:void(0)" class="badge bg-warning text-dark td-none">Select Offer</a>
                                    <?php endif; ?>
                                    
                                <?php endif; ?>
                            <?php elseif($order->status == 'awarded'): ?>
                                <a href="javascript:void(0)" class="badge bg-primary td-none">Order Awarded</a>
                            <?php elseif($order->status == 'selected'): ?>
                                <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Admin to confirm</a>
                            <?php elseif($order->status == 'requested'): ?>
                                <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Requested</a>
                            <?php elseif($order->status == 'cancelled'): ?>
                                <?php if(!empty($order->reject_order)): ?>
                                <a href="javascript:void(0)" class="badge bg-danger td-none">Rejected</a>
                                <br><span class="small mt-1"><?php echo e($order->reject_order ?? ''); ?></span>
                                <?php else: ?>
                                <a href="javascript:void(0)" class="badge bg-danger td-none">Cancelled</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="badge bg-danger td-none">closed</a>
                            <?php endif; ?>
                        </td>
                        <td class="text-center" style="min-width:120px!important;"><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d M, Y')); ?></td>
                        <td class="text-center sticky-column" style="min-width:90px!important;">
                            <a href="javascript:void(0)" id="<?php echo e($order->id); ?>" class="btn btn-sm btn-info view" title="View Order Details" data-page="orders">
                                <i class="bx bx-show"></i>
                            </a>
                            
                            <?php if(empty($order->reject_order)): ?>
                            <a href="javascript:void(0)" id="<?php echo e($order->id); ?>" class="btn btn-sm btn-warning view" title="View Bidding Details" data-page="bids">
                                <i class="fas fa-gavel fa-flip-horizontal"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if($order->status == 'active' && $order->auction_end < $now): ?>
                            <a href="javascript:void(0)" 
                               id="<?php echo e($order->id); ?>" 
                               class="btn btn-sm btn-danger reject" 
                               title="Reject Order" 
                               data-page="reject_order">
                                <i class="fas fa-times-circle"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if($order->status == 'closed'): ?>
                            <a href="/product/<?php echo e($order->slog ?? ''); ?>" class="btn btn-sm btn-primary" title="Re-Order">
                                <i class="bx bx-repeat"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" style="min-width:50px!important;">#</th>
                        <th style="min-width:70px!important;">OrderID</th>
                        <th style="min-width:170px!important;">Product Details</th>
                        <th style="min-width:170px!important;">Order Details</th>
                        <!--<th>Requirements</th>-->
                        <th class="text-center">Attachments</th>
                        <th class="text-center" style="min-width:70px!important;">L1 Rate</th>
                        <th class="text-center" style="min-width:120px!important;">Award Date</th>
                        <th class="text-center" style="min-width:120px!important;">Offer End by</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="min-width:120px!important;">Created On</th>
                        <th class="text-center sticky-column" style="min-width:90px!important;">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<section class="modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></div>
        </div>
        <div class="content"></div>
    </div>
</section>

<?php $__env->startSection('footlink'); ?>

<script>
    
    new DataTable('#example');
    
</script>

<script>
    
    $(document).ready(function(){
        
        $('.view').click(function(){
            var selector = $(this);
            var selectorId = selector.attr("id");
            var pagename = selector.attr("data-page");
            $('.content').html("<div class='spinner'><p style='text-align: center; margin: 35px; font-size: 14px; font-weight: 500; opacity: 0.9;'>Loading...</p></div>");
            $.ajax({
                type: 'get',
                url: "/dbaction",
                data: {selectorId:selectorId,pagename:pagename},
                
                beforeSend: function(){
                    $('.modal').attr("style","display:flex;width:100%;height:100vh;");
                },
                success: function(response){
                    $('.content').html(response);
                    //alert(response);
                    console.log(response);
                },
                complete: function(response){
                    //alert(response);
                    //console.log(response);
                }
            });
        });
        
        $('.reject').click(function(){
            var selector = $(this);
            var rowid = selector.attr("id");
            var pagename = selector.attr("data-page");
        
            // Check if buyer really wants to reject
            var confirmReject = confirm("Are you sure you want to reject this order?");
            if(confirmReject){
                // Ask for reason
                var reason = prompt("Please enter the reason for rejecting this order:");
                
                if(reason !== null && reason.trim() !== ""){
                    $.ajax({
                        type: 'get',
                        url: "/dbaction",
                        data: {
                            //_token: $('meta[name="csrf-token"]').attr('content'),
                            selectorId: rowid,
                            pagename: pagename,
                            reason: reason
                        },
                        success: function(response){
                            console.log(response);
                            if(response.status === 'success'){
                                alert(response.message);
                                // Optionally hide reject button
                                selector.hide();
                            } else {
                                alert("Error: " + response.message);
                            }
                        },
                        error: function(){
                            alert("Something went wrong!");
                        }
                    });
                } else if(reason !== null) {
                    alert("You must provide a reason to reject the order!");
                }
            } else {
                alert("Order rejection cancelled.");
            }
        });
        
    });
</script>

<script>
  document.querySelector('.dismiss').addEventListener('click', function () {
    document.querySelector('.modal').style.display = 'none';
  });
</script>

<?php $__env->stopSection(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/inc/accounts/myOrders.blade.php ENDPATH**/ ?>