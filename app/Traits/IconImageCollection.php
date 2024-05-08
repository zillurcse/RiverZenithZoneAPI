<?php

namespace App\Traits;

trait IconImageCollection
{
    use ImageTrait;
    public static function ICON_COLLECTION(): object
    {
        return (object)[
            'name' => 'icon_image',
            'size' => self::R_ICON()
        ];
    }

    function getIconImageAttribute(): string{
        return $this->getFirstMedia(self::ICON_COLLECTION()->name)?->original_url ?? '';
    }
}
