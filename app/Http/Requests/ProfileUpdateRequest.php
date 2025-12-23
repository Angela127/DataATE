<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
                
            ],
            'identity_card_image' => ['nullable|image|mimes:pdf,jpg,png|max:2048'],
            'license_image' => ['nullable|image|mimes:pdf,jpg,png|max:2048'],
            'matric_staff_image' => ['nullable|image|mimes:pdf,jpg,png|max:2048'],
        ];
    }
}
