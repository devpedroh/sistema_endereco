<?php

namespace App\Repositories\Eloquent;

use App\Models\Cep as CepLocal;
use App\Repositories\Contracts\CepRepositoryInterface;
use App\Repositories\Eloquent\Common\AbstractRepository;

class CepRepository extends AbstractRepository implements CepRepositoryInterface {

    protected $model = CepLocal::class;

}
