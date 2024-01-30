<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateOrUpdateRequest extends FormRequest
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
            'id' => 'nullable|integer',
            'active' => 'boolean',
            'title' => 'nullable|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|string',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'preview_text' => 'nullable|string',
            'h1' => 'nullable|string',
            'preview_alt' => 'nullable|string',
            'preview' => 'nullable', //todo add preview rules
            'categories.*.id' => 'integer',
            'content_blocks.*.id' => 'nullable|integer',
            'content_blocks.*.name' => 'string',
            'content_blocks.*.title' => 'nullable|string',
            'content_blocks.*.description' => 'nullable|string',
            'content_blocks.*.images.*.id' => 'nullable',
            'images.*.id' => 'nullable',

        ];
    }
}
