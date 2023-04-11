<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreObjetivos extends FormRequest
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
            'objetivo' => 'required|min:3|max:200',
            'proceso_id' => 'required',  
        ];
    }

    public function messages()
    {
        return [
            'objetivo.required' => 'El campo Objetivo es requerido',
            'objetivo.min' => 'El campo Objetivo debe tener un minimo de 3 caracteres',
            'objetivo.max' => 'El campo Objetivo debe tener un maximo de 200 caracteres',
            'proceso_id.required' => 'El campo Proceso es requerido',
        ];
    }
}
