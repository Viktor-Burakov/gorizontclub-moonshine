<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostImagesCreateOrUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'preview' => 'nullable|mimes:jpeg,png,jpg,gif|max:10000',
            'oldPreview' => 'nullable|string',
            'images.*.id' => 'nullable',
            'images.*.name' => 'nullable|string',
            'images.*.alt' => 'nullable|string',
            'images.*.slug' => 'nullable|string',
            'images.*.file' => 'nullable|mimes:jpeg,png,jpg,gif|max:10000',
        ];
    }
}
