<?php $__env->startSection('title','Notices - Impurity X'); ?>
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
    <div class="text header-text">Management Panel</div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1>Notices</h1>
            <?php if(Auth::user()->role == '1' || (in_array('5', $access) && in_array('1', $actions))): ?>
            <a href="/admin/manage-notice" class="btn btn-primary">Create New</a>
            <?php endif; ?>
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="noticesTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Notice ID</th>
                            <th>Message</th>
                            <th>Type</th>
                            <!--<th>Status</th>-->
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($notice->id); ?></td>
                                <td><?php echo e($notice->notice_id); ?></td>
                                <td><?php echo e(strlen($notice->message) > 150 ? substr($notice->message, 0, 150) . '...' : $notice->message); ?></td>
                                <td>
                                    <span class="badge <?php echo e($notice->type == 'buyers' ? 'bg-success' : 'bg-primary'); ?> d-flex justify-content-center align-items-center">
                                        <?php echo e($notice->type == 'buyers' ? 'Buyers' : 'Sellers'); ?>

                                    </span>

                                </td>
                                <!--<td>-->
                                <!--    <span class="badge <?php echo e($notice->status == 'active' ? 'bg-success' : 'bg-danger'); ?>">-->
                                <!--        <?php echo e($notice->status == 'active' ? 'Active' : 'Inactive'); ?>-->
                                <!--    </span>-->
                                <!--</td>-->
                                <td><?php echo date_format(date_create($notice->created_at ?? null),'d M, Y'); ?></td>
                                <td class="text-center">
                                    <?php if(Auth::user()->role == '1' || (in_array('5', $access) && in_array('0', $actions))): ?>
                                    <a href="javascript:void(0)" class="notify-btn alert-info view" id="<?php echo e($notice->id); ?>" data-page="noticeview" title="View Details">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <?php endif; ?>
                                    <!--<a href="javascript:void(0)" class="notify-btn alert-primary view" id="<?php echo e($notice->id); ?>" data-page="noticeedit" title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </a>-->
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No notices found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Notice ID</th>
                            <th>Message</th>
                            <th>Type</th>
                            <!--<th>Status</th>-->
                            <th>Created At</th>
                            <th class="text-center">Action</th>
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
            <div class="poptitle">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></span></div>
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
    new DataTable('#noticesTable');
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/notices.blade.php ENDPATH**/ ?>