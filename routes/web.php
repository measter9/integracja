<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testContreoller;

Route::get('/json', [testContreoller::class, 'json']);
Route::get('/xml', [testContreoller::class, 'xml']);


Route::get('/', function(){
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
