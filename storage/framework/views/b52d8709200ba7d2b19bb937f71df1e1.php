<?php $__env->startSection('title','Orders - Impurity X'); ?>

<?php $__env->startSection('headlink'); ?>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('/assets/backend/css/style.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $settings = session('settings');
    $access = explode(',', $settings[0]->access ?? '');
    $actions = explode(',', $settings[0]->actions ?? '');
?>
<style>
    .cursor-pointer {
      cursor: pointer;
    }
</style>
<section class="task__section">
    <div class="text header-text">Management Panel <span>Total Queries: <b><?php echo e(count($orders)); ?></b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Orders</h1>
            <?php if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('3', $actions))): ?>
            <form method="POST" action="/admin/buyer-orders/export" class="row m-none">
                <?php echo csrf_field(); ?>
                <div class="d-flex g-1">
                    <input type="date" name="from_date" class="form-control me-2" required>
                    <input type="date" name="to_date" class="form-control me-2" required>
                    
                    <select name="with_attachments" class="form-control me-2">
                        <option value="">Include Attachments?</option>
                        <option value="yes">Yes</option>
                        <option value="no" selected>No</option>
                    </select>
                
                    <select name="status" class="form-control me-2">
                        <option value="all">All</option>
                        <option value="pending">Initiate</option>
                        <option value="active">Active</option>
                        <option value="selected">Selected</option>
                        <option value="awarded">Awarded</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="closed">Closed</option>
                    </select>
                    
                    <button type="submit" class="btn btn-success bg-success text-white me-2">Export</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Order ID</th>
                            <th>Buyer Details</th>
                            <th>Product Details</th>
                            <th>Order Details</th>
                            <th>Requirements</th>
                            <!--<th>Attachments</th>-->
                            <th>Auction End</th>
                            <th>Status</th>
                            <th>Seller Status</th>
                            <th>Seller Offer Status</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $now = \Carbon\Carbon::now();
                            
                        ?>
                        
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
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
                            <td><?php echo e($key + 1); ?></td>
                            <td><strong><?php echo e($financialYear . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)); ?></strong></td>
                            <td>
                                <?php echo $order->first_name . ' ' . $order->last_name; ?>

                                <br><small><?php echo e($order->email); ?></small>
                            </td>
                            <td>
                                <?php echo $order->sku ?? 'N/A'; ?><br>
                                <?php echo e($order->name ?? 'N/A'); ?>

                            </td>
                            <td>
                                Qty: <?php echo e($order->quantity); ?> <?php echo e($order->uom); ?><br>
                                Delivery: <?php echo e(\Carbon\Carbon::parse($order->delivery_date)->format('d M, Y')); ?><br>
                                Location: <?php echo e($order->delivery_location); ?>

                            </td>
                            <!--<td><?php echo e($order->specific_requirements ?? 'N/A'); ?></td>-->
                            <td>
                                <?php $attachments = json_decode($order->attachments, true); ?>
                                <?php if(!empty($attachments)): ?>
                                    <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(asset('public/' . $file)); ?>" target="_blank">View</a><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($order->auction_end)->format('d M, Y H:i')); ?></td>
                            <td>
                                <?php if($order->status == 'requested'): ?>
                                    <a href="javascript:void(0)" class="badge bg-light border td-none text-dark">Buyer's Requested</a>
                                <?php elseif($order->status == 'pending'): ?>
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Initiate</a>
                                <?php elseif($order->status == 'active'): ?>
                                    <?php if($order->auction_end > $now): ?>
                                        <a href="javascript:void(0)" class="badge bg-success td-none">Active</a>
                                    <?php else: ?>
                                    
                                        <?php if($order->display_status === 'No Offer Recd'): ?>
                                            <a href="javascript:void(0)" class="badge bg-secondary td-none">No Offer Recd</a>
                                        <?php else: ?>
                                        <a href="javascript:void(0)" class="badge bg-warning text-dark td-none">Pending From Buyer</a>
                                        <?php endif; ?>
                                        
                                    <?php endif; ?>
                                <?php elseif($order->status == 'awarded'): ?>
                                    <a href="javascript:void(0)" class="badge bg-primary td-none">Order Awarded</a>
                                <?php elseif($order->status == 'selected'): ?>
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Pending Confirmation</a>
                                <?php elseif($order->status == 'cancelled' && !empty($order->reject_order)): ?>
                                    <a href="javascript:void(0)" class="badge bg-danger td-none">Rejected From Buyer</a>
                                    <br><small class="text-center"><?php echo e($order->reject_order ?? ''); ?></small>
                                <?php elseif($order->status == 'cancelled'): ?>
                                    <a href="javascript:void(0)" class="badge bg-secondary td-none">Cancelled</a>
                                <?php else: ?>
                                    <a href="javascript:void(0)" class="badge bg-danger td-none">closed</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->seller_status == 'order-initiated'): ?>
                                    <a href="javascript:void(0)" class="badge bg-light border td-none text-dark">Order Initiated</a>
                                <?php elseif($order->seller_status == 'order-task-completed'): ?>
                                    <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Order Task Completed</a>
                                <?php elseif($order->seller_status == 'delivery-initiated'): ?>
                                    <a href="javascript:void(0)" class="badge bg-primary td-none">Delivery Initiated</a>
                                <?php elseif($order->seller_status == 'delivery-completed'): ?>
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Delivery Completed</a>
                                <?php elseif($order->seller_status == 'accepted'): ?>
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Buyer Accepted</a>
                                <?php else: ?>
                                    <a href="javascript:void(0)" class="badge bg-light text-dark text-center td-none">--</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->bid_view_status == '1'): ?>
                                    <a href="javascript:void(0)" id="<?php echo e($order->id); ?>" data-page="orderSellerView" data-status="0" class="notify alert-success status">Active</a>
                                <?php else: ?>
                                    <a href="javascript:void(0)" id="<?php echo e($order->id); ?>" data-page="orderSellerView" data-status="1" class="notify alert-danger status">Inactive</a>
                                <?php endif; ?>
                            </td>
                            <td style="min-width:100px;"><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d M, Y')); ?></td>
                            <td style="min-width:80px;">
                                <?php if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('0', $actions))): ?>
                                <a href="javascript:void(0)" id="<?php echo e($order->id); ?>" class="notify-btn alert-info view" title="View Details" data-page="orders">
                                    <i class="bx bx-show"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('2', $actions))): ?>
                                <a href="javascript:void(0)" class="notify-btn alert-warning edit-auction"
                                   data-id="<?php echo e($order->id); ?>"
                                   data-status="<?php echo e($order->status); ?>"
                                   data-sellerstatus="<?php echo e($order->seller_status); ?>"
                                   data-date="<?php echo e(\Carbon\Carbon::parse($order->auction_end)->format('Y-m-d\TH:i')); ?>" title="Change Status">
                                   <i class="bx bx-cog"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('2', $actions))): ?>
                                <a href="javascript:void(0)" class="notify-btn alert-dark edit-order"
                                   data-id="<?php echo e($order->id); ?>"
                                   data-date="<?php echo e(\Carbon\Carbon::parse($order->auction_end)->format('Y-m-d\TH:i')); ?>" title="Edit Order Details">
                                   <i class="bx bx-edit"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('4', $actions))): ?>
                                <a href="javascript:void(0)" class="notify alert-danger delete mt-1" id="<?php echo e($order->id); ?>" data-page="delOrderStatus" title="Delete"><i class="bx bx-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr No.</th>
                            <th>Order ID</th>
                            <th>Buyer Details</th>
                            <th>Product Details</th>
                            <th>Order Details</th>
                            <th>Requirements</th>
                            <!--<th>Attachments</th>-->
                            <th>Auction End</th>
                            <th>Status</th>
                            <th>Seller Status</th>
                            <th>Seller Offer Status</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

<section class="editAuctionModal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">Edit Auction End Date/Time</div>
            <div class="dismiss"><span class="bx bx-window-close close-edit-modal"></span></div>
        </div>
        <div class="editContent p-3">
            <form id="editAuctionForm" method="POST" action="/admin/update-auction-end">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="order_id" id="edit-order-id">
                <div class="mb-3">
                    <label for="auction_end">Auction End</label>
                    <input type="datetime-local" class="form-control" name="auction_end" id="auction-end-input" min="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d\TH:i')); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="auction_end">Order Status</label>
                    <select name="status" id="edit-status" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <!--<option value="selected">Selected</option>-->
                        <option value="awarded">Awarded</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="editOrderModal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">Edit Order Details</div>
            <div class="dismiss"><span class="bx bx-window-close close-edit-order"></span></div>
        </div>
        <div class="editContent p-3">
            <form id="editOrderForm" method="POST" action="/admin/update-order-details" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="order_id" id="edit-orderid">
                
                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="edit-quantity" min="1" required>
                </div>

                <div class="mb-3">
                    <label>Delivery Date</label>
                    <input type="date" class="form-control" name="delivery_date" id="edit-delivery-date" required>
                </div>

                <div class="mb-3">
                    <label>Delivery Location</label>
                    <input type="text" class="form-control" name="delivery_location" id="edit-delivery-location" required>
                </div>

                <div class="mb-3">
                    <label>Specific Requirements</label>
                    <textarea class="form-control" name="specific_requirements" id="edit-specific-req" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label>Attachments (optional)</label>
                    <input type="file" name="attachments[]" multiple class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></div>
        </div>
        <div class="content"></div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footlink'); ?>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    
    new DataTable('#example');
    
    $(document).ready(function(){
            
        // Open edit modal
        $(document).on('click', '.edit-auction', function () {
            let currentStatus = $(this).data('status');
            let currentsellerStatus = $(this).data('sellerstatus');
    
            $('#edit-order-id').val($(this).data('id'));
            $('#auction-end-input').val($(this).data('date'));
            $('#edit-status').val(currentStatus);
    
            // =============================
            // Keep your existing disable rules
            // =============================
            let disabledStatuses = ["selected", "awarded", "cancelled"];
            let disabledStatuses1 = ["awarded", "cancelled"];
            let disabledSellerStatuses = ["accepted"];
            
            if (disabledStatuses.includes(currentStatus)) {
                $('#auction-end-input').prop("readonly", true);
                
                if (disabledStatuses1.includes(currentStatus) 
                    && !disabledSellerStatuses.includes(currentsellerStatus)) {
                    $('#updateBtn').prop("disabled", true);
                }
            } else {
                $('#auction-end-input').prop("readonly", false);
                $('#updateBtn').prop("disabled", false);
            }
    
            // =============================
            // New rule for dropdown options
            // =============================
            $('#edit-status option').prop('disabled', false); // reset all
    
            if (currentStatus === "active") {
                $('#edit-status option[value="awarded"]').prop('disabled', true);
                $('#edit-status option[value="closed"]').prop('disabled', true);
            }
    
            if (currentStatus === "selected") {
                $('#edit-status option[value="pending"]').prop('disabled', true);
                $('#edit-status option[value="active"]').prop('disabled', true);
                $('#edit-status option[value="close"]').prop('disabled', true);
            }
    
            if (currentsellerStatus === "accepted") {
                $('#edit-status option[value="pending"]').prop('disabled', true);
                $('#edit-status option[value="active"]').prop('disabled', true);
                $('#edit-status option[value="awarded"]').prop('disabled', true);
                $('#edit-status option[value="cancelled"]').prop('disabled', true);
            }
    
            // Refresh if using bootstrap-select
            if ($.fn.selectpicker) {
                $('#edit-status').selectpicker('refresh');
            }
    
            $('.editAuctionModal').attr("style","display:flex;width:100%;height:100vh;");
        });
    
        $('.close-edit-modal').on('click', function () {
            $('.editAuctionModal').removeAttr("style");
        });
        
    });
    
    $(document).ready(function () {
    
        // Open "Edit Order Details" Modal
        $(document).on('click', '.edit-order', function () {
            const id = $(this).data('id');
    
            // Fetch order details via AJAX
            $.ajax({
                url: '/admin/get-order-edit-details/' + id,
                method: 'GET',
                success: function (response) {
                    if (response.success) {
                        let order = response.data;
                        $('#edit-orderid').val(order.id);
                        $('#edit-quantity').val(order.quantity);
                        $('#edit-delivery-date').val(order.delivery_date);
                        $('#edit-delivery-location').val(order.delivery_location);
                        $('.note-editable').html(order.specific_requirements ?? '');
    
                        $('.editOrderModal').attr("style","display:flex;width:100%;height:100vh;");
                    } else {
                        alert('Failed to fetch order details.');
                    }
                },
                error: function () {
                    alert('Error fetching order details.');
                }
            });
        });
    
        // Close modal
        $('.close-edit-order').on('click', function () {
            $('.editOrderModal').removeAttr("style");
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    
<script type="text/javascript">
    $(document).ready(function () {
        $('#edit-specific-req').summernote({
            height: 300,
        });
    });
</script>

<script src="<?php echo e(asset('/assets/backend/js/script.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/orders.blade.php ENDPATH**/ ?>