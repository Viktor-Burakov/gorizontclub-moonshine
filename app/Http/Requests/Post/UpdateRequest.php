<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'string',
            'url' => 'string',
            'date_start' => 'nullable|string',
            'date_end' => 'nullable|string',
            'preview_text' => 'nullable|string',
            'H1' => 'string',
            'preview' => 'nullable|string',
            'preview_alt' => 'nullable|string',
            'category' => '',
        ];
    }
}
