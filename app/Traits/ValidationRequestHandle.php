<?php

namespace App\Traits;
use App\ApiResponseClass;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;

trait ValidationRequestHandle
{
    protected function failedValidation(Validator $validator)
    {
        $response = new ApiResponseClass();
        throw new HttpResponseException($response->errorResponse(
            'validation error',
            $validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
