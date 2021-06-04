<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EncomendaPost extends FormRequest
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
            'nif' => 'required|digits:9',
            'endereco' => 'required',
            'tipo_pagamento' => 'required|in:VISA,MC,PAYPAL',
            'ref_pagamento' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (($this->tipo_pagamento != 'PAYPAL') && (strlen($value) != 16)) {
                        $fail('A referência de pagamento tem de conter 16 digitos.');
                    } else if (($this->tipo_pagamento == 'PAYPAL') && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('A referência de pagamento tem de ter um email válido.');
                    }
                }
            ]
        ];
    }
}
