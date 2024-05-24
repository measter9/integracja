<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testContreoller;

Route::get('/json', [testContreoller::class, 'json']);
Route::get('/xml', [testContreoller::class, 'xml']);


Route::get('/index', function(){
    return view('welcome');
});

