<?php

namespace App\Providers;

use App\Rules\Base64Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class Base64ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('base64', Base64Validator::class);
    }
}
