<?php

namespace App\Admin;

class Message
{
   public static function FETCH(): \Illuminate\Foundation\Application|array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
   {
       return __('response.fetch_successfully');
   }

   public static function CREATED(): \Illuminate\Foundation\Application|array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
   {
       return __('response.created');
   }

   public static function DELETED(): \Illuminate\Foundation\Application|array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
   {
       return __('response.deleted');
   }

   public static function UPDATED(): \Illuminate\Foundation\Application|array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
   {
       return __('response.updated');
   }

}
