<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoardingHouseRequest extends FormRequest
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
            'address' => 'required|string',
            'number_of_rooms' => 'required|integer|min:1|max:1000',
            'owner' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Boarding house name is required.',
            'address.required' => 'Address is required.',
            'number_of_rooms.required' => 'Number of rooms is required.',
            'number_of_rooms.min' => 'Number of rooms must be at least 1.',
            'number_of_rooms.max' => 'Number of rooms cannot exceed 1000.',
            'owner.required' => 'Owner name is required.',
            'contact.required' => 'Contact information is required.',
        ];
    }
}