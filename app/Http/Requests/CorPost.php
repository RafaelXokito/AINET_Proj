<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorPost extends FormRequest
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
            'codigo' => array('required',
                              'regex:/^((?:[0-9a-f]{2}){2,4}|[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i'),
            'nome' => 'required|max:255|string',
            'foto' => 'mimes:jpeg,jpg,png|max:8192'
        ];
    }
}
