<?php

namespace App\Repositories\Json;

use App\Entities\User\UserEntity;
use App\Entities\User\UserJsonEntity;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class JsonUserRepository extends JsonBaseRepository implements UserRepositoryInterface
{
    public function create(array $data) : UserEntity
    {
        $newUser = parent::create($data);

        return new UserJsonEntity($newUser);
    }

 

    public function find(int $id) : UserEntity
    {
        $user = parent::find($id);

        return new UserJsonEntity($user);
    }

   
}