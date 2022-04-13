<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileFoodController;

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


Route::prefix('mobile-food')->middleware(['force-json'])->group(function() {
    Route::post('change-address', [MobileFoodController::class, 'changeAddress']);
    Route::get('detail', [MobileFoodController::class, 'getMobileFoodDetail']);
    Route::get('nearby', [MobileFoodController::class, 'getNearbyMobileFoods']);
    Route::post('add', [MobileFoodController::class, 'addMobileFood']);
});
