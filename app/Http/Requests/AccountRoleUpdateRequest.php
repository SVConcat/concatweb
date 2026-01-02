<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRoleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = auth()->user();

        return [
            'role' => 'required|in:student,admin',
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'Rol is verplicht.',
            'role.in' => 'Ongeldige rol geselecteerd.',
        ];
    }
}
