<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\PagesController;

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

Route::get('/', [PagesController::class, 'catalog']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [PagesController::class, 'catalog'])->name('catalog');
Route::get('/catalog/{id}', [PagesController::class, 'productPage'])->name('product.show');

// basket
Route::post('/store-in-basket', [PagesController::class, 'store_in_basket'])->name('store.basket');
Route::get('/basket', [PagesController::class, 'basket'])->name('basket');

// basket update and remove routes
Route::post('/basket/update/{id}/{action}', [PagesController::class, 'updateBasket'])->name('basket.update');
Route::delete('/basket/remove/{id}', [PagesController::class, 'removeFromBasket'])->name('basket.remove');

// orders 
Route::post('/place-order', [PagesController::class, 'placeOrder'])->name('place.order');
Route::get('/orders', [PagesController::class, 'orders'])->name('orders');


// admin
Route::get('/admin1', [PagesController::class, 'admin1']);
Route::post('/admin2', [PagesController::class, 'admin2']);
Route::get('/admin-logout', [PagesController::class, 'admin_logout'])->name('admin.logout');
// admin pages
Route::get('/add-product1', [PagesController::class, 'add_product1'])->name('add.product');
Route::post('/add-product2', [PagesController::class, 'add_product2']);

Route::get('/admin/products', [PagesController::class, 'adminProducts'])->name('admin.products');
Route::get('/admin/products/edit/{id}', [PagesController::class, 'editProductForm'])->name('admin.products.edit');
Route::post('/admin/products/edit/{id}', [PagesController::class, 'updateProduct'])->name('admin.products.update');
Route::delete('/admin/products/delete/{id}', [PagesController::class, 'deleteProduct'])->name('admin.products.delete');