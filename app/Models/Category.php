<?php

namespace App\Models;

use App\Models\Scopes\CategoryFilterScope;
use App\Observers\CategoryObserver;
use App\Traits\BannerImageCollection;
use App\Traits\IconImageCollection;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
#[ObservedBy(CategoryObserver::class), ScopedBy([CategoryFilterScope::class])]
class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations, BannerImageCollection, IconImageCollection, SoftDeletes;
    public array $translatable = ['name','description'];
    protected $guarded = ['banner_image', 'icon_image'];
    public function scopeAdmin(Builder $builder){
        $builder->where('admin_id', admin()->id);
    }

    public function children(){
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
}
