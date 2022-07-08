<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
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
            'email'     => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|exists:users,email',
            'password'  => 'required'
        ];
    }

    public function messages()
    {
      return [
        'email.required'    => 'El correo electrónico es requerido',
        'email.regex'       => 'El formato del correo electrónico no es válido',
        'email.exists'      => 'Estas credenciales no coinciden con nuestros registros',

        'password.required' => 'La contraseña es requerida',
      ];
    }
}
