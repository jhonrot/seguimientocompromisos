<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeriodos extends FormRequest
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
            'anio' => 'required|numeric|min:2020|max:2050',
            'mes' => 'required|numeric|min:1|max:12',  
        ];
    }

    public function messages()
    {
        return [
            'anio.required' => 'El campo Año es requerido',
            'anio.min' => 'El campo Año debe ser mayor a 2020',
            'anio.max' => 'El campo Año debe ser menor a 2050',
            'anio.numeric' => 'El campo Año debe ser numeríco',
            'mes.required' => 'El campo Mes es requerido',
            'mes.min' => 'El campo Mes debe estar entre Enero y Diciembre',
            'mes.max' => 'El campo Mes debe estar entre Enero y Diciembre',
            'mes.numeric' => 'El campo Mes debe pertenecer al rango escogido',
        ];
    }
}
