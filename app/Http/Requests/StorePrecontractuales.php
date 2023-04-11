<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrecontractuales extends FormRequest
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
                    'cdp_numero' => 'required',
                    'fecha_expedicion' => 'required',
                    'proyecto_id' => 'required',
                    'paac' => 'required',
                    'fecha_convocatoria' => 'nullable',
                    'fecha_aprobacion_asp' => 'nullable',
                    'fecha_aprobacion_edp' => 'nullable',
                    'fecha_publicacion_contratacion' => 'nullable',
                    'plazo_adjudicacion' => 'nullable|numeric|min:1',
                    'fecha_adjudicacion' => 'nullable',
                ];
                break;

            default:
                return [
                    'cdp_numero' => 'required',
                    'fecha_expedicion' => 'required',
                    'proyecto_id' => 'required|unique:cdps',
                    'paac' => 'required',
                    'fecha_convocatoria' => 'nullable',
                    'fecha_aprobacion_asp' => 'nullable',
                    'fecha_aprobacion_edp' => 'nullable',
                    'fecha_publicacion_contratacion' => 'nullable',
                    'plazo_adjudicacion' => 'nullable|numeric|min:1',
                    'fecha_adjudicacion' => 'nullable',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'cdp_numero.required' => 'El campo N° CDP es requerido',
            'fecha_expedicion.required' => 'El campo Fecha expedición CDP es requerido',

            'proyecto_id.required' => 'El campo Proyecto es requerido',
            'proyecto_id.unique' => 'El Proyecto ya tiene etapa precontractual',

            'paac.required' => 'El campo ¿Cuenta con PAC? es requerido',

            'plazo_adjudicacion.numeric' => 'El campo Plazo estimado adjudicación debe ser numeríco',
            'plazo_adjudicacion.min' => 'El campo Plazo estimado adjudicación debe ser minimo 1',
        ];
    }
}
