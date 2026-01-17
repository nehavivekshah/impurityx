<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FrontendController;

Route::get('/login', [FrontendController::class, 'login']);
Route::post('/login', [FrontendController::class, 'loginPost'])->name('login');
Route::get('/register', [FrontendController::class, 'register']);
Route::post('/register', [FrontendController::class, 'registerPost'])->name('register');
Route::get('/forgot-password', [FrontendController::class, 'forgotPassword']);
Route::post('/forgot-password', [FrontendController::class, 'forgotPasswordPost'])->name('forgotPassword');
Route::get('/reset-password/{id}', [FrontendController::class, 'resetPassword']);
Route::post('/reset-password/{id}', [FrontendController::class, 'resetPasswordPost'])->name('resetPassword');

// OTP Verification Routes
Route::get('/verify-otp', [FrontendController::class, 'show'])->name('otp.show');
Route::post('/verify-otp', [FrontendController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [FrontendController::class, 'resendOtp'])->name('otp.resend');

Route::get('/blog', [FrontendController::class, 'blog']);
Route::get('/blog/{category_slog}', [FrontendController::class, 'blog']);
Route::get('/blog/{category_slog}/{article_slog}', [FrontendController::class, 'blogArticle']);

Route::get('/about-us', [FrontendController::class, 'about']);
Route::get('/how-it-works', [FrontendController::class, 'faq']);
Route::get('/contact-us', [FrontendController::class, 'contactUs']);
Route::post('/contact-us', [FrontendController::class, 'contactForm']);
Route::get('/support-policy', [FrontendController::class, 'supportPolicy']);
Route::get('/return-policy', [FrontendController::class, 'returnPolicy']);
Route::get('/seller-policy', [FrontendController::class, 'sellerPolicy']);
Route::get('/buyer-policy', [FrontendController::class, 'buyerPolicy']);
Route::get('/non-disclosure-agreement', [FrontendController::class, 'nonDisclosureAgreement']);
Route::get('/payment-policy', [FrontendController::class, 'paymentPolicy']);
Route::get('/delivery-policy', [FrontendController::class, 'deliveryPolicy']);
Route::get('/refund-policy', [FrontendController::class, 'refundPolicy']);
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy']);
Route::get('/terms-conditions', [FrontendController::class, 'termsConditions']);

//Seller Routers
Route::get('/seller/register', [FrontendController::class, 'sellerRegister']);
Route::post('/seller/register', [FrontendController::class, 'sellerRegisterPost'])->name('sellerRegister');

Route::get('/seller/login', [FrontendController::class, 'sellerLogin']);
Route::post('/seller/login', [FrontendController::class, 'sellerLoginPost'])->name('sellerLogin');
Route::get('/seller/forgot-password', [FrontendController::class, 'sellerForgotPassword']);
Route::post('/seller/forgot-password', [FrontendController::class, 'sellerForgotPasswordPost'])->name('sellerForgotPassword');
Route::get('/seller/reset-password/{id}', [FrontendController::class, 'sellerResetPassword']);
Route::post('/seller/reset-password/{id}', [FrontendController::class, 'sellerRasswordPost'])->name('sellerResetPassword');

// OTP Verification Routes
Route::get('/seller/verify-otp', [FrontendController::class, 'sellerShow'])->name('otp.sellerShow');
Route::post('/seller/verify-otp', [FrontendController::class, 'verifyOtp'])->name('otp.verifyOtp');
Route::post('/seller/resend-otp', [FrontendController::class, 'resendOtp'])->name('otp.verifyOtp');

Route::get('/seller/blog', [FrontendController::class, 'sellerBlog']);
Route::get('/seller/blog/{category_slog}', [FrontendController::class, 'sellerBlog']);
Route::get('/seller/blog/{category_slog}/{article_slog}', [FrontendController::class, 'sellerBlogArticle']);
Route::get('/seller/about-us', [FrontendController::class, 'sellerAbout']);
Route::get('/seller/how-it-works', [FrontendController::class, 'sellerFaq']);
Route::get('/seller/contact-us', [FrontendController::class, 'sellerContactUs']);
Route::post('/seller/contact-us', [FrontendController::class, 'sellerContactForm']);
Route::get('/seller/support-policy', [FrontendController::class, 'sellerSupportPolicy']);
Route::get('/seller/return-policy', [FrontendController::class, 'sellerReturnPolicy']);
Route::get('/seller/seller-policy', [FrontendController::class, 'SellerSellerPolicy']);
Route::get('/seller/buyer-policy', [FrontendController::class, 'SellerBuyerPolicy']);
Route::get('/seller/non-disclosure-agreement', [FrontendController::class, 'SellerNonDisclosureAgreement']);
Route::get('/seller/complaince-policy', [FrontendController::class, 'sellerComplaincePolicy']);
Route::get('/seller/payment-policy', [FrontendController::class, 'sellerPaymentPolicy']);
Route::get('/seller/delivery-policy', [FrontendController::class, 'sellerDeliveryPolicy']);
Route::get('/seller/refund-policy', [FrontendController::class, 'sellerRefundPolicy']);
Route::get('/seller/privacy-policy', [FrontendController::class, 'sellerPrivacyPolicy']);
Route::get('/seller/terms-conditions', [FrontendController::class, 'sellerTermsConditions']);

Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'loginPost'])->name('admin.login.post');
Route::get('/admin/register', [AuthController::class, 'register'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'registerPost'])->name('admin.register.post');

// Buyer Panel (Default Guard: web)
Route::middleware('auth:web')->group(function () {
    Route::get('/', [FrontendController::class, 'index']);
    Route::get('/category/{category_slog}', [FrontendController::class, 'category']);
    Route::get('/products', [FrontendController::class, 'products']);
    Route::get('/product/{product_slog}', [FrontendController::class, 'productDetails']);
    Route::post('/product/{product_slog}', [FrontendController::class, 'productDetailsPost']);
    
    Route::match(['get', 'post'], '/my-account/{page}', [FrontendController::class, 'myAccount']);
    Route::match(['get', 'post'], '/my-account/{page}/{q}', [FrontendController::class, 'myAccountExports']);
    Route::get('/my-orders', [FrontendController::class, 'myOrders']);
    Route::get('/my-order-details', [FrontendController::class, 'myOrderDetails']);
    Route::get('/dbaction', [SettingsController::class, 'buyerDBaction']);
    Route::get('/get-order-details/{orderNo}', [SettingsController::class, 'getOrderDetails']);
    Route::get('/logout', [FrontendController::class, 'logout'])->name('buyer.logout');
});

// Seller Panel
Route::middleware('auth:seller')->group(function () {
    Route::get('/seller', [FrontendController::class, 'sellerIndex']);
    Route::get('/seller/category/{category_slog}', [FrontendController::class, 'sellerCategory']);
    Route::get('/seller/products', [FrontendController::class, 'sellerProducts']);
    Route::get('/seller/product/{product_slog}/{oid}', [FrontendController::class, 'sellerProductDetails']);
    Route::post('/seller/product/{product_slog}/{oid}', [FrontendController::class, 'sellerProductDetailsPost']);
    
    Route::get('/seller/get-order-details/{orderNo}', [SettingsController::class, 'getOrderDetails']);
    Route::get('/seller/dbaction', [SettingsController::class, 'buyerDBaction']);
    Route::post('/seller/update-order-seller-status', [FrontendController::class, 'updateSellerOrderStatus']);
    
    Route::match(['get', 'post'], '/seller/my-account/{page}', [FrontendController::class, 'sellerMyAccount']);
    Route::match(['get', 'post'], '/seller/my-account/{page}/{q}', [FrontendController::class, 'myAccountExports']);
    Route::get('/seller/logout', [FrontendController::class, 'sellerLogout'])->name('seller.logout');
});

// Admin Panel
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin', [HomeController::class, 'home']);

    Route::get('/admin/users', [UserController::class, 'users']);
    Route::get('/admin/buyers', [UserController::class, 'buyers']);
    Route::get('/admin/sellers', [UserController::class, 'sellers']);
    Route::post('/admin/{role}/exportUser', [UserController::class, 'exportUserMaster']);
    Route::get('/admin/manage-user', [UserController::class, 'manageUser'])->name('manageUser');
    Route::post('/admin/manage-user', [UserController::class, 'manageUserPost'])->name('manageUser');
    Route::get('/admin/profile', [SettingsController::class, 'manageProfile'])->name('manageProfile');
    Route::post('/admin/profile', [SettingsController::class, 'manageProfilePost'])->name('manageProfile');
    Route::get('/admin/reset-password', [SettingsController::class, 'managePassword'])->name('managePassword');
    Route::post('/admin/reset-password', [SettingsController::class, 'managePasswordPost'])->name('managePassword');
    Route::get('/admin/categories', [CategoryController::class, 'categories']);
    Route::get('/admin/categories/export', [CategoryController::class, 'exportCategoryMaster']);
    Route::get('/admin/manage-category', [CategoryController::class, 'manageCategory'])->name('manageCategory');
    Route::post('/admin/manage-category', [CategoryController::class, 'manageCategoryPost'])->name('manageCategory');
    Route::get('/admin/products', [ProductController::class, 'products']);
    Route::get('/admin/products/export', [ProductController::class, 'exportProductMaster']);
    Route::get('/admin/request-product-addition', [ProductController::class, 'requestProductAddition']);
    Route::get('/admin/manage-product', [ProductController::class, 'manageProduct'])->name('manageProduct');
    Route::post('/admin/manage-product', [ProductController::class, 'manageProductPost'])->name('manageProduct');
    Route::get('/admin/biddings', [OrderController::class, 'biddings']);
    Route::get('/admin/orders', [OrderController::class, 'orders']);
    Route::post('/admin/buyer-orders/export', [OrderController::class, 'exportOrderMaster']);
    Route::post('/admin/seller-biddings/export', [OrderController::class, 'exportSellerBiddings']);
    Route::post('/admin/update-auction-end', [OrderController::class, 'updateAuctionEnd']);
    Route::get('/admin/post-categories', [SettingsController::class, 'postCategory']);
    Route::get('/admin/manage-post-category', [SettingsController::class, 'managePostCategory'])->name('managePostCategory');
    Route::post('/admin/manage-post-category', [SettingsController::class, 'managePostCategoryPost'])->name('managePostCategory');
    Route::get('/admin/posts', [SettingsController::class, 'posts']);
    Route::get('/admin/manage-post', [SettingsController::class, 'managePost'])->name('managePost');
    Route::post('/admin/manage-post', [SettingsController::class, 'managePostPost'])->name('managePost');
    Route::get('/admin/sliders', [SettingsController::class, 'sliders']);
    Route::get('/admin/manage-slider', [SettingsController::class, 'manageSlider'])->name('manageSlider');
    Route::post('/admin/manage-slider', [SettingsController::class, 'manageSliderPost'])->name('manageSlider');
    Route::get('/admin/galleries', [SettingsController::class, 'galleries']);
    Route::get('/admin/manage-gallery', [SettingsController::class, 'manageGallery'])->name('manageGallery');
    Route::post('/admin/manage-gallery', [SettingsController::class, 'manageGalleryPost'])->name('manageGallery');
    Route::get('/admin/reviews', [SettingsController::class, 'reviews']);
    Route::get('/admin/manage-review', [SettingsController::class, 'manageReview'])->name('manageReview');
    Route::post('/admin/manage-review', [SettingsController::class, 'manageReviewPost'])->name('manageReview');
    Route::get('/admin/pages', [SettingsController::class, 'pages']);
    Route::get('/admin/manage-page', [SettingsController::class, 'managePage'])->name('managePage');
    Route::post('/admin/manage-page', [SettingsController::class, 'managePagePost'])->name('managePage');
    Route::get('/admin/notifications', [SettingsController::class, 'notifications']);
    Route::get('/admin/manage-notification', [SettingsController::class, 'manageNotification'])->name('manageNotification');
    Route::post('/admin/manage-notification', [SettingsController::class, 'manageNotificationPost'])->name('manageNotification');
    Route::get('/admin/permissions', [SettingsController::class, 'permissions']);
    Route::get('/admin/manage-permission', [SettingsController::class, 'managePermission'])->name('managePermission');
    Route::post('/admin/manage-permission', [SettingsController::class, 'managePermissionPost'])->name('managePermission');
    Route::get('/admin/notices', [SettingsController::class, 'notices']);
    Route::get('/admin/manage-notice', [SettingsController::class, 'manageNotice'])->name('manageNotice');
    Route::post('/admin/manage-notice', [SettingsController::class, 'manageNoticePost'])->name('manageNotice');
    Route::get('/admin/supports', [SettingsController::class, 'supports']);
    Route::post('/admin/supports', [SettingsController::class, 'supportPost'])->name('supports');
    Route::get('/admin/communication-sellers', [SettingsController::class, 'communicationSellers']);
    Route::post('/admin/communication-sellers', [SettingsController::class, 'supportPost'])->name('communicationSellers');
    Route::get('/admin/manage-communication-sellers', [SettingsController::class, 'manageCommunicationSellers']);
    Route::post('/admin/manage-communication-sellers', [SettingsController::class, 'manageCommunicationSellersPost'])->name('manageCommunicationSellers');
    Route::get('/admin/get-order-details/{orderNo}', [SettingsController::class, 'getOrderDetails']);
    
    Route::get('/admin/get-order-edit-details/{id}', [SettingsController::class, 'getOrderEditDetails']);
    Route::post('/admin/update-order-details', [SettingsController::class, 'updateOrderDetails']);

    Route::get('/admin/action', [SettingsController::class, 'action']);
    Route::get('/admin/dbaction', [SettingsController::class, 'dbAction']);
    Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return 'DONE';
});