<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlan_actividades extends FormRequest
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
            'actividad' => 'required|min:4|max:200',
            'actividad_descripcion' => 'required|min:4|max:500',

            'meta' => 'required|min:4|max:200',
            'meta_descripcion' => 'required|min:4|max:500',

            'indicador' => 'required|min:4|max:100',
            'cantidad' => 'required|numeric|min:1',
            'obligacion_id' => 'required',

            "unidad" => "array",
            "unidad.*" => "required",
        ];
    }

    public function messages()
    {
        return [
            'actividad.required' => 'El campo Actividad es requerido',
            'actividad.min' => 'El campo Actividad debe tener un minimo de 4 caracteres',
            'actividad.max' => 'El campo Actividad debe tener un maximo de 200 caracteres',

            'actividad_descripcion.required' => 'El campo Descripción de la actividad es requerido',
            'actividad_descripcion.min' => 'El campo Descripción de la actividad debe tener un minimo de 4 caracteres',
            'actividad_descripcion.max' => 'El campo Descripción de la actividad debe tener un maximo de 500 caracteres',

            'meta.required' => 'El campo Meta es requerido',
            'meta.min' => 'El campo Meta debe tener un minimo de 4 caracteres',
            'meta.max' => 'El campo Meta debe tener un maximo de 200 caracteres',

            'meta_descripcion.required' => 'El campo Descripción de la meta de la actividad es requerido',
            'meta_descripcion.min' => 'El campo Descripción de la meta de la actividad debe tener un minimo de 4 caracteres',
            'meta_descripcion.max' => 'El campo Descripción de la meta de la actividad debe tener un maximo de 500 caracteres',

            'indicador.required' => 'El campo Indicador de la actividad es requerido',
            'indicador.min' => 'El campo Indicador de la actividad debe tener un minimo de 4 caracteres',
            'indicador.max' => 'El campo Indicador de la actividad debe tener un maximo de 100 caracteres',

            'cantidad.required' => 'El campo Cantidad es requerido',
            'cantidad.numeric' => 'El campo Cantidad debe ser numeríco',
            'cantidad.min' => 'El campo Cantidad debe ser mayor a 0',

            'obligacion_id.required' => 'El campo Obligación contractual es requerido',

            'unidad.required' => 'El campo Unidad es requerido',           
        ];
    }
}
