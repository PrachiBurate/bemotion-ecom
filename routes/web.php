<?php

use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\OfficeLocationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\BulkOrderController;
use App\Http\Controllers\Admin\BulkOrdersController;
   use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CouponController;
  use App\Http\Controllers\Admin\SettingController;
    use App\Http\Controllers\Admin\ProductController;
       use App\Http\Controllers\Admin\DealController;
       use App\Http\Controllers\Admin\OrderController;
 use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ProcessStepController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\WeeklyDealController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\AboutsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\ComboController;
use App\Http\Controllers\Admin\BundleController;
use App\Http\Controllers\CheckoutController;







Route::get('/', [HomeController::class, 'home']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/blog', [BlogsController::class, 'index']);
Route::post('/blog-details', [BlogsController::class, 'showPost']);
Route::get('/blog-details', [BlogsController::class, 'showPage']);
Route::post('/blog/comment', [BlogsController::class, 'comment']);


Route::get('/cart', function () {
    return view('cart');
});


Route::get('/contact', [ContactController::class, 'contactPage'])->name('contact');


Route::get('/faq', function () {
    return view('faq');
});

Route::get('/wishlist', function () {
    return view('wishlist');
});

Route::get('/shops', [HomeController::class,'shops'])->name('shops');
Route::get('/shop-details/{slug}', [HomeController::class, 'shopDetails'])
    ->name('shop.details');


Route::get('/shops-grid', function () {
    return view('shops-grid');
});
Route::get('/shop-right-sidebar', function () {
    return view('shop-right-sidebar');
});


Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected routes
Route::middleware(['admin'])->group(function () {

    // 🔥 DASHBOARD
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('permission:dashboard.view');

Route::get('/deals', [HomeController::class, 'deals']);
    // 🔥 ROLES
    Route::get('/roles', [RoleController::class, 'index'])
        ->middleware('permission:roles.view');

    Route::post('/roles/store', [RoleController::class, 'store'])
        ->middleware('permission:roles.create');

  Route::put('/roles/update/{role}', [RoleController::class, 'update'])
    ->middleware('permission:roles.edit');

    Route::get('/roles/delete/{id}', [RoleController::class, 'delete'])
        ->middleware('permission:roles.delete');


    // 🔥 USERS
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:users.view');

    Route::post('/users/store', [UserController::class, 'store'])
        ->middleware('permission:users.create');

    Route::post('/users/update/{id}', [UserController::class, 'update'])
        ->middleware('permission:users.edit');

    Route::post('/users/delete/{id}', [UserController::class, 'delete'])
        ->middleware('permission:users.delete');

        
Route::get('/blogs', [BlogController::class, 'index'])->middleware('permission:blogs.view');
Route::post('/blogs/store', [BlogController::class, 'store'])->middleware('permission:blogs.create');
Route::post('/blogs/update/{id}', [BlogController::class, 'update'])->middleware('permission:blogs.edit');
Route::post('/blogs/delete/{id}', [BlogController::class, 'delete'])->middleware('permission:blogs.delete');
Route::post('/admin/blogs/upload-image', [BlogController::class, 'uploadImage'])
    ->name('admin.blogs.upload-image');
// BANNERS
Route::get('/banners', [BannerController::class, 'index'])
    ->middleware('permission:banners.view');

Route::post('/banners/update/{id}', [BannerController::class, 'update'])
    ->middleware('permission:banners.edit');

    Route::get('/blog-comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])
    ->middleware('permission:comments.view');

Route::post('/blog-comments/delete/{id}', [\App\Http\Controllers\Admin\CommentController::class, 'delete'])
    ->middleware('permission:comments.delete');

Route::post('/blog-comments/status/{id}', [\App\Http\Controllers\Admin\CommentController::class, 'status'])
    ->middleware('permission:comments.edit');

   // ================= FAQ =================
Route::get('/faqs', [\App\Http\Controllers\Admin\FaqController::class, 'index'])
    ->middleware('permission:faqs.view');

Route::post('/faqs/store', [\App\Http\Controllers\Admin\FaqController::class, 'store'])
    ->middleware('permission:faqs.create');

Route::post('/faqs/update/{id}', [\App\Http\Controllers\Admin\FaqController::class, 'update'])
    ->middleware('permission:faqs.edit');

Route::post('/faqs/delete/{id}', [\App\Http\Controllers\Admin\FaqController::class, 'delete'])
    ->middleware('permission:faqs.delete');


// ================= FAQ QUERIES =================
Route::get('/admin/faq-queries', [\App\Http\Controllers\Admin\FaqController::class, 'faqQueries'])
    ->name('faq.queries')
    ->middleware('permission:faq_queries.view');

Route::post('/admin/faq-queries/delete/{id}', [\App\Http\Controllers\Admin\FaqController::class, 'deleteFaqQuery'])
    ->middleware('permission:faq_queries.delete');

Route::post('/admin/faq-queries/status/{id}', [\App\Http\Controllers\Admin\FaqController::class, 'updateFaqQueryStatus'])
    ->middleware('permission:faq_queries.update');


// ================= CONTACT QUERIES =================
Route::get('/admin/contact-queries', [\App\Http\Controllers\Admin\ContactController::class, 'contactQueries'])
    ->name('contact.queries')
    ->middleware('permission:contact_queries.view');

Route::post('/admin/contact-queries/status/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'updateContactStatus'])
    ->middleware('permission:contact_queries.update');

Route::post('/admin/contact-queries/delete/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'deleteContact'])
    ->middleware('permission:contact_queries.delete');

    Route::get('/admin/offices', [OfficeLocationController::class, 'index'])
    ->name('offices')
    ->middleware('permission:office_locations.view');

// Store
Route::post('/admin/offices/store', [OfficeLocationController::class, 'store'])
    ->middleware('permission:office_locations.create');

// Update
Route::post('/admin/offices/update/{id}', [OfficeLocationController::class, 'update'])
    ->middleware('permission:office_locations.edit');

// Delete
Route::post('/admin/offices/delete/{id}', [OfficeLocationController::class, 'delete'])
    ->middleware('permission:office_locations.delete');

    // Categories
Route::get('/admin/categories', [CategoryController::class, 'index'])
    ->middleware('permission:categories.view');

Route::post('/admin/categories/store', [CategoryController::class, 'store'])
    ->middleware('permission:categories.create');

Route::post('/admin/categories/update/{id}', [CategoryController::class, 'update'])
    ->middleware('permission:categories.edit');

Route::post('/admin/categories/delete/{id}', [CategoryController::class, 'delete'])
    ->middleware('permission:categories.delete');


// Subcategories
Route::get('/admin/subcategories', [SubcategoryController::class, 'index'])
    ->middleware('permission:subcategories.view');

Route::post('/admin/subcategories/store', [SubcategoryController::class, 'store'])
    ->middleware('permission:subcategories.create');

Route::post('/admin/subcategories/update/{id}', [SubcategoryController::class, 'update'])
    ->middleware('permission:subcategories.edit');

Route::post('/admin/subcategories/delete/{id}', [SubcategoryController::class, 'delete'])
    ->middleware('permission:subcategories.delete');

    Route::get('/admin/brands', [BrandController::class, 'index'])
    ->middleware('permission:brands.view');

Route::post('/admin/brands/store', [BrandController::class, 'store'])
    ->middleware('permission:brands.create');

Route::post('/admin/brands/update/{id}', [BrandController::class, 'update'])
    ->middleware('permission:brands.edit');

Route::post('/admin/brands/delete/{id}', [BrandController::class, 'delete'])
    ->middleware('permission:brands.delete');




Route::get('/admin/bulk-orders', [BulkOrdersController::class, 'index'])
    ->name('bulk.orders')
    ->middleware('permission:bulk_orders.view');

Route::post('/admin/bulk-orders/status/{id}', [BulkOrdersController::class, 'status'])
    ->middleware('permission:bulk_orders.update');

Route::post('/admin/bulk-orders/delete/{id}', [BulkOrdersController::class, 'delete'])
    ->middleware('permission:bulk_orders.delete');

    Route::get('/admin/change-password', [ProfileController::class, 'passwordForm'])
    ->name('profile.password')
    ->middleware(['auth','is_admin']);

Route::post('/admin/change-password', [ProfileController::class, 'changePassword'])
    ->name('profile.password.update')
    ->middleware(['auth','is_admin']);

      Route::get('/admin/coupons', [CouponController::class, 'index'])
        ->name('coupons')
        ->middleware('permission:coupons.view');

    Route::post('/admin/coupons/store', [CouponController::class, 'store'])
        ->middleware('permission:coupons.create');

    Route::post('/admin/coupons/update/{id}', [CouponController::class, 'update'])
        ->middleware('permission:coupons.edit');

    Route::post('/admin/coupons/status/{id}', [CouponController::class, 'status'])
        ->middleware('permission:coupons.edit');

    Route::post('/admin/coupons/delete/{id}', [CouponController::class, 'delete'])
        ->middleware('permission:coupons.delete');

      

Route::get('/admin/settings', [SettingController::class, 'index'])
    ->name('settings')
    ->middleware('permission:settings.view');

Route::post('/admin/settings/update', [SettingController::class, 'update'])
    ->middleware('permission:settings.edit');



Route::get('/admin/products', [ProductController::class, 'index'])
    ->name('products')
    ->middleware('permission:products.view');

Route::post('/admin/products/store', [ProductController::class, 'store'])
    ->middleware('permission:products.create');

Route::post('/admin/products/update/{id}', [ProductController::class, 'update'])
    ->middleware('permission:products.edit');

Route::post('/admin/products/delete/{id}', [ProductController::class, 'delete'])
    ->middleware('permission:products.delete');
 

Route::get('/admin/deals', [DealController::class, 'index'])
    ->middleware('permission:deals.view');

Route::post('/admin/deals/store', [DealController::class, 'store'])
    ->middleware('permission:deals.create');

Route::post('/admin/deals/update/{id}', [DealController::class, 'update'])
    ->middleware('permission:deals.edit');

Route::post('/admin/deals/delete/{id}', [DealController::class, 'delete'])
    ->middleware('permission:deals.delete');
    
    
Route::get('/admin/orders', [OrderController::class, 'index'])
    ->middleware('permission:orders.view');

Route::post('/admin/orders/status/{id}', [OrderController::class, 'updateStatus'])
    ->middleware('permission:orders.update');

Route::get('/admin/transactions', [OrderController::class, 'transactions'])
    ->middleware('permission:transactions.view');



Route::get('/admin/pages', [PageController::class, 'index'])
    ->middleware('permission:pages.view');

Route::post('/admin/pages/update/{id}', [PageController::class, 'update'])
    ->middleware('permission:pages.edit');

    Route::post('/admin/pages/upload-image', [PageController::class, 'uploadImage'])
    ->name('admin.pages.upload-image');

    Route::get('/admin/testimonials', [TestimonialController::class, 'index'])->middleware('permission:testimonials.view');

Route::post('/admin/testimonials/store', [TestimonialController::class, 'store'])->middleware('permission:testimonials.create');

Route::post('/admin/testimonials/update/{id}', [TestimonialController::class, 'update'])->middleware('permission:testimonials.edit');

Route::post('/admin/testimonials/delete/{id}', [TestimonialController::class, 'delete'])->middleware('permission:testimonials.delete');

Route::get('/admin/process-steps', [ProcessStepController::class, 'index'])
    ->middleware('permission:process_steps.view');

Route::post('/admin/process-steps/store', [ProcessStepController::class, 'store'])
    ->middleware('permission:process_steps.create');

Route::post('/admin/process-steps/update/{id}', [ProcessStepController::class, 'update'])
    ->middleware('permission:process_steps.edit');

Route::post('/admin/process-steps/delete/{id}', [ProcessStepController::class, 'delete'])
    ->middleware('permission:process_steps.delete');

    Route::get('/admin/hero', [HeroSliderController::class, 'index'])
    ->middleware('permission:hero.view');

Route::post('/admin/hero/store', [HeroSliderController::class, 'store'])
    ->middleware('permission:hero.create');

Route::put('/admin/hero/update/{id}', [HeroSliderController::class, 'update'])
    ->name('admin.hero.update');

Route::post('/admin/hero/delete/{id}', [HeroSliderController::class, 'delete'])
    ->middleware('permission:hero.delete');

    Route::get('/admin/features', [FeatureController::class, 'index'])->middleware('permission:features.view');

Route::post('/admin/features/store', [FeatureController::class, 'store'])->middleware('permission:features.create');

Route::post('/admin/features/update/{id}', [FeatureController::class, 'update'])->middleware('permission:features.edit');

Route::post('/admin/features/delete/{id}', [FeatureController::class, 'delete'])->middleware('permission:features.delete');



  Route::get('/admin/weekly-deals', [WeeklyDealController::class, 'index'])
        ->middleware('permission:weekly_deals.view');

    Route::post('/admin/weekly-deals/store', [WeeklyDealController::class, 'store'])
        ->middleware('permission:weekly_deals.create');

    Route::post('/admin/weekly-deals/update/{id}', [WeeklyDealController::class, 'update'])
        ->middleware('permission:weekly_deals.edit');

    Route::post('/admin/weekly-deals/delete/{id}', [WeeklyDealController::class, 'delete'])
        ->middleware('permission:weekly_deals.delete');

        Route::get('/admin/teams', [TeamController::class, 'index'])->middleware('permission:teams.view');
Route::post('/admin/teams/store', [TeamController::class, 'store'])->middleware('permission:teams.create');
Route::post('/admin/teams/update/{id}', [TeamController::class, 'update'])->middleware('permission:teams.edit');
Route::post('/admin/teams/delete/{id}', [TeamController::class, 'delete'])->middleware('permission:teams.delete');
Route::get('/admin/about', [AboutsController::class,'index'])->middleware('permission:about.view');

Route::post('/admin/about/update/{id}', [AboutsController::class,'update'])->middleware('permission:about.edit');
});


Route::post('/newsletter', [BlogsController::class, 'subscribe']);
Route::get('/faq', [FaqController::class, 'faq']);

Route::post('/faq-submit', [FaqController::class, 'faqSubmit'])->name('faq.submit');
Route::post('/contact-submit', [ContactController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/bulk-order', [BulkOrderController::class, 'bulkOrderPage'])->name('bulk.order');
Route::post('/bulk-order-submit', [BulkOrderController::class, 'bulkOrderSubmit'])
    ->name('bulk.order.submit');
    Route::post('/admin/products/stock/{id}', [ProductController::class, 'updateStock']);



Route::get('/login', [CustomerAuthController::class,'loginPage']);
Route::post('/login', [CustomerAuthController::class,'login']);

Route::get('/register', [CustomerAuthController::class,'registerPage']);
Route::post('/register', [CustomerAuthController::class,'register']);

Route::get('/logout', [CustomerAuthController::class,'logout']);

Route::get('/privacy-policy', [HomeController::class, 'page']);
Route::get('/terms', [HomeController::class, 'page']);


Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

Route::post('/cart/add',[CartController::class,'add']);
Route::get('/cart/sidebar',[CartController::class,'sidebar']);
Route::post('/cart/update',[CartController::class,'update']);
Route::post('/cart/delete',[CartController::class,'delete']);
Route::post('/cart/increase',[CartController::class,'increase']);

Route::post('/cart/decrease',[CartController::class,'decrease']);

Route::post('/cart/remove',[CartController::class,'remove']);

Route::post('/wishlist/toggle',[WishlistController::class,'toggle']);
Route::get('/wishlist/count',[WishlistController::class,'count']);
Route::get('/wishlist',[WishlistController::class,'index']);
Route::post('/wishlist/remove',[WishlistController::class,'remove']);
Route::post('/wishlist/move-to-cart',[WishlistController::class,'moveToCart']);

Route::get('/header-counts', function () {
    return response()->json([
        'wishlistCount' => session('wishlist') ? count(session('wishlist')) : 0,
        'cartCount' => session('cart') ? count(session('cart')) : 0,
    ]);
});

Route::prefix('admin')->group(function () {

    Route::get('/combos',[ComboController::class,'index'])->name('combos');

    Route::post('/combos/store',[ComboController::class,'store']);

    Route::post('/combos/update/{id}',[ComboController::class,'update']);

    Route::post('/combos/delete/{id}',[ComboController::class,'delete']);

});

Route::get('/admin/bundles',[BundleController::class,'index'])->name('bundles');

Route::post('/admin/bundles/store',[BundleController::class,'store']);

Route::post('/admin/bundles/update/{id}',[BundleController::class,'update']);

Route::post('/admin/bundles/delete/{id}',[BundleController::class,'delete']);

Route::post('/admin/bundles/status/{id}',[BundleController::class,'toggleStatus']);


Route::middleware('customer')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');

    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
        ->name('checkout.placeOrder');

    Route::get('/order-success/{id}', [CheckoutController::class, 'success'])
        ->name('order.success');

    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])
        ->name('my.orders');

    Route::get('/my-orders/{id}', [CheckoutController::class, 'orderDetails'])
        ->name('order.details');
});

Route::get('/header-counts', [CartController::class, 'headerCounts']);