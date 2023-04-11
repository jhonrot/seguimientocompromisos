<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequerimientos extends FormRequest
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
                if ($this->request->get('obs_support') == null){
                    return [
                        'tema' => 'required',
                        "evidencia.*" => "mimes:jpeg,png,jpg,bmp,pdf|max:5000",
                        "obs_creator" => 'required|min:10|max:500',                  
                    ];
                }else{
                    return [
                        'state' => 'required',
                        "obs_support" => 'required|min:10|max:500',                  
                    ];
                }
            break;

            default:
                return [
                    'tema' => 'required',
                    "evidencia.*" => "mimes:jpeg,png,jpg,bmp,pdf|max:5000",
                    "obs_creator" => 'required|min:10|max:500',                  
                ];
            break;
        }
    }

    public function messages()
    {
        return [
            'tema.required' => 'El campo Tema es requerido',
            'state.required' => 'El campo Estado es requerido',
            'obs_creator.required' => 'El campo Observación usuario es requerido',
            'obs_creator.min' => 'El campo Observación usuario debe tener minimo minimo 10 caracteres',
            'obs_creator.max' => 'El campo Observación usuario debe tener minimo maximo 500 caracteres',
            'obs_support.required' => 'El campo Observación soporte es requerido',
            'obs_support.min' => 'El campo Observación soporte debe tener minimo minimo 10 caracteres',
            'obs_support.max' => 'El campo Observación soporte debe tener minimo maximo 500 caracteres',
            'evidencia.*' => 'El archivo de evidencia debe ser un documento en formato PDF ó imagen',
        ];
    }
}
