<?php
namespace App\Entities\AnswerSheet ;


use App\Entities\Question\QuestionEntity;
use App\Models\AnswerSheet;
use App\Models\Question;
use Carbon\Carbon;

class AnswerSheetEloquentEntity implements AnswerSheetEntity
{
    private $answerSheet;

    public function __construct(AnswerSheet  $answerSheet)
    {
        $this->answerSheet = $answerSheet ;
    }



     public function getId(): int
     {
         return $this->answerSheet->id ;
     }

   
   public function getQuizzeId(): int 
   {
      return $this->answerSheet->quizze_id ;
   }



   public function getAnswers(): array 
   {
      return json_decode($this->answerSheet->answers,true) ;
   }

   public function getStatus(): int 
   {
     return $this->answerSheet->status ;
   }

   public function getScore(): float|null 
   {
    return $this->answerSheet?->score ;
   }

   public function getFinishedAt(): Carbon 
   {
     return Carbon::parse($this->answerSheet->finished_at);
   }
 
   
   
    
 
  
}