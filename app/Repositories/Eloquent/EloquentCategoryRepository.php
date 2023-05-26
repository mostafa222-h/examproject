<?php

namespace App\Repositories\Eloquent;

use App\Entities\Category\CategoryEloquentEntity;
use App\Entities\User\UserEloquentEntity;
use App\Entities\User\UserEntity;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;


class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepositoryInterface
{
    protected $model = Category::class;


    public function create(array $data)
    {
        $createdCategory=  parent::create($data);
        return new CategoryEloquentEntity($createdCategory);
    }

    public function update(int $id, array $data)
    {
      if(!parent::update($id,$data)) 
      {
        throw new \Exception('The category could not be updated.');
        //return new UserEloquentEntity(null);
      } 
     return new CategoryEloquentEntity(parent::find($id)); 
    }
    
        
    

   
}