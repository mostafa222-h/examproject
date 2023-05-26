<?php

namespace App\Repositories\Eloquent;

use App\Entities\Question\QuestionEloquentEntity;
use App\Models\Question;

use App\Repositories\Contracts\QuestionRepositoryInterface;


class EloquentQuestionRepository extends EloquentBaseRepository implements QuestionRepositoryInterface
{
    protected $model = Question::class;


    public function create(array $data)
    {
        $createdQuizze=  parent::create($data);
        return new QuestionEloquentEntity($createdQuizze);
    }

    public function update(int $id, array $data)
    {
      if(!parent::update($id,$data)) 
      {
        throw new \Exception('The quizze could not be updated.');
        //return new UserEloquentEntity(null);
      } 
     return new QuestionEloquentEntity(parent::find($id)); 
    }
    
        
    

   
}