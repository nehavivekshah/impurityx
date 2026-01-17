<?php include('header.php');?>
<body>
    <!-- ========== inner-page-banner start ============= -->
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title  wow fadeInLeft text-center" data-wow-duration="1.5s" data-wow-delay=".4s">
                Products Details
            </h2>
        </div>
    </div>
    <!-- ========== inner-page-banner end ============= -->
    <!-- ========== auction-details start ============= -->
    <div class="auction-details-section pt-120">
        <img alt="image" src="assets/images/bg/section-bg.png" class="img-fluid section-bg-top">
        <img alt="image" src="assets/images/bg/section-bg.png" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row g-4 mb-50">
                <div
                    class="col-xl-5 col-lg-7 d-flex flex-column align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4">
                    <div class="slide-content">
                        <div class="tab-content mb-4 d-flex justify-content-lg-start justify-content-center  wow fadeInUp"
                            data-wow-duration="1.5s" data-wow-delay=".4s">
                            <div class="tab-pane big-image fade show active" id="gallery-img1">
                                <img alt="image" name="gallery-img1" src="assets/img/products/human.jpg"
                                    class="img-fluid">
                            </div>
                            <div class="tab-pane big-image fade" id="gallery-img2">
                                <img alt="image" name="gallery-img2" src="assets/img/products/h-2.jpg"
                                    class="img-fluid">
                            </div>
                            <div class="tab-pane big-image fade" id="gallery-img3">
                                <!-- <div class="auction-gallery-timer d-flex align-items-center justify-content-center">
                                <h3 id="countdown-timer-3"></h3>
                            </div> -->
                                <img alt="image" name="gallery-img3" src="assets/img/products/h-4.jpg"
                                    class="img-fluid">
                            </div>
                        </div>
                        <ul class="nav small-image-list d-flex flex-row flex-row justify-content-center gap-4  wow fadeInDown"
                            data-wow-duration="1.5s" data-wow-delay=".4s">
                            <li class="nav-item">
                                <div id="details-img1" data-bs-toggle="pill" data-bs-target="#gallery-img1"
                                    aria-controls="gallery-img1">
                                    <img alt="image" name="details-img1" src="assets/img/products/human.jpg"
                                        class="img-fluid">
                                </div>
                            </li>
                            <li class="nav-item">
                                <div id="details-img2" data-bs-toggle="pill" data-bs-target="#gallery-img2"
                                    aria-controls="gallery-img2">
                                    <img alt="image" name="details-img2" src="assets/img/products/h-2.jpg"
                                        class="img-fluid">
                                </div>
                            </li>
                            <li class="nav-item">
                                <div id="details-img3" data-bs-toggle="pill" data-bs-target="#gallery-img3"
                                    aria-controls="gallery-img3">
                                    <img alt="image" name="details-img3" src="assets/img/products/h-4.jpg"
                                        class="img-fluid">
                                </div>
                            </li>
                        </ul>
                        <label class="form-label form-label-small pt-3">Attachments :</label>
                        <div class="row gy-2">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <div class="col-md-12">
                                <div class="input-group attachment-input-group">
                                    <label class="input-group-text attachment-label"
                                        for="attachment<?php echo $i; ?>">Attachment
                                        (<?php echo $i; ?>)</label>
                                    <input type="file" class="form-control attachment-input"
                                        id="attachment<?php echo $i; ?>" name="attachment<?php echo $i; ?>">
                                    <button class="btn btn-outline-secondary delete-attachment" type="button"
                                        id="deleteAttachment<?php echo $i; ?>" style="display:none;"
                                        title="Remove Attachment">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div id="file-name-display<?php echo $i; ?>" class="file-name-display">
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-5">
                    <div class="product-details-rightwow sticky-md-top fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <h3>Human Metabolites</h3>
                        <p class="para">
                            At Impurity X, we understand the critical role human metabolites play in drug development.
                        </p>
                        <form class="w-100 form-wrapper form-products slide-content">
                            <div class="row gy-3">
                                <!-- Order ID -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="order_id" name="order_id"
                                            placeholder="Order Id">
                                        <label for="order_id">Order Id *</label>
                                    </div>
                                </div>
                                <!-- SKU -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="sku" name="sku" placeholder="SKU">
                                        <label for="sku">SKU *</label>
                                    </div>
                                </div>
                                <!-- CAS Number -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="cas_number" name="cas_number"
                                            placeholder="CAS Number">
                                        <label for="cas_number">CAS Number *</label>
                                    </div>
                                </div>
                                <!-- Impurity Name -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="impurity_name" name="impurity_name"
                                            placeholder="Impurity Name">
                                        <label for="impurity_name">Impurity Name *</label>
                                    </div>
                                </div>
                                <!-- Quantity Required -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="qty" name="qty"
                                            placeholder="Quantity Required">
                                        <label for="qty">QTY Required *</label>
                                    </div>
                                </div>
                                <!-- UOM -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="uom" name="uom" placeholder="UOM">
                                        <label for="uom">UOM *</label>
                                    </div>
                                </div>
                                <!-- Delivery By -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="delivery_by" name="delivery_by"
                                            placeholder="Delivery By">
                                        <label for="delivery_by">Delivery By *</label>
                                    </div>
                                </div>
                                <!-- Delivery At -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="delivery_at" name="delivery_at"
                                            placeholder="Delivery At">
                                        <label for="delivery_at">Delivery At *</label>
                                    </div>
                                </div>
                                <!-- Detailed Requirements --> 
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Detailed Requirements"
                                            id="detailed_requirements" name="detailed_requirements"
                                            style="height: 150px" required></textarea>
                                        <label for="detailed_requirements">Detailed Requirements *</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="account-btn" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <!-- ========== auction-details end ============= --> 
    <!-- =============== Footer-action-section start =============== -->
    <?php include('footer.php');?>