@extends('backend.layout')
@section('title','Register - Impurity X')

@section('headlink')
<link href="{{ asset('/assets/backend/css/app.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                <div class="card login-card animated-card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="card-title">Welcome to Impurity X</h4>
                            <p class="card-subtitle text-muted">Create an Account</p>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST">
        
                            @csrf
        
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
        
                            <div class="form-group">
                                <div class="input-group @error('reg_name') is-invalid @enderror">
                                    <img src="{{ asset('/assets/backend/icons/user.svg') }}" class="input-icon" alt="Name Icon" />
                                    <input type="text" name="reg_name" class="form-control" placeholder="Enter your name" value="{{ old('reg_name') }}" required />
                                </div>
                                @error('reg_name')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <div class="input-group @error('reg_mob') is-invalid @enderror">
                                    <img src="{{ asset('/assets/backend/icons/mob.svg') }}" class="input-icon" alt="Mobile Icon" />
                                    <input type="text" name="reg_mob" class="form-control" placeholder="Enter your mobile no." value="{{ old('reg_mob') }}" required />
                                </div>
                                @error('reg_mob')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <div class="input-group @error('reg_email') is-invalid @enderror">
                                    <img src="{{ asset('/assets/backend/icons/email.svg') }}" class="input-icon" alt="Email Icon" />
                                    <input type="email" name="reg_email" class="form-control" placeholder="Enter your email" value="{{ old('reg_email') }}" required />
                                </div>
                                @error('reg_email')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <div class="input-group @error('reg_password') is-invalid @enderror">
                                    <img src="{{ asset('/assets/backend/icons/lock.svg') }}" class="input-icon" alt="Password Icon" />
                                    <input type="password" name="reg_password" class="form-control" placeholder="Password" required />
                                </div>
                                @error('reg_password')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
        
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-block w-100">Register</button>
                            </div>
        
                            <div class="form-group text-center mt-3 mb-0">
                                <small class="text-muted">Already have an account?</small><br>
                                <a class="text-primary font-weight-bold" href="{{ route('login') }}">Login Here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection