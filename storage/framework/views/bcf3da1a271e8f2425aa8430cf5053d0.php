<?php $__env->startSection('title','Manage Post - Impurity X'); ?>
<?php $__env->startSection('headlink'); ?>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
<!-- Link Styles -->
<link rel="stylesheet" href="<?php echo e(asset('/assets/backend/css/style.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="task__section">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom bg-white shadow-sm mb-3">
        <h5 class="fw-bold mb-0 text-dark">Management Panel</h5>
    
        <div class="d-flex align-items-center gap-3">
    
            <!-- Notification Icon -->
            <div class="position-relative">
                <a href="#" class="btn btn-light position-relative p-2 rounded-circle shadow-sm">
                    <i class="bx bx-bell fs-5 text-dark"></i>
                    <!--<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3+</span>-->
                </a>
            </div>
    
            <!-- User Dropdown -->
            <div class="dropdown">
                <a href="javascript:void(0)" class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 position-relative" data-bs-toggle="dropdown">
                    <i class="bx bx-user fs-5"></i> <?php echo e(Auth::user()->first_name); ?>

                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-white rounded-circle"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border right-menu">
                    <li><a class="dropdown-item" href="/admin/profile"><i class="bx bx-user me-2"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href="/admin/reset-password"><i class="bx bx-reset me-2"></i> Reset Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/admin/logout"><i class="bx bx-log-out me-2"></i> Logout</a></li>
                </ul>
            </div>
    
        </div>
    </div>
    <div class="scrum-board-container">
        <div class="flex justify-content-center">
            <div class="col-md-12 rounded bg-white">
                <h1 class="h3 box-title pb-2">
                    <a href="/admin/posts" class="text-small mr-3" title="Back"><img src="<?php echo e(asset('/assets/backend/icons/back.svg')); ?>" class="back-icon" /></a>
                    <?php if(count($post)=='0'): ?> 
                        New Post 
                    <?php else: ?>
                        Edit Post Details
                    <?php endif; ?>
                </h1><hr>
                <form action="<?php echo e(route('managePost')); ?>" method="POST" class="card-body pb-3 px-3" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="small">Title*</label><br>
                            <div class="input-group">
                                <img src="<?php echo e(asset('/assets/backend/icons/edit.svg')); ?>" class="input-icon" />
                                <input type="hidden" name="id" value="<?php echo e($_GET['id'] ?? ''); ?>" />
                                <input type="text" name="post_title" class="form-control" placeholder="Enter Title*" value="<?php echo e($post[0]->title ?? ''); ?>" required />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small">Category*</label><br>
                            <div class="input-group">
                                <img src="<?php echo e(asset('/assets/backend/icons/edit.svg')); ?>" class="input-icon" />
                                <select name="post_category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $postCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php if(($category->slog ?? '') == ($post[0]->category ?? '')): ?>
                                    
                                    <option value="<?php echo e($category->slog ?? ''); ?>" selected><?php echo e($category->title ?? ''); ?></option>
                                    
                                    <?php else: ?>
                                    
                                    <option value="<?php echo e($category->slog ?? ''); ?>"><?php echo e($category->title ?? ''); ?></option>
                                    
                                    <?php endif; ?>
                                    
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small">Photo*</label><br>
                            <div class="input-group">
                                <?php if(!empty($post[0]->imgs)): ?>
                                <img src="<?php echo e(asset('/public/assets/frontend/img/posts/'.$post[0]->imgs)); ?>" class="img-icon" />
                                <?php else: ?>
                                <img src="<?php echo e(asset('/assets/backend/icons/edit.svg')); ?>" class="input-icon" />
                                <?php endif; ?>
                                <input type="file" name="post_file" class="form-control" <?php if(empty($post[0]->imgs)): ?> required <?php endif; ?> />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small">Author Name*</label><br>
                            <div class="input-group">
                                <img src="<?php echo e(asset('/assets/backend/icons/edit.svg')); ?>" class="input-icon" />
                                <input type="text" name="post_author" class="form-control" placeholder="Enter author name*" value="<?php echo e($post[0]->author ?? ''); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small">Content*</label><br>
                        <textarea name="post_content" class="form-control" id="summernote" placeholder="Write your review*" required><?php echo e($post[0]->content ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="small">Short Description (200 character)*</label><br>
                        <textarea name="post_shortcontent" class="form-control" id="" placeholder="Write here*" maxlength="200" required><?php echo e($post[0]->shortContent ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="small">Tags ("," use comma separator)*</label><br>
                        <textarea name="post_tags" class="form-control" id="" placeholder="tag 1, tag 2 ....*" maxlength="200" required><?php echo e($post[0]->tags ?? ''); ?></textarea>
                    </div>
                    <div class="form-group text-center mt-3 mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-light border">Reset</button>
                    </div>
                </form>
            <div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footlink'); ?>
    
<!-- Scripts -->
<script src="<?php echo e(asset('/assets/backend/js/script.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    
<script type="text/javascript">
    $(document).ready(function () {
        $('#summernote').summernote({
            height: 300,
        });
        $('#summernote1').summernote({
            height: 300,
            addclass: {
                debug: false,
                classTags: [{title:"Button","value":"btn btn-success"},"jumbotron", "lead","img-rounded","img-circle", "img-responsive","btn", "btn btn-success","btn btn-danger","text-muted", "text-primary", "text-warning", "text-danger", "text-success", "table-bordered", "table-responsive", "alert", "alert alert-success", "alert alert-info", "alert alert-warning", "alert alert-danger", "visible-sm", "hidden-xs", "hidden-md", "hidden-lg", "hidden-print"]
            },
            toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video', 'hr']],
                        ['view', ['codeview']]
                    ],
                    fontSize: 12
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/managePost.blade.php ENDPATH**/ ?>