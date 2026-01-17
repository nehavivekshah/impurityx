@php
    $settings = session('settings');
    $access = explode(',', $settings[0]->access ?? '');
    $actions = explode(',', $settings[0]->actions ?? '');
@endphp
<div class="sidebar open desktop">
    <div class="logo_details" style="height: 100px;">
        <!--<div class="logo_name">ImpurityX</div>-->
        <img src="/assets/frontend/images/logo.png" style="width:65%;margin:auto;padding-bottom:5px;" />
        <!--<i class="bx bx-menu-alt-right" id="btn"></i>-->
    </div>
    
    <ul class="nav-list" id="accordion">
        <li>
            <a href="/admin/" class="{{ request()->is('admin') ? 'active' : '' }}">
                <i class="bx bx-home-alt"></i>
                <span class="link_name">Overview</span>
            </a>
            <span class="tooltip">Overview</span>
        </li>
        @if(Auth::user()->role == '1' || in_array('1', $access))
        <li>
            <hr>
            <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#blogs">
                Blogs Management <i class="bx bx-chevron-down"></i>
            </span>
            <div id="blogs" class="collapse {{ collect(['admin/posts*', 'admin/post-categories*', 'admin/manage-post-category*', 'admin/manage-post*'])->contains(fn($route) => request()->is($route)) ? 'show' : '' }}" data-bs-parent="#accordion">
                <ul class="p-0">
                    @if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('1', $actions)))
                    <li>
                        <a href="/admin/manage-post" class="{{ (request()->is('admin/manage-post') && empty($_GET['id'])) ? 'active' : '' }}">
                            <i class="bx bx-plus"></i>
                            <span class="link_name">New Post</span>
                        </a>
                        <span class="tooltip">New Post</span>
                    </li>
                    @endif
                    <li>
                        <a href="/admin/posts" class="{{ (request()->is('admin/posts*') || (request()->is('admin/manage-post') && !empty($_GET['id']))) ? 'active' : '' }}">
                            <i class="bx bx-layer"></i>
                            <span class="link_name">All Posts</span>
                        </a>
                        <span class="tooltip">All Posts</span>
                    </li>
                    <li>
                        <a href="/admin/post-categories" class="{{ (request()->is('admin/post-categories*') || request()->is('admin/manage-post-category*')) ? 'active' : '' }}">
                            <i class="bx bx-layer"></i>
                            <span class="link_name">Categories</span>
                        </a>
                        <span class="tooltip">Categories</span>
                    </li>
                </ul>
            </div>
        </li>
        @endif
        @if(Auth::user()->role == '1' || in_array('2', $access))
        <li><hr>
            <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#ump">Users Management <i class="bx bx-chevron-down"></i></span>
            <div id="ump" class="collapse {{ request()->is('admin/user*', 'admin/seller*', 'admin/buyer*', 'admin/admin*', 'admin/manage-user*') ? 'show' : '' }}" data-bs-parent="#accordion">
                <ul class="p-0">
                    <li>
                        <a href="/admin/users" class="{{ request()->is('admin/user*', 'admin/manage-user*') ? 'active' : '' }}">
                            <i class="bx bx-group"></i>
                            <span class="link_name">All Users</span>
                        </a>
                        <span class="tooltip">All Users</span>
                    </li>
                    <li>
                        <a href="/admin/sellers" class="{{ request()->is('admin/seller*') ? 'active' : '' }}">
                            <i class="bx bxs-user"></i>
                            <span class="link_name">Sellers</span>
                        </a>
                        <span class="tooltip">Sellers</span>
                    </li>
                    <li>
                        <a href="/admin/buyers" class="{{ request()->is('admin/buyer*') ? 'active' : '' }}">
                            <i class="bx bx-user"></i>
                            <span class="link_name">Buyers</span>
                        </a>
                        <span class="tooltip">Buyers</span>
                    </li>
                    <!--<li>
                        <a href="/admin/admin" class="{{ request()->is('admin/admin*') ? 'active' : '' }}">
                            <i class="bx bx-user"></i>
                            <span class="link_name">Admin</span>
                        </a>
                        <span class="tooltip">Admin</span>
                    </li>-->
                </ul>
            </div>
        </li>
        @endif
        @if(Auth::user()->role == '1' || in_array('3', $access))
        <li><hr>
            <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#cmp">Products Management <i class="bx bx-chevron-down"></i></span>
            <div id="cmp" class="collapse {{ request()->is('admin/product*', 'admin/request-product-addition*', 'admin/manage-product*', 'admin/categories*', 'admin/manage-category*') ? 'show' : '' }}" data-bs-parent="#accordion">
                <ul class="p-0">
                    @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('1', $actions)))
                    <li>
                        <a href="/admin/manage-product" class="{{ request()->is('admin/manage-product*') ? 'active' : '' }}">
                            <i class="bx bx-plus"></i>
                            <span class="link_name">New Product</span>
                        </a>
                        <span class="tooltip">New Product</span>
                    </li>
                    @endif
                    <li>
                        <a href="/admin/products" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                            <i class="bx bx-layer"></i>
                            <span class="link_name">All Products</span>
                        </a>
                        <span class="tooltip">All Products</span>
                    </li>
                    <li>
                        <a href="/admin/request-product-addition" class="{{ request()->is('admin/request-product-addition*') ? 'active' : '' }}">
                            <i class="bx bx-layer"></i>
                            <span class="link_name">Req. Product Addition</span>
                        </a>
                        <span class="tooltip">Req. Product Addition</span>
                    </li>
                    <li>
                        <a href="/admin/categories" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                            <i class="bx bx-layer"></i>
                            <span class="link_name">Categories</span>
                        </a>
                        <span class="tooltip">Categories</span>
                    </li>
                    <!--<li>
                        <a href="/admin/colors" class="{{ request()->is('admin/colors*') ? 'active' : '' }}">
                            <i class="bx bx-layer"></i>
                            <span class="link_name">Colors</span>
                        </a>
                        <span class="tooltip">Colors</span>
                    </li>
                    <li>
                        <a href="/admin/sizes" class="{{ request()->is('admin/sizes*') ? 'active' : '' }}">
                            <i class="bx bx-layer"></i>
                            <span class="link_name">Sizes</span>
                        </a>
                        <span class="tooltip">Sizes</span>
                    </li>-->
                </ul>
            </div>
        </li>
        @endif
        @if(Auth::user()->role == '1' || in_array('4', $access))
        <li><hr>
            <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#bmp">Orders Management <i class="bx bx-chevron-down"></i></span>
            <div id="bmp" class="collapse {{ request()->is('admin/order*','admin/biddings*') ? 'show' : '' }}" data-bs-parent="#accordion">
                <ul class="p-0">
                    <li>
                        <a href="/admin/orders" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                            <i class="bx bx-calendar-check"></i>
                            <span class="link_name">Buyer Orders</span>
                        </a>
                        <span class="tooltip">Buyer Orders</span>
                    </li>
                    <li>
                        <a href="/admin/biddings" class="{{ request()->is('admin/biddings*') ? 'active' : '' }}">
                            <i class="bx bx-book"></i>
                            <span class="link_name">Seller biddings</span>
                        </a>
                        <span class="tooltip">Seller biddings</span>
                    </li>
                </ul>
            </div>
        </li>
        @endif
        @if(Auth::user()->role == '1' || in_array('5', $access))
        <li><hr>
            <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#supports">Supports Management <i class="bx bx-chevron-down"></i></span>
            <div id="supports" class="collapse {{ request()->is('admin/notices*','admin/supports*','admin/communication-sellers*','admin/manage-communication-sellers*') ? 'show' : '' }}" data-bs-parent="#accordion">
                <ul class="p-0">
                    <li>
                        <a href="/admin/notices" class="{{ request()->is('admin/notices*') ? 'active' : '' }}">
                            <i class="bx bx-pin"></i>
                            <span class="link_name">Notices</span>
                        </a>
                        <span class="tooltip">Notices</span>
                    </li>
                    <li>
                        <a href="/admin/supports" class="{{ request()->is('admin/supports*') ? 'active' : '' }}">
                            <i class="bx bx-support"></i>
                            <span class="link_name">Comm. with Support</span>
                        </a>
                        <span class="tooltip">Comm. with Support</span>
                    </li>
                    <li>
                        <a href="/admin/communication-sellers" class="{{ request()->is('admin/communication-sellers*','admin/manage-communication-sellers*') ? 'active' : '' }}">
                            <i class="bx bx-support"></i>
                            <span class="link_name">Comm b/w B and S</span>
                        </a>
                        <span class="tooltip">Comm. b/w B and S</span>
                    </li>
                </ul>
            </div>
        </li>
        @endif
        @if(Auth::user()->role == '1' || in_array('6', $access))
        <li><hr>
            <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#pms">Page Management <i class="bx bx-chevron-down"></i></span>
            <div id="pms" class="collapse {{ request()->is('admin/slider*', 'admin/gallerie*', 'admin/review*', 'admin/page*') ? 'show' : '' }}" data-bs-parent="#accordion">
                <ul class="p-0">
                    <li><a href="/admin/sliders" class="{{ request()->is('admin/slider*') ? 'active' : '' }}"><i class="bx bx-image"></i><span class="link_name">Sliders</span></a><span class="tooltip">Sliders</span></li>
                    <!--<li><a href="/admin/galleries" class="{{ request()->is('admin/gallerie*') ? 'active' : '' }}"><i class="bx bx-images"></i><span class="link_name">Gallery</span></a><span class="tooltip">Gallery</span></li>
                    <li><a href="/admin/reviews" class="{{ request()->is('admin/review*') ? 'active' : '' }}"><i class="bx bx-star"></i><span class="link_name">Reviews</span></a><span class="tooltip">Reviews</span></li>-->
                    <li><a href="/admin/pages" class="{{ request()->is('admin/page*') ? 'active' : '' }}"><i class="bx bx-globe"></i><span class="link_name">Pages</span></a><span class="tooltip">Pages</span></li>
                </ul>
            </div>
        </li>
        @endif
        @if(Auth::user()->role == '1' || in_array('7', $access))
        <li><hr>
            <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#psmp">Settings Management <i class="bx bx-chevron-down"></i></span>
            <div id="psmp" class="collapse {{ request()->is('admin/notification*', 'admin/permission*', 'admin/manage-permission*') ? 'show' : '' }}" data-bs-parent="#accordion">
                <ul class="p-0">
                    <!--<li><a href="/admin/notifications" class="{{ request()->is('admin/notification*') ? 'active' : '' }}"><i class="bx bx-bell"></i><span class="link_name">Notification</span></a><span class="tooltip">Notification</span></li>-->
                    <li><a href="/admin/permissions" class="{{ request()->is('admin/permission*', 'admin/manage-permission*') ? 'active' : '' }}"><i class="bx bx-lock"></i><span class="link_name">Permission</span></a><span class="tooltip">Permission</span></li>
                </ul>
            </div>
        </li>
        @endif

        <li class="profile">
            <div class="profile_details">
                <img src="{{ asset('/assets/backend/icons/user.svg') }}" alt="profile image">
                <div class="profile_content">
                    <div class="name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                    @if(Auth::user()->role=='1')
                    <div class="designation">Admin</div>
                    @endif
                </div>
            </div>
            <form action="/admin/logout" method="get">
                @csrf
                <button type="submit" class="logout-button" title="Logout">
                    <i class="bx bx-log-out" id="log_out"></i>
                </button>
            </form>
        </li>
    </ul>
</div>

<div class="mobile-sidebar mobile" id="mob-menu">
    <div class="container-fluid">
        <div class="mobile-logo">
            <i class="bx bx-menu-alt-right" id="mbtn"></i>
            <div class="mobile_logo_name">Impurity X</div>
        </div>
        <ul class="nav-list">
            @if(Auth::user()->role == '1' || in_array('1', $access))
            <li>
                <hr>
                <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#blogs">
                    Blogs Management <i class="bx bx-chevron-down"></i>
                </span>
                <div id="blogs" class="collapse {{ collect(['admin/posts*', 'admin/post-categories*', 'admin/manage-post-category*', 'admin/manage-post*'])->contains(fn($route) => request()->is($route)) ? 'show' : '' }}" data-bs-parent="#accordion">
                    <ul class="p-0">
                        @if(Auth::user()->role == '1' || (in_array('1', $access) && in_array('1', $actions)))
                        <li>
                            <a href="/admin/manage-post" class="{{ (request()->is('admin/manage-post') && empty($_GET['id'])) ? 'active' : '' }}">
                                <i class="bx bx-plus"></i>
                                <span class="link_name">New Post</span>
                            </a>
                            <span class="tooltip">New Post</span>
                        </li>
                        @endif
                        <li>
                            <a href="/admin/posts" class="{{ (request()->is('admin/posts*') || (request()->is('admin/manage-post') && !empty($_GET['id']))) ? 'active' : '' }}">
                                <i class="bx bx-layer"></i>
                                <span class="link_name">All Posts</span>
                            </a>
                            <span class="tooltip">All Posts</span>
                        </li>
                        <li>
                            <a href="/admin/post-categories" class="{{ (request()->is('admin/post-categories*') || request()->is('admin/manage-post-category*')) ? 'active' : '' }}">
                                <i class="bx bx-layer"></i>
                                <span class="link_name">Categories</span>
                            </a>
                            <span class="tooltip">Categories</span>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->role == '1' || in_array('2', $access))
            <li><hr>
                <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#ump">Users Management <i class="bx bx-chevron-down"></i></span>
                <div id="ump" class="collapse {{ request()->is('admin/user*', 'admin/seller*', 'admin/buyer*', 'admin/admin*', 'admin/manage-user*') ? 'show' : '' }}" data-bs-parent="#accordion">
                    <ul class="p-0">
                        <li>
                            <a href="/admin/users" class="{{ request()->is('admin/user*', 'admin/manage-user*') ? 'active' : '' }}">
                                <i class="bx bx-group"></i>
                                <span class="link_name">All Users</span>
                            </a>
                            <span class="tooltip">All Users</span>
                        </li>
                        <li>
                            <a href="/admin/sellers" class="{{ request()->is('admin/seller*') ? 'active' : '' }}">
                                <i class="bx bxs-user"></i>
                                <span class="link_name">Sellers</span>
                            </a>
                            <span class="tooltip">Sellers</span>
                        </li>
                        <li>
                            <a href="/admin/buyers" class="{{ request()->is('admin/buyer*') ? 'active' : '' }}">
                                <i class="bx bx-user"></i>
                                <span class="link_name">Buyers</span>
                            </a>
                            <span class="tooltip">Buyers</span>
                        </li>
                        <!--<li>
                            <a href="/admin/admin" class="{{ request()->is('admin/admin*') ? 'active' : '' }}">
                                <i class="bx bx-user"></i>
                                <span class="link_name">Admin</span>
                            </a>
                            <span class="tooltip">Admin</span>
                        </li>-->
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->role == '1' || in_array('3', $access))
            <li><hr>
                <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#cmp">Products Management <i class="bx bx-chevron-down"></i></span>
                <div id="cmp" class="collapse {{ request()->is('admin/product*', 'admin/request-product-addition*', 'admin/manage-product*', 'admin/categories*', 'admin/manage-category*') ? 'show' : '' }}" data-bs-parent="#accordion">
                    <ul class="p-0">
                        @if(Auth::user()->role == '1' || (in_array('3', $access) && in_array('1', $actions)))
                        <li>
                            <a href="/admin/manage-product" class="{{ request()->is('admin/manage-product*') ? 'active' : '' }}">
                                <i class="bx bx-plus"></i>
                                <span class="link_name">New Product</span>
                            </a>
                            <span class="tooltip">New Product</span>
                        </li>
                        @endif
                        <li>
                            <a href="/admin/products" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                                <i class="bx bx-layer"></i>
                                <span class="link_name">All Products</span>
                            </a>
                            <span class="tooltip">All Products</span>
                        </li>
                        <li>
                            <a href="/admin/request-product-addition" class="{{ request()->is('admin/request-product-addition*') ? 'active' : '' }}">
                                <i class="bx bx-layer"></i>
                                <span class="link_name">Req. Product Addition</span>
                            </a>
                            <span class="tooltip">Req. Product Addition</span>
                        </li>
                        <li>
                            <a href="/admin/categories" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                                <i class="bx bx-layer"></i>
                                <span class="link_name">Categories</span>
                            </a>
                            <span class="tooltip">Categories</span>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->role == '1' || in_array('4', $access))
            <li><hr>
                <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#bmp">Orders Management <i class="bx bx-chevron-down"></i></span>
                <div id="bmp" class="collapse {{ request()->is('admin/order*','admin/biddings*') ? 'show' : '' }}" data-bs-parent="#accordion">
                    <ul class="p-0">
                        <li>
                            <a href="/admin/orders" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                                <i class="bx bx-calendar-check"></i>
                                <span class="link_name">Buyer Orders</span>
                            </a>
                            <span class="tooltip">Buyer Orders</span>
                        </li>
                        <li>
                            <a href="/admin/biddings" class="{{ request()->is('admin/biddings*') ? 'active' : '' }}">
                                <i class="bx bx-book"></i>
                                <span class="link_name">Seller biddings</span>
                            </a>
                            <span class="tooltip">Seller biddings</span>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->role == '1' || in_array('5', $access))
            <li><hr>
                <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#supports">Supports Management <i class="bx bx-chevron-down"></i></span>
                <div id="supports" class="collapse {{ request()->is('admin/notices*','admin/supports*','admin/communication-sellers*','admin/manage-communication-sellers*') ? 'show' : '' }}" data-bs-parent="#accordion">
                    <ul class="p-0">
                        <li>
                            <a href="/admin/notices" class="{{ request()->is('admin/notices*') ? 'active' : '' }}">
                                <i class="bx bx-pin"></i>
                                <span class="link_name">Notices</span>
                            </a>
                            <span class="tooltip">Notices</span>
                        </li>
                        <li>
                            <a href="/admin/supports" class="{{ request()->is('admin/supports*') ? 'active' : '' }}">
                                <i class="bx bx-support"></i>
                                <span class="link_name">Comm. with Support</span>
                            </a>
                            <span class="tooltip">Comm. with Support</span>
                        </li>
                        <li>
                            <a href="/admin/communication-sellers" class="{{ request()->is('admin/communication-sellers*','admin/manage-communication-sellers*') ? 'active' : '' }}">
                                <i class="bx bx-support"></i>
                                <span class="link_name">Comm b/w B and S</span>
                            </a>
                            <span class="tooltip">Comm. b/w B and S</span>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->role == '1' || in_array('6', $access))
            <li><hr>
                <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#pms">Page Management <i class="bx bx-chevron-down"></i></span>
                <div id="pms" class="collapse {{ request()->is('admin/slider*', 'admin/gallerie*', 'admin/review*', 'admin/page*') ? 'show' : '' }}" data-bs-parent="#accordion">
                    <ul class="p-0">
                        <li><a href="/admin/sliders" class="{{ request()->is('admin/slider*') ? 'active' : '' }}"><i class="bx bx-image"></i><span class="link_name">Sliders</span></a><span class="tooltip">Sliders</span></li>
                        <!--<li><a href="/admin/galleries" class="{{ request()->is('admin/gallerie*') ? 'active' : '' }}"><i class="bx bx-images"></i><span class="link_name">Gallery</span></a><span class="tooltip">Gallery</span></li>
                        <li><a href="/admin/reviews" class="{{ request()->is('admin/review*') ? 'active' : '' }}"><i class="bx bx-star"></i><span class="link_name">Reviews</span></a><span class="tooltip">Reviews</span></li>-->
                        <li><a href="/admin/pages" class="{{ request()->is('admin/page*') ? 'active' : '' }}"><i class="bx bx-globe"></i><span class="link_name">Pages</span></a><span class="tooltip">Pages</span></li>
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->role == '1' || in_array('7', $access))
            <li><hr>
                <span class="divider collapsed" data-bs-toggle="collapse" data-bs-target="#psmp">Settings Management <i class="bx bx-chevron-down"></i></span>
                <div id="psmp" class="collapse {{ request()->is('admin/notification*', 'admin/permission*', 'admin/manage-permission*') ? 'show' : '' }}" data-bs-parent="#accordion">
                    <ul class="p-0">
                        <!--<li><a href="/admin/notifications" class="{{ request()->is('admin/notification*') ? 'active' : '' }}"><i class="bx bx-bell"></i><span class="link_name">Notification</span></a><span class="tooltip">Notification</span></li>-->
                        <li><a href="/admin/permissions" class="{{ request()->is('admin/permission*', 'admin/manage-permission*') ? 'active' : '' }}"><i class="bx bx-lock"></i><span class="link_name">Permission</span></a><span class="tooltip">Permission</span></li>
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>

<nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-bottom mobile">
    <div class="container-fluid">
        <ul class="navbar-nav text-center">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="/admin/"><i class='bx bx-home-alt'></i><br>Home</a>
            </li>
            @if(Auth::user()->role == '1' || in_array('3', $access))
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/product*') ? 'active' : '' }}" href="/admin/products"><i class="bx bx-layer"></i><br>Products</a>
            </li>
            @endif
            @if(Auth::user()->role == '1' || in_array('5', $access))
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/supports*') ? 'active' : '' }}" href="/admin/supports"><i class="bx bx-help-circle"></i><br>Support</a>
            </li>
            @endif
            <li class="nav-item" id="m-menu">
                <a class="nav-link" href="javascript:void(0)"><i class="bx bx-user-circle"></i><br>{{ Auth::user()->first_name }}</a>
            </li>
        </ul>
    </div>
</nav>