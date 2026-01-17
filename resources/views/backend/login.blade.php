@extends('backend.layout')
@section('title','Login - Impurity X')

<?php if(Auth::check()){ Auth::logout(); } ?>

@section('headlink')
<link href="{{ asset('/assets/backend/css/app.css'); }}" rel="stylesheet" />
@endsection

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                <div class="card login-card animated-card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="card-title">Welcome Back!</h4>
                            <p class="card-subtitle text-muted">Login to continue to Impurity X</p>
                        </div>

                        <form action="/admin/login" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="input-group @error('email') is-invalid @enderror">
                                    <img src="{{ asset('/assets/backend/icons/email.svg'); }}" class="input-icon" alt="Email Icon" />
                                    {{-- Use 'email' as name for default Laravel auth --}}
                                    <input type="email" name="login_email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus />
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group @error('password') is-invalid @enderror">
                                    <img src="{{ asset('/assets/backend/icons/lock.svg'); }}" class="input-icon" alt="Password Icon" />
                                    <input type="password" name="login_password" class="form-control" placeholder="Password" required autocomplete="current-password" />
                                </div>
                                 @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="login_remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="small-link" href="{{ route('password.request') }}">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-block w-100">Login</button>
                            </div>

                            <!--<div class="form-group text-center mt-4 mb-0">
                                <span class="text-muted">Don't have an account?</span>
                                <a class="font-weight-bold" href="{{ route('register') }}">Sign Up</a>
                            </div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection