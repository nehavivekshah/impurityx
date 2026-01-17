<?php $__env->startSection('title','Biddings - Impurity X'); ?>

<?php $__env->startSection('headlink'); ?>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('/assets/backend/css/style.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $settings = session('settings');
    $access = explode(',', $settings[0]->access ?? '');
    $actions = explode(',', $settings[0]->actions ?? '');
?>
<section class="task__section">
    <div class="text header-text">Management Panel <span>Total Biddings: <b><?php echo e(count($biddings)); ?></b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Biddings</h1>
            <?php if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('3', $actions))): ?>
            <form method="POST" action="/admin/seller-biddings/export" class="row m-none">
                <?php echo csrf_field(); ?>
                <div class="d-flex g-1">
                    <input type="date" name="from_date" class="form-control me-2" required>
                    <input type="date" name="to_date" class="form-control me-2" required>
                    
                    <!--<select name="with_attachments" class="form-control me-2">
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
                    </select>-->
                    
                    <button type="submit" class="btn btn-success bg-success text-white me-2">Export</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="biddingTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Order ID</th>
                            <th>Product Details</th>
                            <th>Seller Details</th>
                            <th>Bid Price</th>
                            <th>Delivery Days</th>
                            <th>Temperature</th>
                            <th>Status</th>
                            <th>Bid Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $biddings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        
                            $month = date('m', strtotime($bid->created_at));
                            $year = date('Y', strtotime($bid->created_at));
                            
                            if ($month >= 3) {
                                // March to Dec
                                $fy_start = date('y', strtotime($bid->created_at));
                                $fy_end = date('y', strtotime('+1 year', strtotime($bid->created_at)));
                            } else {
                                // Jan-Feb
                                $fy_start = date('y', strtotime('-1 year', strtotime($bid->created_at)));
                                $fy_end = date('y', strtotime($bid->created_at));
                            }
                            
                            $financialYear = $fy_start . '' . $fy_end;
                        
                        ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td>
                                <strong><?php echo e($financialYear . '-' . str_pad($bid->order_id, 4, '0', STR_PAD_LEFT)); ?></strong><br>
                                <?php echo e($bid->buyer_fname . ' ' . $bid->buyer_lname); ?><br>
                                <small><?php echo e($bid->buyer_email); ?></small>
                            </td>
                            <td>
                                <?php echo $bid->sku ?? 'N/A'; ?><br>
                                <?php echo e($bid->proName ?? 'N/A'); ?>

                            </td>
                            <td>
                                <?php echo e($bid->seller_fname . ' ' . $bid->seller_lname); ?><br>
                                <small><?php echo e($bid->seller_email); ?></small>
                            </td>
                            <td>Rs. <?php echo e($bid->price); ?></td>
                            <td><?php echo e($bid->days); ?> Days</td>
                            <td><?php echo e($bid->temp ?? 'N/A'); ?></td>
                            <td>
                                <?php if($bid->status == 'pending'): ?>
                                    <span class="badge bg-secondary">In Process</span>
                                <?php elseif($bid->status == 'awarded'): ?>
                                    <span class="badge bg-success">Awarded</span>
                                <?php elseif($bid->status == 'cancelled'): ?>
                                    <span class="badge bg-danger">Cancelled</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?php echo e(ucfirst($bid->status)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($bid->created_at)->format('d M, Y H:i')); ?></td>
                            <td>
                                <!--<a href="javascript:void(0)" class="notify-btn alert-dark edit-bid" data-id="<?php echo e($bid->id); ?>">
                                    <i class="bx bx-edit"></i>
                                </a>-->
                                <?php if(Auth::user()->role == '1' || (in_array('4', $access) && in_array('4', $actions))): ?>
                                <a href="javascript:void(0)" class="notify alert-danger delete" id="<?php echo e($bid->id); ?>" data-page="delBidStatus" title="Delete" <?php if($bid->status == 'awarded'): ?> style="pointer-events:none;cursor:default;opacity:.5;" <?php endif; ?>><i class="bx bx-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr No.</th>
                            <th>Order ID</th>
                            <th>Product Details</th>
                            <th>Seller Details</th>
                            <th>Bid Price</th>
                            <th>Delivery Days</th>
                            <th>Temperature</th>
                            <th>Status</th>
                            <th>Bid Time</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

<section class="modal bid-view-modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Bidding Details</div>
            <div class="dismiss"><span class="bx bx-window-close close-bid-modal"></span></div>
        </div>
        <div class="content"></div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footlink'); ?>
<script src="<?php echo e(asset('/assets/backend/js/script.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#biddingTable');

    $(document).on('click', '.view-bid', function () {
        const bidId = $(this).data('id');
        $.ajax({
            url: '/admin/view-bid',
            type: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                bid_id: bidId
            },
            success: function (response) {
                $('.bid-view-modal .content').html(response);
                $('.bid-view-modal').css('display', 'flex');
            }
        });
    });

    $('.close-bid-modal').on('click', function () {
        $('.bid-view-modal').hide();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/biddings.blade.php ENDPATH**/ ?>