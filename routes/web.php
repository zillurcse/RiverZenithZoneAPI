<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return \App\Models\User::first()->createToken('admin token')->plainTextToken;
    return view('welcome');
});
