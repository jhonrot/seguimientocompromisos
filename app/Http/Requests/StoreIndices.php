<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndices extends FormRequest
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
                if ($this->request->get('name') == $this->request->get('name_origin')) {
                    return [
                        'name' => 'required|string|min:4|max:100',
                        'description' => 'nullable||min:4|max:45',
                        'equipo_id' => 'required',
                    ];
                }else{
                    return [
                        'name' => 'required|string|unique:indices|min:4|max:100',
                        'description' => 'nullable||min:4|max:45',
                        'equipo_id' => 'required',
                    ];
                }
                break;

            default:
                return [
                    'name' => 'required|string|unique:indices|min:4|max:100',
                    'description' => 'nullable||min:4|max:45',
                    'equipo_id' => 'required',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre es requerido',
            'name.unique' => 'El campo Nombre ya existe',
            'name.min' => 'El campo Nombre debe tener un minimo de 4 caracteres',
            'name.max' => 'El campo Nombre debe tener un maximo de 100 caracteres',
            'description.min' => 'El campo Descripción debe tener un minimo de 4 caracteres',
            'description.max' => 'El campo Descripción debe tener un maximo de 45 caracteres',
            
            'equipo_id.required' => 'El campo Equipo es requerido',
        ];
    }
}
