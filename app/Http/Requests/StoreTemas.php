<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemas extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'estado_id' => 'required',
            "evidencia" => "array",
            "evidencia.*" => "mimes:pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls,mp3|max:5000",
        ];
    }

    public function messages()
    {
        return [
            'tema.required' => 'El campo Compromiso es requerido',
            'tema.min' => 'El campo Compromiso debe tener un minimo de 3 caracteres',
            'tema.max' => 'El campo Compromiso debe tener un maximo de 200 caracteres',
            'estado_id.required' => 'El campo Estado es requerido',
            'fecha_cumplimiento.required' => 'El campo Fecha cumplimiento es requerido',
            'evidencia.mimes' => 'El campo evidencia debe ser formato pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls ó mp3',
            'evidencia.max' => 'El campo evidencia debe tener como maximo un peso de 5MB (5000 kilobytes)',
            'equipo_id.required' => 'El campo Equipo es requerido',
            'clasificacion_id.required' => 'El campo Referencia transversal es requerido',
            'description.min' => 'El campo Descripción detallada del compromiso debe tener un minimo de 4 caracteres',
            'description.max' => 'El campo Descripción detallada del compromiso debe tener un maximo de 2000 caracteres',
        ];
    }
}
