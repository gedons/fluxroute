<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:1000',
            'image' => 'nullable|string',
            'user_id' => 'exists:users,id',            
            'delivery_status' => 'nullable|string',
            'driver_name' => 'required|string',
            'delivery_address' => 'required|string',
            'tracking_number' => 'required|string',
            'special_instructions' => 'required|string',
            'payment_reference' => 'nullable|string',
        ];
    }
}
