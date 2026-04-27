<?php

use App\Http\Controllers\QuoteApiController;
use App\Http\Controllers\RiddleApiController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'daily', 'as' => 'api.'], function () {
    Route::get('quote/{lang?}', [QuoteApiController::class, 'dailyQuote'])->name('dailyquote');
    Route::get('riddle/{lang?}', [RiddleApiController::class, 'dailyRiddle'])->name('dailyriddle');
});

Route::group(['prefix' => 'fw', 'as' => 'api.'], function () {
    Route::get('ver', [App\Http\Controllers\ApiFWController::class, 'version']);
    Route::get('ver_mobile', [App\Http\Controllers\ApiFWController::class, 'version'])->defaults('mobile', true);
    Route::get('dl', [App\Http\Controllers\ApiFWController::class, 'download']);
});

Route::group(['prefix' => 'news', 'as' => 'api.news.'], function () {
    Route::get('/', [App\Http\Controllers\ApiNewsController::class, 'index'])->name('index');
    Route::get('/{id}', [App\Http\Controllers\ApiNewsController::class, 'show'])->name('show');
});


