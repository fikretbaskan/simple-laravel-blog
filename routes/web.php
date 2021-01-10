<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Back\ConfigController;



/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/

/*Route::get('admin/panel',[Dashboard::class,'index'])->name('admin.dashboard');
Route::get('admin/login',[AuthController::class,'login'])->name('admin.login');
Route::post('admin/login',[AuthController::class,'loginpost'])->name('admin.login.post');
Route::get('admin/logout',[AuthController::class,'logout'])->name('admin.logout');
*/

Route::get('aktif-degil',function(){
    return view('front.widgets.offline');
});

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function(){
    Route::get('login',[AuthController::class,'login'])->name('login');
    Route::post('login',[AuthController::class,'loginpost'])->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
    Route::get('panel',[Dashboard::class,'index'])->name('dashboard');
    //Eğer giriş yapışsa routelerı
    //Articles
    Route::get('articles/trashed',[ArticleController::class,'trashed'])->name('trashed');
    Route::resource('articles',ArticleController::class);
    Route::get('/switch',[ArticleController::class,'mySwitch'])->name('switch');
    Route::get('/recovery/article/{id}',[ArticleController::class,'recovery'])->name('recovery');
    Route::get('article/destroy/{id}',[ArticleController::class,'hardDestroy'])->name('hardDestroy');
    //Categories
    Route::get('categories',[CategoryController::class,'index'])->name('category.index');
    Route::get('categories/switch',[CategoryController::class,'mySwitch'])->name('category.switch');
    Route::post('categories/create',[CategoryController::class,'create'])->name('category.create');
    Route::post('categories/update',[CategoryController::class,'update'])->name('category.update');
    Route::post('categories/delete',[CategoryController::class,'delete'])->name('category.delete');
    Route::get('/categories/getData',[CategoryController::class,'getData'])->name('category.getdata');
    //pages
    Route::get('/pages',[PageController::class,'index'])->name('page.index');
    Route::get('/pages/create',[PageController::class,'create'])->name('page.create');
    Route::post('/pages/store',[PageController::class,'store'])->name('page.store');
    Route::get('/pages/switch',[PageController::class,'mySwitch'])->name('page.switch');
    Route::get('/pages/edit/{id}',[PageController::class,'edit'])->name('page.edit');
    Route::post('/pages/update/{id}',[PageController::class,'update'])->name('page.update');
    Route::get('/pages/delete/{id}',[PageController::class,'delete'])->name('page.delete');
    Route::get('/pages/order',[PageController::class,'orders'])->name('page.orders');

    Route::get('settings',[ConfigController::class,'index'])->name('settings');
    Route::post('settings/update',[ConfigController::class,'update'])->name('settings.update');

    Route::get('logout',[AuthController::class,'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [Homepage::class,'index'])->name('homepage');
//Route::get('/yazilar/sayfa', [Homepage::class,'index'])->name('homepage');
Route::get('/category/{categorySlug}',[Homepage::class,'category'])->name('category');
Route::get('/contact',[Homepage::class,'contact'])->name('contact'); //Başa taşıdık aşağıdan
Route::post('/contact',[Homepage::class,'contactpost'])->name('contact.post');
Route::get('/{category}/{slug}',[Homepage::class,'single'])->name('single');
Route::get('/{page}',[Homepage::class,'page'])->name('page');

