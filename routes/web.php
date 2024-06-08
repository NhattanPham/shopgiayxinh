<?php

use App\Http\Controllers\BackEnd\CategoriesController;
use App\Http\Controllers\BackEnd\ConfigController;
use App\Http\Controllers\BackEnd\DashBoardController;
use App\Http\Controllers\BackEnd\MenuController;
use App\Http\Controllers\BackEnd\OrderController;
use App\Http\Controllers\BackEnd\PageController;
use App\Http\Controllers\BackEnd\PlaceController;
use App\Http\Controllers\BackEnd\PostController;
use App\Http\Controllers\BackEnd\ProductController;
use App\Http\Controllers\BackEnd\SliderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\FrontEnd\BlogController;
use App\Http\Controllers\FrontEnd\CartController;
use App\Http\Controllers\FrontEnd\CheckoutController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\LoginController;
use App\Http\Controllers\FrontEnd\ProductShowController;
use App\Http\Controllers\FrontEnd\ProfileController;
use App\Http\Controllers\FrontEnd\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    // Admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/', [DashBoardController::class, 'index']);
            Route::redirect('dashboard', '/admin');
            // Menu
            Route::controller(MenuController::class)->group(function () {
                Route::get('menu', 'index');
                Route::get('menu/create', 'create');
                Route::get('menu/edit/{id}', 'edit');
                Route::post('menu', 'update');
            });
            // Category
            Route::controller(CategoriesController::class)->group(function () {
                Route::get('categories/{extension}', 'index');
                Route::get('categories/{extension}/create', 'create');
                Route::get('categories/{extension}/edit/{id}', 'edit');
                Route::get('categories/{extension}/published/{id}', 'published');
                Route::post('categories/{extension}', 'update');
            });
            // Post
            Route::controller(PostController::class)->group(function () {
                Route::get('posts', 'index');
                Route::get('posts/create', 'create');
                Route::get('posts/edit/{id}', 'edit');
                Route::post('posts', 'update');
            });
            // Page
            Route::controller(PageController::class)->group(function () {
                Route::get('pages', 'index');
                Route::get('pages/create', 'create');
                Route::get('pages/edit/{id}', 'edit');
                Route::post('pages', 'update');
            });
            // Product
            Route::controller(ProductController::class)->group(function () {
                Route::get('products', 'index');
                Route::get('products/create', 'create');
                Route::get('products/edit/{id}', 'edit');
                Route::get('products/getList', 'getList');
                Route::post('products', 'update');
            });
            // Order
            Route::controller(OrderController::class)->group(function () {
                Route::get('orders', 'index');
                Route::get('orders/create', 'create');
                Route::post('orders/create', 'create');
                Route::get('orders/edit/{id}', 'edit');
                Route::post('orders/edit/{id}', 'edit');
                Route::post('orders', 'update');
            });
            // User
            Route::controller(UserController::class)->group(function () {
                Route::get('users', 'index');
                Route::get('users/create', 'create');
                Route::get('users/edit/{id}', 'edit');
                Route::get('users/blocked/{id}', 'blocked');
                Route::post('users', 'update');
            });
            // Slider
            Route::controller(SliderController::class)->group(function () {
                Route::get('sliders', 'index');
                Route::get('sliders/create', 'create');
                Route::get('sliders/edit/{id}', 'edit');
                Route::post('sliders', 'update');
                Route::post('sliders/updateIndex', 'updateIndex');
                Route::get('sliders/delete/{id}', 'destroy');
            });
            // Config
            Route::controller(ConfigController::class)->group(function () {
                Route::get('config', 'index');
                Route::get('config/limited/{number}/{limitedpage}', 'limited');
            });

            // file manager
            Route::group(['prefix' => '/laravel-filemanager'], function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
            });
            Route::view('/media', 'backend.media.list');
        });
    });
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'index')->name('login');
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::get('logout', 'logout');
    });
    // Blog
    Route::controller(BlogController::class)->group(function () {
        Route::get('/blog', 'index');
        Route::get('/blog/{slug}.html', 'showDetail');
    });
    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/addToCart/{id}', [CartController::class, 'addToCart']);
    Route::post('/cart/updateQuantity', [CartController::class, 'updateQuantity']);
    Route::post('/cart/addToCheckout', [CartController::class, 'addToCheckout']);
    Route::delete('/cart', [CartController::class, 'destroy']);
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/addToWishlist/{id}', [WishlistController::class, 'addToWishlist']);
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'index');
        Route::get('purchase', 'purchase');
    });
    // Page Not Found
    Route::get('page-not-found', function () {
        return view('frontend.pageNotFound');
    });
    // Place
    Route::controller(PlaceController::class)->group(function () {
        Route::get('province', 'getProvince');
        Route::get('district/{id}', 'getDistrict');
        Route::get('ward/{id}', 'getWard');
    });
    // Product
    Route::controller(ProductShowController::class)->group(function () {
        Route::get('/{cate_slug}/{slug}.html', 'showProductDetail');
        Route::get('/{slug}', 'showProductWithCategory');
    });
});
