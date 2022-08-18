<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface {

    public function get ($id, $column);
    public function where ($where);
    public function find ($id);
    public function findAll ();
    public function create (array $data);
    public function update (array $data, $id);

}
