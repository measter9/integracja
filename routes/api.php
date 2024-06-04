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
    Route::get('/between/{from}/{to}','between');
    Route::get('/getTypes','getRatesTypes');
});

Route::controller(PricesController::class)->prefix("prices")->group(function () {
    Route::get('/in/{city}', 'in');
    Route::get('/in/{city}/{category}', 'in_category');
    Route::get('/inbetween/{city}/{category}/{from}/{to}','inCategoryBetween');
    Route::get('/getCities','getCities');
    Route::get('/getCategories','getCategories');
});
