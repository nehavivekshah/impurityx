@php
    $user = session('users');
    $user = \App\Models\User::find($user->id);
    $notify = $user->notify ? json_decode($user->notify, true) : [];
@endphp
<div class="nav flex-column nav-pills gap-1 wow fadeInUp">

    <!-- Dashboard -->
    <a href="/my-account/dashboard" class="nav-link nav-btn-style mx-auto mb-20 {{ request()->is('my-account/dashboard') ? 'active' : '' }}"><span><i class='bx bxs-dashboard me-2'></i> Dashboard</span></a>

    <!-- Dropdown -->
    <div class="nav-item">
        <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#actionTaskMenu" role="button" aria-expanded="false" aria-controls="actionTaskMenu">
            <i class='bx bxs-check-square me-2'></i> Action Task
            <i class='bx bx-chevron-down ms-auto'></i>
        </a>
    
        <!-- Collapsible Menu Items -->
        <div class="collapse {{ collect(['my-account/my-orders*', 'my-account/supports*', 'my-account/communication-sellers*', 'my-account/request-order*', 'my-account/delivery-acceptance*'])->contains(fn($route) => request()->is($route)) ? 'show' : '' }} mt-1 ms-3" id="actionTaskMenu">
            <ul class="list-unstyled">
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/my-orders') ? 'active' : '' }}" href="/my-account/my-orders">
                        <i class='bx bx-play-circle me-2'></i> My Orders
                    </a>
                </li>
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/supports') ? 'active' : '' }}" href="/my-account/supports">
                        <i class='bx bx-support me-2'></i> Communicate with Support
                    </a>
                </li>
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/communication-sellers') ? 'active' : '' }}" href="/my-account/communication-sellers">
                        <i class='bx bx-support me-2'></i> Communicate with Sellers
                    </a>
                </li>
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/request-order') ? 'active' : '' }}" href="/my-account/request-order">
                        <i class='bx bx-plus-circle me-2'></i> Request Product Addition
                    </a>
                </li>
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/delivery-acceptance') ? 'active' : '' }}" href="/my-account/delivery-acceptance">
                        <i class='bx bx-package me-2'></i> Delivery Acceptance
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Reports Collapse Menu -->
    <div class="nav-item">
        <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#reportsMenu" role="button" aria-expanded="false" aria-controls="reportsMenu">
            <i class='bx bxs-report me-2'></i> Reports
            <i class='bx bx-chevron-down ms-auto'></i>
        </a>
    
        <div class="collapse {{ collect(['my-account/process-orders*', 'my-account/completed-orders*', 'my-account/all-orders*', 'my-account/purchase-report*'])->contains(fn($route) => request()->is($route)) ? 'show' : '' }} mt-1 ms-3" id="reportsMenu">
            <ul class="list-unstyled">
                <!--<li class="">
                    <a class="text-decoration-none d-flex align-items-center" data-bs-toggle="pill" href="/my-account/initiated-biddings">
                        <i class='bx bx-loader-circle me-2'></i> Initiated Bid Status
                    </a>
                </li>
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center" data-bs-toggle="pill" href="/my-account/active-biddings">
                        <i class='bx bx-play-circle me-2'></i> Active Bidding Status
                    </a>
                </li>
    
                <li class=>
                    <a class="text-decoration-none d-flex align-items-center" data-bs-toggle="pill" href="/my-account/final-biddings">
                        <i class='bx bx-flag-checkered me-2'></i> Final Bidding Status
                    </a>
                </li>
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center" data-bs-toggle="pill" href="/my-account/confirm-orders">
                        <i class='bx bx-badge-check me-2'></i> Order Confirm / Awarded
                    </a>
                </li>-->
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/process-orders') ? 'active' : '' }}" href="/my-account/process-orders">
                        <i class='bx bx-loader me-2'></i> In Process Orders
                    </a>
                </li>
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/completed-orders') ? 'active' : '' }}" href="/my-account/completed-orders">
                        <i class='bx bx-check-circle me-2'></i> Completed Orders
                    </a>
                </li>
    
                <!--<li class="">
                    <a class="text-decoration-none d-flex align-items-center" data-bs-toggle="pill" href="/my-account/terminated-orders">
                        <i class='bx bx-block me-2'></i> Terminated Orders
                    </a>
                </li>
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center" data-bs-toggle="pill" href="/my-account/cancelled-orders">
                        <i class='bx bx-x-circle me-2'></i> Cancelled Orders
                    </a>
                </li>-->
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/all-orders') ? 'active' : '' }}" href="/my-account/all-orders">
                        <i class='bx bx-list-ul me-2'></i> All Orders
                    </a>
                </li>
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center {{ request()->is('my-account/purchase-report') ? 'active' : '' }}" href="/my-account/purchase-report">
                        <i class='bx bx-file me-2'></i> Purchase Report
                    </a>
                </li>
    
                <!--<li class="">
                    <a class="text-decoration-none d-flex align-items-center" data-bs-toggle="pill" href="/my-account/logs-eller">
                        <i class='bx bx-message-dots me-2'></i> Comm Log with Seller
                    </a>
                </li>
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center" data-bs-toggle="pill" href="/my-account/communication-support">
                        <i class='bx bx-headphone me-2'></i> Comm Log with Support
                    </a>
                </li>-->
            </ul>
        </div>
    </div>

    <!-- My Profile -->
    <a href="/my-account/my-profile" class="nav-link nav-btn-style mx-auto mb-20 {{ request()->is('my-account/my-profile') ? 'active' : '' }}"><span><i class='bx bxs-user me-2'></i> My Profile</span></a>

    <!-- My Notices -->
    <a href="/my-account/my-notices" class="nav-link nav-btn-style mx-auto mb-20">
        <span><i class='bx bxs-bell me-2'></i> My Notices</span> 
        @if(isset($notify['notice']) && $notify['notice'] == 1)<i class='fas fa-circle' style="color:#ff0018!important;"></i>@endif
    </a>

    <!-- My Rewards -->
    <!--<a href="/my-account/my-rewards" class="nav-link nav-btn-style mx-auto mb-20"><span><i class='bx bxs-gift me-2'></i> My Rewards</span></a>-->

    <!-- Logout -->
    <a href="/logout" class="nav-link nav-btn-style mx-auto"><span><i class='bx bxs-log-out me-2'></i> Logout</span></a>
</div>