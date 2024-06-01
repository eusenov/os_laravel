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

Route::get('/catalog', [PagesController::class, 'catalog'])->name('catalog');
Route::get('/catalog/{id}', [PagesController::class, 'productPage'])->name('product.show');

// basket
Route::post('/store-in-basket', [PagesController::class, 'store_in_basket'])->name('store.basket');
Route::get('/basket', [PagesController::class, 'basket'])->name('basket');

// admin
Route::get('/admin-login', [PagesController::class, 'admin_login']);
Route::post('/admin-val', [PagesController::class, 'admin_val']);
Route::get('/admin', [PagesController::class, 'admin'])->name('admin');

Route::get('/admin-logout', [PagesController::class, 'admin_logout'])->name('admin.logout');

// admin pages
Route::get('/add-product1', [PagesController::class, 'add_product1'])->name('add.product');
Route::post('/add-product2', [PagesController::class, 'add_product2']);
