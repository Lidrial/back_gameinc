<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories',
            'games' => 'array',
            'games.*' => 'integer|exists:games,id',

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
            //
            'name.required' => 'Le nom est requis',
            'name.string' => 'Le nom doit être une chaîne de caractères',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'name.unique' => 'Le nom doit être unique',
            'games.array' => 'Les jeux doivent être un tableau',
            'games.*.integer' => 'Les jeux doivent être des entiers',
            'games.*.exists' => 'Les jeux doivent exister',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
