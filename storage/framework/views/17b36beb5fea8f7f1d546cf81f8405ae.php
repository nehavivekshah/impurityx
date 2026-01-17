<style>
    @media (max-width: 768px) {
        .w-45 input {
            width: 50%;
        }
    }
</style>
<div class="dashboard-area box--shadow mt-4 mb-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Left Column -->
            <form action="<?php echo e(url('/seller/my-account/communication-buyers')); ?>" method="POST" class="col-md-5 border rounded <?php if(!request()->has('id')): ?> p-4 <?php else: ?> p-0 <?php endif; ?>">
                <?php echo csrf_field(); ?>
                <?php if(request()->has('id')): ?>
                <div class="card p-0 border-0">
                    <!-- Header -->
                    <div class="card-header bg-light text-dark">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <!-- Center: Communication Info -->
                            <div class="text-left flex-grow-1">
                                <h5 class="mb-1" style="display: inline-flex ; align-items: center; gap: 10px;">
                                    #<?php echo e($getCom?->communication_id); ?>

                                    <span class="badge <?php echo e($getCom->state == 0 ? 'bg-success' : 'bg-danger'); ?>" style="font-size: 13px; padding: 6px 10px; height: 20px; font-weight: 400;display: inline-flex ; align-items: center;">
                                        <?php echo e($getCom->state == 0 ? 'Open' : 'Closed'); ?>

                                    </span>
                                </h5>
                                <small class="text-secondary d-block">
                                    <strong>Order Id:</strong> <?php echo e($getCom?->order_no ?? 'N/A'); ?>

                                    <span class="mx-1">|</span>
                                    <strong>CAS No.:</strong> <?php echo e($getCom?->cas_no ?? 'N/A'); ?>

                                </small>
                            </div>
                            <!-- Right: Status Badge -->
                            <div>
                                <a href="<?php echo e(url('/seller/my-account/communication-buyers')); ?>" class="btn btn-sm btn-dark">
                                    <i class="bx bx-reply"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php $type = explode("-",($getCom?->communication_id ?? '')); ?>
                    <!-- Chat Body -->
                    <div class="card-body" style="background-color: #f4f6f9; max-height: 450px; overflow-y: auto;">
                        <!-- Buyer Message -->
                        <div class="d-flex align-items-start mb-4 animate__animated animate__fadeIn">
                            <div class="me-2">
                                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                    <?php if($type[0] == 'CBS'): ?>
                                    <i class="bx bx-user"></i>
                                    <?php else: ?>
                                    <i class="bx bx-store"></i>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="p-3 rounded-3 shadow-sm" style="background: white; max-width: 70%;">
                                <?php if($type[0] == 'CBS'): ?>
                                <strong class="text-primary"><?php echo e($getCom?->impurity_name ?? 'Me'); ?></strong>
                                <?php else: ?>
                                <strong class="text-primary">Seller - </strong>
                                <?php endif; ?>
                                <p class="mb-1"><?php echo e($getCom?->message); ?></p>
                                <small class="text-muted">
                                    <i class="bx bx-time"></i> <?php echo e($getCom?->created_at?->format('d M Y, h:i A')); ?>

                                </small>
                            </div>
                        </div>
                        <!-- Seller Reply -->
                        <?php if(!empty($getCom?->reply)): ?>
                        <div class="d-flex align-items-start justify-content-end mb-4 animate__animated animate__fadeIn animate__delay-1s">
                            <div class="p-3 rounded-3 shadow-sm text-white" style="background: linear-gradient(135deg, #28a745, #218838); max-width: 70%;">
                                <?php if($type[0] != 'CBS'): ?>
                                <strong><?php echo e($getCom?->impurity_name ?? 'Me'); ?></strong>
                                <?php else: ?>
                                <strong>Seller</strong>
                                <?php endif; ?>
                                <p class="mb-1"><?php echo e($getCom->reply); ?></p>
                                <small class="text-light">
                                    <i class="bx bx-time"></i> <?php echo e($getCom?->updated_at?->format('d M Y, h:i A')); ?>

                                </small>
                            </div>
                            <div class="ms-2">
                                <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                    <?php if($type[0] != 'CBS'): ?>
                                    <i class="bx bx-user"></i>
                                    <?php else: ?>
                                    <i class="bx bx-store"></i>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($getCom->reply)): ?>
                    <!-- Footer -->
                    <div class="card-footer bg-light text-center small text-muted">
                        Last updated: <?php echo e($getCom?->updated_at?->format('d M Y, h:i A')); ?>

                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if(!request()->has('id') || empty($getCom->reply) && ($type[0] == 'CBS')): ?>
                <?php if(empty($getCom->communication_id)): ?>
                <!-- Communication ID -->
                <div class="mb-3">
                    <label for="communicationId" class="fw-bold">Communication ID:</label>
                    <input type="text" class="form-control" name="communicationId"
                        value="<?php echo e($communicationId ?? 'AUTO-GEN'); ?>" readonly>
                </div>
                <!-- Order No -->
                <div class="mb-3">
                    <label for="order_no" class="fw-bold">Order No #:</label>
                    <input type="text" class="form-control" name="orderNo" id="orderNo" />
                </div>
                <!-- CAS No -->
                <div class="mb-3">
                    <label for="cas_no" class="fw-bold">CAS No:</label>
                    <input type="text" class="form-control" name="casNo" id="casNo" readonly>
                </div>
                <!-- Impurity Name -->
                <div class="mb-3">
                    <label for="impurity_name" class="fw-bold">Impurity Name:</label>
                    <input type="text" class="form-control" name="impurityName" id="impurityName" readonly>
                </div>
                <?php endif; ?>
                <!-- Message Box -->
                <div class="mb-3">
                    <?php if(empty($getCom->reply) && !empty($getCom->message)): ?>
                    <label for="message" class="fw-bold">Seller Reply:</label>
                    <input type="hidden" class="form-control" name="orderNo" id="orderNo" value="<?php echo e($getCom?->order_no ?? ''); ?>" />
                    <input type="hidden" name="replyId" value="<?php echo e($_GET['id'] ?? ''); ?>" />
                    <?php else: ?>
                    <label for="message" class="fw-bold">Message:</label>
                    <?php endif; ?>
                    <textarea class="form-control" name="message" id="message" rows="7"
                        placeholder="Type your message here..." required></textarea>
                </div>
                <!-- Action Buttons -->
                <div class="text-end">
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Send</button>
                </div>
                <?php endif; ?>
            </form>
            <!-- Right Column: Table -->
            <div class="col-md-7">
                <div class="col-md-12 px-0 px-md-3 mb-3">
                    <form method="POST" action="/seller/my-account/communication-buyers/export" class="row bg-light border py-3">
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
                            <select name="seller_status" class="form-control">
                                <option value="all">All</option>
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-striped table-hover rounded" id="example" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Communication ID</th>
                            <th>Order No</th>
                            <th>CAS No</th>
                            <th>Impurity Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sr = 1; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $communications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo $sr; $sr++; ?></td>
                            <td><?php echo e($com->communication_id); ?></td>
                            <td><?php echo e($com->order_no); ?></td>
                            <td><?php echo e($com->cas_no); ?></td>
                            <td><?php echo e($com->impurity_name); ?></td>
                            <td>
                                <span class="badge <?php echo e($com->status == 'open' ? 'bg-success' : 'bg-danger'); ?>">
                                    <?php echo e($com->status == 'open' ? 'Open' : 'Closed'); ?>

                                </span>
                            </td>
                            <td><?php echo e($com->created_at); ?></td>
                            <td class="text-center">
                                <a href="<?php echo e(url('/seller/my-account/communication-buyers?id=' . $com->id)); ?>"
                                    class="btn btn-sm btn-info" title="View Details">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">No communications found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('footlink'); ?>
<script>
    new DataTable('#example');
</script>
<?php $__env->stopSection(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/seller/inc/accounts/communication-buyers.blade.php ENDPATH**/ ?>