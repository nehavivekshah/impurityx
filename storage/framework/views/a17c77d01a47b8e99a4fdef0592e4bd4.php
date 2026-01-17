<?php echo $__env->make('.frontend.inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                <?php echo $__env->make('.frontend.inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                    <?php echo $__env->make('.frontend.inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="col-lg-10" style="min-height: 60vh; margin-top:0px;">
                <?php if($page == 'my-orders'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.myOrders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'supports'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.communication-support', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'communication-sellers'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.communication-sellers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'request-order'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.buyer-requesting-quote', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'delivery-acceptance'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.delivery-acceptance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'process-orders'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.process-orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'completed-orders'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.completed-orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'all-orders'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.all-orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'purchase-report'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.purchase-report', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'my-profile'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.myProfile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'my-notices'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.myNotices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($page == 'my-rewards'): ?>
                <?php echo $__env->make('.frontend.inc.accounts.myRewards', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                <?php echo $__env->make('.frontend.inc.accounts.myAccount', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('.frontend.inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/frontend/buyer-dashboard.blade.php ENDPATH**/ ?>