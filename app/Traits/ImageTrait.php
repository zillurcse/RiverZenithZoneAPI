<?php

namespace App\Traits;

trait ImageTrait
{
    const IMAGE_BASE_SIZE = 100;

    public static function R_16_9(): object
    {
        return (object)[
            'height' => self::IMAGE_BASE_SIZE * 9,
            'width' => self::IMAGE_BASE_SIZE * 16,
        ];
    }

    public static function R_ICON(): object
    {
        return (object)[
            'height' => 36,
            'width' => 36,
        ];
    }

}
