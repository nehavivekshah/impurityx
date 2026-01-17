<?php echo $__env->make('.frontend.seller.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>
   
    <!-- ========== inner-page-banner start ============= -->
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft text-center" data-wow-duration="1.5s" data-wow-delay=".2s">Blog Details</h2> 
        </div>
    </div>

    <!-- ========== inner-page-banner end ============= -->
    <div class="blog-details-section pt-120 pb-120">
        <img alt="image"  src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-top" >
        <img alt="image"  src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-bottom" >
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-8">
                    <div class="blog-details-single">
                        <div class="blog-img">
                            <img alt="image"  src="<?php echo e(asset('public/assets/frontend/img/posts/' . ($post->imgs ?? 'default.jpg'))); ?>" class="img-fluid wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                        </div>
                        <ul class="blog-meta gap-2">
                            <li><a href="javascript:void(0)"><img alt="image"  src="/public/assets/frontend/images/icons/calendar.svg" >Date: <?php echo date_format(date_create($post->created_at ?? null),'d M, Y'); ?></a></li>
                            <!--<li><a href="javascript:void(0)"><img alt="image"  src="/public/assets/frontend/images/icons/tags.svg" >Auction</a></li>-->
                            <li><a href="javascript:void(0)"><img alt="image"  src="/public/assets/frontend/images/icons/admin.svg" >Posted by <?php echo e($post->author ?? '--'); ?></a></li>
                        </ul>
                        <h3 class="blog-title"><?php echo e($post->title ?? ''); ?></h3>
                        <div class="blog-content">
                            <?php echo $post->content ?? ''; ?>

                        </div>
                        <!--<div class="blog-tag">
                            <div class="row g-3">
                                <div class="col-md-6 d-flex justify-content-md-start justify-content-center align-items-center">
                                    <h6>Post Tag:</h6>
                                    <ul class="tag-list">
                                        <li><a href="#">Network Setup</a></li>
                                        <li><a href="#">Cars</a></li>
                                        <li><a href="#">Technology</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-6 d-flex justify-content-md-end justify-content-center align-items-center">
                                    <ul class="share-social gap-3">
                                        <li><a href="https://www.facebook.com/"><i class='bx bxl-facebook'></i></a></li>
                                        <li><a href="https://www.twitter.com/"><i class='bx bxl-twitter'></i></a></li>
                                        <li><a href="https://www.instagram.com/"><i class='bx bxl-instagram'></i></a></li>
                                        <li><a href="https://www.pinterest.com/"><i class='bx bxl-pinterest-alt'></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>-->
                        <!--div class="blog-author gap-4 flex-md-nowrap flex-wrap">
                            <div class="author-image">
                                <img alt="image"  src="/public/assets/frontend/images/blog/blog-author.png" class="img-fluid" >
                            </div>
                            <div class="author-detials text-md-start text-center">
                                <h5>-- Leslie Alexander</h5>
                                <p class="para">It has survived not only five centuries, but also the leap into electronic typesetting unchanged. It was popularised in the sheets containing lorem ipsum is simply free text.</p>
                            </div>
                        </div>
                        <div class="blog-comment">
                            <div class="blog-widget-title">
                                <h4>Comments (03)</h4>
                                <span></span>
                            </div>
                            <ul class="comment-list mb-50">
                                <li>
                                    <div class="comment-box">
                                        <div class="comment-header d-flex justify-content-between align-items-center">
                                            <div class="author d-flex flex-wrap">
                                                <img alt="image"  src="/public/assets/frontend/images/blog/comment1.png" >
                                                <h5><a href="#">Leslie Waston</a></h5><span class="commnt-date"> April 6, 2022 at 3:54 am</span>
                                            </div>    
                                            <a href="#" class="commnt-reply"><i class="bi bi-reply"></i></a>
                                        </div>
                                        <div class="comment-body">
                                            <p class="para">Aenean dolor massa, rhoncus ut tortor in, pretium tempus neque. Vestibulum venenati leo et dic tum finibus. Nulla vulputate dolor sit amet tristique dapibus.Gochujang ugh viral, butcher     pabst put a bird on it meditation austin.</p>
                                        </div>
                                    </div>
                                    <ul class="comment-reply">
                                        <li>
                                            <div class="comment-box">
                                                <div class="comment-header d-flex justify-content-between align-items-center">
                                                    <div class="author d-flex flex-wrap">
                                                        <img alt="image"  src="/public/assets/frontend/images/blog/comment2.png" >
                                                        <h5><a href="#">Robert Fox</a></h5><span class="commnt-date"> April 6, 2022 at 3:54 am</span>
                                                    </div>    
                                                    <a href="#" class="commnt-reply"><i class="bi bi-reply"></i></a>
                                                </div>
                                                <div class="comment-body">
                                                    <p class="para">Aenean dolor massa, rhoncus ut tortor in, pretium tempus neque. Vestibulum venenati leo et dic tum finibus. Nulla vulputate dolor sit amet tristique dapibus.Gochujang ugh viral, butcher     pabst put a bird on it meditation austin.</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <div class="comment-box">
                                        <div class="comment-header d-flex justify-content-between align-items-center">
                                            <div class="author d-flex flex-wrap">
                                                <img alt="image"  src="/public/assets/frontend/images/blog/comment3.png" >
                                                <h5><a href="#">William Harvey</a></h5><span class="commnt-date"> April 6, 2022 at 3:54 am</span>
                                            </div>    
                                            <a href="#" class="commnt-reply"><i class="bi bi-reply"></i></a>
                                        </div>
                                        <div class="comment-body">
                                            <p class="para">Aenean dolor massa, rhoncus ut tortor in, pretium tempus neque. Vestibulum venenati leo et dic tum finibus. Nulla vulputate dolor sit amet tristique dapibus.Gochujang ugh viral, butcher     pabst put a bird on it meditation austin.</p>
                                        </div>
                                    </div>
                                </li>
                             </ul>
                        </div>-->
                        <!--<div class="comment-form">
                            <div class="blog-widget-title style2">
                                <h4>Leave A Comment</h4>
                                <p class="para">Your email address will not be published.</p>
                                <span></span>
                            </div>
                            <form action="#">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 col-md-6">
                                        <div class="form-inner">
                                            <input type="text" placeholder="Your Name :">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 col-md-6">
                                        <div class="form-inner">
                                            <input type="email" placeholder="Your Email :">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <textarea name="message" placeholder="Write Message :" rows="12"></textarea>
                                        </div>    
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="eg-btn btn--primary btn--md form--btn">Submit Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>-->
                    </div>
                </div>
                <div class="col-lg-4">

                    <!-- blog-sidebar -->
                    <div class="blog-sidebar">
                        <!--<div class="blog-widget-item wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div class="search-area">
                                <div class="sidebar-widget-title">
                                    <h4>Search From Blog</h4>
                                    <span></span>
                                </div>
                                <div class="blog-widget-body">
                                    <form>
                                        <div class="form-inner">
                                            <input type="text" placeholder="Search Here">
                                            <button class="search--btn"><i class='bx bx-search-alt-2'></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>-->
                        <div class="blog-widget-item wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".4s" style="padding-top: 0px;">
                            <div class="blog-category">
                                <div class="sidebar-widget-title">
                                    <h4>Recent Post</h4>
                                    <span></span>
                                </div>
                                <div class="blog-widget-body">
                                    <ul class="recent-post">
                                        <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="single-post">
                                            <div class="post-img">
                                                <a href="/seller/blog/<?php echo e($relatedPost->categoryRelation->slog); ?>/<?php echo e($relatedPost->slog); ?>"><img alt="<?php echo e($relatedPost->title ?? ''); ?>"  src="<?php echo e(asset('public/assets/frontend/img/posts/' . ($relatedPost->imgs ?? 'default.jpg'))); ?>"
                                                        ></a>
                                            </div>
                                            <div class="post-content">
                                                <span><?php echo e($relatedPost->created_at ? $relatedPost->created_at->format('d M, Y') : ''); ?></span>
                                                <h6><a href="/seller/blog/<?php echo e($relatedPost->categoryRelation->slog); ?>/<?php echo e($relatedPost->slog); ?>"><?php echo e(\Illuminate\Support\Str::limit($relatedPost->title ?? 'Unknown Article', 50, '...')); ?></a>
                                                </h6>
                                            </div>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="blog-widget-item wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".4s">
                            <div class="top-blog">
                                <div class="sidebar-widget-title">
                                    <h4>Post Categories</h4>
                                    <span></span>
                                </div>
                                <div class="blog-widget-body">
                                    <ul class="category-list">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="/seller/blog/<?php echo e($category->slog ?? ''); ?>"><span><?php echo e($category->title ?? ''); ?></span><span><?php echo e($category->posts_count ?? '0'); ?></span></a></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--<div class="blog-widget-item wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".8s">
                            <div class="tag-area">
                                <div class="sidebar-widget-title">
                                    <h4>Follow Social</h4>
                                    <span></span>
                                </div>
                                <div class="blog-widget-body">
                                    <ul class="sidebar-social-list gap-4">
                                        <li><a href="https://www.facebook.com/"><i class='bx bxl-facebook'></i></a></li>
                                        <li><a href="https://www.twitter.com/"><i class='bx bxl-twitter'></i></a></li>
                                        <li><a href="https://www.instagram.com/"><i class='bx bxl-instagram'></i></a></li>
                                        <li><a href="https://www.pinterest.com/"><i class='bx bxl-pinterest-alt'></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-banner wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="1s">
                            <div class="banner-content">
                                <span>CARS</span>
                                <h3>Toyota AIGID A Clasis Cars Sale</h3>
                                <a href="auction-details.html" class="eg-btn btn--primary card--btn">Details</a>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===============  Hero area end=============== -->
<?php echo $__env->make('.frontend.seller.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/frontend/seller/blog-details.blade.php ENDPATH**/ ?>