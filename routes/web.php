<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Site\MenusController as SiteMenusController;
use App\Http\Controllers\Site\PagesController as SitePagesController;
use App\Http\Controllers\Site\BlogsController as SiteBlogsController;
use App\Http\Controllers\Site\PropertiesController as SitePropertiesController;
use App\Http\Controllers\Site\ContactController as SiteContactController;

if(Request::segment(1)) {
    $slugDetails = DB::table('slugs')->where([['slug','=',Request::segment(1)]])->first();
    if($slugDetails) {
        if($slugDetails->slug_type == 'Menus') {
            Route::get('/'.$slugDetails->slug, [SiteMenusController::class, 'details']);
        } else if($slugDetails->slug_type == 'Pages') {
            Route::get('/'.$slugDetails->slug, [SitePagesController::class, 'details']);
        } else if($slugDetails->slug_type == 'Blogs') {
            Route::get('/'.$slugDetails->slug, [SiteBlogsController::class, 'details']);
        } else if($slugDetails->slug_type == 'Properties') {
            Route::get('/'.$slugDetails->slug, [SitePropertiesController::class, 'details']);
        }
        
    }
}

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

use App\Http\Controllers\Site\HomeController as SiteHomeController; 
Route::get('/', [SiteHomeController::class, 'index']);
Route::get('/home', [SiteHomeController::class, 'index']);

Route::get('/blogs', [SiteBlogsController::class, 'index']);

Route::get('/listing', [SitePropertiesController::class, 'index']);

Route::get('/contact-us', [SiteContactController::class, 'index']);
Route::post('/contact-us/store', [SiteContactController::class, 'store']);

use App\Http\Controllers\Site\ProfileController as SiteProfileController;
Route::get('/profile', [SiteProfileController::class, 'index'])->middleware('auth');
Route::get('/tenants', [SiteProfileController::class, 'tenants'])->middleware('auth');
Route::get('/properties', [SiteProfileController::class, 'properties'])->middleware('auth');
Route::get('/change-password', [SiteProfileController::class, 'changePassword'])->middleware('auth');
Route::get('/logout', [SiteProfileController::class, 'logOut'])->middleware('auth');

use App\Http\Controllers\Site\LoginController as SiteLoginController; 
Route::get('/login', [SiteLoginController::class, 'index']);
Route::post('/login/check-login', [SiteLoginController::class, 'authenticated']);

use App\Http\Controllers\Site\SignUpController as SiteSignUpController;
Route::get('/sign-up', [SiteSignUpController::class, 'index']);
Route::post('/sign-up/save-user', [SiteSignUpController::class, 'saveUser']);
Route::post('/sign-up/check-username', [SiteSignUpController::class, 'checkUsername']);
Route::post('/sign-up/check-email', [SiteSignUpController::class, 'checkEmail']);

use App\Http\Controllers\Admin\LoginController as AdminLoginController; 
Route::get('/admin', [AdminLoginController::class, 'index']);
Route::get('/admin/login', [AdminLoginController::class, 'index']);
Route::post('/admin/check-login', [AdminLoginController::class, 'authenticated']);

use App\Http\Controllers\Admin\ForgotPasswordController as AdminForgotPasswordController; 
Route::get('/admin/forgot-password', [AdminForgotPasswordController::class, 'index']);
Route::post('/admin/fotgot-password/check-email', [AdminForgotPasswordController::class, 'checkEmail']);

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; 
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('auth');

use App\Http\Controllers\Admin\ProfileController as AdminProfileController; 
Route::get('/admin/profile', [AdminProfileController::class, 'index'])->middleware('auth');
Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->middleware('auth');
Route::post('/admin/profile/store', [AdminProfileController::class, 'store'])->middleware('auth');

Route::get('/admin/logout', [AdminProfileController::class, 'logout'])->middleware('auth');

use App\Http\Controllers\Admin\ChangePasswordController as AdminChangePasswordController; 
Route::get('/admin/change-password', [AdminChangePasswordController::class, 'index'])->middleware('auth');
Route::post('/admin/change-password/store', [AdminChangePasswordController::class, 'store'])->middleware('auth');

use App\Http\Controllers\Admin\SiteSettingsController as AdminSiteSettingsController; 
Route::get('/admin/site-settings', [AdminSiteSettingsController::class, 'index'])->middleware('auth');
Route::post('/admin/site-settings/store', [AdminSiteSettingsController::class, 'store'])->middleware('auth');

use App\Http\Controllers\Admin\EmailTemplatesController as AdminEmailTemplatesController; 
Route::get('/admin/email-templates', [AdminEmailTemplatesController::class, 'index'])->middleware('auth');
Route::get('/admin/email-templates/edit', [AdminEmailTemplatesController::class, 'edit'])->middleware('auth');
Route::get('/admin/email-templates/edit/{id}', [AdminEmailTemplatesController::class, 'edit'])->middleware('auth');
Route::post('/admin/email-templates/store', [AdminEmailTemplatesController::class, 'store'])->middleware('auth');
Route::get('/admin/email-templates/delete/{id}', [AdminEmailTemplatesController::class, 'destroy'])->middleware('auth');
Route::post('/admin/email-templates/ajax-table-data', [AdminEmailTemplatesController::class, 'ajaxTableData'])->middleware('auth');

use App\Http\Controllers\Admin\TestimonialsController as AdminTestimonialsController; 
Route::get('/admin/testimonials', [AdminTestimonialsController::class, 'index'])->middleware('auth');
Route::get('/admin/testimonials/edit', [AdminTestimonialsController::class, 'edit'])->middleware('auth');
Route::get('/admin/testimonials/edit/{id}', [AdminTestimonialsController::class, 'edit'])->middleware('auth');
Route::post('/admin/testimonials/store', [AdminTestimonialsController::class, 'store'])->middleware('auth');
Route::get('/admin/testimonials/delete/{id}', [AdminTestimonialsController::class, 'destroy'])->middleware('auth');
Route::post('/admin/testimonials/ajax-table-data', [AdminTestimonialsController::class, 'ajaxTableData'])->middleware('auth');

use App\Http\Controllers\Admin\BlogsController as AdminBlogsController; 
Route::get('/admin/blogs', [AdminBlogsController::class, 'index'])->middleware('auth');
Route::get('/admin/blogs/edit', [AdminBlogsController::class, 'edit'])->middleware('auth');
Route::get('/admin/blogs/edit/{id}', [AdminBlogsController::class, 'edit'])->middleware('auth');
Route::post('/admin/blogs/store', [AdminBlogsController::class, 'store'])->middleware('auth');
Route::get('/admin/blogs/delete/{id}', [AdminBlogsController::class, 'destroy'])->middleware('auth');
Route::post('/admin/blogs/get-slug-url', [AdminBlogsController::class, 'getSlugUrl'])->middleware('auth');
Route::post('/admin/blogs/ajax-table-data', [AdminBlogsController::class, 'ajaxTableData'])->middleware('auth');

use App\Http\Controllers\Admin\HomeSlidersController as AdminHomeSlidersController; 
Route::get('/admin/home-sliders', [AdminHomeSlidersController::class, 'index'])->middleware('auth');
Route::get('/admin/home-sliders/edit', [AdminHomeSlidersController::class, 'edit'])->middleware('auth');
Route::get('/admin/home-sliders/edit/{id}', [AdminHomeSlidersController::class, 'edit'])->middleware('auth');
Route::post('/admin/home-sliders/store', [AdminHomeSlidersController::class, 'store'])->middleware('auth');
Route::get('/admin/home-sliders/delete/{id}', [AdminHomeSlidersController::class, 'destroy'])->middleware('auth');
Route::post('/admin/home-sliders/get-slug-url', [AdminHomeSlidersController::class, 'getSlugUrl'])->middleware('auth');
Route::post('/admin/home-sliders/ajax-table-data', [AdminHomeSlidersController::class, 'ajaxTableData'])->middleware('auth');

use App\Http\Controllers\Admin\PagesController as AdminPagesController;
Route::get('/admin/pages', [AdminPagesController::class, 'index'])->middleware('auth');
Route::get('/admin/pages/edit', [AdminPagesController::class, 'edit'])->middleware('auth');
Route::get('/admin/pages/edit/{id}', [AdminPagesController::class, 'edit'])->middleware('auth');
Route::post('/admin/pages/store', [AdminPagesController::class, 'store'])->middleware('auth');
Route::get('/admin/pages/delete/{id}', [AdminPagesController::class, 'destroy'])->middleware('auth');
Route::post('/admin/pages/get-slug-url', [AdminPagesController::class, 'getSlugUrl'])->middleware('auth');
Route::post('/admin/pages/ajax-table-data', [AdminPagesController::class, 'ajaxTableData'])->middleware('auth');

use App\Http\Controllers\Admin\MenusController as AdminMenusController;
Route::get('/admin/menus', [AdminMenusController::class, 'index'])->middleware('auth');
Route::get('/admin/menus/edit', [AdminMenusController::class, 'edit'])->middleware('auth');
Route::get('/admin/menus/edit/{id}', [AdminMenusController::class, 'edit'])->middleware('auth');
Route::post('/admin/menus/store', [AdminMenusController::class, 'store'])->middleware('auth');
Route::get('/admin/menus/delete/{id}', [AdminMenusController::class, 'destroy'])->middleware('auth');
Route::post('/admin/menus/get-slug-url', [AdminMenusController::class, 'getSlugUrl'])->middleware('auth');
Route::post('/admin/menus/update-serialize-menus', [AdminMenusController::class, 'updateSerializeMenus'])->middleware('auth');

use App\Http\Controllers\Admin\UsersController as AdminUsersController;
Route::get('/admin/users', [AdminUsersController::class, 'index'])->middleware('auth');
Route::get('/admin/users/edit', [AdminUsersController::class, 'edit'])->middleware('auth');
Route::get('/admin/users/edit/{id}', [AdminUsersController::class, 'edit'])->middleware('auth');
Route::post('/admin/users/store', [AdminUsersController::class, 'store'])->middleware('auth');
Route::get('/admin/users/delete/{id}', [AdminUsersController::class, 'destroy'])->middleware('auth');
Route::post('/admin/users/ajax-table-data', [AdminUsersController::class, 'ajaxTableData'])->middleware('auth');
Route::post('/admin/users/check-username', [AdminUsersController::class, 'checkUsername']);
Route::post('/admin/users/check-email', [AdminUsersController::class, 'checkEmail']);

use App\Http\Controllers\Admin\ContactsController as AdminContactsController; 
Route::get('/admin/contacts', [AdminContactsController::class, 'index'])->middleware('auth');
Route::get('/admin/contacts/details/{id}', [AdminContactsController::class, 'details'])->middleware('auth');
Route::get('/admin/contacts/delete/{id}', [AdminContactsController::class, 'destroy'])->middleware('auth');
Route::post('/admin/contacts/ajax-table-data', [AdminContactsController::class, 'ajaxTableData'])->middleware('auth');
