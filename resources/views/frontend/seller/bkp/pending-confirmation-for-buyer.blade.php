<?php include('header.php');?>
<!-- ========== inner-page-banner start ============= -->
<div class="inner-banner">
    <div class="container">
        <h2 class="inner-banner-title text-center wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s">
            Pending Confirmation
        </h2>
    </div>
</div>
<!-- ========== inner-page-banner end ============= -->
<!-- ========== auction-details start ============= -->
<div class="auction-details-section pt-120">
    <img src="assets/images/bg/section-bg.png" alt="section-bg" class="img-fluid section-bg-top">
    <img src="assets/images/bg/section-bg.png" alt="section-bg" class="img-fluid section-bg-bottom">
    <div class="container">
        <!-- product-details-container start-->
        <div class="row g-4 mb-50 product-details-container">
            <!-- image-column start-->
            <div
                class="col-xl-5 col-lg-7 d-flex flex-column align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4 sticky-md-top">
                <div class="slide-content">
                    <div class="tab-content mb-4 d-flex justify-content-lg-start justify-content-center wow fadeInUp"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        <div class="tab-pane big-image fade show active" id="gallery-img1">
                            <img src="assets/img/products/human.jpg" alt="Product Image" class="img-fluid">
                        </div>
                        <div class="tab-pane big-image fade" id="gallery-img2">
                            <img src="assets/img/products/h-2.jpg" alt="Product Image" class="img-fluid">
                        </div>
                        <div class="tab-pane big-image fade" id="gallery-img3">
                            <img src="assets/img/products/h-4.jpg" alt="Product Image" class="img-fluid">
                        </div>
                        <div class="tab-pane big-image fade" id="gallery-img4">
                            <img src="assets/img/products/h-2.jpg" alt="Product Image" class="img-fluid">
                        </div>
                    </div>
                    <ul class="nav small-image-list d-flex flex-md-row flex-row justify-content-center gap-4 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        <li class="nav-item">
                            <div id="details-img1" data-bs-toggle="pill" data-bs-target="#gallery-img1"
                                aria-controls="gallery-img1">
                                <img src="assets/img/products/human.jpg" alt="Thumbnail" class="img-fluid">
                            </div>
                        </li>
                        <li class="nav-item">
                            <div id="details-img2" data-bs-toggle="pill" data-bs-target="#gallery-img2"
                                aria-controls="gallery-img2">
                                <img src="assets/img/products/h-2.jpg" alt="Thumbnail" class="img-fluid">
                            </div>
                        </li>
                        <li class="nav-item">
                            <div id="details-img3" data-bs-toggle="pill" data-bs-target="#gallery-img3"
                                aria-controls="gallery-img3">
                                <img src="assets/img/products/h-4.jpg" alt="Thumbnail" class="img-fluid">
                            </div>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <div id="details-img4" data-bs-toggle="pill" data-bs-target="#gallery-img4"
                                aria-controls="gallery-img4">
                                <img src="assets/img/products/h-2.jpg" alt="Thumbnail" class="img-fluid">
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
            <!-- image-column end-->
            <!-- content-column start-->
            <div class="col-xl-7 col-lg-5 content-column">
                <div class="product-details-right wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <h3>Human Metabolites</h3>
                    <p class="para">
                        At Impurity X, we understand the critical role human metabolites play in drug development.
                    </p>
                    <form class="w-100 form-wrapper form-products">
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
                            <!-- My Bid Section -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-success text-white text-center">
                                        Auction Results
                                    </div>
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="rate" class="form-label">Rate</label>
                                                    <input type="text" class="form-control" id="rate"
                                                        name="rate" placeholder="150.00" value="150.00">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="delivery-days" class="form-label">Delivery Days</label>
                                                    <input type="text" class="form-control" id="delivery-days"
                                                        name="delivery-days" placeholder="30" value="30">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="storage-temp" class="form-label">Storage Temp
                                                        (°C)</label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" class="form-control me-2"
                                                            id="storage-temp-min" name="storage-temp-min"
                                                            placeholder="-2" value="-2" style="width: 40%;">
                                                        <span class="me-2">to</span>
                                                        <input type="text" class="form-control" id="storage-temp-max"
                                                            name="storage-temp-max" placeholder="-8" value="-8"
                                                            style="width: 40%;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <div>
                                                    Auction ending in <br class="d-none d-md-block">
                                                    <span class="fw-bold">72H : 15M : 23S</span> at<br>
                                                    05-Jul-2025 10:00:00
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ongoing Bid Section -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        ONGOING BID
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="buyer-confirm">
                                                        <th>Offer</th>
                                                        <th>Per unit rate</th>
                                                        <th>Delivery Days</th>
                                                        <th>Storage Temp (°C)</th>
                                                        <th>Bidding time</th>
                                                        <th>Accept</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>150.00 </td> <td>30</td>
                                                        <td>-2 to -8</td>
                                                        <td>30-06-2025 13:10:00</td>
                                                        <td>Y</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>165.00</td>
                                                        <td>25</td>
                                                        <td>25 to 35</td>
                                                        <td>30-06-2025 11:10:00</td>
                                                        <td rowspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>170.00</td>
                                                        <td>60</td>
                                                        <td>5 to 10</td>
                                                        <td>30-06-2025 10:10:00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>175.00</td>
                                                        <td>5</td>
                                                        <td>25 to 35</td>
                                                        <td>30-06-2025 10:05:00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>180.00</td>
                                                        <td>25</td>
                                                        <td>5 to 10</td>
                                                        <td>30-06-2025 10:00:05</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Detailed Requirements"
                                        id="detailed_requirements" name="detailed_requirements" style="height: 150px"
                                        required></textarea>
                                    <label for="detailed_requirements">Detailed Requirements *</label>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-7">
                                <div class="d-flex gap-1">
                                    <button class="account-btn post" type="submit">Post Query</button> 
                                <button class="account-btn not-interested" type="submit">Not Interested</button> 
                                </div>
                            </div> 
                            <div class="col-5 text-end"> 
                                <button class="account-btn accept" type="submit">Accept</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- content-column end-->
        </div>
    </div>
</div>
<!-- ========== auction-details end ============= -->
<!-- =============== Footer-action-section start =============== -->
<?php include('footer.php');?>