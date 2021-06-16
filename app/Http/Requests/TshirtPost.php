<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TshirtPost extends FormRequest
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
            'cor_codigo' => 'required|exists:cores,codigo',
            'tamanho' => 'required|in:XS,S,M,L,XL',
            'quantidade' => 'required|min:0|numeric',
        ];
    }
}
