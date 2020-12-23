<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $path = explode('/', Request::path())[1];
        
        return [
            'name' => Rule::requiredIf($path === 'register'),
            'email' => Rule::requiredIf(in_array($path, ['register', 'login', 'forgot-password', 'reset-password'])),
            'password' => Rule::requiredIf(in_array($path, ['register', 'login', 'reset-password'])),
            'password_confirm' => [
                Rule::requiredIf(in_array($path, ['register', 'reset-password'])),
                'same:password'
            ],
            'token' => Rule::requiredIf($path === 'reset-password')
        ];
    }

    public function response(array $errors)
    {
        // Always return JSON.
        return response()->json($errors, 422);
    }
}
