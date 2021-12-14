<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\TransactionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// untuk di call axios yang ada di component vue bagian method>> bisa call controller 
Route::get('get_category',[CategoryController::class, 'index']);

Route::get('getUnitType',[UnitTypeController::class, 'index']);

Route::get('getItem',[ItemController::class, 'getItem']);
Route::post('add_item/{id}',[ItemController::class, 'addItem']);
Route::post('edit_item/{id}',[ItemController::class, 'editItem']);
Route::post('delete_item/{id}',[ItemController::class, 'deleteItem']);

Route::get('getPurchaseTransactions',[TransactionController::class, 'getPurchaseTransactions']);
Route::post('addPurchaseData',[TransactionController::class, 'addPurchaseTransaction']);
Route::get('getTransactionType',[TransactionController::class, 'getTransactionType']);
