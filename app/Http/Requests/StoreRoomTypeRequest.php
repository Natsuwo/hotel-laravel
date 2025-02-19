<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomTypeRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
            'bed_type' => 'required|string',
            'bed_count' => 'required|numeric',
            'acreage' => 'required|numeric',
            'guest_count' => 'required|numeric',
            'features' => 'required|array',
            'amenities' => 'required|array',
            'facilities' => 'required|array',
            'images' => 'required|array',
            'price_per_night' => 'required|numeric',
            'price_per_hour' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ];
    }
}
