<footer>
    <div class="footer-top">
        <div class="container-fluid">
            <div class="row gy-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h5>Overview</h5>
                        <!-- <a href="/seller/index.html"><img alt="image" src="/assets/frontend/img/logo/logo.jpg"></a> -->
                        <p>At Impurity X, we specialize in bridging the gap between chemical manufacturers, suppliers,
                            and buyers through a smart, transparent, and competitive chemical bidding platform With a
                            focus on impurities.</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 d-flex justify-content-lg-center">
                    <div class="footer-item">
                        <h5>Quick Links</h5>
                        <ul class="footer-list">
                            <li><a href="/seller/">Home</a></li>
                            <li><a href="/seller/about-us">About Us</a></li>
                            <li><a href="/seller/products">All Products</a></li>
                            <li><a href="/seller/how-it-works">How It Works</a></li>
                            <li><a href="/seller/blog">Blogs</a></li>
                            <li><a href="/seller/contact-us">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 d-flex justify-content-lg-center">
                    <div class="footer-item">
                        <h5>Policies</h5>
                        <ul class="footer-list">
                            <li><a href="/seller/support-policy">Support Policy</a></li>
                            <li><a href="/seller/return-policy"> Return Policy </a></li>
                            <li><a href="/seller/seller-policy">Seller Policy</a></li>
                            <li><a href="/seller/buyer-policy">Buyer Policy</a></li> 
                            <li><a href="/seller/privacy-policy">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 d-flex justify-content-lg-center">
                    <div class="footer-item">
                        <h5>Terms & Conditions</h5>
                        <ul class="footer-list">
                            <li><a href="/seller/terms-conditions">Terms & Conditions</a></li>
                            <li><a href="/seller/non-disclosure-agreement">Non Disclosure Agreement</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h5>Contact Us</h5>
                        <ul class="recent-feed-list">
                            <li class="single-feed">
                                <div class="feed-img">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="feed-content">
                                    <h6>ThirdWorld Innomart Private Limited <br> G-159, B Wing, Express Zone Mall, Western
                                        Express Highway, Malad East, Near Dindoshi Metro Station, Mumbai 400097,
                                        Maharashtra, India</h6>
                                </div>
                            </li>
                            <li class="single-feed">
                                <div class="feed-img">
                                    <i class="bx bx-phone-call"></i>
                                </div>
                                <div class="feed-content">
                                    <h6><a href="tel:+91 8554999074">+91 8554 999 074</a></h6>
                                </div>
                            </li>
                            <li class="single-feed">
                                <div class="feed-img">
                                    <i class="bx bx-envelope"></i>
                                </div>
                                <div class="feed-content">
                                    <h6><a href="mailto:support@impurityx.com">support@impurityx.com</a></h6>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row d-flex align-items-center g-4">
                <div class="col-lg-12 d-flex justify-content-lg-center justify-content-center">
                    <p><a href="/seller/">Impurity X</a> Copyright 2025 | Developed By <a href="https://webbrella.com/"
                            class="egns-lab">Webbrella Infotech</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="mobile-icon-footer d-block d-md-none">
    <div class="container">
        <div class="row">
            <div class="col-4 col-md-4">
                <a href="/seller">
                    <i class="bi bi-house-door"></i>
                    <span>Home</span>
                </a>
            </div>
            <div class="col-4 col-md-4">
                <a href="/seller/products">
                    <i class="fas fa-list"></i>
                    <span>Categories</span>
                </a>
            </div>
            <div class="col-4 col-md-4">
                <a href="/seller/my-account/my-profile">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </div>
        </div>
    </div>
</div>
<style>
    @media (max-width: 767px) {
       .footer-bottom{
        margin-bottom: 55px;
    }
    }
    .mobile-icon-footer .bi-house-door::before {
        font-weight: 900 !important;
    }
    .mobile-icon-footer {
        background-color: #fff;
        padding: 5px 0;
        position: fixed;
        width: 100%;
        bottom: 0px;
        left: 0px;
        z-index: 9999;
    }
    .mobile-icon-footer i, .mobile-icon-footer span { 
        display: block; 
        line-height: 22px; 
        font-size: 14px;
    }
    .mobile-icon-footer a {
        text-align: center;
    }
</style>
<div class="responseMsg">
    <!-- Validation Errors -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input:<br><br>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <!-- Session Error (custom error message) -->
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>
    
    <!-- Session Success (optional) -->
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
</div>
<!-- =============== Footer-action-section end =============== -->
<!-- js file link -->
<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="/assets/frontend/js/jquery-3.6.0.min.js"></script>
<script src="/assets/frontend/js/jquery-ui.js"></script>
<script src="/assets/frontend/js/bootstrap.bundle.min.js"></script>
<script src="/assets/frontend/js/wow.min.js"></script>
<script src="/assets/frontend/js/swiper-bundle.min.js"></script>
<script src="/assets/frontend/js/slick.js"></script>
<script src="/assets/frontend/js/jquery.nice-select.js"></script>
<script src="/assets/frontend/js/odometer.min.js"></script>
<script src="/assets/frontend/js/viewport.jquery.js"></script>
<script src="/assets/frontend/js/jquery.magnific-popup.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="/assets/frontend/js/main.js"></script>
<script>
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
    function validatePassword() {
        if (password.value != confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords Don't Match");
        } else {
            confirmPassword.setCustomValidity(''); // Clearing the Validator so form can be submitted
        }
    }
    password.onchange = validatePassword;
    confirmPassword.onkeyup = validatePassword;
</script>
<script>
    $(document).ready(function () {
        // Handle file input change
        $('.attachment-input').on('change', function () {
            const fileInputId = $(this).attr('id');
            const fileNumber = fileInputId.replace('attachment', '');
            const deleteButtonId = 'deleteAttachment' + fileNumber;
            const fileNameDisplayId = 'file-name-display' + fileNumber;
            const file = this.files[0];
            if (file) {
                // Validate file type (Example - add your own allowed types)
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf']; // example
                if (allowedTypes.indexOf(file.type) === -1) {
                    $('#' + fileNameDisplayId).text('Invalid file type');
                    $('#' + fileNameDisplayId).addClass('error');
                    $('#' + deleteButtonId).hide();
                    $(this).val(''); //Clear the input
                    return;
                }
                // Display file name
                $('#' + fileNameDisplayId).text('Selected file: ' + file.name);
                $('#' + fileNameDisplayId).removeClass('error'); //Remove error class if any
                // Show delete button
                $('#' + deleteButtonId).show();
            } else {
                $('#' + fileNameDisplayId).text('');
                $('#' + fileNameDisplayId).removeClass('error');
                $('#' + deleteButtonId).hide();
            }
        });
        // Handle delete attachment
        $('.delete-attachment').on('click', function () {
            const deleteButtonId = $(this).attr('id');
            const fileNumber = deleteButtonId.replace('deleteAttachment', '');
            const fileInputId = 'attachment' + fileNumber;
            const fileNameDisplayId = 'file-name-display' + fileNumber;
            // Clear file input
            $('#' + fileInputId).val('');
            // Hide delete button
            $(this).hide();
            // Clear file name display and error class
            $('#' + fileNameDisplayId).text('');
            $('#' + fileNameDisplayId).removeClass('error');
        });
        $("#rfqForm").submit(function (e) {
            e.preventDefault(); // Prevent the default form submission
            var formData = new FormData(this); // Create FormData object to handle file uploads
            // Basic client-side validation (you should have more robust server-side validation)
            if (!$("#casNumber").val() || !$("#impurityName").val()) {
                alert("Please fill in all required fields.");
                return;
            }
            $.ajax({
                url: "process_rfq", // Replace with your server-side script URL
                type: "POST",
                data: formData,
                processData: false, // Important: Don't process the data
                contentType: false, // Important: Set content type to false
                success: function (response) {
                    alert(response); // Display success message or handle errors
                    $("#rfqForm")[0].reset(); // Clear the form
                    $('.delete-attachment').hide(); // Hide delete buttons
                    $('.file-name-display').text(''); // Clear file name displays
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        });
    });
</script> 
<!-- Buyer Panel tab Stuck -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tabs
    var tabElms = document.querySelectorAll('button[data-bs-toggle="pill"], a[data-bs-toggle="pill"]');
    tabElms.forEach(function(tabEl) {
        tabEl.addEventListener('click', function(event) {
            // If it's a dropdown item, prevent default behavior
            if (this.classList.contains('dropdown-item')) {
                event.preventDefault();
            }
            
            var target = this.getAttribute('data-bs-target');
            var tabPane = document.querySelector(target);
            
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(function(pane) {
                pane.classList.remove('show', 'active');
            });
            
            // Show the selected tab pane
            if (tabPane) {
                tabPane.classList.add('show', 'active');
            }
            
            // Deactivate all tab buttons
            document.querySelectorAll('.nav-link').forEach(function(link) {
                link.classList.remove('active');
            });
            
            // Activate the current tab button
            this.classList.add('active');
        });
    });
});
// Initialize all Bootstrap tooltips and popovers
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Initialize Bootstrap popovers
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
});
</script>
<script>
  const qtyInput = document.getElementById('quantity');
  const pointsInput = document.getElementById('points');
  const increaseBtn = document.getElementById('increase');
  const decreaseBtn = document.getElementById('decrease');

  const pointPerVoucher = 500;

  function updatePoints(qty) {
    const total = qty * pointPerVoucher;
    pointsInput.value = total.toLocaleString(); // Adds commas
  }

  increaseBtn.addEventListener('click', () => {
    let qty = parseInt(qtyInput.value);
    qty++;
    qtyInput.value = qty;
    updatePoints(qty);
  });

  decreaseBtn.addEventListener('click', () => {
    let qty = parseInt(qtyInput.value);
    if (qty > 1) {
      qty--;
      qtyInput.value = qty;
      updatePoints(qty);
    }
  });

  // Initial calculation
  updatePoints(parseInt(qtyInput.value));
</script>

<?php echo $__env->yieldContent('footlink'); ?>

<script>
    $(document).ready(function () {
        $('#orderNo').on('change', function () {
            let orderNo = $(this).val();
    
            if (orderNo.trim() !== '') {
                $.ajax({
                    url: `/seller/get-order-details/${orderNo}`,
                    type: 'GET',
                    success: function (res) {
                        if (res.status) {
                            $('#casNo').val(res.cas_no);
                            $('#impurityName').val(res.impurity_name);
                        } else {
                            $('#casNo').val('');
                            $('#impurityName').val('');
                            alert(res.message);
                        }
                    },
                    error: function () {
                        alert('Error fetching order details.');
                    }
                });
            }
        });
    });
</script>
</body>
</html><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/seller/inc/footer.blade.php ENDPATH**/ ?>