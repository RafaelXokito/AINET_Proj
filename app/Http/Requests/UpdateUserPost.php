<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserPost extends FormRequest
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
            'name' =>         'required',
            'foto' =>         'nullable|image|max:8192',   // Máximum size = 8Mb
            'bloqueado' => 'nullable|in:0,1',
            'tipo' => 'nullable|in:F,A',
            'nif' => 'nullable|digits:9',
            'endereco' => 'nullable',
            'tipo_pagamento' => 'nullable|in:VISA,MC,PAYPAL',
            'ref_pagamento' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (($this->tipo_pagamento != 'PAYPAL') && (! preg_match('/[^0-9]/', $value) && strlen((string) $value) == 16)) {
                        $fail('A referência de pagamento tem de conter 16 digitos.');
                    } else if (($this->tipo_pagamento == 'PAYPAL') && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('A referência de pagamento tem de ter um email válido.');
                    }
                }
            ]
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator( $validator )
    {
        $validator->after(function ($validator) {
            if (Auth::user()->tipo == 'A' && !isset($this['tipo']) ) {
                $validator->errors()->add('tipo', 'O campo tipo é obrigatório!');
            }
            if (Auth::user()->tipo == 'A' && !isset($this['bloqueado']) ) {
                $validator->errors()->add('bloqueado', 'O campo bloquado é obrigatório!');
            }
        });
    }
}
