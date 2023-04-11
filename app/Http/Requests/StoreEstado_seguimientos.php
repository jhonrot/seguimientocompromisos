<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstado_seguimientos extends FormRequest
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
            'name' => 'required|string|unique:estado_seguimientos|min:4|max:45',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre es requerido',
            'name.unique' => 'El campo Nombre ya existe',
            'name.min' => 'El campo Nombre debe tener un minimo de 4 caracteres',
            'name.max' => 'El campo Nombre debe tener un maximo de 45 caracteres',
        ];
    }
}
