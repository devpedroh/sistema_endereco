<?php

namespace App\Repositories\Contracts;

interface CepRepositoryInterface {

    public function find ($cep);
    public function where ($where);
    public function findAll ();
    public function create (array $data);
    public function update (array $data, $id);
    public function delete ($id);

}
