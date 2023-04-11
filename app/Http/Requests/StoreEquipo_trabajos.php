<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipo_trabajos extends FormRequest
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
            'descripcion' => 'required|string|unique:equipo_trabajos|min:4|max:60',
            'organismo_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'descripcion.required' => 'El campo Descripción es requerido',
            'descripcion.unique' => 'El campo Descripción ya existe',
            'descripcion.min' => 'El campo Descripción debe tener un minimo de 4 caracteres',
            'descripcion.max' => 'El campo Descripción debe tener un maximo de 60 caracteres',
            
            'organismo_id.required' => 'El campo Organismo es requerido',
        ];
    }
}
