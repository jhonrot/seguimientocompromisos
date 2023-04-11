<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEjecuciones extends FormRequest
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
                    'fecha_suscripcion_contrato' => 'required',
                    'fecha_socializacion_contratista' => 'required',
                    'tiempo_ejecucion' => 'required|numeric|min:1',
                    'fecha_cierre_proyecto' => 'required',
                    'tiempo_etapa_contractual' => 'required|numeric|min:1',

                    'prorroga' => 'nullable',
                    'tiempo_prorroga' => 'nullable|numeric|min:1',
                    'fecha_prorroga' => 'nullable',

                    'precontractual_id' => 'required',
                ];
                break;

            default:
                return [
                    'fecha_suscripcion_contrato' => 'required',
                    'fecha_socializacion_contratista' => 'required',
                    'tiempo_ejecucion' => 'required|numeric|min:1',
                    'fecha_cierre_proyecto' => 'required',
                    'tiempo_etapa_contractual' => 'required|numeric|min:1',

                    'prorroga' => 'nullable',
                    'tiempo_prorroga' => 'nullable|numeric|min:1',
                    'fecha_prorroga' => 'nullable',

                    'precontractual_id' => 'required|unique:ejecuciones',
                ];
                break;
        }     
    }

    public function messages()
    {
        return [
            'fecha_suscripcion_contrato.required' => 'El campo Fecha suscripción del contrato es requerido',
            'fecha_socializacion_contratista.required' => 'El campo Fecha socialización con contratista es requerido',
            
            'tiempo_ejecucion.required' => 'El campo Tiempo ejecución es requerido',
            'tiempo_ejecucion.numeric' => 'El campo Tiempo ejecución debe ser numeríco',
            'tiempo_ejecucion.min' => 'El campo Tiempo ejecución debe ser minimo 1',

            'fecha_cierre_proyecto.required' => 'El campo Fecha cierre del proyecto es requerido',

            'tiempo_etapa_contractual.required' => 'El campo Tiempo etapa contractual-Ejecución es requerido',
            'tiempo_etapa_contractual.numeric' => 'El campo Tiempo etapa contractual-Ejecución debe ser numeríco',
            'tiempo_etapa_contractual.min' => 'El campo Tiempo etapa contractual-Ejecución debe ser minimo 1',

            'precontractual_id.required' => 'El campo Fecha expedición CDP es requerido',
            'precontractual_id.unique' => 'El proyecto ya tiene etapa de ejecución', 

            'tiempo_prorroga.numeric' => 'El campo Tiempo de prorroga debe ser numeríco',
            'tiempo_prorroga.min' => 'El campo Tiempo de prorroga debe ser minimo 1',
        ];
    }
}
