@include('.frontend.inc.header')
<body>
    <div class="login-section pt-120 pb-120">
        <div class="container">
            <div class="row d-flex justify-content-center g-4">
                <div class="col-xl-5 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>Verify Your Email</h3>
                            <p>Enter the 6-digit code we sent to your email</p>
                        </div>

                        {{-- Flash success / error --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        @php
                            // Prefer controller-passed $email, then old(), then session('otp_email')
                            $emailVal = isset($email) && $email ? $email : (old('email') ?: session('otp_email'));
                        @endphp

                        <div class="mb-3 small">
                            @if($emailVal)
                                We sent a code to <strong>{{ $emailVal }}</strong>.
                            @else
                                Please enter the registered email and the code you received.
                            @endif
                        </div>

                        {{-- Verify OTP --}}
                        <form action="/verify-otp" method="post" class="w-100">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label style="padding:0px!important;">Email Id*</label>
                                        <input type="email"
                                               name="email"
                                               placeholder="Enter Your Email Id*"
                                               value="{{ $emailVal }}"
                                               required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label style="padding:0px!important;">Verification Code*</label>
                                        <input type="text"
                                               name="code"
                                               placeholder="6-digit code"
                                               inputmode="numeric"
                                               pattern="\d{6}"
                                               maxlength="6"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <button class="account-btn mt-3 w-100">Verify</button>
                        </form>

                        {{-- Resend OTP --}}
                        <form action="/resend-otp" method="post" class="mt-3 text-center">
                            @csrf
                            <input type="hidden" name="email" value="{{ $emailVal }}">
                            <button type="submit" class="btn btn-link p-0 small">Resend code</button>
                        </form>

                        <div class="form-poicy-area mt-4 text-center">
                            <p class="mb-0"><a href="/login">Back to Login</a> &nbsp;|&nbsp; New Member? <a href="/register">Signup here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('.frontend.inc.footer')
