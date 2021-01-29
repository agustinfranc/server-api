<?php

use App\Http\Controllers\ServerController;
use Illuminate\Http\Request;
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

Route::apiResource('servers', ServerController::class);

Route::prefix('/servers')->group(function () {
    Route::post('/{server}/upload', [ServerController::class, 'upload'])->name('servers.upload');

    Route::post('/{server}/request', [ServerController::class, 'request'])->name('servers.request');

    Route::put('/order', [ServerController::class, 'sort'])->name('servers.order');
});
