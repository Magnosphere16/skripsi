<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TurnOverController;

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

Route::get('downloadTransaction/{id}/{start}/{end}',[TransactionController::class, 'transactionExport']);
Route::get('get_category',[CategoryController::class, 'index']);

Route::get('getUnitType',[UnitTypeController::class, 'index']);

Route::get('getUnitTypeId/{id}',[ItemController::class, 'getUnitTypeId']);
Route::get('getCategoryId/{id}',[ItemController::class, 'getUnitTypeId']);


Route::get('getAsset',[TransactionController::class, 'getAsset']);

Route::post('add_item/{user_id}',[ItemController::class, 'addItem']);
Route::post('import_item/{user_id}',[ItemController::class, 'import']);

Route::post('edit_item/{id}',[ItemController::class, 'editItem']);
Route::post('delete_item/{id}',[ItemController::class, 'deleteItem']);

// Route::get('getPurchaseTransactions',[TransactionController::class, 'getPurchaseTransactions']);
Route::get('getSaleTransactions/{id}',[TransactionController::class, 'getSaleTransactions']);
Route::get('getTransactionType',[TransactionController::class, 'getTransactionType']);

Route::get('getTransactionDetail/{id}',[TransactionController::class, 'getSaleTransactions']);

// Route::post('addPurchaseData',[TransactionController::class, 'addPurchaseTransaction']);
Route::post('addSaleData',[TransactionController::class, 'addSaleTransaction']);

Route::get('getSale/{id}',[TransactionController::class, 'getSale']);

Route::get('getSoldProduct/{id}',[TransactionController::class, 'getSoldProduct']);
Route::get('getBestSeller/{id}',[TransactionController::class, 'bestSeller']);

Route::get('getItem/{id}',[ItemController::class, 'getItem']);

Route::post('setTarget/{id}',[TurnOverController::class,'setTarget']);
Route::get('getCurrMonthSale',[TurnOverController::class, 'getTurnOverCurrentMonth']);
Route::get('userTurnOver/{id}',[TurnOverController::class, 'getUserTurnOver']);

Route::get('getItemInfo/{id}',[ItemController::class, 'getItemInfo']);
Route::get('getSalesPerMonth/{id}',[TransactionController::class, 'getSalesPerMonth']);
Route::get('getSalesTransactionPerMonth/{id}',[TransactionController::class, 'getSalesTransactionPerMonth']);

Route::get('getTurnOverPerMonth/{id}',[TurnOverController::class, 'getTurnOverPerMonth']);