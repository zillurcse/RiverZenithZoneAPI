<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::post('/auth/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
Route::get('/user', function (Request $request) {
    return auth('user')->user();
})->middleware('auth:user');
