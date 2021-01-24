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


//Rutas Generales
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//UserController
Route::get('/admin', [App\Http\Controllers\UserController::class, 'admin'])->name('admin');
Route::get('/config', [App\Http\Controllers\UserController::class, 'config'])->name('config');
Route::post('/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename}', [\App\Http\Controllers\UserController::class, 'getImage'])->name('user.image');
Route::get('/privacy', [App\Http\Controllers\UserController::class, 'privacyPolicy'])->name('privacy');
Route::get('/shipping-returns', [App\Http\Controllers\UserController::class, 'shippingAndReturns'])->name('ship-nd-returns');
Route::get('/contact', [App\Http\Controllers\UserController::class, 'contact'])->name('contact');
Route::get('/contact/email', [App\Http\Controllers\UserController::class, 'sendContactMail'])->name('contactmail');


//CategoryController
Route::get('/category', [\App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
Route::post('/category/save', [\App\Http\Controllers\CategoryController::class, 'save'])->name('category.save');
Route::get('/category/all', [\App\Http\Controllers\CategoryController::class, 'getAll'])->name('category.all');
Route::get('/category/delete/{id}', [\App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');
Route::get('/category/edit/{id}', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
Route::get('/category/{filename}', [\App\Http\Controllers\CategoryController::class, 'getImage'])->name('category.image');



//ProductController
Route::get('/product', [\App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
Route::post('/product/save', [\App\Http\Controllers\ProductController::class, 'save'])->name('product.save');
Route::get('/product/all', [\App\Http\Controllers\ProductController::class, 'getAll'])->name('product.all');
Route::get('/product/{filename}', [\App\Http\Controllers\ProductController::class, 'getImage'])->name('product.image');
Route::get('/product/delete/{id}', [\App\Http\Controllers\ProductController::class, 'delete'])->name('product.delete');
Route::get('/product/edit/{id}', [\App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/update/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::get('/product/detail/{brand}-{name}', [\App\Http\Controllers\ProductController::class, 'detail'])->name('product.detail');
Route::get('/product/stock/{id}', [\App\Http\Controllers\ProductController::class, 'stock'])->name('product.stock');
Route::post('/product/updateStock/{id}', [\App\Http\Controllers\ProductController::class, 'updateStock'])->name('product.updateStock');
Route::get('/products', [\App\Http\Controllers\ProductController::class, 'getAllForUsers'])->name('products.all');
Route::get('/products/category/{id}', [\App\Http\Controllers\ProductController::class, 'categoriesForUser'])->name('products.category');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');



//ProductImageController
Route::get('/product/image/{id}', [\App\Http\Controllers\ProductImageController::class, 'deleteImage'])->name('product_image.delete');



//CartController
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart/delete/{id}', [App\Http\Controllers\CartController::class, 'delete'])->name('cart.delete');
Route::get('/cart/more-quantity/{id}', [App\Http\Controllers\CartController::class, 'moreQuantity'])->name('cart.more-quantity');
Route::get('/cart/less-quantity/{id}', [App\Http\Controllers\CartController::class, 'lessQuantity'])->name('cart.less-quantity');


//AddressController
Route::get('/config/address', [App\Http\Controllers\AddressController::class, 'index'])->name('address.index');
Route::get('/config/address/create', [\App\Http\Controllers\AddressController::class, 'create'])->name('address.create');
Route::post('/config/address/save', [\App\Http\Controllers\AddressController::class, 'save'])->name('address.save');
Route::get('/config/address/set-default/{id}', [\App\Http\Controllers\AddressController::class, 'setDefault'])->name('address.set-default');
Route::get('/config/address/edit/{id}', [\App\Http\Controllers\AddressController::class, 'edit'])->name('address.edit');
Route::post('/config/address/update/{id}', [\App\Http\Controllers\AddressController::class, 'update'])->name('address.update');
Route::get('/config/address/delete/{id}', [\App\Http\Controllers\AddressController::class, 'delete'])->name('address.delete');


//OrderController
Route::get('/order', [\App\Http\Controllers\OrderController::class, 'create'])->name('order.create');
Route::get('/order/save', [\App\Http\Controllers\OrderController::class, 'save'])->name('order.save');
Route::get('/order/address', [\App\Http\Controllers\OrderController::class, 'changeAddress'])->name('order.address');
Route::get('/order/manage', [\App\Http\Controllers\OrderController::class, 'index'])->name('order.manage');
Route::get('/order/manage/all', [\App\Http\Controllers\OrderController::class, 'all'])->name('order.manage.all');
Route::get('/order/manage/pending/{search?}', [\App\Http\Controllers\OrderController::class, 'pending'])->name('order.manage.pending');
Route::get('/order/manage/finalized/{search?}', [\App\Http\Controllers\OrderController::class, 'finalized'])->name('order.manage.finalized');
Route::get('/order/manage/canceled/{search?}', [\App\Http\Controllers\OrderController::class, 'canceled'])->name('order.manage.canceled');
Route::get('/order/manage/detail/{id}', [\App\Http\Controllers\OrderController::class, 'detail'])->name('order.manage.detail');
Route::get('/order/manage/edit/{id}', [\App\Http\Controllers\OrderController::class, 'edit'])->name('order.manage.edit');
Route::post('/order/manage/update/{id}{address_id}', [\App\Http\Controllers\OrderController::class, 'update'])->name('order.manage.update');
Route::get('/order/user/all', [\App\Http\Controllers\OrderController::class, 'userAll'])->name('order.user.all');
Route::get('/order/email', [\App\Http\Controllers\OrderController::class, 'sendMail'])->name('sendmail');


//StripeController
Route::get('stripe', [\App\Http\Controllers\StripePaymentController::class, 'stripe'])->name('stripe.payment');
Route::post('stripe', [\App\Http\Controllers\StripePaymentController::class, 'stripePost'])->name('stripe.post');