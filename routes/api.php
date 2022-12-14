<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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
Route::get('/list',[ProductController::class, 'index']);
Route::post('/search',[ProductController::class, 'search']);
Route::post('/search-price-filter',[ProductController::class, 'searchPriceFilter']);
Route::post('/search-sort',[ProductController::class, 'searchSort']);
Route::delete('/{id}',[ProductController::class, 'destroy']);
Route::post('/add',[ProductController::class, 'store']);
Route::post('/add-batch',[ProductController::class, 'storeBatch']);
Route::post('/add-batch-images',[ProductController::class, 'storeBatchImages']);
Route::put('/edit/{id}',[ProductController::class, 'update']);
Route::get('/getFile/{id}',[ProductController::class, 'downloadfile']);
Route::post('/sendMail',['App\Http\Controllers\MailController'::class, 'sendMail']);


