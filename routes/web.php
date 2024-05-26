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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/main', [PagesController::class, 'main']);

// admin
Route::get('/admin1', [PagesController::class, 'admin1']);
Route::post('/admin2', [PagesController::class, 'admin2']);
// admin pages
Route::get('/add-product1', [PagesController::class, 'add_product1']);
Route::post('/add-product2', [PagesController::class, 'add_product2']);