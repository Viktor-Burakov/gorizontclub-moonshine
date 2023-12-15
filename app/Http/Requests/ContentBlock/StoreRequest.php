<?php

namespace App\Http\Requests\ContentBlock;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $name
 */
class StoreRequest extends FormRequest
{
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
            'post_id' => 'required|integer',
            'name' => 'string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
