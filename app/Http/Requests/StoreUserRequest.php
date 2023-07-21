<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|confirmed|string|min:6',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'zipcode' => 'required|string|max:20',
            'contact_number' => 'required|string|max:20',
            'role' => 'required|string|in:user,driver',
            'driver_license_number' => 'required|string|max:255',
            'vehicle_info' => 'required|string|max:255',
            
        ];
    }
}
