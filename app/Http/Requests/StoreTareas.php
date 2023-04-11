<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTareas extends FormRequest
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
            'tarea' => 'required|min:4|max:200',
            'meta' => 'required|min:4|max:200',
            'avance_indicador' => 'required|min:0|max:100',
            'vigencia' => 'nullable',
            'mes' => 'nullable',
            'plan_actividad_id' => 'required',
            'periodo_id' => 'required',
            "evidencia" => "array",
            "evidencia.*" => "mimes:pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls,mp3|max:5000",
             
        ];
    }

    public function messages()
    {
        return [
            'tarea.required' => 'El campo Descripción de la tarea es requerido',
            'tarea.min' => 'El campo Descripción de la tarea debe tener un minimo de 4 caracteres',
            'tarea.max' => 'El campo Descripción de la tarea debe tener un maximo de 200 caracteres',

            'meta.required' => 'El campo Meta de la tarea es requerido',
            'meta.min' => 'El campo Meta de la tarea debe tener un minimo de 4 caracteres',
            'meta.max' => 'El campo Meta de la tarea debe tener un maximo de 200 caracteres',

            'avance_indicador.required' => 'El campo Avance del indicador es requerido',
            'avance_indicador.min' => 'El campo Avance del indicador debe ser minimo 0',
            'avance_indicador.max' => 'El campo Avance del indicador debe maximo 100',

            'evidencia.*.mimes' => 'El campo evidencia debe ser formato pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls ó mp3',
            'evidencia.max' => 'El campo evidencia debe tener como maximo un peso de 5MB (5000 kilobytes)',

            'plan_actividad_id.required' => 'El campo Actividad es requerido',
            'periodo_id.required' => 'El campo Periodo es requerido',
        ];
    }
}
