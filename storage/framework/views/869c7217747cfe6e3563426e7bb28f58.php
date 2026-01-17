<style>
    @media (max-width: 768px) {
        .w-45 input{ 
            width: 50%;
        }
    }
</style>
<div class="dashboard-area box--shadow mt-0 mt-md-5">
    <div class="container-fluid">
        <div class="row">
            <form action="/seller/my-account/supports" method="POST" class="col-md-5 border rounded <?php if(!request()->has('id')): ?> p-4 <?php else: ?> p-0 <?php endif; ?>">
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
                                        <span class="badge <?php echo e($getCom->status == 0 ? 'bg-success' : 'bg-danger'); ?>" style="font-size: 13px; padding: 6px 10px; height: 20px; font-weight: 400;display: inline-flex ; align-items: center;">
                                            <?php echo e($getCom->status == 0 ? 'Open' : 'Closed'); ?>

                                        </span>
                                    </h5>
                                </div>
                        
                                <!-- Right: Status Badge -->
                                <div>
                                    <a href="<?php echo e(url('/seller/my-account/supports')); ?>" class="btn btn-sm btn-dark">
                                        <i class="bx bx-reply"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Body -->
                        <div class="card-body" style="background-color: #f4f6f9; max-height: 450px; overflow-y: auto;">
                            
                            <!-- Buyer Message -->
                            <div class="d-flex align-items-start mb-4 animate__animated animate__fadeIn">
                                <div class="me-2">
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                        <i class="bx bx-user"></i>
                                    </div>
                                </div>
                                <div class="p-3 rounded-3 shadow-sm" style="background: white; max-width: 70%;">
                                    <strong class="text-primary"><?php echo e($getCom?->impurity_name ?? 'Me'); ?></strong>
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
                                        <strong>Support Team</strong>
                                        <p class="mb-1"><?php echo e($getCom->reply); ?></p>
                                        <small class="text-light">
                                            <i class="bx bx-time"></i> <?php echo e($getCom?->updated_at?->format('d M Y, h:i A')); ?>

                                        </small>
                                    </div>
                                    <div class="ms-2">
                                        <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                            <i class="bx bx-store"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                
                        <!-- Footer -->
                        <div class="card-footer bg-light text-center small text-muted">
                            Last updated: <?php echo e($getCom?->updated_at?->format('d M Y, h:i A')); ?>

                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if(!request()->has('id')): ?>
                <!-- Order No -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="communicationId" class="fw-bold">Communication ID:</label>
                            <input type="text" class="form-control" name="communicationId"
                                value="<?php echo e($communicationId ?? 'AUTO-GEN'); ?>" readonly>
                        </div>
                    </div>
                </div>
    
                <!-- Message Box -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="message" class="fw-bold">Message:</label>
                            <textarea class="form-control" name="message" name="message" rows="7"
                                placeholder="Type your message here..." required><?php echo e(old('message')); ?></textarea>
                        </div>
                    </div>
                </div>
    
                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-12 text-end">
                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-success">Send</button>
                    </div>
                </div>
                <?php endif; ?>
            </form>
            <div class="col-md-7">
                
                <div class="col-md-12 px-0 px-md-3 mb-3">
                    <form method="POST" action="/seller/my-account/supports/export" class="row bg-light border py-3">
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
                            <th>Message</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sr = 1; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $communications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo $sr; $sr++; ?></td>
                                <td><?php echo e($com->communication_id); ?></td>
                                <td><?php echo e(substr($com->message, 0, 100)); ?>..</td>
                                <td>
                                    <span class="badge <?php echo e($com->status == 'open' ? 'bg-success' : 'bg-danger'); ?>">
                                        <?php echo e($com->status == 'open' ? 'Open' : 'Closed'); ?>

                                    </span>
                                </td>
                                <td><?php echo e($com->created_at); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(url('/seller/my-account/supports?id=' . $com->id)); ?>"
                                       class="btn btn-sm btn-info" title="View Details">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center">No communications found</td>
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

<?php $__env->stopSection(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/seller/inc/accounts/communication-support.blade.php ENDPATH**/ ?>