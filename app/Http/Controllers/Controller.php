<?php

namespace App\Http\Controllers;

use App\ApiResponseClass;

abstract class Controller
{
    public function helper(): ApiResponseClass
    {
        return new ApiResponseClass();
    }
}
