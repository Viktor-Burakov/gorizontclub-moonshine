<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailRequest extends FormRequest
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
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'content' => 'nullable|string',
            'gallery' => 'nullable|string',
            'content' => 'nullable|array',
            'content.*.type' => 'string',
            'content.*.value' => 'nullable|string',
            'content.*.level' => 'nullable|string',
            'content.*.img.*' =>
            'image|mimes:jpg,png,jpeg,gif|max:10000',
        ];
    }
}
