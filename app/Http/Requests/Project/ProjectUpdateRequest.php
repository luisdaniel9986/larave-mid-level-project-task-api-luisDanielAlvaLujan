<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('projects', 'name')
                ->where(function ($query) {
                    return $query->where('status', 'ACTIVE');
                })->ignore($this->route('id'))
            ],
            'description'   =>  'nullable|string|min:3|max:200',

        ];
    }

    public function messages():array{
        return [
            'name.required' =>  'EL NOMBRE DEL PROYECTO ES OBLIGATORIO',
            'name.string'   =>  'EL NOMBRE DEBE SER UNA CADENA DE TEXTO',
            'name.min'      =>  'EL NOMBRE DEBE CONTENER 3 CARACTERES COMO MINIMO',
            'name.max'      =>  'EL NOMBRE DEBE CONTENER 100 CARACTERES COMO MÁXIMO',
            'name.unique'   =>  'EL NOMBRE YA EXISTE PARA OTRO PROYECTO'
        ];
    }

      protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}

