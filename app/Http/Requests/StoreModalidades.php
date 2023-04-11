<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModalidades extends FormRequest
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
                if ($this->request->get('tipo') == $this->request->get('tipo_origin')) {
                    return [
                        'tipo' => 'required|string|min:4|max:100',
                        'tiempo' => 'required|numeric|min:0|max:100',
                    ];
                }else{
                    return [
                        'tipo' => 'required|string|unique:modalidades|min:4|max:100',
                        'tiempo' => 'required|numeric|min:0|max:100',
                    ];
                }
                break;

            default:
                return [
                    'tipo' => 'required|string|unique:modalidades|min:4|max:100',
                    'tiempo' => 'required|numeric|min:0|max:100',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'tipo.required' => 'El campo Tipo es requerido',
            'tipo.unique' => 'El campo Tipo ya existe',
            'tipo.min' => 'El campo Tipo debe tener un minimo de 4 caracteres',
            'tipo.max' => 'El campo Tipo debe tener un maximo de 100 caracteres',
            'tiempo.required' => 'El campo Tiempo es requerido',
            'tiempo.numeric' => 'El campo Tiempo es de tipo numeríco',
            'tiempo.min' => 'El campo Tiempo debe ser minimo 0',
            'tiempo.max' => 'El campo Tiempo debe ser maximo 100',
        ];
    }
}
