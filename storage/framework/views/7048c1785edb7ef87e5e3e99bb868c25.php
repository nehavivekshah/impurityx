<?php echo $__env->make('.frontend.seller.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    .offcanvas{ 
        z-index: 999999;
    }
    .offcanvas-start{
        width: 300px;
    }
    .navbar-toggler-icon{
        font-size: 28px;
    }
    @media(max-width:768px){
        .offcanvas-body{
            padding: 0px;
        }
    }
</style>
<div class="dashboard-section">
    <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-top">
    <img alt="image" src="/public/assets/frontend/images/bg/section-bg.png" class="img-fluid section-bg-bottom">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-2 bg-dashboard bg-dashboard-buyer rounded-0 d-none d-lg-block">
                <?php echo $__env->make('.frontend.seller.inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <button class="navbar-toggler d-lg-none text-start" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <i class="bx bx-menu navbar-toggler-icon"></i>
            </button>
            <div class="offcanvas offcanvas-start bg-dashboard-buyer" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- The actual sidebar content from your include -->
                    <?php echo $__env->make('.frontend.seller.inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="col-lg-10" style="min-height: 60vh;">
                <?php if($page == 'my-biddings'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.myBiddings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'my-orders'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.myOrders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'supports'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.communication-support', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'communication-buyers'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.communication-buyers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'bidding-status'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.bidding-status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'completed-orders'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.completed-orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'sales-report'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.sales-report', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'my-profile'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.myProfile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'my-notices'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.myNotices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'my-rewards'): ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.myRewards', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                    <?php echo $__env->make('.frontend.seller.inc.accounts.myAccount', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('.frontend.seller.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/frontend/seller/seller-dashboard.blade.php ENDPATH**/ ?>