<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use App\Rules\UniqueSlug;
use App\Traits\ValidationRequestHandle;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    use ValidationRequestHandle;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'array|required',
            'name.en' => [
                'required',
                'string',
                new UniqueSlug(Category::class)
            ],
            'description' => 'nullable',
            'banner_image' => 'nullable|base64',
            'icon_image' => 'nullable|base64',
            'parent_id' => 'nullable|exists:categories,id'
        ];
    }
}
