<?php

namespace App\Http\Requests\Reservation;

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
            'room_id' => 'required|exists:rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'duration' => 'required|numeric',
            'adults' => 'required|numeric',
            'child' => 'numeric|nullable',
            'notes' => 'string|nullable',
            'status' => 'required|in:0,1,2,3', // 0: pending, 1: confirm, 2: rejected, 3: cancelled
        ];
    }
}
