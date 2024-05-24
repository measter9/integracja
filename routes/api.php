<?php

use App\Http\Controllers\PricesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StopyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(StopyController::class)->prefix("rates")->group(function () {
    Route::get('/current', 'current');
    Route::get('/date/{date}', 'on');
});

Route::controller(PricesController::class)->prefix("prices")->group(function () {
    Route::get('/in/{city}', 'in');
});
