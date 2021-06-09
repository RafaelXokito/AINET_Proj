<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EstampaPost extends FormRequest
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
            'cliente_id' => 'exists:clientes,id',
            'categoria_id' => ['exists:categorias,id',
                                function ($attribute, $value, $fail) {
                                    if ((Auth::user()->tipo != 'C') && !isset($value)) {
                                        $fail('A estampa tem de ter uma categoria.');
                                    }
                                } ],
            'nome' => 'required|max:255',
            'descricao' => 'required',
            'imagem_url' => 'required|mimes:png,jpg,jpeg,bmp|max:8192',
            'informacao_extra' => 'nullable',
        ];
    }
}
