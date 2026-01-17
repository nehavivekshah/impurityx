@extends('backend.layout')
@section('title','Manage Communication Buyer & Seller - Impurity X')
@section('headlink')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Link Styles -->
<link rel="stylesheet" href="{{ asset('/assets/backend/css/style.css') }}">
@endsection
@section('content')
<section class="task__section">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom bg-white shadow-sm mb-3">
        <h5 class="fw-bold mb-0 text-dark">Management Panel</h5>
    
        <div class="d-flex align-items-center gap-3">
    
            <!-- Notification Icon -->
            <div class="position-relative">
                <a href="#" class="btn btn-light position-relative p-2 rounded-circle shadow-sm">
                    <i class="bx bx-bell fs-5 text-dark"></i>
                    <!--<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3+</span>-->
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
            <div class="col-md-12 rounded bg-white">
                <h1 class="h3 box-title pb-2">
                    <a href="/admin/communication-sellers" class="text-small mr-3" title="Back"><img src="{{ asset('/assets/backend/icons/back.svg'); }}" class="back-icon" /></a>
                    @if($_GET['p'] == 'buyer')
                        @if(count($getCom)=='0') 
                            New Communication With Sellers
                        @else
                            Edit Communication Seller Details
                        @endif
                    @else
                        @if(count($getCom)=='0') 
                            New Communication With Buyer 
                        @else
                            Edit Communication Buyer Details
                        @endif
                    @endif
                </h1><hr>
                <form action="/admin/manage-communication-sellers" method="POST" class="card-body row pb-3 px-3" enctype="multipart/form-data">
                    @csrf
                    <!-- Communication ID -->
                    <div class="col-md-6 mb-3">
                        <label for="communicationId" class="fw-bold">Communication ID:</label>
                        <input type="text" class="form-control" name="communicationId"
                               value="{{ $communicationId ?? 'AUTO-GEN' }}" readonly>
                    </div>

                    <!-- Order No -->
                    <div class="col-md-6 mb-3">
                        <label for="order_no" class="fw-bold">Order No #:</label>
                        <input type="text" class="form-control" name="orderNo" id="orderNo" />
                    </div>

                    <!-- CAS No -->
                    <div class="col-md-6 mb-3">
                        <label for="cas_no" class="fw-bold">CAS No:</label>
                        <input type="text" class="form-control" name="casNo" id="casNo" readonly>
                    </div>

                    <!-- Impurity Name -->
                    <div class="col-md-6 mb-3">
                        <label for="impurity_name" class="fw-bold">Impurity Name:</label>
                        <input type="text" class="form-control" name="impurityName" id="impurityName" readonly>
                    </div>
                    
                    <!-- Message Box -->
                    <div class="col-md-12 mb-3">
                        <label for="message" class="fw-bold">Message:</label>
                        <textarea class="form-control" name="message" id="message" rows="7"
                                  placeholder="Type your message here..." required></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Send</button>
                        <a href="{{ url()->previous() }}" class="btn btn-light border">Cancel</a>
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

<script>
    $(document).ready(function () {
        $('#orderNo').on('change', function () {
            let orderNo = $(this).val();
    
            if (orderNo.trim() !== '') {
                $.ajax({
                    url: `/admin/get-order-details/${orderNo}`,
                    type: 'GET',
                    success: function (res) {
                        if (res.status) {
                            $('#casNo').val(res.cas_no);
                            $('#impurityName').val(res.impurity_name);
                        } else {
                            $('#casNo').val('');
                            $('#impurityName').val('');
                            alert(res.message);
                        }
                    },
                    error: function () {
                        alert('Error fetching order details.');
                    }
                });
            }
        });
    });
</script>
@endsection