<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\list_invoiceController;
use App\Http\Controllers\login;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(list_invoiceController::class)->group(function () {

    Route::get('/index','index')->name('daily.sale.report');
    Route::get('/show/{id}','show');
    Route::post('/store','store')->middleware(['auth:sanctum']);
    Route::patch('/update/{id}','update')->middleware(['auth:sanctum']);
    Route::delete('/destroy/{id}','destroy')->middleware(['auth:sanctum']);
    

});//end group

Route::controller(login::class)->group(function () {

    Route::post('/login','index')->name('login');
    Route::post('/logout','logout')->name('login')->middleware(['auth:sanctum']);
    
    

});//end group
