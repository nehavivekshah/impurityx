@extends('backend.layout')
@section('title','Manage Profile - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Link Styles -->
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection
@section('content')
<section class="task__section">
    <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom bg-white shadow-sm mb-3">
        <h5 class="fw-bold mb-0 text-dark">Dashboard</h5>
    
        <div class="d-flex align-items-center gap-3">
    
            <!-- Notification Icon -->
            <div class="position-relative">
                <a href="#" class="btn btn-light position-relative p-2 rounded-circle shadow-sm">
                    <i class="bx bx-bell fs-5 text-dark"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3+</span>
                </a>
            </div>
    
            <!-- User Dropdown -->
            <div class="dropdown">
                <a href="javascript:void(0)" class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 position-relative" data-bs-toggle="dropdown">
                    <i class="bx bx-user fs-5"></i> {{ Auth::user()->first_name }}
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-white rounded-circle"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border right-menu">
                    <li><a class="dropdown-item" href="/admin/profile"><i class="bx bx-user me-2"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href="/admin/reset-password"><i class="bx bx-reset me-2"></i> Reset Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/admin/logout"><i class="bx bx-log-out me-2"></i> Logout</a></li>
                </ul>
            </div>
    
        </div>
    </div>
    <div class="scrum-board-container">
        <div class="flex justify-content-center">
            <div class="col-md-4 rounded bg-white mb-3">
                <h1 class="h3 box-title pb-2">Manage Profile</h1><hr>
                <form action="{{ route('manageProfile') }}" method="POST" class="row card-body pb-3 px-3">
                    @csrf
                    <div class="form-group col-md-12">
                        <label class="small">Name*</label><br>
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/user.svg'); }}" class="input-icon" />
                            <input type="text" name="mp_name" class="form-control" autocomplete="off" placeholder="Enter your name" value="{{ $profiles[0]->first_name ?? '' }} {{ $profiles[0]->last_name ?? '' }}" required />
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="small">Mobile No.*</label><br>
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/mob.svg'); }}" class="input-icon" />
                            <input type="text" name="mp_mob" class="form-control" placeholder="Enter your mobile no." value="{{ $profiles[0]->mob ?? '' }}" required />
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="small">Email Id*</label><br>
                        <div class="input-group">
                            <img src="{{ asset('/assets/backend/icons/email.svg'); }}" class="input-icon" />
                            <input type="email" name="mp_email" class="form-control" placeholder="Enter your email id" value="{{ $profiles[0]->email ?? '' }}" required />
                        </div>
                    </div>
                    <div class="form-group text-center mt-1 mb-0">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-light border">Reset</button>
                    </div>
                </form>
            <div>
        </div>
    </div>
</section>
@endsection
@section('footlink')
<!-- Scripts -->
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
@endsection