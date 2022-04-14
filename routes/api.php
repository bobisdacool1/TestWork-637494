<?php

use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TokenController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ChannelController::class)
    ->middleware('auth:sanctum')
    ->prefix('channel')
    ->name('channel.')
    ->group(function () {
        Route::post('index', 'index')->name('index');
        Route::post('show/{id}', 'show')->name('show');
        Route::post('search', 'search')->name('search');
        Route::post('destroy/{id}', 'destroy')->name('destroy');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('store', 'store')->name('store');
        Route::post('test', 'test')->name('test');
    });

Route::controller(SubscriberController::class)
    ->middleware('auth:sanctum')
    ->prefix('subscriber')
    ->name('subscriber.')
    ->group(function () {
        Route::post('index', 'index')->name('index');
        Route::post('show/{id}', 'show')->name('show');
        Route::post('search', 'search')->name('search');
        Route::post('destroy/{id}', 'destroy')->name('destroy');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('store', 'store')->name('store');
        Route::post('test', 'test')->name('test');
    });

// the code bellow is created for demonstration purposes
Route::post('/token/new', [TokenController::class, 'new'])->name('token.new');
