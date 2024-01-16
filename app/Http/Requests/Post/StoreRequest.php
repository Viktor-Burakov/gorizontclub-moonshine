<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'nullable|integer',
            'title' => 'string',
            'slug' => 'string',
            'description' => 'nullable|string',
            'date_start' => 'nullable|string',
            'date_end' => 'nullable|string',
            'preview_text' => 'nullable|string',
            'h1' => 'string',
            'preview' => 'nullable|mimes:jpeg,png,jpg,gif|max:7000',
            'preview_alt' => 'nullable|string',
            'categories' => 'nullable|array',
        ];
    }
}
