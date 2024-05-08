<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Base64Validator
{
    /**
     * Check if the file is in base64 image
     */
    public function validate($attribute, $value, $parameters, $validator): bool
    {
        $explode = $this->explodeString($value);
        $allow = $this->allowedFormat();
        $format = $this->dataFormat($explode);

        // check file format
        if (!in_array($format, $allow)) {
            return false;
        }

        // check base64 format
        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
            return false;
        }

        return true;
    }

    /**
     * Check the data format
     */
    public function dataFormat($explode): array|string
    {
        return str_replace(
            [
                'data:image/',
                ';',
                'base64',
            ],
            [
                '', '', '',
            ],
            $explode[0]
        );
    }

    /**
     * The allowed format in base 64 image
     */
    public function allowedFormat(): array
    {
        return ['gif', 'jpg', 'jpeg', 'png'];
    }

    /**
     * Explode base 64 image
     */
    public function explodeString($value): array
    {
        return explode(',', $value);
    }
}
