<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
            ],
        ];
    }
}
