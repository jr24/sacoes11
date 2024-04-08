<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegistrationRequest extends FormRequest
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
    public function rules($id = null): array
    {
        return [
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:30',
            'lastname' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:30',
            'address' => 'required|string|max:100',
            'phone' => 'numeric|digits:7',
            'cellPhone' => 'required|numeric|digits:8',
            'active' => 'required|boolean',
            'email' => 'required|email|max:50|unique:users,email,' . $id,
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,recepcionista,sastre,cliente'
        ];
    }
}
