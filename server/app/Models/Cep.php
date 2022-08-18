<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cep extends Model {

    protected $fillable = [
        'id',
        'numero',
        'cep',
        'logradouro',
        'complemento',
        'bairro',
        'localidade',
        'uf',
        'ddd'
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at',
        'updated_at'
    ];

}
