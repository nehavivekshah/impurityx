<?php echo $__env->make('.frontend.seller.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <style>
        label{
            padding-left: 0px!important;
        }
    </style>
    <div class="signup-section pt-40 pb-40">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>Create My Seller Account</h3>
                            <p>Create your account to start offering your quotes</p>
                        </div>
                        <form action="/seller/register" method="POST" class="w-100">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>First Name *</label>
                                        <input type="text" name="fname" placeholder="Enter Your First Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Last Name *</label>
                                        <input type="text" name="lname" placeholder="Enter Your Last Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Mobile No. *</label>
                                        <input type="text" name="mob" placeholder="Enter Your Mobile No." minlength="11" maxlength="13" value="+91" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Whatsapp No.</label>
                                        <input type="text" name="whatsapp" placeholder="Enter Your Whatsapp No." minlength="11" maxlength="13" value="+91" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Enter Your Email *</label>
                                        <input type="email" name="email" placeholder="Enter Your Email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Company Name *</label>
                                        <input type="text" name="company" placeholder="Enter Your Company Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Trade Name *</label>
                                        <input type="text" name="trade" placeholder="Enter Trade Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>PAN No / Income Tax Regn No *</label>
                                        <input type="text" name="incomTaxno" placeholder="Enter Pan No." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>GSTIN / VAT / TIN Regn No. *</label>
                                        <input type="text" name="taxNo" placeholder="Enter GSTIN No." required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>Registered Address *</label>
                                        <input type="text" name="regAddress" placeholder="Enter Registered Address" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>Communication Address *</label>
                                        <input type="text" name="comAddress" placeholder="Enter Communication Address" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>City *</label>
                                        <input type="text" name="city" placeholder="Enter Your City" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Pincode / Zipcode *</label>
                                        <input type="text" name="pincode" placeholder="Enter Your Pincode" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>State *</label>
                                        <input type="text" name="state" placeholder="Enter Your State" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Country *</label>
                                        <input type="text" name="country" placeholder="Enter Your Country" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Password *</label>
                                        <input type="password" name="password" id="password"
                                            placeholder="Create Password" required />
                                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Confirm Password *</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            placeholder="Confirm Password" required />
                                        <i class="bi bi-eye-slash" id="toggleConfirmPassword"></i>
                                    </div>
                                </div>
                            </div>
                            <button class="account-btn my-4" name="submit" type="submit">Create My Seller Account</button>
                        </form>
                        <div class="form-poicy-area mt-3">
                            <p>Do you already have an account? <a href="/seller/login">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $__env->make('.frontend.seller.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/frontend/seller/register.blade.php ENDPATH**/ ?>