<?php

namespace App\Http\Requests\V1\Account;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'order' => 'required|array',
            'order.amount' => 'required|numeric|min:0',
            'order.payment_method' => 'required|string',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|integer|max:255',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'numeric|min:0'
        ];
    }
}
