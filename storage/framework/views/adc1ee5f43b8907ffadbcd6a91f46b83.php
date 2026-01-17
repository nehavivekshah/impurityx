<?php echo $__env->make('.frontend.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
$galleries = json_decode(($product->gallery ?? ''), true);
$user = session('users');
?>
<style>
    .input-group .form-floating>.form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    @media(max-width:768px) {
        .big-image img {
            height: 30vh;
        }
    }
</style>
<div class="auction-details-section pt-120">
    <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-top">
    <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-bottom">
    <div class="container">
        <div class="row g-4 mb-50">
            <div
                class="col-xl-5 col-lg-7 d-flex flex-column align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4 sticky-md-top">
                <div class="slide-content">
                    <div class="tab-content d-flex justify-content-lg-start justify-content-center wow fadeInUp"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        <?php if(!empty($product->img)): ?>
                        <div class="tab-pane1 big-image fade show active" id="gallery-img1">
                            <img alt="<?php echo e($product->img); ?>" name="gallery-img1"
                                src="<?php echo e(asset('public/assets/frontend/img/products/' . $product->img)); ?>"
                                class="img-fluid">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($galleries) && is_iterable($galleries)): ?>
                        <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tab-pane1 big-image fade" id="gallery-img<?php echo e($k + 2); ?>">
                            <img alt="<?php echo e($gallery); ?>" name="gallery-img<?php echo e($k + 2); ?>"
                                src="<?php echo e(asset('public/assets/frontend/img/products/' . $gallery)); ?>" class="img-fluid">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <ul class="nav small-image-list d-flex flex-row justify-content-center gap-4 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        <?php if(!empty($galleries) && is_iterable($galleries)): ?>
                        <?php if(!empty($product->img)): ?>
                        <li class="nav-item">
                            <div id="details-img1" data-bs-toggle="pill" data-bs-target="#gallery-img1"
                                aria-controls="gallery-img1">
                                <img alt="<?php echo e($product->img); ?>" name="details-img1"
                                    src="<?php echo e(asset('public/assets/frontend/img/products/' . $product->img)); ?>"
                                    class="img-fluid">
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <div id="details-img<?php echo e($k + 2); ?>" data-bs-toggle="pill"
                                data-bs-target="#gallery-img<?php echo e($k + 2); ?>" aria-controls="gallery-img<?php echo e($k + 2); ?>">
                                <img alt="<?php echo e($gallery); ?>" name="details-img<?php echo e($k + 2); ?>"
                                    src="<?php echo e(asset('public/assets/frontend/img/products/' . $gallery)); ?>"
                                    class="img-fluid">
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-xl-7 col-lg-5">
                <div class="product-details-rightwow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <h3><?php echo e($product->name ?? 'Unknown Name'); ?></h3>
                    <p class="para">
                        <?php if(!empty($product->sku)): ?>
                        <strong>SKU:</strong> <?php echo e($product->sku); ?><br>
                        <?php endif; ?>
                        <?php if(!empty($product->synonym)): ?>
                        <strong>Synonym Name:</strong> <?php echo e($product->synonym); ?><br>
                        <?php endif; ?>
                        <?php if(!empty($product->impurity_type)): ?>
                        <strong>Impurity Type:</strong> <?php echo e($product->impurity_type); ?><br>
                        <?php endif; ?>
                        <?php if(!empty($product->cas_no)): ?>
                        <strong>CAS No.:</strong> <?php echo e($product->cas_no); ?><br>
                        <?php endif; ?>
                        <?php if(!empty($product->uom)): ?>
                        <!--<strong>UOM:</strong> <?php echo e($product->uom); ?><br>-->
                        <?php endif; ?>
                        <?php if(!empty($product->purity)): ?>
                        <strong>Purity:</strong> <?php echo e($product->purity); ?>%<br>
                        <?php endif; ?>
                        <?php if(!empty($product->potency)): ?>
                        <strong>Potency:</strong> <?php echo e($product->potency); ?>%<br>
                        <?php endif; ?>
                        <?php if(!empty($product->molecular_name)): ?>
                        <strong>Molecular Name:</strong> <?php echo e($product->molecular_name); ?><br>
                        <?php endif; ?>
                        <?php if(!empty($product->molecular_weight)): ?>
                        <strong>Molecular Weight:</strong> <?php echo e($product->molecular_weight); ?><br>
                        <?php endif; ?>
                    </p>
                    <form action="/product/<?php echo e($product->slog ?? 'unknown-name'); ?>" method="POST"
                        class="w-100 form-wrapper form-products" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="buyerId" value="<?php echo e($user->id ?? ''); ?>" />
                        <div class="row gy-3">
                            <!-- Quantity Required (Already exists, retained for completeness) -->
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="form-floating flex-grow-1">
                                        <input type="number" class="form-control" id="qty" min="1" name="qty"
                                            placeholder="Quantity Required" required>
                                        <label for="qty">Quantity Required *</label>
                                    </div>
                                    <span class="input-group-text"><?php echo e($product->uom); ?></span>
                                </div>
                            </div>
                            <!-- Delivery Date -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="delivery_date" name="delivery_date"
                                        placeholder="Delivery Date" required>
                                    <label for="delivery_date">Delivery Date *</label>
                                </div>
                            </div>
                            <!-- Delivery Location -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="delivery_location"
                                        name="delivery_location" placeholder="Delivery Location" required>
                                    <label for="delivery_location">Delivery Location *</label>
                                </div>
                            </div>
                            <!-- Specific Requirements -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="specific_requirements"
                                        name="specific_requirements" placeholder="Specific Requirements"
                                        style="height: 120px"></textarea>
                                    <label for="specific_requirements">Specific Requirements</label>
                                </div>
                            </div>
                            <!-- Multiple File Attachment -->
                            <div class="col-md-12">
                                <label for="attachments" class="form-label fw-bold pl-0"
                                    style="padding-left:0px!important;">Attach Files (PDF, DOC, CSV, Images)</label>
                                <input class="form-control" type="file" id="attachments" name="attachments[]" multiple>
                            </div>
                            <div class="col-12">
                                <?php if(!empty($user->id)): ?>
                                <button class="eg-btn btn--primary btn--md form--btn btn-block w-100"
                                    type="submit">Submit</button>
                                <?php else: ?>
                                <a href="/login" class="eg-btn btn--primary btn--md form--btn btn-block w-100"
                                    type="submit">Submit</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center g-4">
            <div class="col-lg-12">
                <ul class="nav nav-pills describe-pills d-flex flex-row justify-content-start gap-sm-4 gap-3 mb-45 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".2s" id="pills-tab" role="tablist">
                    <?php if(!empty($product->des)): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active details-tab-btn" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Products Description</button>
                    </li>
                    <?php endif; ?>
                    <?php if(!empty($product->ainfo)): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link details-tab-btn" id="pills-bid-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-bid" type="button" role="tab" aria-controls="pills-bid"
                            aria-selected="false">Additional Information</button>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <?php if(!empty($product->des)): ?>
                    <div class="tab-pane fade show active wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s"
                        id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="describe-content">
                            <?php echo $product->des ?? ''; ?>

                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($product->ainfo)): ?>
                    <div class="tab-pane fade" id="pills-bid" role="tabpanel" aria-labelledby="pills-bid-tab">
                        <div class="table-responsive">
                            <?php echo $product->ainfo ?? ''; ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========== auction-details end ============= -->
<!-- =============== counter-section end =============== -->
<div class="about-us-counter pt-120 pb-120">
    <div class="container">
        <div class="row g-4 d-flex justify-content-center">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay="0.3s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/1.png" alt="employee">
                    </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="400"> </h3>
                        <p>Happy Customer</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay="0.6s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/2.png" alt="review">
                    </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="250"> </h3>
                        <p>Good Reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay="0.9s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/3.png" alt="smily">
                    </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="350"> </h3>
                        <p>Verified Suppliers</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".8s">
                    <div class="counter-icon"> <img src="/public/assets/frontend/img/icon/counter/4.png" alt="comment">
                    </div>
                    <div class="coundown d-flex flex-column">
                        <h3 class="odometer" data-odometer-final="500"> </h3>
                        <p>Buyer Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About-us-counter section End -->
<script>
    // Set today's date as the minimum selectable date
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById("delivery_date").setAttribute('min', today);
    });
</script>
<?php $__env->startSection('footlink'); ?>
<script src="https://cdn.tiny.cloud/1/lm91u59zbi9ehgp0ku57df4j1asfy1web6ap6b6h74jz6txl/tinymce/6/tinymce.min.js"
    referrerpolicy="origin" crossorigin="anonymous"></script>
<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
    tinymce.init({
        selector: 'textarea',
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('.frontend.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/frontend/product-details.blade.php ENDPATH**/ ?>