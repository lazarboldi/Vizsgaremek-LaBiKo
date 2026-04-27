<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc|unique:users|max:255',
            'password' => 'required|string|min:8|max:255|confirmed',
            'phone' => 'required|string|regex:/^\+?[1-9]\d{7,14}$/',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'password.confirmed' => 'A jelszavak nem egyeznek.',
            'password.required' => 'A jelszó megadása kötelező.',
            'password.min' => 'A jelszónak legalább 8 karakter hosszúnak kell lennie.',
            'email.required' => 'Az e-mail cím megadása kötelező.',
            'email.email' => 'Az e-mail cím formátuma érvénytelen.',
            'email.unique' => 'Ez az e-mail cím már foglalt.',
            'phone.required' => 'A telefonszám megadása kötelező.',
            'phone.regex' => 'A telefonszám formátuma érvénytelen.',
            'name.required' => 'A név megadása kötelező.',
        ];
    }
}
