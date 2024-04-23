<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRegistrationRequest extends FormRequest
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
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'description' => 'required|string|max:255',
            'priority' => 'required|string|in:low,regular,high',
            'idCliente' => 'required|integer|exists:users,id',
            'idSastre' => 'required|integer|exists:users,id',
            'details.*.typeGarment' => 'required|string|in:pantalon,saco,chaleco,camisa',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.costUnit' => 'required|numeric|min:50',
        ];
    }
}
