<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CepCreateRequest extends FormRequest
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
            'numero' => 'unique:ceps|integer|required',
            'cep' => 'required|string|unique:ceps',
            'logradouro' => '',
            'complemento' => '',
            'bairro' => '',
            'localidade' => 'required|string',
            'uf' => 'required|string|min:2',
            'ddd' => 'required|integer|min:2',
        ];
    }
}
