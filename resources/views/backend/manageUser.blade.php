@extends('backend.layout')
@section('title','Manage User - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection

@section('content')
<section class="task__section">
    <div class="scrum-board-container">
        <div class="flex justify-content-center">
            <div class="col-md-6 rounded bg-white mb-3">
                <h1 class="h3 box-title pb-2">
                    <a href="/admin/users" class="text-small mr-3" title="Back">
                        <img src="{{ asset('/assets/backend/icons/back.svg') }}" class="back-icon" />
                    </a>
                    @if(!empty($user)) Edit User @else Add New User @endif
                </h1>
                <hr>

                <form action="{{ route('manageUser') }}" method="POST" class="row card-body pt-3 pb-4 px-4">
                    @csrf
                    @if(!empty($user))
                        <input type="hidden" name="id" value="{{ $user->id }}">
                    @endif

                    <!-- Basic User Details -->
                    <div class="form-group col-md-6">
                        <label class="small">First Name*</label>
                        <input type="text" name="first_name" class="form-control"
                            value="{{ $user->first_name ?? '' }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">Last Name*</label>
                        <input type="text" name="last_name" class="form-control"
                            value="{{ $user->last_name ?? '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">Mobile*</label>
                        <input type="text" name="mob" class="form-control"
                            value="{{ $user->mob ?? '' }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">WhatsApp</label>
                        <input type="text" name="whatsapp" class="form-control"
                            value="{{ $user->whatsapp ?? '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">Email*</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ $user->email ?? '' }}" required>
                    </div>

                    <!--<div class="form-group col-md-6">
                        <label class="small">Password @if(empty($user)) * @endif</label>
                        <input type="password" name="password" class="form-control"
                            @if(empty($user)) required @endif>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">Date of Birth</label>
                        <input type="date" name="dob" class="form-control"
                            value="{{ $user->dob ?? '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select</option>
                            <option value="Male" @if(($user->gender ?? '')=='Male') selected @endif>Male</option>
                            <option value="Female" @if(($user->gender ?? '')=='Female') selected @endif>Female</option>
                            <option value="Other" @if(($user->gender ?? '')=='Other') selected @endif>Other</option>
                        </select>
                    </div>-->

                    <div class="form-group col-md-6">
                        <label class="small">Role*</label>
                        <select name="role" class="form-control" required>
                            <option value="">Select Role</option>
                            <option value="1" @if(($user->role ?? '')=='1') selected @endif>Admin</option>
                            <option value="2" @if(($user->role ?? '')=='2') selected @endif>Manager</option>
                            <option value="3" @if(($user->role ?? '')=='3') selected @endif>Agent</option>
                            <option value="4" @if(($user->role ?? '')=='4') selected @endif>Seller</option>
                            <option value="5" @if(($user->role ?? '')=='5') selected @endif>Buyer</option>
                        </select>
                    </div>

                    <!-- User Meta Details -->
                    <div class="col-12 m-0 pt-2 pb-0">
                        <h5 class="font-weight-bold sub-title-3">Additional Details</h5>
                    </div>

                    <input type="hidden" name="umid" value="{{ $meta->id ?? '' }}">

                    <div class="form-group col-md-6">
                        <label class="small">Company</label>
                        <input type="text" name="company" class="form-control"
                            value="{{ $meta->company ?? '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">Trade</label>
                        <input type="text" name="trade" class="form-control"
                            value="{{ $meta->trade ?? '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">PAN No.</label>
                        <input type="text" name="panno" class="form-control"
                            value="{{ $meta->panno ?? '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">VAT No.</label>
                        <input type="text" name="vat" class="form-control"
                            value="{{ $meta->vat ?? '' }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label class="small">Registered Address</label>
                        <textarea name="regAddress" class="form-control">{{ $meta->regAddress ?? '' }}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="small">Communication Address</label>
                        <textarea name="comAddress" class="form-control">{{ $meta->comAddress ?? '' }}</textarea>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="small">City</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ $meta->city ?? '' }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="small">State</label>
                        <input type="text" name="state" class="form-control"
                            value="{{ $meta->state ?? '' }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="small">Pincode</label>
                        <input type="text" name="pincode" class="form-control"
                            value="{{ $meta->pincode ?? '' }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small">Country</label>
                        <input type="text" name="country" class="form-control"
                            value="{{ $meta->country ?? '' }}">
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label class="small">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" @if(($user->status ?? '')=='1') selected @endif>Active</option>
                            <option value="0" @if(($user->status ?? '')=='0') selected @endif>Inactive</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="form-group text-center mt-3 mb-0 col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-light border">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footlink')
<script src="{{ asset('/assets/backend/js/script.js') }}"></script>
@endsection