<?php
namespace App\Entities\Quizze ;


use App\Models\Quizze;

class QuizzeEloquentEntity implements QuizzeEntity
{
     private $quizze ;

    public function __construct(Quizze $quizze)
    {
        $this->quizze = $quizze ;
    }
    
  public function getId ():int
  {
    return $this->quizze->id;
  }

  public function getTitle ():string
  {
    return $this->quizze->title;
  }

  public function getDescription ():string
  {
    return $this->quizze->description;
  }

  public function getCategoryId ():int
  {
    return $this->quizze->category_id;
  }

  public function getStartDate ():string
  {
    return $this->quizze->start_date;
  }

  public function getDuration ():string
  {
    return $this->quizze->duration;
  }

  public function getIsActive():bool
  {
    return $this->quizze->is_active;
  }

  
}