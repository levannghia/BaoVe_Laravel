<?php

use App\Http\Controllers\admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\site\ProductSiteController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\GalleryController;
use App\Http\Controllers\admin\AuthenticationController;
use App\Http\Controllers\admin\CategoryLV1Controller;
use App\Http\Controllers\admin\NewsController;
use App\Http\Controllers\admin\NhaDatController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\PhotoController;
use App\Http\Controllers\admin\StandardController;
use App\Http\Controllers\admin\VideoController;
use App\Http\Controllers\admin\ConfigController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\SeoPageController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\YKienKHControlle;
use App\Http\Controllers\site\HomeController;
use App\Http\Controllers\site\NewsSiteController;
use App\Http\Controllers\site\PageSiteController;
use App\Http\Controllers\site\VideoSiteController;
use App\Http\Controllers\site\CartController;
use App\Http\Controllers\site\LocationController;
use App\Http\Controllers\site\OrderSiteController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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

//USER
// Route::get('/public', function () {
//     return abort(404);
// });
Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'vi'])) {
        abort(400);
    }
 
    App::setLocale($locale);
 
    Session::put('locale',$locale);
    return redirect()->back();
});
Route::get("/", [HomeController::class, "index"])->name('home');
Route::get("/site-map", [HomeController::class, "siteMap"]);
Route::get("/category-lv1-show-products/{id}", [HomeController::class, "showProductInCategoryLV1"]);
Route::post("/show-map", [HomeController::class, "showMap"])->name('show.map');
Route::post("/hover-category-lv-1", [HomeController::class, "hoverCategoryLV1"])->name('hover.category');
// Route::get("/site", [HomeController::class, "siteMap"])->name('site.map');
Route::get("/home", [HomeController::class, "getProductByCategory"])->name('show.product.category');
Route::get("/search", [HomeController::class, "Search"])->name('search.product');
//Product
Route::get("/san-pham/{slug}", [ProductSiteController::class, "getProductBySlug"])->name('get.product.slug');
Route::get("/san-pham", [ProductSiteController::class, "getAllProduct"])->name('get.product');
Route::get("/mua-ban-nha-dat/{slug}", [ProductSiteController::class, "getNhaDatBySlug"])->name('get.nha.dat.slug');
Route::get("/mua-ban-nha-dat", [ProductSiteController::class, "getAllNhaDat"])->name('get.nha.dat');
Route::get("/danh-muc/{slug}", [ProductSiteController::class, "productCategory"])->name('get.product.category.slug');

//News
Route::get("/tin-tuc/{slug}", [NewsSiteController::class, "getNewsBySlug"])->name('get.news.slug');
Route::get("/tin-tuc", [NewsSiteController::class, "getAllNews"])->name('get.news');
//page
Route::get("/lien-he", [PageSiteController::class, "getPageLienHe"])->name('get.page.lien.he');
Route::post("/post-lien-he", [PageSiteController::class, "postLienHe"])->name('post.page.lien.he');
Route::get("/gioi-thieu", [PageSiteController::class, "getPageGioiThieu"])->name('get.page.gioi.thieu');
//video
Route::get("/video", [VideoSiteController::class, "getAllVideo"])->name('get.video');
//Cart
Route::post("/cart", [CartController::class, "saveCart"])->name('save.cart');
Route::get("/cart", [CartController::class, "getCart"]);
Route::get("/delete-cart/{rowId}", [CartController::class, "deleteCart"]);
Route::post("/update-cart", [CartController::class, "updateCart"])->name('update.cart');

//location
Route::get("/quan-huyen", [LocationController::class, "loadQuanHuyen"]);
Route::get("/phuong-xa", [LocationController::class, "loadPhuongXa"]);

//order
Route::post("/order/check-out", [OrderSiteController::class, "checkOut"])->name('check.out');

//ADMIN

Route::prefix('admin')->group(function () {
    //login
    Route::get("/login", [AuthenticationController::class, "getLogin"])->name("admin.login");
    Route::post("/login", [AuthenticationController::class, "postLogin"])->name("admin.post.login");
    Route::get("/logout", [AuthenticationController::class, "logout"])->name("admin.logout");
    Route::get("/create", [AuthenticationController::class, "create"])->name("admin.create");
    Route::middleware(['check.login'])->group(function () {
        //admin
        Route::name("admin.")->controller(AuthenticationController::class)->group(function () {
            Route::get('/profile', 'getProfile')->name('profile');
            Route::post('/change-password', 'changePassword')->name('change.password');
            Route::post('/update', 'update')->name('update');
            // Route::post('/orders', 'store');
        });
        //dashboard
        Route::name("admin.dashboard.")->controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'thongKe')->name('thong.ke');
            // Route::get('/test', 'test');
        });
        // //Category LV1
        // Route::name('admin.category.lv1.')->prefix('category-lv-1')->controller(CategoryLV1Controller::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/add', 'create')->name('add');
        //     Route::post('/store', 'store')->name('store');
        //     Route::get('/edit/{id}', 'edit')->name('edit');
        //     Route::get('/delete/{id}', 'destroy')->name('delete');
        //     Route::post('/update/{id}', 'update')->name('update');
        //     Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
        //     Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
        //     Route::get('/status/{id}/{status}', 'status')->name('status');
        //     Route::post('/resorting', 'resortPosition')->name('resorting');
        // });

        // //Category
        // Route::name('admin.category.')->prefix('category')->controller(CategoryController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/add', 'create')->name('add');
        //     Route::post('/store', 'store')->name('store');
        //     Route::get('/edit/{id}', 'edit')->name('edit');
        //     Route::post('/update/{id}', 'update')->name('update');
        //     Route::get('/delete/{id}', 'destroy')->name('delete');
        //     Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
        //     Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
        //     Route::get('/status/{id}/{status}', 'status')->name('status');
        //     Route::post('/resorting', 'resortPosition')->name('resorting');
        // });

        // //Product
        // Route::name('admin.product.')->prefix('product')->controller(ProductController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/add', 'create')->name('add');
        //     Route::post('/store', 'store')->name('store');
        //     Route::get('/edit/{id}', 'edit')->name('edit');
        //     Route::post('/update/{id}', 'update')->name('update');
        //     Route::get('/delete/{id}', 'destroy')->name('delete');
        //     Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
        //     Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
        //     Route::get('/status/{id}/{status}', 'status')->name('status');
        // });

        // //Nha Dat
        // Route::name('admin.nha.dat.')->prefix('nha-dat')->controller(NhaDatController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/add', 'create')->name('add');
        //     Route::post('/store', 'store')->name('store');
        //     Route::get('/edit/{id}', 'edit')->name('edit');
        //     Route::post('/update/{id}', 'update')->name('update');
        //     Route::get('/delete/{id}', 'destroy')->name('delete');
        //     Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
        //     Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
        //     Route::get('/status/{id}/{status}', 'status')->name('status');
        // });

        // //Gallery
        // Route::name('admin.gallery.')->prefix('gallery')->controller(GalleryController::class)->group(function () {
        //     Route::get('/{id}', 'index')->name('index');
        //     Route::get('/add/{id}', 'create')->name('add');
        //     Route::post('/store/{id}', 'store')->name('store');
        //     Route::get('/edit/{id}', 'edit')->name('edit');
        //     Route::post('/update/{id}', 'update')->name('update');
        //     Route::get('/delete/{id}', 'destroy')->name('delete');
        //     Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
        //     Route::get('/status/{id}/{status}', 'status')->name('status');
        //     Route::post('/resorting', 'resortPosition')->name('resorting');
        // });

        //New
        Route::name('admin.news.')->prefix('news')->controller(NewsController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('add');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('delete');
            Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
            Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
            Route::get('/status/{id}/{status}', 'status')->name('status');
        });

        //Dịch Vụ
        Route::name('admin.service.')->prefix('service')->controller(ServiceController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('add');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('delete');
            Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
            Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
            Route::get('/status/{id}/{status}', 'status')->name('status');
        });

        //Video
        Route::name('admin.video.')->prefix('video')->controller(VideoController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('add');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('delete');
            Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
            Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
            Route::get('/status/{id}/{status}', 'status')->name('status');
        });

        //tiêu chí
        Route::name('admin.standard.')->prefix('tieu-chi')->controller(StandardController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('add');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('delete');
            Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
            Route::get('/status/{id}/{status}', 'status')->name('status');
            Route::post('/resorting', 'resortPosition')->name('resorting');
        });

        //Trang tĩnh
        Route::name('admin.page.')->prefix('page')->controller(PageController::class)->group(function () {
            Route::get('/{slug}', 'getPage')->name('get');
            Route::post('/{id}', 'postPage')->name('post');
        });

        //Seo Page
        Route::name('admin.seo.page.')->prefix('seo-page')->controller(SeoPageController::class)->group(function () {
            Route::get('/{type}', 'getSeoPage')->name('get');
            Route::post('/{id}', 'postSeoPage')->name('post');

            // Route::get('/status/{id}/{status}', 'status')->name('status');
            // Route::post('/resorting', 'resortPosition')->name('resorting');
        });

        //Photo
        Route::name('admin.photo.')->prefix('photo')->controller(PhotoController::class)->group(function () {
            Route::get('/logo', 'getLogo')->name('logo');
            Route::get('/favicon', 'getFavicon')->name('favicon');
            Route::post('/photo/{id}', 'postPhoto')->name('post.photo');

            Route::get('/add/{type}', 'create')->name('create.list');
            Route::post('/store/{type}', 'store')->name('store');
            Route::get('/{type}', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');

            Route::get('/delete/{id}', 'destroy')->name('delete');
            Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
            Route::get('/status/{id}/{status}', 'status')->name('status');
            Route::post('/resorting', 'resortPosition')->name('resorting');
        });

        //config
        Route::name('admin.config.')->prefix('config')->controller(ConfigController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/update', 'update')->name('update');
        });

        //Contact
        Route::name('admin.contact.')->prefix('contact')->controller(ContactController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            // Route::get('/add', 'create')->name('add');
            // Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('delete');
            Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
            // Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
            Route::get('/status/{id}/{status}', 'status')->name('status');
        });

        //order
        Route::name('admin.order.')->prefix('don-hang')->controller(OrderController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('add');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}', 'orderDetail')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('delete');
            Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
            Route::post('/status', 'status')->name('status');
            Route::post('/resorting', 'resortPosition')->name('resorting');
        });

        //Ý kiến khách hàng
        Route::name('admin.y.kien.')->prefix('y-kien-khach-hang')->controller(YKienKHControlle::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('add');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('delete');
            Route::get('/delete-all/{id}', 'deleteAll')->name('delete.all');
            Route::get('/noi-bac/{id}/{noiBac}', 'noiBac')->name('noi.bac');
            Route::get('/status/{id}/{status}', 'status')->name('status');
        });
    });
});
