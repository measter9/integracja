<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testContreoller;

Route::get('/json', [testContreoller::class, 'json']);
Route::get('/xml', [testContreoller::class, 'xml']);


Route::get('/', function(){
    return view('home');
});
Route::get('/download',[testContreoller::class,'downloadTest']);
Route::get('/downloadXML',[testContreoller::class,'downloadTestXml']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/chart', [App\Http\Controllers\HomeController::class, 'chart'])->name('chart');

//Route::get('/chart',function (){
//    return view('chart');
//});
