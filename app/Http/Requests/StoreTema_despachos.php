<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTema_despachos extends FormRequest
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
            'descripcion' => 'min:3|max:200|nullable',
            'fecha_reunion' => 'required',
            'hora_reunion' => 'required',
            'objetivo' => 'min:3|max:200|nullable',
            'asistentes' => 'min:3|max:1000|nullable',
            'orden' => 'min:3|max:200|nullable',
            'desarrollo' => 'min:3|max:11000|nullable',
            'estado' => 'required|min:1|max:2', 
            "evidencia" => "array",
            "evidencia.*" => "mimes:pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls,mp3|max:5000",
        ];
    }

    public function messages()
    {
        return [
            'descripcion.min' => 'El campo Tema de la reunión  debe tener minimo 3 caracteres',
            'descripcion.max' => 'El campo Tema de la reunión  debe tener maximo 200 caracteres',
            
            'estado.required' => 'El campo Estado reunión es requerido',
            'estado.min' => 'El campo Estado reunión  no corresponde coon los datos del sistema, refresque el navegador e intentelo de nuevo',
            'estado.max' => 'El campo Estado reunión  no corresponde coon los datos del sistema, refresque el navegador e intentelo de nuevo',

            'fecha_reunion.required' => 'El campo Fecha de la reunión es requerido',
            'hora_reunion.required' => 'El campo Hora de la reunión es requerido',

            'objetivo.min' => 'El campo Objetivo de la reunión  debe tener minimo 3 caracteres',
            'objetivo.max' => 'El campo Objetivo de la reunión  debe tener maximo 200 caracteres',

            'asistentes.min' => 'El campo Asistentes  debe tener minimo 3 caracteres',
            'asistentes.max' => 'El campo Asistentes  debe tener maximo 1000 caracteres',

            'orden.min' => 'El campo Orden del día  debe tener minimo 3 caracteres',
            'orden.max' => 'El campo Orden del día  debe tener maximo 200 caracteres',

            'desarrollo.min' => 'El campo Desarrollo de la reunión debe tener minimo 3 caracteres',
            'desarrollo.max' => 'El campo Desarrollo de la reunión debe tener maximo 11000 caracteres',
            
            'evidencia.mimes' => 'El campo evidencia debe ser formato pdf,jpeg,png,jpg,bmp,docx,doc,xlsx,txt,csv,xls ó mp3',
            'evidencia.max' => 'El campo evidencia debe tener como maximo un peso de 5MB (5000 kilobytes)',
        ];
    }
}
