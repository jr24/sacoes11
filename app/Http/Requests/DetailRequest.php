<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
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
            'typeGarment' => 'required|string|in:pantalon,saco,chaleco,camisa',
            'quantity' => 'required|integer|min:1',
            'costUnit' => 'required|numeric|min:50',
            'idOrder' => 'required|integer|exists:orders,id'
        ];
    }
}
