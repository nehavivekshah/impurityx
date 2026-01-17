<?php $page_title = $page; ?>

<?php $__env->startSection('title', ucfirst($page_title).'- Impurity X'); ?>
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
    <div class="text header-text">Management Panel <span>Total Member: <b><?php echo e(count($users)); ?></b></span></div>
    <div class="scrum-board-container">
        <div class="board-title">
            <h1><?php echo e($page_title); ?></h1>
            <?php if($page!='all users'): ?>
            <?php if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('1', $actions))): ?>
            <!--<a href="manage-user?dir=<?php echo e($page[1]); ?>" class="btn btn-primary">Add New</a>-->
            <?php endif; ?>
            <?php if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('3', $actions))): ?>
            <form method="POST" action="/admin/<?php echo e($page); ?>/exportUser" class="row m-none">
                <?php echo csrf_field(); ?>
                <div class="d-flex g-1">
                    <input type="date" name="from_date" class="form-control me-2" required>
                    <input type="date" name="to_date" class="form-control me-2" required>
                    <button type="submit" class="btn btn-success bg-success text-white me-2">Export</button>
                </div>
            </form>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="flex">
            <div class="col-md-12 rounded p-3 bg-white">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile No.</th>
                            <th>Email Id</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo $k+1; ?></td>
                            <td><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></td>
                            <td><?php echo e($user->mob); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <?php if($user->role=='1'): ?>
                                <span class="fw-bold text-primary">Admin</span>
                                <?php elseif($user->role=='2'): ?>
                                <span class="fw-bold text-danger">Manager</span>
                                <?php elseif($user->role=='3'): ?>
                                <span class="fw-bold text-info">Agent</span>
                                <?php elseif($user->role=='4'): ?>
                                <span class="fw-bold text-success">Seller</span>
                                <?php else: ?>
                                <span class="fw-bold text-secondary">Buyer</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($user->status=='1'): ?>
                                <a href="javascript:void(0)" class="notify alert-success status" id="<?php echo e($user->id); ?>" data-status="2" data-page="userStatus">Active</a>
                                <?php else: ?>
                                <a href="javascript:void(0)" class="notify alert-danger status" id="<?php echo e($user->id); ?>" data-status="1" data-page="userStatus">Deactive</a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(date_format(date_create($user->updated_at), 'd M, Y')); ?></td>
                            <td><?php echo e(date_format(date_create($user->created_at), 'd M, Y')); ?></td>
                            <td width="120px">
                                <?php if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('0', $actions))): ?>
                                <a href="javascript:void(0)" class="notify alert-info view" id="<?php echo e($user->id); ?>" data-page="User" title="View Details"><i class="bx bx-show"></i></a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('2', $actions))): ?>
                                <a href="manage-user?id=<?php echo e($user->id); ?>" class="notify alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role == '1' || (in_array('2', $access) && in_array('4', $actions))): ?>
                                <a href="javascript:void(0)" class="notify alert-danger delete" id="<?php echo e($user->id); ?>" data-page="delUserStatus" title="Delete"><i class="bx bx-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile No.</th>
                            <th>Email Id</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Date</th>
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
<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/users.blade.php ENDPATH**/ ?>