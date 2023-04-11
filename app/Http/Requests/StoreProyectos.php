<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Proyecto;
use Illuminate\Validation\Rule;

class StoreProyectos extends FormRequest
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
                if ($this->request->get('bp') == $this->request->get('bp_origin')) {
                    return [
                        'name' => 'required|string|min:4|max:500',
                        'bp' => 'required|string|min:5|max:10',
                        'comuna_id' => 'required',
                        'organismo_id' => 'required',
                        'user_id' => 'required',
                    ];
                }else{
                    return [
                        'name' => 'required|string|min:4|max:500',
                        'bp' => 'required|string|unique:proyectos|min:5|max:10',
                        'comuna_id' => 'required',
                        'organismo_id' => 'required',
                        'user_id' => 'required',
                    ];
                }    
                break;
            default:

                return [
                    'name' => 'required|string|min:4|max:500',
                    'bp' => 'required|string|unique:proyectos|min:5|max:10',
                    'comuna_id' => 'required',
                    'organismo_id' => 'required',
                    'user_id' => 'required',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre es requerido',
            'name.min' => 'El campo Nombre debe tener un minimo de 4 caracteres',
            'name.max' => 'El campo Nombre debe tener un maximo de 500 caracteres',
            'bp.required' => 'El campo BP es requerido',
            'bp.unique' => 'El campo BP ya existe',
            'bp.min' => 'El campo BP debe tener un minimo de 5 caracteres',
            'bp.max' => 'El campo BP debe tener un maximo de 10 caracteres',
            'comuna_id.required' => 'El campo Comuna es requerido',
            'organismo_id.required' => 'El campo Organismo es requerido',
            'user_id.required' => 'El campo Usuario es requerido',
        ];
    }
}