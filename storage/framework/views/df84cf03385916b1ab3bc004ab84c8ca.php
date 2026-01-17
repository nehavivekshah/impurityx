<?php echo $__env->make('.frontend.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    @media(max-width:768px){
     .live-auction-section{
        z-index: 0;
     } 
} 
</style>
<body>
    
    <!-- ========== inner-page-banner start ============= -->
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft text-center" data-wow-duration="1.5s" data-wow-delay=".2s">
                <?php echo e($pagetitle ?? 'Products'); ?>

            </h2>
        </div>
    </div>
    
    <!-- ========== inner-page-banner end ============= -->
    <div class="live-auction-section pt-120 pb-120">
        <!--<img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-top">
        <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-bottom">-->
        <div class="container">
            <div class="row gy-4 mb-60 d-flex justify-content-center">
                <?php if($products->isEmpty()): ?>
                    <div class="col-12 text-center" style="margin-top: 75px; padding: 100px 0px;">
                        <h4>No products found in this category.</h4>
                    </div>
                <?php else: ?>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-lg-3 col-md-6 col-sm-10">
                            <div data-wow-duration="1.5s" data-wow-delay="0.2s"
                                class="eg-card auction-card1 wow animate fadeInDown">
                                <div class="auction-img">
                                    <img alt="<?php echo e($product->name ?? 'Unknown'); ?>"
                                         src="/public/assets/frontend/img/products/<?php echo e($product->img ?? 'default.jpg'); ?>">
                                </div>
                                <div class="auction-content">
                                    <h4><a href="/product/<?php echo e($product->slog ?? 'unknown'); ?>"><?php echo e($product->name ?? 'Unknown'); ?></a></h4>
                                    <div class="auction-card-bttm">
                                        <a href="/product/<?php echo e($product->slog ?? 'unknown'); ?>"
                                           class="eg-btn btn--primary btn--sm">Place An Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
        
            </div> 
        </div>
    </div>
    <!-- ===============  Hero area end=============== -->
<?php echo $__env->make('.frontend.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/frontend/products.blade.php ENDPATH**/ ?>