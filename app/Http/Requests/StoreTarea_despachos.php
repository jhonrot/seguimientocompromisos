<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarea_despachos extends FormRequest
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
        switch ($this->method()) {
            case 'PUT':
                return [
                    'descripcion' => 'nullable|min:3|max:400',
                    'fecha_inicio' => 'required',
                    'fecha_final' => 'required', 
                    'hora' => 'nullable',
                ];
                break;
            default:
                return [
                    'descripcion' => 'nullable|min:3|max:400',
                    'fecha_inicio' => 'required',
                    'fecha_final' => 'required', 
                    'tema' => 'required|min:3|max:200',
                    'tema_despacho_id' => 'required', 
                    'hora' => 'nullable',
                ];
        }
    }

    public function messages()
    {
        return [
            'descripcion.min' => 'El campo Descripción detallada del compromiso debe tener minimo 3 caracteres',
            'descripcion.max' => 'El campo Descripción detallada del compromiso debe tener maximo 400 caracteres',

            'fecha_inicio.required' => 'El campo Fecha cumplimiento es requerido',

            'fecha_final.required' => 'El campo Fecha programada de cumplimiento es requerido',

            'tema.required' => 'El campo Compromiso es requerido, por favor salga e intentelo de nuevo',
            'tema.min' => 'El campo Compromiso debe tener minimo 3 caracteres',
            'tema.max' => 'El campo Compromiso debe tener maximo 200 caracteres',
            
            'tema_despacho_id.required' => 'El campo Id de la tarea es requerido, por favor salga e intentelo de nuevo',
        ];
    }
}
