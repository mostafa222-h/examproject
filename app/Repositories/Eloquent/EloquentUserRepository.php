<?php

namespace App\Repositories\Eloquent;

use App\Entities\User\UserEloquentEntity;
use App\Entities\User\UserEntity;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepositoryInterface
{
    protected $model = User::class;


    public function create(array $data)
    {
        $newUser =  parent::create($data);
        return new UserEloquentEntity($newUser);
    }

    public function update(int $id, array $data): UserEntity
    {
      if(!parent::update($id,$data)) 
      {
        throw new \Exception('The user could not be updated.');
        //return new UserEloquentEntity(null);
      } 
     return new UserEloquentEntity(parent::find($id)); 
    }
    
        
    

   
}