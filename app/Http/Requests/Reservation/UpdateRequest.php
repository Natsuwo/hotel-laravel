<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'check_in' => 'date|required',
            'check_out' => 'date|required',
            'duration' => 'numeric|required',
            'total_price' => 'numeric|required',
            'tax_price' => 'numeric|required',
            'vat_price' => 'numeric|required',
            'coupon_id' => 'numeric|nullable|exists:coupons,id',
            'room_id' => 'numeric|nullable|exists:rooms,id',
            'guest_id' => 'numeric|nullable|exists:guests,id',
            'adults' => 'numeric|nullable',
            'children' => 'numeric|nullable',
            'status' => 'in:0,1,2,3|nullable',
            'notes' => 'string|nullable',

        ];
    }
}
