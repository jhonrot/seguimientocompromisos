<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaas extends FormRequest
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
        $total = 0;
        foreach ($this->request->get('presupuesto_modalidad') as $key => $array_pres){
            $total = ($total + intval($array_pres));
        }

        switch ($this->method()) {
            case 'PUT':
                return [
                    'presupuesto_proyecto' => 'required|numeric|min:'.$total.'|max:'.$total,
                    'cantidad' => 'required|numeric|min:1|max:4',
                    'proyecto_id' => 'required',

                    "modalidad_id"    => "required|array",
                    "modalidad_id.*"  => "required|distinct",
                    
                    "presupuesto_modalidad"    => "required|array",
                    "presupuesto_modalidad.*"  => "required|numeric|min:1",

                    'socializacion' => 'required',
                    'plazo' => 'required|numeric|min:1',
                    'publicacion' => 'required', 
                    
                    'id_paa' => 'required',
                ];
                break;

            default:
                return [
                    'presupuesto_proyecto' => 'required|numeric|min:'.$total.'|max:'.$total,
                    'cantidad' => 'required|numeric|min:1|max:4',
                    'proyecto_id' => 'required|unique:presupuestos',

                    "modalidad_id"    => "required|array",
                    "modalidad_id.*"  => "required|distinct",
                    
                    "presupuesto_modalidad"    => "required|array",
                    "presupuesto_modalidad.*"  => "required|numeric|min:1",

                    'socializacion' => 'required',
                    'plazo' => 'required|numeric|min:1',
                    'publicacion' => 'required',

                    'id_paa' => 'required',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'presupuesto_proyecto.required' => 'El campo Presupuesto del proyecto es requerido',
            'presupuesto_proyecto.min' => 'La suma de los presupuestos de las modalidades debe ser igual al campo Presupuesto del proyecto: $ '.number_format($this->request->get('presupuesto_proyecto'),0,",","."),
            'presupuesto_proyecto.max' => 'La suma de los presupuestos de las modalidades debe ser igual al campo Presupuesto del proyecto: $ '.number_format($this->request->get('presupuesto_proyecto'),0,",","."),

            'cantidad.required' => 'El campo Número de modalidades de contratación es requerido',
            'cantidad.numeric' => 'El campo Número de modalidades de contratación debe ser numeríco',
            'cantidad.min' => 'El campo Número de modalidades de contratación debe ser minimo 1',
            'cantidad.max' => 'El campo Número de modalidades de contratación debe ser minimo 4',

            'proyecto_id.required' => 'El campo Id del proyecto es requerido',
            'proyecto_id.unique' => 'El Proyecto ya tiene un PAA',

            'modalidad_id.required' => 'El campo Modalidad es requerido',
            'modalidad_id.array' => 'El campo Modalidad debe ser un conjunto',
            'modalidad_id.*.required' => 'El campo Modalidad es requerido',
            'modalidad_id.*.distinct' => 'El campo Modalidad debe ser único en cada presupuesto',

            'presupuesto_modalidad.required' => 'El campo Presupuesto modalidad es requerido',
            'presupuesto_modalidad.array' => 'El campo Presupuesto modalidad debe ser un conjunto',
            'presupuesto_modalidad.*.required' => 'El campo Presupuesto modalidad es requerido',
            'presupuesto_modalidad.*.numeric' => 'El campo Presupuesto modalidad debe ser numeríco',
            'presupuesto_modalidad.*.min' => 'El campo Presupuesto modalidad debe ser minimo 1',

            'socializacion.required' => 'El campo Fecha socialización a la comunidad es requerido',
            'plazo.required' => 'El campo Plazo ejecución fisica del proyecto es requerido',
            'plazo.numeric' => 'El campo Plazo ejecución fisica del proyecto debe ser numeríco',
            'plazo.min' => 'El campo Plazo ejecución fisica del proyecto debe ser minimo 1',
            'publicacion.required' => 'El campo Fecha publicación PAA es requerido',

            'id_paa.required' => 'El campo Consecutivo PAA (Id) es requerido',
        ];
    }
}
