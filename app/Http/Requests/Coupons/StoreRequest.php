<?php

namespace App\Http\Requests\Coupons;

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
            'code' => 'required|string|max:255',
            'discount' => 'required|numeric',
            'discount_type' => 'required|in:fixed,percentage',
            'usage_per_user' => 'required|numeric',
            'usage_limit_per_coupon' => 'required|numeric',
            'usage_limit' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:0,1',
        ];
    }
}
