<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization is handled by the auth middleware
    }

    public function rules(): array
    {
        $userId = Auth::id(); // Get the current user's ID

        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'sa_id_number' => ['required', 'string', 'min:13', 'max:13', Rule::unique('users')->ignore($userId)],
            'mobile_number' => 'nullable|string|max:20',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'birth_date' => 'nullable|date',
            'language' => 'required|string|max:255',
            'interests' => 'nullable|array',
            'interests.*' => 'integer|exists:interests,id',
        ];
    }
}