<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'string|required',
            'description' => 'string|nullable',
            'category' => 'string|required',
            'gallery_id' => 'integer|nullable',
            'stock_quantity' => 'integer|required',
            'reorder_level' => 'integer|required',
            'safety_stock' => 'integer|required',
            'purchase_price' => 'numeric|required',
            'selling_price' => 'numeric|nullable',
            'last_order_date' => 'date|nullable',
            'last_received_date' => 'date|nullable',
            'supplier_id' => 'integer|nullable',
        ];
    }
}
