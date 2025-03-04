<?php

namespace App\Http\Requests\Guest;

class UpdateRequest extends StoreRequest
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'nationality' => 'required|string',
            'address' => 'nullable|string',
            'passport' => 'nullable|string',
            'gender' => 'nullable|string',
            'dob' => 'nullable|date',
            'avatar' => 'nullable|string|url',
        ];
    }
}
