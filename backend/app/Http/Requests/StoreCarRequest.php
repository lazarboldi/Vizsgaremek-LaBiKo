<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'make' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required','string','max:255'],
            'color' => ['required','string','max:100'],
            'description' => ['required','string'],
            'year' => ['required','integer','min:1900','max:2100'],
            'mileage' => ['required','integer','min:0'],
            'fuel_type' => ['required','string','max:100'],
            'transmission' => ['required','string','max:100'],
            'engine_size' => ['required','integer','min:1']
        ];
    }
}