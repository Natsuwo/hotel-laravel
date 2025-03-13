<?php

namespace App\Http\Requests\Coupons;

use App\Http\Requests\Coupons\StoreRequest;

class UpdateRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
