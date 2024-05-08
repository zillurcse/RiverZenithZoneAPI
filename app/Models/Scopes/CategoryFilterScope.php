<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CategoryFilterScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (request()->method() == "GET"){
            if ($name = request()->name){
                $builder->where('name->'.app()->getLocale(), 'like', '%'.$name.'%');
            }
            if ($name = request()->is_main){
                $builder->whereNull('parent_id', '');
            }
        }

    }
}
