<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcesos extends FormRequest
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
        return [
            'proceso' => 'required|min:3|max:200',
            'descripcion' => 'nullable|min:3|max:1000', 
        ];
    }

    public function messages()
    {
        return [
            'proceso.required' => 'El campo Proceso es requerido',
            'proceso.min' => 'El campo Proceso debe tener un minimo de 3 caracteres',
            'proceso.max' => 'El campo Proceso debe tener un maximo de 200 caracteres',
            'descripcion.min' => 'El campo Descripción debe tener un minimo de 3 caracteres',
            'descripcion.max' => 'El campo Descripción debe tener un maximo de 1000 caracteres',
        ];
    }
}
