<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[UserController::class,'register']);
Route::get('alldata',[UserController::class,'getdata']);
Route::post('login',[UserController::class,'login']);
Route::post('update',[UserController::class,'update']);
Route::get('delete/{id}',[UserController::class,'delete']);
