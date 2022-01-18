<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;


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

Route:: get('/items',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/sale_transactions',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/purchase_transactions',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/profile',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/newSale',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/newPurchase',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/target',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/item_details/{id}',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/transaction_detail/{id}',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/import',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/addNewItem',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');

Auth::routes();

Route:: get('/home',[App\Http\Controllers\HomeController::class,'index'])->name('home');
Route:: post('/CheckEmail',[App\Http\Controllers\UserController::class,'checkEmail']);
Route:: post('/registerUser',[App\Http\Controllers\Auth\RegisterController::class,'create']);

Route::post('/addPurchaseData',[TransactionController::class, 'addPurchaseTransaction']);

// //sent to Page
// Route::get('/manage_items', 'App\Http\Controllers\PageController@itemPage');

// //item management
// Route::post('/add_item', 'App\Http\Controllers\ItemController@addItem');
