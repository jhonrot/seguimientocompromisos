<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Illuminate\Validation\Rule;

class StoreUsers extends FormRequest
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
                
                if (strlen( $this->request->get( 'password' ) ) > 0 || strlen( $this->request->get( 'password-confirm' ) ) > 0) {
                    if ($this->request->get('email') == $this->request->get('email_origin')) {
                        if ($this->request->get('num_document') == $this->request->get('num_document_origin')) {
                            return [
                                'type_document' => 'required',
                                'num_document' => 'required|string|min:3|max:20',
                                'name' => 'required|min:3|max:45',
                                'last_name' => 'required|min:3|max:90',
                                'email' =>'required|min:11|max:45|email',
                                'password' => 'required|min:7|max:45|confirmed',
                                'telefono' => 'nullable|min:7|max:7',
                                'celular' => 'nullable|min:10|max:10',
                                "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                            ];
                        }else{
                            return [
                                'type_document' => 'required',
                                'num_document' => 'required|unique:users|string|min:3|max:20',
                                'name' => 'required|min:3|max:45',
                                'last_name' => 'required|min:3|max:90',
                                'email' =>'required|min:11|max:45|email',
                                'password' => 'required|min:7|max:45|confirmed',
                                'telefono' => 'nullable|min:7|max:7',
                                'celular' => 'nullable|min:10|max:10',
                                "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                            ];
                        }
                    }else{
                        if ($this->request->get('num_document') == $this->request->get('num_document_origin')) {
                            return [
                                'type_document' => 'required',
                                'num_document' => 'required|string|min:3|max:20',
                                'name' => 'required|min:3|max:45',
                                'last_name' => 'required|min:3|max:90',
                                'email' =>'required|min:11|max:45|email|unique:users',
                                'password' => 'required|min:7|max:45|confirmed',
                                'telefono' => 'nullable|min:7|max:7',
                                'celular' => 'nullable|min:10|max:10',
                                "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                            ];
                        }else{
                            return [
                                'type_document' => 'required',
                                'num_document' => 'required|unique:users|string|min:3|max:20',
                                'name' => 'required|min:3|max:45',
                                'last_name' => 'required|min:3|max:90',
                                'email' =>'required|min:11|max:45|email|unique:users',
                                'password' => 'required|min:7|max:45|confirmed',
                                'telefono' => 'nullable|min:7|max:7',
                                'celular' => 'nullable|min:10|max:10',
                                "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                            ];
                        }
                    }
                }else{
                    if ($this->request->get('email') == $this->request->get('email_origin')) {
                        if ($this->request->get('num_document') == $this->request->get('num_document_origin')) {
                            return [
                                'type_document' => 'required',
                                'num_document' => 'required|string|min:3|max:20',
                                'name' => 'required|min:3|max:45',
                                'last_name' => 'required|min:3|max:90',
                                'email' =>'required|min:11|max:45|email',
                                'telefono' => 'nullable|min:7|max:7',
                                'celular' => 'nullable|min:10|max:10',
                                "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                            ];
                        }else{
                            return [
                                'type_document' => 'required',
                                'num_document' => 'required|unique:users|string|min:3|max:20',
                                'name' => 'required|min:3|max:45',
                                'last_name' => 'required|min:3|max:90',
                                'email' =>'required|min:11|max:45|email',
                                'telefono' => 'nullable|min:7|max:7',
                                'celular' => 'nullable|min:10|max:10',
                                "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                            ];
                        }
                    }else{
                        if ($this->request->get('num_document') == $this->request->get('num_document_origin')) {
                            return [
                                'type_document' => 'required',
                                'num_document' => 'required|string|min:3|max:20',
                                'name' => 'required|min:3|max:45',
                                'last_name' => 'required|min:3|max:90',
                                'email' =>'required|min:11|max:45|email|unique:users',
                                'telefono' => 'nullable|min:7|max:7',
                                'celular' => 'nullable|min:10|max:10',
                                "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                            ];
                        }else{
                            return [
                                'type_document' => 'required',
                                'num_document' => 'required|unique:users|string|min:3|max:20',
                                'name' => 'required|min:3|max:45',
                                'last_name' => 'required|min:3|max:90',
                                'email' =>'required|min:11|max:45|email|unique:users',
                                'telefono' => 'nullable|min:7|max:7',
                                'celular' => 'nullable|min:10|max:10',
                                "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                            ]; 
                        }
                    } 
                }
                break;

            default:
                return [
                    'type_document' => 'required',
                    'num_document' => 'required|unique:users|string|min:3|max:20',
                    'name' => 'required|min:3|max:45',
                    'last_name' => 'required|min:3|max:90',
                    'email' => 'required|unique:users|email|min:11|max:45',
                    'password' => 'required|min:7|max:45|confirmed',
                    'state' => 'required',
                    'state_logic' => 'required',
                    'telefono' => 'nullable|min:7|max:7',
                    'celular' => 'nullable|min:10|max:10',
                    "foto.*" => "image|mimes:jpeg,png,jpg,bmp|max:5000",
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'type_document.required' => 'El campo Tipo documento es requerido',
            'num_document.required' => 'El campo Número de documento es requerido',
            'num_document.unique' => 'El campo Número de documento ya existe',
            'num_document.min' => 'El campo Número de documento debe tener un minimo de 3 números',
            'num_document.max' => 'El campo Número de documento debe tener un maximo de 20 números',
            'name.required' => 'El campo Nombre(s) es requerido',
            'name.min' => 'El campo Nombre(s)  debe tener un minimo de 3 caracteres',
            'name.max' => 'El campo Nombre(s)  debe tener un maximo de 45 caracteres',
            'last_name.required' => 'El campo Apellidos es requerido',
            'last_name.min' => 'El campo Apellidos debe tener un minimo de 3 caracteres',
            'last_name.max' => 'El campo Apellidos debe tener un maximo de 90 caracteres',
            'email.required' => 'El campo Correo es requerido',
            'email.unique' => 'El campo Correo ya existe',
            'email.min' => 'El campo Correo debe tener un minimo de 11 caracteres',
            'email.max' => 'El campo Correo debe tener un maximo de 45 caracteres',
            'email.email' => 'El campo Correo debe debe ser de tipo correo (example@mail.com)',
            'password.required' => 'El campo Contraseña es requerido',
            'password.min' => 'El campo Contraseña debe tener un minimo de 7 caracteres',
            'password.max' => 'El campo Contraseña debe tener un maximo de 45 caractres',
            'password.confirmed' => 'El campo Contraseña no coincide con el campo confirmar contraseña',
            'state.required' => 'El campo ingreso por logueo es requerido',
            'state_logic.required' => 'El campo responsable es requerido',
            'telefono.min' => 'El campo teléfono debe tener un minimo de 7 números',
            'telefono.max' => 'El campo teléfono debe tener un maximo de 7 números',
            'celular.min' => 'El campo celular debe tener un minimo de 10 números',
            'celular.max' => 'El campo celular debe tener un maximo de 10 números',
            'foto.*' => 'El archivo de evidencia debe ser un documento en formato imagen (.png, .jpg, .jpeg, .bmp)',
        ];
    }
}
