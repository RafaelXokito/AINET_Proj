<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEstadoEncomendaPost extends FormRequest
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
            'estado' => [
                'required',
                'in:pendente,paga,fechado,anulado',
                function ($attribute, $value, $fail) {
                    if ((Auth ::user()->tipo != 'A') && ($value == 'anulado')) {
                        $fail('O estado da encomenda tem de ser "Pendente" ou "Paga" ou "Fechado".');
                    }
                }
            ],
        ];
    }
}
