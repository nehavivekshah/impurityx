@include('.frontend.seller.inc.header')
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
                @include('.frontend.seller.inc.sidebar')
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
                    @include('.frontend.seller.inc.sidebar')
                </div>
            </div>
            <div class="col-lg-10" style="min-height: 60vh;">
                @if($page == 'my-biddings')
                    @include('.frontend.seller.inc.accounts.myBiddings')
                @elseif($page == 'my-orders')
                    @include('.frontend.seller.inc.accounts.myOrders')
                @elseif($page == 'supports')
                    @include('.frontend.seller.inc.accounts.communication-support')
                @elseif($page == 'communication-buyers')
                    @include('.frontend.seller.inc.accounts.communication-buyers')
                @elseif($page == 'bidding-status')
                    @include('.frontend.seller.inc.accounts.bidding-status')
                @elseif($page == 'completed-orders')
                    @include('.frontend.seller.inc.accounts.completed-orders')
                @elseif($page == 'sales-report')
                    @include('.frontend.seller.inc.accounts.sales-report')
                @elseif($page == 'my-profile')
                    @include('.frontend.seller.inc.accounts.myProfile')
                @elseif($page == 'my-notices')
                    @include('.frontend.seller.inc.accounts.myNotices')
                @elseif($page == 'my-rewards')
                    @include('.frontend.seller.inc.accounts.myRewards')
                @else
                    @include('.frontend.seller.inc.accounts.myAccount')
                @endif
            </div>
        </div>
    </div>
</div>
@include('.frontend.seller.inc.footer')