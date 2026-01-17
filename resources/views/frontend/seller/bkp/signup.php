<?php include('header.php');?>
<body>
    <!-- ========== inner-page-banner end ============= -->
    <div class="signup-section pt-120 pb-120">
        <img alt="image" src="assets/images/bg/section-bg.png" class="section-bg-top">
        <img alt="image" src="assets/images/bg/section-bg.png" class="section-bg-bottom">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-4 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>Sign Up</h3>
                            <p>Login your account to start the bidding</p>
                        </div>
                        <form class="w-100">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>Name *</label>
                                        <input type="email" placeholder="Enter Your Name">
                                    </div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="form-inner">
                                        <label>Last Name *</label>
                                        <input type="email" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>Enter Your Email *</label>
                                        <input type="email" placeholder="Enter Your Email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>Password *</label>
                                        <input type="password" name="password" id="password"
                                            placeholder="Create A Password" />
                                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                                    </div>
                                </div>
                                <div class="col-md-12 d-none">
                                    <div class="form-agreement form-inner d-flex justify-content-between flex-wrap">
                                        <div class="form-group">
                                            <input type="checkbox" id="html">
                                            <label for="html">I agree to the Terms & Policy</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="account-btn">Create Account</button>
                        </form>
                        <div class="alternate-signup-box d-none">
                            <h6>or signup WITH</h6>
                            <div class="btn-group gap-4">
                                <a href="#" class="eg-btn google-btn d-flex align-items-center"><i
                                        class='bx bxl-google'></i><span>signup whit google</span></a>
                                <a href="#" class="eg-btn facebook-btn d-flex align-items-center"><i
                                        class='bx bxl-facebook'></i>signup whit facebook</a>
                            </div>
                        </div>
                        <div class="form-poicy-area pt-3">
                            <p>By continuing, you agree to ImpurityX
                                <a href="#">Terms & Conditions</a> & <a href="#">Privacy Policy.</a></p>
                            <p>Do you already have an account? <a href="login.php">Log in here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===============  Hero area end=============== -->
    <!-- =============== counter-section end =============== -->
    <!-- =============== Footer-action-section start =============== -->
    <?php include('footer.php');?>