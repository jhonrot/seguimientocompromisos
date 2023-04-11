<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoles extends FormRequest
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
                            'name' => 'required|min:4|max:255',
                        ];
                    }else{
                        return [
                            'name' => 'required|min:4|max:255|unique:roles',
                        ];
                    }
                
                break;
        
            default:
                return [
                    'name' => 'required|min:4|max:255|unique:roles',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre es requerido',
            'name.min' => 'El campo Nombre debe tener un minimo de 4 caracteres',
            'name.max' => 'El campo Nombre debe tener un maximo de 255 caracteres',
            'name.unique' => 'El campo Nombre ya existe',
        ];
    }
}
