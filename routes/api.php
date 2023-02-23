<?php

use App\Http\Controllers\Api\FrontController\ImagesController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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
//Route::group(['prefix' => 'v1', 'middleware' => 'api'], function () {
//});
Route::post('/test', [TestController::class, 'index']);
Route::get('/images', ImagesController::class);

