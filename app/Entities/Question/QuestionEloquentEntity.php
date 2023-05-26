<?php
namespace App\Entities\Question ;

use App\Entities\Question\QuestionEntity;
use App\Models\Question;

class QuestionEloquentEntity implements QuestionEntity
{
     private $question;

    public function __construct(Question  $question)
    {
        $this->question = $question ;
    }



    public function getId(): int
    {
        return $this->question->id ;
    }
 
    public function getTitle(): string 
    {
        return $this->question->title ;
    }

    public function getScore(): float 
    {
        return floatval($this->question->score)  ;
    }

    public function getIsActive(): int 
    {
        return $this->question->is_active ;
    }

    public function getOptions(): array
    {
        return json_decode($this->question->options , true)  ;
    }


    public function getQuizzeId(): int
    {
        return $this->question->quizze_id ;
    }

    

   
    
 
  
}