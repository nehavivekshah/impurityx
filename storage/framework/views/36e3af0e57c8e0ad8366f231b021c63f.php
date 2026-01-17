<?php $__env->startSection('title','Posts - Impurity X'); ?>
<?php $__env->startSection('headlink'); ?>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Link Styles -->
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
    <div class="text header-text">Management Panel <span>Total Posts: <b><?php echo e(count($posts)); ?></b></span></div>
    <!-- Page Header -->
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>All Posts</h1>
            <?php if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('1', $actions))): ?>
            <a href="/admin/manage-post" class="btn btn-primary">Add New</a>
            <?php endif; ?>
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Photo</th>
                            <th>Created On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td><?php echo e($post->title); ?></td>
                            <td><?php echo e($post->catetitle); ?></td>
                            <td><img src="<?php echo e(asset('/public/assets/frontend/img/posts/'.$post->imgs)); ?>" class="input-img rounded" /></td>
                            <td><?php echo e(date_format(date_create($post->created_at), 'd M, Y')); ?></td>
                            <td>
                                <?php if($post->status=='1'): ?>
                                <a href="javascript:void(0)" class="notify alert-success status" id="<?php echo e($post->id); ?>" data-status="2" data-page="postStatus">Active</a>
                                <?php else: ?>
                                <a href="javascript:void(0)" class="notify alert-danger status" id="<?php echo e($post->id); ?>" data-status="1" data-page="postStatus">Deactive</a>
                                <?php endif; ?>
                            </td>
                            <td style="width:120px;">
                                <?php if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('0', $actions))): ?>
                                <a href="/blog/<?php echo e($post->category ?? ''); ?>/<?php echo e($post->slog ?? ''); ?>" class="notify-btn alert-primary" title="view" target="_blank"><i class="bx bx-show"></i></a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('2', $actions))): ?>
                                <a href="/admin/manage-post?id=<?php echo e($post->id); ?>" class="notify-btn alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('4', $actions))): ?>
                                <a href="javascript:void(0)"  class="notify-btn alert-danger delete" id="<?php echo e($post->id); ?>" data-page="delpostStatus" title="Delete"><i class="bx bx-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sr No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Photo</th>
                            <th>Created On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            <div>
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
<!-- Scripts -->
<script src="<?php echo e(asset('/assets/backend/js/script.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    new DataTable('#example');
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/posts.blade.php ENDPATH**/ ?>