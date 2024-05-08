<?php

namespace App\Traits;

trait BannerImageCollection
{
    use ImageTrait;
    public static function BANNER_COLLECTION(): object
    {
        return (object)[
            'name' => 'banner_image',
            'size' => self::R_16_9()
        ];
    }

    function getBannerImageAttribute(): string{
        return $this->getFirstMedia(self::BANNER_COLLECTION()->name)?->original_url ?? '';
    }
}
