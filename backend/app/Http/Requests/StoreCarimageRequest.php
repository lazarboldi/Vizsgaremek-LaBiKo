<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarimageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'car_id' => ['required','exists:cars,id'],
            'image' => ['required', 'file', 'max:20480']
        ];
    }

    public function messages(): array
    {
        return [
            'car_id.required' => 'A car_id mező kötelező.',
            'car_id.exists' => 'A kiválasztott autó nem létezik.',
            'image.required' => 'Kérlek válassz ki egy képet.',
            'image.file' => 'A feltöltött elemnek fájlnak kell lennie.',
            'image.max' => 'A fájl maximális mérete 20 MB lehet.'
        ];
    }
}