<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\Common\AbstractRepository;

class UserRepository extends AbstractRepository implements UserRepositoryInterface {

    protected $model = User::class;

}
