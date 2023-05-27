<?php

namespace App\Repositories\Eloquent;

use App\Entities\AnswerSheet\AnswerSheetEloquentEntity;
use App\Entities\Question\QuestionEloquentEntity;
use App\Models\AnswerSheet;

use App\Repositories\Contracts\AnswerSheetRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;


class EloquentAnswerSheetRepository extends EloquentBaseRepository implements AnswerSheetRepositoryInterface
{
    protected $model = AnswerSheet::class;


    public function create(array $data)
    {
        $createdAnswerSheet=  parent::create($data);
        return new AnswerSheetEloquentEntity($createdAnswerSheet);
    }

    public function update(int $id, array $data)
    {
      if(!parent::update($id,$data)) 
      {
        throw new \Exception('The  question could not be updated.');
        //return new UserEloquentEntity(null);
      } 
     return new QuestionEloquentEntity(parent::find($id)); 
    }
    
        
    

   
}