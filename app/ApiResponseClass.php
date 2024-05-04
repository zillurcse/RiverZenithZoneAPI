<?php

namespace App;

class ApiResponseClass
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function errorResponse($message, $errors = [] , $status_code = 500){
        $packet['result'] = false;
        $packet['message'] = $message;
        if ($errors){
            $packet['errors'] = $errors;
        }
        return response()->json($packet, $status_code);
    }

    public function response(string $message, mixed $data = [] , int $status_code = 200){
        $packet['message'] = $message;
        if ($data){
            $packet['data'] = $data;
        }
        return response()->json($packet, $status_code);
    }

}
