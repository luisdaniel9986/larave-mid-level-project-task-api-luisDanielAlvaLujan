<?php

namespace App\Http\Requests\Task;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TaskUpdateRequest extends FormRequest
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
            'project_id'    =>  [
                'required',
                 Rule::exists('projects','id')->where(function($query){
                    return $query->where('status','ACTIVE');
                })
            ],

            'title'          => [
                'required',
                'string',
                'min:3',
                'max:100'
            ],
            'description'   =>  'nullable|string|min:3|max:200',
            'priority'      =>  [
                'required',
                Rule::in(['LOW','MEDIUM','HIGH'])
            ],
            'due_date'  =>  'required|date',
            'status'      =>  [
                'required',
                Rule::in(['PENDING','IN_PROGRESS','DONE'])
            ]

        ];
    }

    public function messages():array{
        return [
            'project_id.required' =>  'EL ID DEL PROYECTO ES OBLIGATORIO',
            'project_id.exists'   =>  'EL PROYECTO NO EXISTE O SE ENCUENTRA INACTIVO',

            'title.required'    =>  'EL TITULO DE LA TAREA ES OBLIGATORIO',
            'title.min'              =>  'EL NOMBRE DE LA TAREA DEBE CONTENER 3 CARACTERES COMO MINIMO',
            'title.max'              =>  'EL NOMBRE DE LA TAREA DEBE CONTENER 100 CARACTERES COMO MÁXIMO',

            'description.min'              =>  'LA DESCRIPCIÓN DE LA TAREA DEBE CONTENER 3 CARACTERES COMO MINIMO',
            'description.max'              =>  'LA DESCRIPCIÓN DE LA TAREA DEBE CONTENER 300 CARACTERES COMO MÁXIMO',
            'description.string'            =>  'LA DESCRIPCIÓN DE LA TAREA DEBE SER UNA CADENA DE TEXTO',

            'priority.required'     =>  'ES OBLIGATORIO INDICAR LA PRIORIDAD DE LA TAREA',
            'priority.in'       =>  'LA PRIORIDAD PUEDE SER LOW,MEDIUM O HIGH',

            'status.required'     =>  'ES OBLIGATORIO INDICAR EL ESTADO DE LA TAREA',
            'status.in'       =>  'EL ESTADO DE LA TAREA PUEDE SER PENDING,IN_PROGRESS O DONE',

            'due_date.required' =>  'LA FECHA ES OBLIGATORIA',
            'due_date.date'     =>  'EL FORMATO DE LA FECHA ES INCORRECTO'

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
