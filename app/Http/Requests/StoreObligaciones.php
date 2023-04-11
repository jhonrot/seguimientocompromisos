<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreObligaciones extends FormRequest
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
            'obligacion' => 'required|min:3|max:200',
            'objetivo_id' => 'required',  
        ];
    }

    public function messages()
    {
        return [
            'obligacion.required' => 'El campo Obligación es requerido',
            'obligacion.min' => 'El campo Obligación debe tener un minimo de 3 caracteres',
            'obligacion.max' => 'El campo Obligación debe tener un maximo de 200 caracteres',
            'objetivo_id.required' => 'El campo Objetivo es requerido',
        ];
    }
}
