<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('login');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
Auth::routes(['verify' => true]);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/dang-ky', [App\Http\Controllers\HomeController::class, 'regis'])->name('regis');
Route::get('search_product', [App\Http\Controllers\HomeController::class,'ajaxSearch'])->name('search_product');

Route::get('/danh-muc/{slug}', [App\Http\Controllers\ProductController::class, 'showProductBySlug'])->name('showProductBySlug');
Route::get('/san-pham/{slug}', [App\Http\Controllers\ProductController::class, 'showDetailProduct'])->name('showDetailProduct');

Route::get('/{slug}', [App\Http\Controllers\PageController::class, 'showPageBySlug'])->name('showPageBySlug');
Route::post('/thong-bao-lien-he', [App\Http\Controllers\PageController::class, 'store']);
Route::get('/tin-tuc/{slug}', [App\Http\Controllers\PageController::class, 'showNewsArticle']);

Route::get('cart/gio-hang', [App\Http\Controllers\CartController::class, 'show'])->name('cart.show');
Route::get('cart/add', [App\Http\Controllers\CartController::class, 'ajaxAdd'])->name('cart.add');
Route::get('cart/remove/{rowId}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('cart/destroy', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
Route::get('cart/update', [App\Http\Controllers\CartController::class,'update'])->name('cart.update');
Route::get('cart/thanh-toan', [App\Http\Controllers\CartController::class,'checkout'])->name('checkout');
Route::post('order/add', [App\Http\Controllers\CartController::class,'order']);
Route::get('chi-tiet-don-hang/{idDH}', [App\Http\Controllers\CartController::class,'detailOrder'])->name('detailOrder');

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'show'])->name('dashboard');
    Route::get('admin', [App\Http\Controllers\DashboardController::class, 'show']);
    Route::get('admin/user/list', [App\Http\Controllers\AdminUserController::class, 'list'])->name('user.view');
    Route::get('admin/user/add', [App\Http\Controllers\AdminUserController::class, 'add'])->can('user.add');
    Route::post('admin/user/store', [App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.user.store')->can('user.add');
    Route::get('admin/user/delete/{id}', [App\Http\Controllers\AdminUserController::class, 'delete'])->name('delete_user')->can('user.delete');
    Route::get('admin/user/action', [App\Http\Controllers\AdminUserController::class, 'action']);
    Route::get('admin/user/edit/{id}', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('user.edit')->can('user.edit');
    Route::post('admin/user/update/{id}', [App\Http\Controllers\AdminUserController::class, 'update'])->name('user.update')->can('user.edit');

    Route::get('admin/page/list', [App\Http\Controllers\AdminPageController::class, 'list'])->name('admin.page.list');
    Route::get('admin/page/add', [App\Http\Controllers\AdminPageController::class, 'add'])->can('page.add');
    Route::post('admin/page/store', [App\Http\Controllers\AdminPageController::class, 'store'])->can('page.add');
    Route::get('admin/page/delete/{id}', [App\Http\Controllers\AdminPageController::class, 'delete'])->name('delete_page')->can('page.delete');
    Route::get('admin/page/action', [App\Http\Controllers\AdminPageController::class, 'action']);
    Route::get('admin/page/edit/{id}', [App\Http\Controllers\AdminPageController::class, 'edit'])->name('page.edit')->can('page.edit');
    Route::post('admin/page/update/{id}', [App\Http\Controllers\AdminPageController::class, 'update'])->name('page.update')->can('page.edit');

    Route::get('admin/post/list', [App\Http\Controllers\AdminPostController::class, 'list'])->name('admin.post.list');
    Route::get('admin/post/cat/list', [App\Http\Controllers\AdminPostController::class, 'listCat'])->name('admin.post.listCat');
    Route::post('admin/post/cat/store', [App\Http\Controllers\AdminPostController::class, 'storeCat'])->can('post.add');
    Route::get('admin/post/cat/edit/{id}', [App\Http\Controllers\AdminPostController::class, 'editCat'])->name('admin.post.editCat')->can('post.edit');
    Route::get('admin/post/edit/{id}', [App\Http\Controllers\AdminPostController::class, 'editPost'])->name('admin.post.editPost')->can('post.edit');
    Route::post('admin/post/cat/update/{id}', [App\Http\Controllers\AdminPostController::class, 'updateCat'])->name('admin.post.updateCat')->can('post.edit');
    Route::post('admin/post/update/{id}', [App\Http\Controllers\AdminPostController::class, 'updatePost'])->name('admin.post.updatePost')->can('post.edit');
    Route::get('admin/post/delete/{id}', [App\Http\Controllers\AdminPostController::class, 'delete'])->name('delete_catpost')->can('post.delete');
    Route::get('admin/post/add', [App\Http\Controllers\AdminPostController::class, 'add'])->name('admin.post.add')->can('post.add');
    Route::post('admin/post/store', [App\Http\Controllers\AdminPostController::class, 'store'])->can('post.add');
    Route::get('admin/post/action', [App\Http\Controllers\AdminPostController::class, 'action']);
    Route::get('admin/post/deletePost/{id}', [App\Http\Controllers\AdminPostController::class, 'deletePost'])->name('delete_post')->can('post.delete');

    Route::get('admin/product/list', [App\Http\Controllers\AdminProductController::class, 'list'])->name('admin.product.list');
    Route::get('admin/product/add', [App\Http\Controllers\AdminProductController::class, 'add'])->name('admin.product.add')->can('product.add');
    Route::get('admin/product/cat', [App\Http\Controllers\AdminProductController::class, 'cat'])->name('admin.product.cat');
    Route::post('admin/product/cat/store', [App\Http\Controllers\AdminProductController::class, 'storeCat'])->can('product.add');
    Route::get('admin/product/cat/delete/{id}', [App\Http\Controllers\AdminProductController::class, 'deleteCat'])->name('delete_catproduct')->can('product.delete');
    Route::get('admin/product/cat/edit/{id}', [App\Http\Controllers\AdminProductController::class, 'editCat'])->name('admin.product.editCat')->can('product.edit');
    Route::post('admin/product/updateCat/{id}', [App\Http\Controllers\AdminProductController::class, 'updateCat'])->name('admin.product.updateCat')->can('product.edit');
    Route::get('admin/product/product-brand/list', [App\Http\Controllers\AdminProductController::class, 'listBrand'])->name('admin.product.listBrand');
    Route::post('admin/product/product-brand/store', [App\Http\Controllers\AdminProductController::class, 'storeBrand'])->can('product.add');
    Route::get('admin/product/product-brand/delete/{id}', [App\Http\Controllers\AdminProductController::class, 'deleteBrand'])->name('admin.product.deleteBrand')->can('product.delete');
    Route::get('admin/product/product-brand/edit/{id}', [App\Http\Controllers\AdminProductController::class, 'editBrand'])->name('admin.product.editBrand')->can('product.edit');
    Route::post('admin/product/product-brand/update/{id}', [App\Http\Controllers\AdminProductController::class, 'updateBrand'])->name('admin.product.updateBrand');
    Route::get('admin/product/product-color/list', [App\Http\Controllers\AdminProductController::class, 'listColor'])->name('admin.product.listColor');
    Route::post('admin/product/product-color/add_color', [App\Http\Controllers\AdminProductController::class, 'add_color'])->can('product.add');
    Route::get('admin/product/product-color/delete/{id}', [App\Http\Controllers\AdminProductController::class, 'deleteColor'])->name('admin.product.deleteColor')->can('product.delete');
    Route::post('admin/product/store', [App\Http\Controllers\AdminProductController::class, 'store'])->name('product.store');
    Route::get('admin/product/action', [App\Http\Controllers\AdminProductController::class, 'action']);
    Route::get('admin/product/edit/{id}', [App\Http\Controllers\AdminProductController::class, 'editProduct'])->name('admin.product.editProduct')->can('product.edit');
    Route::post('admin/product/update/{id}', [App\Http\Controllers\AdminProductController::class, 'update'])->name('admin.product.update')->can('product.edit');
    Route::get('admin/product/deleteProduct/{id}', [App\Http\Controllers\AdminProductController::class, 'deleteProduct'])->name('delete_product')->can('product.delete');
    Route::get('admin/product/add_img/{id}', [App\Http\Controllers\AdminProductController::class, 'add_img'])->name('admin.product.add_img')->can('product.add');
    Route::post('admin/product/update_img/{id}', [App\Http\Controllers\AdminProductController::class, 'update_img'])->name('admin.product.update_img');
    Route::get('admin/product/delete_img/{id}', [App\Http\Controllers\AdminProductController::class, 'delete_img'])->name('delete_img');

    Route::post('admin/slider/add', [App\Http\Controllers\AdminSliderController::class, 'add'])->name('admin.slider.add');
    Route::get('admin/slider/list', [App\Http\Controllers\AdminSliderController::class, 'list'])->name('admin.slider.list');
    Route::get('admin/slider/delete/{id}', [App\Http\Controllers\AdminSliderController::class, 'delete'])->name('admin.slider.delete')->can('slider.delete');
    Route::get('admin/slider/up/{id}', [App\Http\Controllers\AdminSliderController::class, 'up'])->name('admin.slider.up');

    Route::get('admin/order/list', [App\Http\Controllers\AdminOrderController::class, 'list'])->name('admin.order.list');
    Route::get('admin/order/detail/{id}', [App\Http\Controllers\AdminOrderController::class, 'detail'])->name('admin.order.detail')->can('order.detail');
    Route::post('admin/order/update_status/{id}', [App\Http\Controllers\AdminOrderController::class, 'update_status'])->name('admin.order.update_status');
    Route::get('admin/order/delete/{id}', [App\Http\Controllers\AdminOrderController::class, 'delete'])->name('admin.order.delete_order')->can('order.delete');
    Route::get('admin/order/action', [App\Http\Controllers\AdminOrderController::class, 'action']);

    Route::get('admin/permission/list', [App\Http\Controllers\AdminPermissionController::class, 'list'])->name('admin.permission.list');
    Route::get('admin/permission/add', [App\Http\Controllers\AdminPermissionController::class, 'add'])->name('admin.permission.add');
    Route::post('admin/permission/store', [App\Http\Controllers\AdminPermissionController::class, 'store'])->name('admin.permission.store');
    Route::get('admin/permission/edit/{id}', [App\Http\Controllers\AdminPermissionController::class, 'edit'])->name('admin.permission.edit');
    Route::post('admin/permission/update/{id}', [App\Http\Controllers\AdminPermissionController::class, 'update'])->name('admin.permission.update');
    Route::get('admin/permission/delete/{id}', [App\Http\Controllers\AdminPermissionController::class, 'delete'])->name('admin.permission.delete');

    Route::get('admin/role/add', [App\Http\Controllers\AdminRoleController::class, 'add'])->name('admin.role.add')->can('role.add');
    Route::post('admin/role/store', [App\Http\Controllers\AdminRoleController::class, 'store'])->name('admin.role.store')->can('role.add');
    Route::get('admin/role', [App\Http\Controllers\AdminRoleController::class, 'index'])->name('admin.role.index')->can('role.view');
    Route::get('admin/role/edit/{role}', [App\Http\Controllers\AdminRoleController::class, 'edit'])->name('admin.role.edit')->can('role.edit');
    Route::post('admin/role/update/{role}', [App\Http\Controllers\AdminRoleController::class, 'update'])->name('admin.role.update')->can('role.edit');
    Route::get('admin/role/delete/{role}', [App\Http\Controllers\AdminRoleController::class, 'delete'])->name('admin.role.delete')->can('role.delete');
});
