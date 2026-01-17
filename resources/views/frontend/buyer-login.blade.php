@include('.frontend.inc.header')
<body>
    <!-- ========== inner-page-banner start ============= -->
    <!-- <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".2s">Log In</h2>
        </div>
    </div> -->
    <!-- ========== inner-page-banner end ============= -->
    <div class="login-section pt-120 pb-120">
        <!-- <img alt="imges" src="assets/images/bg/section-bg.png" class="img-fluid section-bg-top">
        <img alt="imges" src="assets/images/bg/section-bg.png" class="img-fluid section-bg-bottom"> -->
        <div class="container">
            <div class="row d-flex justify-content-center g-4">
                <div class="col-xl-5 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>Welcome Back</h3>
                            <p>To Login Your Account</p>
                        </div>
                        <form action="/login" method="post" class="w-100">
                            @csrf
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
                                                I accept <a href="/terms-conditions" class="fw-bold">terms &amp; conditions</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-agreement form-inner d-flex justify-content-between flex-wrap">
                                        <div class="form-group d-flex align-item-center gx-2">
                                            <input type="checkbox" id="html" style="display:inline-block;width:19px;height:19px;margin-right:7px;">
                                            <span for="html" class="small" style="padding:0px!important;">Remember me</span>
                                        </div>
                                        <a href="/forgot-password" class="small">Forgotten Password?</a>
                                    </div>
                                </div>
                            </div>
                            <button class="account-btn mt-3">Login</button>
                        </form>
                         <div class="form-poicy-area mt-4">
                            <p class="mb-0">New Member? <a href="/register">signup here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===============  Hero area end=============== -->
    <!-- =============== counter-section end =============== -->
    <!-- =============== Footer-action-section start =============== -->
@include('.frontend.inc.footer')