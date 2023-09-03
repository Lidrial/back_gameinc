<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            //
            'first_name' => 'bail|string|max:255',
            'last_name' => 'bail|string|max:255',
            'pseudo' => 'bail|string|max:255|unique:users,pseudo',
            'role_id' => 'bail|integer|exists:roles,id',
            'email' => 'bail|string|email|max:255|unique:users,email',
            'password' => 'bail|string|min:8|confirmed',
            'company_id' => 'bail|integer|exists:companies,id',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return[
            'first_name.string' => 'Le prénom doit être une chaîne de caractères',
            'first_name.max' => 'Le prénom ne doit pas dépasser 255 caractères',
            'last_name.string' => 'Le nom doit être une chaîne de caractères',
            'last_name.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'pseudo.string' => 'Le pseudo doit être une chaîne de caractères',
            'pseudo.unique' => 'Ce pseudo est déjà utilisé',
            'pseudo.max' => 'Le pseudo ne doit pas dépasser 255 caractères',
            'role_id.integer' => 'Le rôle doit être un entier',
            'role_id.exists' => 'Le rôle doit exister',
            'email.string' => 'L\'email doit être une chaîne de caractères',
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères',
            'email.unique' => 'L\'email doit être unique',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Le mot de passe doit être confirmé',
            'company_id.integer' => 'L\'entreprise doit être un entier',
            'company_id.exists' => 'L\'entreprise doit exister',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
