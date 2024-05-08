<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::get('/test', function (Request $request) {
    return auth('admin')->user();
});
Route::apiResource('category', Admin\CategoryController::class);
Route::prefix('user')->group(function (){
    Route::get('info', [Admin\UserController::class, 'info']);
});


