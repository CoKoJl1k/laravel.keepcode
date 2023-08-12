<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RentalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', [ProductController::class], 'index');
Route::post('/rentals', [RentalController::class], 'rent');
Route::post('/rentals/{rental}/extend', [RentalController::class], 'extend');
Route::post('/products', [PurchaseController::class], 'purchase');

//
//Route::get('/products', 'ProductController@index');
//Route::post('/rentals', 'RentalController@rent');
//Route::post('/rentals/{rental}/extend', 'RentalController@extend');
//Route::post('/purchases', 'PurchaseController@purchase');
//
