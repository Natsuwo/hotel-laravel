<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticateGuest(): void
    {
        $this->ensureGuestIsNotRateLimited();
        if (!Auth::guard('guest')->attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->guestThrottleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        RateLimiter::clear($this->guestThrottleKey());
    }

    /**
     * Ensure the guest login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureGuestIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->guestThrottleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->guestThrottleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the guest request.
     */
    public function guestThrottleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip() . '|guest');
    }
}
