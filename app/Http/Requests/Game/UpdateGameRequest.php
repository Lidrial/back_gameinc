<?php

namespace App\Http\Requests\Game;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateGameRequest extends FormRequest
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
            //add rules without required
            'name' => 'bail|string|max:255',
            'description' => 'bail|string|max:255',
            'company_id' => 'bail|integer|exists:companies,id',
            'image' => 'bail|string|max:255',
            'link' => 'bail|string|max:255',
            'category_id' => 'bail|array',
            'category_id.*' => 'integer|exists:categories,id',
            'user_id' => 'bail|array',
            'user_id.*' => 'bail|integer|exists:users,id',
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
            'name.string' => 'Le nom doit être une chaîne de caractères',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'description.string' => 'La description doit être une chaîne de caractères',
            'description.max' => 'La description ne doit pas dépasser 255 caractères',
            'company_id.integer' => 'La compagnie doit être un entier',
            'company_id.exists' => 'La compagnie doit exister',
            'image.string' => 'L\'image doit être une chaîne de caractères',
            'image.max' => 'L\'image ne doit pas dépasser 255 caractères',
            'link.string' => 'Le lien doit être une chaîne de caractères',
            'link.max' => 'Le lien ne doit pas dépasser 255 caractères',
            'category_id' => 'Les catégories doivent être un tableau',
            'category_id.*.integer' => 'La catégorie doit être un entier',
            'category_id.*.exists' => 'La catégorie doit exister',
            'user_id' => 'Les utilisateurs doivent être un tableau',
            'user_id.*.integer' => 'L\'utilisateur doit être un entier',
            'user_id.*.exists' => 'L\'utilisateur doit exister',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
