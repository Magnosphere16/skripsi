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

Route::get('/', function () {
    return view('welcome');
});

Route:: get('/items',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/transactions',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');
Route:: get('/profile',[App\Http\Controllers\HomeController::class,'index'])->where('any','.*');

Auth::routes();

Route:: get('/home',[App\Http\Controllers\HomeController::class,'index']);

// //sent to Page
// Route::get('/manage_items', 'App\Http\Controllers\PageController@itemPage');

// //item management
// Route::post('/add_item', 'App\Http\Controllers\ItemController@addItem');
