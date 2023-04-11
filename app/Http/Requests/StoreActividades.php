<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActividades extends FormRequest
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
            'actividad' => 'required|min:4|max:100',
            'seguimiento_id' => 'required',
            'estado_id' => 'required',
            'fecha' => 'required',
            'acciones_adelantadas' => 'required|min:4|max:1000',
            'acciones_pendientes' => 'nullable|min:4|max:1000',
            'dificultades' => 'nullable|min:4|max:1000',
            'alternativas' => 'nullable|min:4|max:1000',
            'resultados' => 'nullable|min:4|max:1000',
            "evidencia" => "array",
            "evidencia.*" => "mimes:pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls,mp3|max:5000",  
        ];
    }

    public function messages()
    {
        return [
            'actividad.required' => 'El campo Descripción de la tarea es requerido',
            'actividad.min' => 'El campo Descripción de la tarea debe tener minimo 4 caracteres',
            'actividad.max' => 'El campo Descripción de la tarea debe tener maximo 100 caracteres',
            'seguimiento_id.required' => 'El campo Actividad es requerido',
            'estado_id.required' => 'El campo Estado es requerido',
            'fecha.required' => 'El campo Fecha es requerido',
            'acciones_adelantadas.required' => 'El campo Acciones adelantadas es requerido',
            'acciones_adelantadas.min' => 'El campo Acciones adelantadas debe tener minimo 4 caracteres',
            'acciones_adelantadas.max' => 'El campo Acciones adelantadas debe tener maximo 1000 caracteres',
            'acciones_pendientes.required' => 'El campo Acciones pendientes es requerido',
            'acciones_pendientes.min' => 'El campo Acciones pendientes debe tener minimo 4 caracteres',
            'acciones_pendientes.max' => 'El campo Acciones pendientes debe tener maximo 1000 caracteres',
            'dificultades.required' => 'El campo Dificultades presentadas es requerido',
            'dificultades.min' => 'El campo Dificultades presentadas debe tener minimo 4 caracteres',
            'dificultades.max' => 'El campo Dificultades presentadas debe tener maximo 1000 caracteres',
            
            'alternativas.required' => 'El campo Alternativas de solución es requerido',
            'alternativas.min' => 'El campo Alternativas de solución debe tener minimo 4 caracteres',
            'alternativas.max' => 'El campo Alternativas de solución debe tener maximo 1000 caracteres',
            
            'resultados.required' => 'El campo Resultados obtenidos es requerido',
            'resultados.min' => 'El campo Resultados obtenidos debe tener minimo 4 caracteres',
            'resultados.max' => 'El campo AResultados obtenidos debe tener maximo 1000 caracteres',
            
            'evidencia.mimes' => 'El campo evidencia debe ser formato pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls ó mp3',
            'evidencia.max' => 'El campo evidencia debe tener como maximo un peso de 5MB (5000 kilobytes)',
        ];
    }
}
