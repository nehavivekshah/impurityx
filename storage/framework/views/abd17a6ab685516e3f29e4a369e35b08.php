<?php echo $__env->make('.frontend.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>
   
    <!-- ========== inner-page-banner start ============= -->
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft text-center" data-wow-duration="1.5s" data-wow-delay=".2s">Our Blogs</h2> 
        </div>
    </div>

    <!-- ========== inner-page-banner end ============= -->
    <div class="blog-section pt-120 pb-120">
        <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-top" >
        <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-bottom" >
        <div class="container">
            <div class="row g-4 mb-60">
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10">
                    <div class="single-blog-style1 wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="blog-img">
                            <a href="/blog/<?php echo e($post->categoryRelation->slog); ?>/<?php echo e($post->slog); ?>" class="blog-date">
                                <i class="bi bi-calendar-check"></i>
                                <?php echo e($post->created_at ? $post->created_at->format('d M, Y') : ''); ?>

                            </a>
                            <a href="/blog/<?php echo e($post->categoryRelation->slog); ?>/<?php echo e($post->slog); ?>">
                                <img alt="<?php echo e($post->title ?? ''); ?>" src="<?php echo e(asset('public/assets/frontend/img/posts/' . ($post->imgs ?? 'default.jpg'))); ?>">
                            </a>
                        </div>
                        <div class="blog-content">
                            <h3 class="h5">
                                <a href="/blog/<?php echo e($post->categoryRelation->slog); ?>/<?php echo e($post->slog); ?>">
                                    <?php echo e(\Illuminate\Support\Str::limit($post->title ?? 'Unknown Article', 50, '...')); ?>

                                </a>
                            </h3>
        
                            <div class="blog-meta">
                                <div class="comment">
                                    <img alt="<?php echo e($post->category ?? 0); ?>" src="<?php echo e(asset('public/assets/frontend/images/icons/tags.svg')); ?>">
                                    <a href="javascript:void(0)" class="comment">
                                        <?php echo e(ucfirst($post->category ?? 0)); ?>

                                    </a>
                                </div>
                                <div class="author">
                                    <img alt="<?php echo e($post->author ?? ''); ?>" src="<?php echo e(asset('public/assets/frontend/images/blog/user.png')); ?>">
                                    <span class="author-name"><?php echo e($post->author ?? '--'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="row">
            <nav class="pagination-wrap">
                <?php echo e($posts->links('pagination::bootstrap-5')); ?>

            </nav>
        </div>
        </div>
    </div>

    <!-- ===============  Hero area end=============== -->

  <!-- About-us-counter section End --> 
<?php echo $__env->make('.frontend.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/frontend/blog.blade.php ENDPATH**/ ?>