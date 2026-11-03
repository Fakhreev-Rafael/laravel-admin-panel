<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionIndexRequest extends FormRequest
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
            'sort' => ['nullable', 'exists:sort_fields,sort'],
        ];
    }

    /**
     * Prepare the data for validation.
     * 
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'sort' => $this->filled('sort') ? $this->input('sort') : null,
        ]);
    }
}
