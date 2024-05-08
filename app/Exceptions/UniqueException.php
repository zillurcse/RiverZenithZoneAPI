<?php

namespace App\Exceptions;

use App\ApiResponseClass;
use Exception;

class UniqueException extends Exception
{
    /**
     * @return mixed
     */
    public function render(){
        $response = new ApiResponseClass();
        $error = [
            'name.en' => [$this->getMessage()." already exist!"],
        ];
        return $response->errorResponse('validation_error', $error, 422);
    }

}
