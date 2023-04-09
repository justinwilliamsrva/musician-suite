<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if (Auth::user()->isAdmin()) {
            return [
                'name' => ['string', 'max:255'],
                'email' => ['email', 'max:255',],
                'phone_number' => ['nullable', 'regex:/^\(?([0-9]{3})\)?[ -]?([0-9]{3})[ -]?([0-9]{4})$/'],
                'instruments' => ['nullable'],
                'can_book' => ['nullable'],
            ];
        }

        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone_number' => ['nullable', 'regex:/^\(?([0-9]{3})\)?[ -]?([0-9]{3})[ -]?([0-9]{4})$/', Rule::unique(User::class)->ignore($this->user()->id)],
            'instruments' => ['required', 'array', 'min:1', 'max:10'],
            'can_book' => ['required', 'boolean'],
        ];
    }
}
