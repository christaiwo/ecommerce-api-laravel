<?php

namespace App\Http\Requests\V1\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
        $rules = [
            'order' => 'required|array',
            'order.address_id' => 'required|string',
            'order.amount' => 'required|numeric|min:0',
            'order.payment_method' => 'required|string',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|integer|max:255',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'numeric|min:0'
        ];

        // check if the address is just new and add the rules to verify address
        if ($this->has('order.address_id') && $this->input('order.address_id') == 'new') {
            $addressRules = [
                'address' => 'array',
                'address.address' => 'required|string',
                'address.address2' => '',
                'address.city' => 'required|string',
                'address.region' => 'required|string',
                'address.zip' => 'required|integer',
                'address.country' => 'required|string',
            ];
        
            $rules = array_merge($rules, $addressRules);
        
        }
        return $rules;
    }
}
