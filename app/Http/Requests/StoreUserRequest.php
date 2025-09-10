<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'sa_id_number' => 'required|string|min:13|max:13|unique:users,sa_id_number',
            'mobile_number' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'birth_date' => 'nullable|date',
            'language' => 'required|string|max:255',
            'interests' => 'nullable|array',
            'interests.*' => 'integer|exists:interests,id', 
        ];
    }
}
