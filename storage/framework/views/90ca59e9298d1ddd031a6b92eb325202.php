<style>
    @media (max-width: 768px) {
        .w-45 input{ 
            width: 50%;
        }
    }
</style>
<div class="dashboard-area box--shadow">
    <div class="row gy-4 mt-0 mb-4">
        <div class="col-md-12 px-4 mb-3">
            <form method="POST" action="/seller/my-account/my-biddings/export" class="row bg-light border py-3">
                <?php echo csrf_field(); ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col">
                            <h4>Export Data</h4>
                        </div>
                        <div class="col" style="text-align:right;">
                            <button type="submit" class="btn btn-success">Export</button>
                        </div>
                    </div>
                </div>
        
                <div class="mb-3 col-md-7">
                    <label>Date Range</label>
                    <div class="d-flex w-45">
                        <input type="date" name="from_date" class="form-control me-2" required>
                        <input type="date" name="to_date" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-3 col-md-5">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="all">All</option>
                        <option value="pending">In Process</option>
                        <option value="awarded">Awarded</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="col-md-12 px-3 bg-white">
            <table id="example" class="table table-striped border rounded" style="width:100%;font-size: 14px;">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Order ID</th>
                        <th>Product Details</th>
                        <th>Offer Price</th>
                        <th>Delivery Days</th>
                        <th>Temperature</th>
                        <th>Status</th>
                        <th>Offer Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $now = \Carbon\Carbon::now();
                        
                    ?>
                    <?php $__currentLoopData = $biddings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td>
                            <strong><?php echo e(date('y', strtotime($bid->created_at)) . (date('y', strtotime($bid->created_at)) + 1) . '-' . str_pad($bid->order_id, 4, '0', STR_PAD_LEFT)); ?></strong><br>
                            <?php if($bid->status == 'awarded'): ?><?php echo e($bid->buyer_fname . ' ' . $bid->buyer_lname); ?><br>
                            <small><?php echo e($bid->buyer_email); ?></small><?php endif; ?>
                        </td>
                        <td>
                            <?php echo $bid->sku ?? 'N/A'; ?><br>
                            <?php echo e($bid->proName ?? 'N/A'); ?>

                        </td>
                        <td>Rs. <?php echo e($bid->price); ?></td>
                        <td><?php echo e($bid->days); ?> Days</td>
                        <td><?php echo e($bid->temp ?? 'N/A'); ?></td>
                        <td>
                            <?php if($bid->status == 'pending'): ?>
                                <?php if($bid->orderStatus == 'closed'): ?>
                                <span class="badge bg-secondary">Closed</span>
                                <?php elseif($bid->orderStatus == 'cancelled'): ?>
                                <span class="badge bg-secondary">Cancelled</span>
                                <?php else: ?>
                                <span class="badge bg-warning text-dark">In Process</span>
                                <?php endif; ?>
                            <?php elseif($bid->status == 'awarded'): ?>
                                <span class="badge bg-success">Awarded</span>
                            <?php elseif($bid->status == 'cancelled'): ?>
                                <span class="badge bg-secondary">Cancelled</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo e(ucfirst($bid->status)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($bid->created_at)->format('d M, Y H:i')); ?></td>
                        <td>
                            <a href="/seller/product/<?php echo e($bid->slog ?? 'unknown'); ?>/<?php echo e($bid->oid ?? 'Unknown'); ?>" class="btn btn-info btn-sm">
                                <i class="bx bx-show"></i>
                            </a>
                        <!--<a href="javascript:void(0)" class="notify-btn alert-dark edit-bid" data-id="<?php echo e($bid->id); ?>">
                                <i class="bx bx-edit"></i>
                            </a>
                        </td>-->
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Sr No.</th>
                        <th>Order ID</th>
                        <th>Product Details</th>
                        <th>Offer Price</th>
                        <th>Delivery Days</th>
                        <th>Temperature</th>
                        <th>Status</th>
                        <th>Offer Time</th>
                        <th>Action</th>
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
        
    });
</script>

<script>
  document.querySelector('.dismiss').addEventListener('click', function () {
    document.querySelector('.modal').style.display = 'none';
  });
</script>

<?php $__env->stopSection(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/seller/inc/accounts/myBiddings.blade.php ENDPATH**/ ?>