<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'        => 'Deve ser aceito.',
    'active_url'      => 'Deve conter uma URL válida.',
    'after'           => 'Deve conter uma data posterior a :date.',
    'after_or_equal'  => 'Deve conter uma data superior ou igual a :date.',
    'alpha'           => 'Deve conter apenas letras.',
    'alpha_dash'      => 'Deve conter apenas letras, números e traços.',
    'alpha_num'       => 'Deve conter apenas letras e números .',
    'array'           => 'Deve conter um array.',
    'before'          => 'Deve conter uma data anterior a :date.',
    'before_or_equal' => 'Deve conter uma data inferior ou igual a :date.',
    'between'         => [
        'numeric' => 'Deve conter um número entre :min e :max.',
        'file'    => 'Deve conter um arquivo de :min a :max kilobytes.',
        'string'  => 'Deve conter entre :min a :max caracteres.',
        'array'   => 'Deve conter de :min a :max itens.',
    ],
    'boolean'        => 'Deve conter o valor verdadeiro ou falso.',
    'confirmed'      => 'A confirmação para o campo :attribute não coincide.',
    'date'           => 'Não contém uma data válida.',
    'date_equals'    => 'Deve ser uma data igual a :date.',
    'date_format'    => 'A data informada não respeita o formato :format.',
    'different'      => 'Os campos :attribute e :other devem conter valores diferentes.',
    'digits'         => 'Deve conter :digits dígitos.',
    'digits_between' => 'Deve conter entre :min a :max dígitos.',
    'dimensions'     => 'O valor informado não é uma dimensão de imagem válida.',
    'distinct'       => 'Contém um valor duplicado.',
    'email'          => 'Não contém um endereço de email válido.',
    'ends_with'      => 'Deve terminar com um dos seguintes valores: :values',
    'exists'         => 'O valor informado é inválido.',
    'file'           => 'Deve conter um arquivo.',
    'filled'         => 'O campo obrigatório.',
    'gt'             => [
        'numeric' => 'Deve ser maior que :value.',
        'file'    => 'O arquivo deve ser maior que :value kilobytes.',
        'string'  => 'Deve ser maior que :value caracteres.',
        'array'   => 'Deve ter mais que :value itens.',
    ],
    'gte' => [
        'numeric' => 'Deve ser maior ou igual a :value.',
        'file'    => 'O arquivo deve ser maior ou igual a :value kilobytes.',
        'string'  => 'Deve ser maior ou igual a :value caracteres.',
        'array'   => 'Deve ter :value itens ou mais.',
    ],
    'image'    => 'Deve conter uma imagem.',
    'in'       => 'Não contém um valor válido.',
    'in_array' => 'Não existe em :other.',
    'integer'  => 'Deve conter um número inteiro.',
    'ip'       => 'Deve conter um IP válido.',
    'ipv4'     => 'Deve conter um IPv4 válido.',
    'ipv6'     => 'Deve conter um IPv6 válido.',
    'json'     => 'Deve conter uma string JSON válida.',
    'lt'       => [
        'numeric' => 'Deve ser menor que :value.',
        'file'    => 'O arquivo deve ser menor que :value kilobytes.',
        'string'  => 'Deve ser menor que :value caracteres.',
        'array'   => 'Deve ter menos que :value itens.',
    ],
    'lte' => [
        'numeric' => 'Deve ser menor ou igual a :value.',
        'file'    => 'O arquivo deve ser menor ou igual a :value kilobytes.',
        'string'  => 'Deve ser menor ou igual a :value caracteres.',
        'array'   => 'Não deve ter mais que :value itens.',
    ],
    'max' => [
        'numeric' => 'Não pode conter um valor superior a :max.',
        'file'    => 'Não pode conter um arquivo com mais de :max kilobytes.',
        'string'  => 'Não pode conter mais de :max caracteres.',
        'array'   => 'Deve conter no máximo :max itens.',
    ],
    'mimes'     => 'Deve conter um arquivo do tipo: :values.',
    'mimetypes' => 'Deve conter um arquivo do tipo: :values.',
    'min'       => [
        'numeric' => 'Deve conter um número superior ou igual a :min.',
        'file'    => 'Deve conter um arquivo com no mínimo :min kilobytes.',
        'string'  => 'Deve conter no mínimo :min caracteres.',
        'array'   => 'Deve conter no mínimo :min itens.',
    ],
    'not_in'               => 'Contém um valor inválido.',
    'not_regex'            => 'O formato é inválido.',
    'numeric'              => 'Deve conter um valor numérico.',
    'password'             => 'A senha está incorreta.',
    'present'              => 'Deve estar presente.',
    'regex'                => 'O formato do valor informado no campo :attribute é inválido.',
    'required'             => 'Campo é obrigatório.',
    'required_if'          => 'Campo é obrigatório quando o valor do campo :other é igual a :value.',
    'required_unless'      => 'Campo é obrigatório a menos que :other esteja presente em :values.',
    'required_with'        => 'Campo é obrigatório quando :values está presente.',
    'required_with_all'    => 'Campo é obrigatório quando um dos :values está presente.',
    'required_without'     => 'Campo é obrigatório quando :values não está presente.',
    'required_without_all' => 'Campo é obrigatório quando nenhum dos :values está presente.',
    'same'                 => 'Os campos :attribute e :other devem conter valores iguais.',
    'size'                 => [
        'numeric' => 'Deve conter o número :size.',
        'file'    => 'Deve conter um arquivo com o tamanho de :size kilobytes.',
        'string'  => 'Deve conter :size caracteres.',
        'array'   => 'Deve conter :size itens.',
    ],
    'starts_with' => 'Deve começar com um dos seguintes valores: :values',
    'string'      => 'Deve ser uma string.',
    'timezone'    => 'Deve conter um fuso horário válido.',
    'unique'      => ':attribute já está sendo usado.',
    'uploaded'    => 'Falha no Upload do arquivo.',
    'url'         => 'O formato da URL informada é inválido.',
    'uuid'        => 'Deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'address'               => 'endereço',
        'age'                   => 'idade',
        'body'                  => 'conteúdo',
        'city'                  => 'cidade',
        'country'               => 'país',
        'date'                  => 'data',
        'day'                   => 'dia',
        'description'           => 'descrição',
        'excerpt'               => 'resumo',
        'first_name'            => 'primeiro nome',
        'gender'                => 'gênero',
        'hour'                  => 'hora',
        'last_name'             => 'sobrenome',
        'message'               => 'mensagem',
        'minute'                => 'minuto',
        'mobile'                => 'celular',
        'month'                 => 'mês',
        'name'                  => 'nome',
        'password_confirmation' => 'confirmação da senha',
        'password'              => 'senha',
        'phone'                 => 'telefone',
        'second'                => 'segundo',
        'sex'                   => 'sexo',
        'state'                 => 'estado',
        'subject'               => 'assunto',
        'text'                  => 'texto',
        'time'                  => 'hora',
        'title'                 => 'título',
        'username'              => 'usuário',
        'year'                  => 'ano',
        'email'                 => 'e-mail',
        'remember'              => 'lembrar-me',
    ],
];
