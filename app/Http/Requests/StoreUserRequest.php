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
//            'name' => ['required', 'string'],
//            'email' => ['required', 'email', 'unique:users,email'],
//            'password' => ['required', Rules\Password::defaults()],
            'email' => ['required', 'email', 'unique:user_invitations,email'],
        ];
    }
    public function messages(): array
    {
        return [
            'email.unique' => 'Invitation with this email address already requested.'
        ];
    }
}
