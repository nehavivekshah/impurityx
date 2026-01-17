<?php $__env->startSection('title','Products - Impurity X'); ?>
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
    <div class="text header-text">Management Panel <span>Total Products: <b><?php echo e(count($products)); ?></b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Products</h1>
            <div>
                <?php if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('3', $actions))): ?>
                <a href="/admin/products/export" class="btn btn-success bg-success text-white me-2">Export</a>
                <?php endif; ?>
                <?php if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('1', $actions))): ?>
                <a href="/admin/manage-product" class="btn btn-primary">Add New</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <?php if(Auth::user()->role=='0'): ?>
                            <th>Branch</th>
                            <?php endif; ?>
                            <th>Title</th>
                            <th>SKU</th>
                            <th>CAS No</th>
                            <th>UoM</th>
                            <th>HSN</th>
                            <th>GST</th>
                            <th>Featured</th>
                            <th>New</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <?php if(Auth::user()->role=='0'): ?>
                            <td><?php echo e($product->branch); ?></td>
                            <?php endif; ?>
                            <td><?php echo e($product->name); ?></td>
                            <td><?php echo e($product->sku); ?></td>
                            <td><?php echo e($product->cas_no); ?></td>
                            <td><?php echo e($product->uom); ?></td>
                            <td><?php echo e($product->hsn_code); ?></td>
                            <td><?php echo e($product->gst); ?>%</td>
                            <td><?php echo e($product->featured == 1 ? 'Yes' : 'No'); ?></td>
                            <td><?php echo e($product->new == 1 ? 'Yes' : 'No'); ?></td>
                            <td>
                                <?php if($product->status=='1'): ?>
                                <a href="javascript:void(0)" class="notify alert-success status" id="<?php echo e($product->id); ?>" data-status="2" data-page="productStatus">Active</a>
                                <?php else: ?>
                                <a href="javascript:void(0)" class="notify alert-danger status" id="<?php echo e($product->id); ?>" data-status="1" data-page="productStatus">Inactive</a>
                                <?php endif; ?>
                            </td>
                            <td><img src="<?php echo e(asset('public/assets/frontend/img/products/'.$product->img)); ?>" class="input-img rounded" height="50" /></td>
                            <td><?php echo date_format(date_create($product->updated_at),'d M, Y h:i A'); ?></td>
                            <td style="width:80px;">
                                <?php if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('2', $actions))): ?>
                                <a href="/admin/manage-product?id=<?php echo e($product->id); ?>" class="notify-btn alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('4', $actions))): ?>
                                <a href="javascript:void(0)"  class="notify-btn alert-danger delete" id="<?php echo e($product->id); ?>" data-page="productDelete" title="Delete"><i class="bx bx-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr No.</th>
                            <?php if(Auth::user()->role=='0'): ?>
                            <th>Branch</th>
                            <?php endif; ?>
                            <th>Title</th>
                            <th>SKU</th>
                            <th>CAS No</th>
                            <th>UoM</th>
                            <th>HSN</th>
                            <th>GST</th>
                            <th>Featured</th>
                            <th>New</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
<section class="modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></span></div>
        </div>
        <div class="content"></div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footlink'); ?>
<script src="<?php echo e(asset('/assets/backend/js/script.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#example');
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/products.blade.php ENDPATH**/ ?>