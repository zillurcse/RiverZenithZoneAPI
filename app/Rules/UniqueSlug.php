<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class UniqueSlug implements ValidationRule, DataAwareRule
{
    public function __construct($model, $ignore_id = null)
    {
        $this->model = $model;
        $this->ignore_id = $ignore_id;
    }

    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value_slug = Str::slug($value);
        $condition = $this->model::where('slug', $value_slug);
        if ($id = $this->ignore_id){
            $condition = $condition->where('id', '!=', $id);
        }
        if($condition->count()){
            $fail('The `'.$value.'` already exist.');
        }
    }
}
