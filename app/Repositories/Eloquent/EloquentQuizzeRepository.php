<?php

namespace App\Repositories\Eloquent;


use App\Entities\Quizze\QuizzeEloquentEntity;
use App\Models\Quizze;
use App\Repositories\Contracts\QuizzeRepositoryInterface;

class EloquentQuizzeRepository extends EloquentBaseRepository implements QuizzeRepositoryInterface
{
    protected $model = Quizze::class;


    public function create(array $data)
    {
        $createdQuizze=  parent::create($data);
        return new QuizzeEloquentEntity($createdQuizze);
    }

    public function update(int $id, array $data)
    {
      if(!parent::update($id,$data)) 
      {
        throw new \Exception('The quizze could not be updated.');
        //return new UserEloquentEntity(null);
      } 
     return new QuizzeEloquentEntity(parent::find($id)); 
    }
    
        
    

   
}