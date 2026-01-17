<?php
    $user = session('users') ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>ImpurityX - Supporting Drug Development</title>
    <link rel="icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg" type="image/gif" sizes="20x20">
    <link rel="stylesheet" href="/assets/frontend/css/animate.css">
    <!-- css file link -->
    <link rel="stylesheet" href="/assets/frontend/css/all.css">
    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="/assets/frontend/css/bootstrap.min.css">
    <!-- box-icon -->
    <link rel="stylesheet" href="/https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="/assets/frontend/css/boxicons.min.css">
    <!-- bootstrap icon -->
    <link rel="stylesheet" href="/assets/frontend/css/bootstrap-icons.css">
    <!-- jquery ui -->
    <link rel="stylesheet" href="/assets/frontend/css/jquery-ui.css">
    <!-- swiper-slide -->
    <link rel="stylesheet" href="/assets/frontend/css/swiper-bundle.min.css">
    <!-- slick-slide -->
    <link rel="stylesheet" href="/assets/frontend/css/slick-theme.css">
    <link rel="stylesheet" href="/assets/frontend/css/slick.css">
    <!-- select 2 -->
    <link rel="stylesheet" href="/assets/frontend/css/nice-select.css">
    <!-- animate css -->
    <link rel="stylesheet" href="/assets/frontend/css/magnific-popup.css">
    <!-- odometer css -->
    <link rel="stylesheet" href="/assets/frontend/css/odometer.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <!-- style css -->
    <link rel="stylesheet" href="/assets/frontend/css/style.css">
    <link rel="stylesheet" href="/assets/frontend/css/my-style.css">
    <style>
        @media (max-width: 768px){
            .main-menu .mobile-logo-area .logo-impurity {
                max-height: 80px !important; 
            }
            header.style-1 .main-menu{
                padding: 10px 20px;
            }
            header.style-1 .main-menu .menu-list>li a { 
                font-size: 15px;
                padding: 6px 0px;
            }
            header.style-1 .main-menu .menu-list>li .submenu {
                top: 5px; 
            }
            header.style-1 .main-menu .menu-list > li .dropdown-icon {
                color: #ffffff;
            }
            header.style-1 .main-menu .menu-list > li.menu-item-has-children .dropdown-icon { 
                position: absolute; 
                top: 6px; 
                right: 0; 
                font-size: 16px;
            }
            .login-section{
                z-index: 0;
            }
        }
        .swiper{
            z-index: 0;
        }
    </style>
</head>
<body>
    <!-- preloader -->
    <!-- <div class="preloader">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div> -->
    <!-- =============== search-area start =============== -->
    <div class="mobile-search">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-11">
                    <label>What are you lookking for?</label>
                    <input type="text" placeholder="Search Products, Category, Brand">
                </div>
                <div class="col-1 d-flex justify-content-end align-items-center">
                    <div class="search-cross-btn">
                        <!-- <i class="bi bi-search me-4"></i> -->
                        <i class="bi bi-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =============== search-area end  =============== -->
    <!-- ========== topbar ============= -->
    <div class="topbar">
        <div class="topbar-left d-flex flex-row align-items-center">
            <div class="d-flex gap-4">
                <span>
                    <i class="bx bx-phone-call"></i>
                    <a href="tel:+918554999074">
                        <span>+91 8554 999 074</span>
                    </a>
                </span>
                <span>
                    <i class="bx bx-envelope"></i>
                    <a href="mailto:support@impurityx.com">
                        <span>support@impurityx.com</span>
                    </a>
                </span>
            </div>
        </div>
        <div class="topbar-right">
            <ul class="topbar-right-list">
                <li>
                    <ul class="social-icon d-flex gap-2">
                        <li>
                            <a href="https://www.facebook.com/profile.php?id=61582013601892" target="_blank">
                                <img src="/public/assets/frontend/img/icon/social/1.png" alt="facebook" class="img-fluid">
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/impurityx_thirdworld_innomart" target="_blank">
                                <img src="/public/assets/frontend/img/icon/social/2.png" alt="instagram" class="img-fluid">
                            </a>
                        </li>
                        <li>
                            <a href="https://x.com/impurityx_1" target="_blank">
                                <img src="/public/assets/frontend/img/icon/social/4.png" alt="X" class="img-fluid">
                            </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/showcase/impurityx" target="_blank">
                                 <img src="/public/assets/frontend/img/icon/social/3.png" alt="linkedin" class="img-fluid">
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- ========== header============= -->
    <header class="header-area style-1">
        <div class="header-logo">
            <a href="/seller/"><img class="img-fluid logo-impurity" alt="image" src="/assets/frontend/images/logo.png"></a>
        </div>
        <div class="main-menu">
            <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
                <div class="mobile-logo-wrap ">
                    <a href="/seller/"><img class="img-fluid logo-impurity" alt="image"
                            src="/assets/frontend/images/logo.png"></a>
                </div>
                <div class="menu-close-btn">
                    <i class="bi bi-x-lg"></i>
                </div>
                
            </div>
            <ul class="menu-list">
                <li>
                    <a href="/seller/">
                        Home
                    </a>
                </li>
                <li>
                    <a href="/seller/about-us">
                        About Us
                    </a>
                </li>
                <li class="menu-item-has-children">
                    <a href="/seller/products" class="drop-down">Categories</a>
                    <i class="bx bx-plus dropdown-icon"></i>
                    <ul class="submenu" >
                        <?php $__currentLoopData = $dropdownCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="/seller/category/<?php echo e($cat->slog); ?>"><?php echo e($cat->title); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
                <li>
                    <a href="/seller/how-it-works">
                        How It Works
                    </a>
                </li>
                <li>
                    <a href="/seller/blog">
                        Blogs
                    </a>
                </li>
                <li>
                    <a href="/seller/contact-us">
                        Contact Us
                    </a>
                </li>
            </ul>
            <!-- mobile-search-area -->
            <div class="d-lg-none d-block">
                <form action="/seller/products" method="GET" class="mobile-menu-form mb-5">
                    <div class="input-with-btn d-flex flex-column">
                        <input type="text" placeholder="Search here..." name="s" style="max-width: 255px;" value="<?php echo $_GET['search'] ?? ''; ?>">
                        <button type="submit" class="eg-btn btn--primary btn--sm">Search</button>
                    </div>
                </form>
                <div class="hotline two">
                    <div class="hotline-info">
                        <span>Click To Call</span>
                        <h6><a href="tel:+918554999074">+91 8554 999 074</a></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-right d-flex align-items-center">
            <div class="hotline d-md-none d-block d-flex d-none justify-content-center align-items-center">
                <div class="hotline-icon">
                   <i class="bx bx-phone-call"></i>
                </div>
                <div class="hotline-info">
                    <!-- <span>Click To Call</span> -->
                     <a href="tel:+918554999074">+91 8554 999 074</a>
                </div>
            </div>
            <div class="search-container d-none d-md-block">
                <form action="/seller/products" method="GET" class="search-form">
                    <div class="input-group">
                        <input type="text" class="form-control search-input" placeholder="Search Products Here..."
                            name="search" style="max-width: 255px;" value="<?php echo $_GET['search'] ?? ''; ?>">
                        <button class="btn search-button" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="profile-button-container btn-user d-md-block ms-2">
                <!-- Added ms-2 for margin -->
                <a <?php if(session('users') && ($user['role'] == '4')): ?> href="/seller/my-account/dashboard" <?php else: ?> href="/seller/login" <?php endif; ?> class="eg-btn btn--primary btn--lg mobile-account-btn">
                    <i class="fas fa-user"></i> <?php echo e($user['first_name'] ?? ''); ?>

                </a>
            </div>
            <div class="mobile-menu-btn d-lg-none d-block">
                <i class='bx bx-menu'></i>
            </div>
        </div>
    </header><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/seller/inc/header.blade.php ENDPATH**/ ?>