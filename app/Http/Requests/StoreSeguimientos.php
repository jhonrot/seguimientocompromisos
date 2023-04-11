<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeguimientos extends FormRequest
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
            'tema_id' => 'required',
            'estado_id' => 'required',
            'fecha_cumplimiento' => 'required',
            
            'ponderacion' => 'required|numeric|min:1',
            'avance' => 'required|numeric|min:0|max:100',
            
            'seguimiento' => 'required|min:4|max:1000', 
            
            "evidencia" => "array",
            "evidencia.*" => "mimes:pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls,mp3|max:5000",
        ];
    }

    public function messages()
    {
        return [
            'tema_id.required' => 'El campo Compromiso es requerido',
            'estado_id.required' => 'El campo Estado seguimiento es requerido',
            'fecha_cumplimiento.required' => 'El campo Fecha cumplimiento es requerido',
            'seguimiento.required' => 'El campo Descripción actividad es requerido',
            'seguimiento.min' => 'El campo Descripción actividad debe tener minimo 4 caracteres',
            'seguimiento.max' => 'El campo Descripción actividad debe tener maximo 1000 caracteres',
            
            'ponderacion.required' => 'El campo ponderación es requerido',
            'ponderacion.min' => 'El campo ponderación debe ser como minimo 1',
            'ponderacion.numeric' => 'El campo ponderación debe ser de tipo numeríco',

            'avance.required' => 'El campo Avance es requerido',
            'avance.min' => 'El campo Avance debe ser como minimo 0',
            'avance.max' => 'El campo Avance debe ser como maximo 100',
            'avance.numeric' => 'El campo Avance debe ser de tipo numeríco',
            
            'evidencia.mimes' => 'El campo evidencia debe ser formato pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls ó mp3',
            'evidencia.max' => 'El campo evidencia debe tener como maximo un peso de 5MB (5000 kilobytes)',
        ];
    }
}
