<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class edicionUsuarioRequest extends FormRequest
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
            'nombreCompleto'=>'required',
            'correoElectronico'=>'required|email',
        ];
    }
    public function messages(){
        return[
            'nombreCompleto.required'=>'El campo nombre es requerido',

            'correoElectronico.required'=>'El campo Correo Electronico es requerido',
            'correoElectronico.email'=>'El dato ingresado no es un Correo Electronico',
        ];
    }
}
