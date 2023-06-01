<?php

namespace App\Http\Requests\V1\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'address' => 'required|string',
            'address2' => '',
            'city' => 'required|string',
            'region' => 'required|string',
            'zip' => 'required|integer',
            'country' => 'required|string',
        ];
    }
}
