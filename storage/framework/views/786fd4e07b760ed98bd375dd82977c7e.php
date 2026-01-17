<?php
    $user = session('users');
    $user = \App\Models\User::find($user->id);
    $notify = $user->notify ? json_decode($user->notify, true) : [];
?>
<div class="nav flex-column nav-pills gap-1 wow fadeInUp">

    <!-- Dashboard -->
    <a href="/seller/my-account/dashboard" class="nav-link nav-btn-style mx-auto mb-20 <?php echo e(request()->is('seller/my-account/dashboard') ? 'active' : ''); ?>"><span><i class='bx bxs-dashboard me-2'></i> Dashboard</span></a>

    <!-- Dropdown -->
    <div class="nav-item">
        <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#actionTaskMenu" role="button" aria-expanded="false" aria-controls="actionTaskMenu">
            <i class='bx bxs-check-square me-2'></i> Action Task
            <i class='bx bx-chevron-down ms-auto'></i>
        </a>
    
        <!-- Collapsible Menu Items -->
        <div class="collapse <?php echo e(collect(['seller/my-account/my-biddings*', 'seller/my-account/my-orders*', 'seller/my-account/supports*', 'seller/my-account/communication-buyers*', 'seller/my-account/delivery-acceptance*'])->contains(fn($route) => request()->is($route)) ? 'show' : ''); ?> mt-1 ms-3" id="actionTaskMenu">
            <ul class="list-unstyled">
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center <?php echo e(request()->is('seller/my-account/my-biddings') ? 'active' : ''); ?>" href="/seller/my-account/my-biddings">
                        <i class='fas fa-gavel fa-flip-horizontal me-2'></i> My Offers
                    </a>
                </li>
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center <?php echo e(request()->is('seller/my-account/my-orders') ? 'active' : ''); ?>" href="/seller/my-account/my-orders">
                        <i class='bx bx-package me-2'></i> Manage Orders
                    </a>
                </li>
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center <?php echo e(request()->is('seller/my-account/supports') ? 'active' : ''); ?>" href="/seller/my-account/supports">
                        <i class='bx bx-support me-2'></i> Communicate with Support
                    </a>
                </li>
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center <?php echo e(request()->is('seller/my-account/communication-buyers') ? 'active' : ''); ?>" href="/seller/my-account/communication-buyers">
                        <i class='bx bx-support me-2'></i> Communicate with Buyers
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
    
        <div class="collapse <?php echo e(collect(['seller/my-account/bidding-status*', 'seller/my-account/completed-orders*', 'seller/my-account/sales-report*'])->contains(fn($route) => request()->is($route)) ? 'show' : ''); ?> mt-1 ms-3" id="reportsMenu">
            <ul class="list-unstyled">
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center <?php echo e(request()->is('seller/my-account/bidding-status') ? 'active' : ''); ?>" href="/seller/my-account/bidding-status">
                        <i class='bx bx-loader me-2'></i> Bidding Status
                    </a>
                </li>
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center <?php echo e(request()->is('seller/my-account/completed-orders') ? 'active' : ''); ?>" href="/seller/my-account/completed-orders">
                        <i class='bx bx-check-circle me-2'></i> Completed Orders
                    </a>
                </li>
    
                <li class="">
                    <a class="text-decoration-none d-flex align-items-center <?php echo e(request()->is('seller/my-account/sales-report') ? 'active' : ''); ?>" href="/seller/my-account/sales-report">
                        <i class='bx bx-file me-2'></i> My sales Report
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- My Profile -->
    <a href="/seller/my-account/my-profile" class="nav-link nav-btn-style mx-auto mb-20"><span><i class='bx bxs-user me-2'></i> My Profile</span></a>

    <!-- My Notices -->
    <a href="/seller/my-account/my-notices" class="nav-link nav-btn-style mx-auto mb-20">
        <span><i class='bx bxs-bell me-2'></i> My Notices</span> 
        <?php if(isset($notify['notice']) && $notify['notice'] == 1): ?><i class='fas fa-circle' style="color:#ff0018!important;"></i><?php endif; ?>
    </a>

    <!-- My Rewards -->
    <!--<a href="/seller/my-account/my-rewards" class="nav-link nav-btn-style mx-auto mb-20"><span><i class='bx bxs-gift me-2'></i> My Rewards</span></a>-->

    <!-- Logout -->
    <a href="/seller/logout" class="nav-link nav-btn-style mx-auto"><span><i class='bx bxs-log-out me-2'></i> Logout</span></a>
</div><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/seller/inc/sidebar.blade.php ENDPATH**/ ?>