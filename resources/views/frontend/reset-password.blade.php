@include('.frontend.inc.header')
<body>
    <div class="login-section pt-120 pb-120">
        <div class="container">
            <div class="row d-flex justify-content-center g-4">
                <div class="col-xl-5 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>Reset Password</h3>
                            <p>Create your new password</p>
                        </div>

                        {{-- Flash + validation errors (optional) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form action="/reset-password/{{ $key }}" method="post" class="w-100">
                            @csrf
                            <input type="hidden" name="secretkey" value="{{ $key }}">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label style="padding:0px!important;">New Password*</label>
                                        <div class="position-relative">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required>
                                            <i class="bi bi-eye-slash toggle-password" data-target="#password"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label style="padding:0px!important;">Confirm Password*</label>
                                        <div class="position-relative">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                                            <i class="bi bi-eye-slash toggle-password" data-target="#password_confirmation"></i>
                                        </div>
                                        <small id="confirmFeedback" class="d-block mt-1" style="display:none"></small>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="account-btn mt-3 w-100">Reset Password</button>

                            <div class="form-poicy-area mt-4 text-center">
                                <p class="mb-0">Remembered it? <a href="/login">Back to Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password show/hide for both fields
        document.querySelectorAll('.toggle-password').forEach(function(icon){
            icon.addEventListener('click', function(){
                const input = document.querySelector(this.getAttribute('data-target'));
                if(!input) return;
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });
    
        // Real-time confirm password match
        const pw = document.getElementById('password');
        const pwc = document.getElementById('password_confirmation');
        const feedback = document.getElementById('confirmFeedback');
        const submitBtn = document.querySelector('button[type="submit"]');
    
        function validateMatch(){
            if(!pwc.value){
                feedback.style.display = 'none';
                pwc.classList.remove('is-valid','is-invalid');
                submitBtn.disabled = false; // allow submit if user hasn't started typing confirm yet
                return;
            }
            const match = pw.value === pwc.value;
            feedback.style.display = 'block';
            if(match){
                feedback.textContent = 'Passwords match';
                feedback.classList.remove('text-danger');
                feedback.classList.add('text-success');
                pwc.classList.add('is-valid');
                pwc.classList.remove('is-invalid');
                submitBtn.disabled = false;
            } else {
                feedback.textContent = 'Passwords do not match';
                feedback.classList.remove('text-success');
                feedback.classList.add('text-danger');
                pwc.classList.add('is-invalid');
                pwc.classList.remove('is-valid');
                submitBtn.disabled = true;
            }
        }
    
        if(pw && pwc){
            pw.addEventListener('input', validateMatch);
            pwc.addEventListener('input', validateMatch);
            // initial state
            validateMatch();
        }
    </script>

@include('.frontend.inc.footer')