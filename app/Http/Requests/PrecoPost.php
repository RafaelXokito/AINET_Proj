<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PrecoPost extends FormRequest
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
            'preco_un_catalogo' => 'required|min:0|regex:^[0-9]+(\.[0-9]{1,2})?^',
            'preco_un_proprio' => 'required|min:0|regex:^[0-9]+(\.[0-9]{1,2})?^',
            'preco_un_catalogo_desconto' => 'required|min:0|regex:^[0-9]+(\.[0-9]{1,2})?^',
            'preco_un_proprio_desconto' => 'required|min:0|regex:^[0-9]+(\.[0-9]{1,2})?^',
            'quantidade_desconto' => 'required|min:0',
        ];
    }
}
