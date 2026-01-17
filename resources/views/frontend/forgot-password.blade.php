@include('.frontend.inc.header')
<body>
    <div class="login-section pt-120 pb-120">
        <div class="container">
            <div class="row d-flex justify-content-center g-4">
                <div class="col-xl-5 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>Forgot Password</h3>
                            <p>Enter your registered email to reset your password</p>
                        </div>
                        <form action="{{ url('/forgot-password') }}" method="post" class="w-100">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label style="padding:0px!important;">Email Id*</label>
                                        <input type="email" name="username" placeholder="Enter Your Email Id*" required>
                                    </div>
                                </div>
                            </div>
                            <button class="account-btn mt-3">Send Reset Link</button>
                        </form>

                        <div class="form-poicy-area mt-4">
                            <p class="mb-0">Remember your password? <a href="/login">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('.frontend.inc.footer')
