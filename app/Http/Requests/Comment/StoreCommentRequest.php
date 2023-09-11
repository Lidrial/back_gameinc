<?php

namespace App\Http\Requests\Comment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCommentRequest extends FormRequest
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
            'content' => 'bail|required|string|max:255',
            'rate' => 'bail|required|integer|between:0,5',
            'user_id' => 'bail|required|integer|exists:users,id',
            'game_id' => 'bail|required|integer|exists:games,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'content.required' => 'Le contenu est requis',
            'content.string' => 'Le contenu doit être une chaîne de caractères',
            'content.max' => 'Le contenu ne doit pas dépasser 255 caractères',
            'rate.required' => 'La note est requise',
            'rate.integer' => 'La note doit être un entier',
            'rate.between' => 'La note doit être comprise entre 0 et 5',
            'user_id.required' => 'L\'utilisateur est requis',
            'user_id.integer' => 'L\'utilisateur doit être un entier',
            'user_id.exists' => 'L\'utilisateur doit exister',
            'game_id.required' => 'Le jeu est requis',
            'game_id.integer' => 'Le jeu doit être un entier',
            'game_id.exists' => 'Le jeu doit exister',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
