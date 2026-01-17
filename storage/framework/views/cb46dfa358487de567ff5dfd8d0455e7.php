<?php echo $__env->make('.frontend.seller.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="login-section pt-120 pb-120">
        <div class="container">
            <div class="row d-flex justify-content-center g-4">
                <div class="col-xl-5 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>Welcome Back</h3>
                            <p>Login your account to start the bidding</p>
                        </div>
                        <form action="/seller/login" method="post" class="w-100">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label style="padding:0px!important;">Email Id*</label>
                                        <input type="email" name="email" placeholder="Enter Your Email Id*" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label style="padding:0px!important;">Password*</label>
                                        <input type="password" name="password" id="password" placeholder="Password" required />
                                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-agreement form-inner d-flex justify-content-between flex-wrap">
                                        <div class="form-group d-flex align-item-center gx-2">
                                            <input type="checkbox" id="tc" name="tc" value="1" style="display:inline-block;width:19px;height:19px;margin-right:7px;" required>
                                            <span class="small" style="padding:0px!important;" for="tc">
                                                I accept <a href="/seller/terms-conditions" class="fw-bold">terms &amp; conditions</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-agreement form-inner d-flex justify-content-between flex-wrap">
                                        <div class="form-group d-flex align-item-center gx-2">
                                            <input type="checkbox" id="remember" name="remember" style="display:inline-block;width:19px;height:19px;margin-right:7px;">
                                            <span for="html" class="small" style="padding:0px!important;">Remember me</span>
                                        </div>
                                        <a href="/seller/forgot-password" class="small">Forgotten Password?</a>
                                    </div>
                                </div>
                            </div>
                            <button class="account-btn mt-3">Login</button>
                        </form>
                         <div class="form-poicy-area mt-4">
                            <p class="mb-0">New Member? <a href="/seller/register">signup here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $__env->make('.frontend.seller.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/frontend/seller/login.blade.php ENDPATH**/ ?>