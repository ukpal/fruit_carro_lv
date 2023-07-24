<?php
header("Access-Control-Allow-Origin: *");

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Site\LoginController as SiteLoginController;

Route::post('/login/check-login', [SiteLoginController::class, 'authenticated']);

use App\Http\Controllers\Site\SignUpController as SiteSignUpController;

Route::post('/sign-up/check-username', [SiteSignUpController::class, 'checkUsername']);
Route::post('/sign-up/check-email', [SiteSignUpController::class, 'checkEmail']);
Route::post('/sign-up/save-user', [SiteSignUpController::class, 'saveUser']);


use App\Http\Controllers\Site\HomeController as HomePageController;

Route::get('/home/slider', [HomePageController::class, 'slider']);
Route::get('/home/products', [HomePageController::class, 'products']);
Route::get('/home/shopByCategory', [HomePageController::class, 'shopByCategory']);

use App\Http\Controllers\Site\ProductsController as ProductDetailsController;

Route::post('/product/details', [ProductDetailsController::class, 'details']);

use App\Http\Controllers\Site\CartController;

Route::post('/add-to-cart', [CartController::class, 'addToCart']);

use App\Http\Controllers\Site\ShopController;

Route::post('/shop', [ShopController::class, 'index']);

Route::post('/cart', [CartController::class, 'index']);

use App\Http\Controllers\Site\CheckoutController;

Route::post('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout/getStates', [CheckoutController::class, 'getStates']);
Route::post('/checkout/save', [CheckoutController::class, 'saveCheckout']);

use App\Http\Controllers\Site\ContactController;
Route::post('/saveContactMessage', [ContactController::class, 'store']);


////////////////////  ADMIN ROUTES   /////////////////////////////

use App\Http\Controllers\Admin\LoginController as AdminLoginController;

Route::get('/admin', [AdminLoginController::class, 'index']);
Route::get('/admin/login', [AdminLoginController::class, 'index']);
Route::post('/admin/check-login', [AdminLoginController::class, 'authenticated']);



use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::post('/admin/dashboard', [AdminDashboardController::class, 'index']);

use App\Http\Controllers\Admin\HomeSlidersController as AdminHomeSlidersController;

Route::post('/admin/home-sliders', [AdminHomeSlidersController::class, 'index']);
Route::post('/admin/home-sliders/edit', [AdminHomeSlidersController::class, 'edit']);
Route::post('/admin/home-sliders/save', [AdminHomeSlidersController::class, 'store']);
Route::post('/admin/home-sliders/delete', [AdminHomeSlidersController::class, 'destroy']);

use App\Http\Controllers\Admin\ProductCategoriesController as AdminProductCategoriesController;

Route::post('/admin/product-categories', [AdminProductCategoriesController::class, 'index']);
Route::post('/admin/product-categories/edit', [AdminProductCategoriesController::class, 'edit']);
Route::post('/admin/product-categories/save', [AdminProductCategoriesController::class, 'store']);
Route::post('/admin/product-categories/delete', [AdminProductCategoriesController::class, 'destroy']);
Route::post('/admin/product-categories/get-slug-url', [AdminProductCategoriesController::class, 'getSlugUrl']);

use App\Http\Controllers\Admin\ProductsController as AdminProductsController;

Route::post('/admin/products', [AdminProductsController::class, 'index']);
Route::post('/admin/products/edit', [AdminProductsController::class, 'edit']);
Route::post('/admin/products/save', [AdminProductsController::class, 'store']);
Route::post('/admin/products/delete', [AdminProductsController::class, 'destroy']);
Route::post('/admin/products/get-slug-url', [AdminProductsController::class, 'getSlugUrl']);

use App\Http\Controllers\Admin\CountryController as AdminCountryController;

Route::post('/admin/countries/save', [AdminCountryController::class, 'store']);
Route::post('/admin/states/save', [AdminCountryController::class, 'storeStates']);

use App\Http\Controllers\Admin\PaymentTypesController as AdminPaymentTypesController;

Route::post('/admin/paymentTypes/save', [AdminPaymentTypesController::class, 'store']);

use App\Http\Controllers\Admin\SiteSettingsController as AdminSiteSettingsController;

Route::get('/admin/siteSettings', [AdminSiteSettingsController::class, 'index']);
Route::post('/admin/siteSettings/save', [AdminSiteSettingsController::class, 'store']);

use App\Http\Controllers\Admin\ContactsController as AdminContactsController;

Route::post('/admin/contactMessages', [AdminContactsController::class, 'index']);
Route::post('/admin/contactMessages/delete', [AdminContactsController::class, 'destroy']);

use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/admin/logout', [AdminLoginController::class, 'logout']);
    Route::post('/admin/profile', [AdminProfileController::class, 'index']);
    Route::post('/admin/profile/save', [AdminProfileController::class, 'store']);
});
