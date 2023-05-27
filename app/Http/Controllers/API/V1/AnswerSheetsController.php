<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Contracts\ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AnswerSheetRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\QuizzeRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AnswerSheetsController extends ApiController
{
    private $answerSheetRepository;
    private $quizzeRepository ; 
    public function __construct(AnswerSheetRepositoryInterface $answerSheetRepository , QuizzeRepositoryInterface $quizzeRepository )
    {
        $this->answerSheetRepository = $answerSheetRepository ;

        $this->quizzeRepository = $quizzeRepository ;
    }
    
        
    
   
    public function index(Request $request)
    {
        $this->validate($request,[
            'search' => 'nullable|string' ,
            'page' => 'required|numeric' ,
            'pagesize' => 'nullable|numeric'
        ]);

        $answerSheets = $this->answerSheetRepository->paginate($request->search,$request->page,$request->pagesize ?? 20, ['quizze_id','score' , 'answers','status','finished_at']);
        return $this->respondSuccess('ALL  answerSheet ',$answerSheets);
    }
    public function store(Request $request)
    {
        
         $this->validate($request,[
             'quizze_id' => 'required|numeric',
             'answers' => 'required|json' ,
             'status' => 'required|numeric' ,
             'score' => 'required|numeric' ,
             'finished_at' => 'required|date' ,
           
                                    ]);

         if(! $this->quizzeRepository->find($request->quizze_id))
         {
            return $this->respondForbidden('There is no Quizze.');
         }                           
        

         $answerSheet = $this->answerSheetRepository->create([
            'quizze_id' => $request->quizze_id ,
            'answers' => $request->answers ,
            'status' => $request->status,
            'score' => $request->score ,
            'finished_at' =>$request->finished_at,
         ]);
       
         return $this->respondCreated('Answer-Sheet created successfully.' ,[
            'quizze_id' =>  $answerSheet->getQuizzeId() ,
            'answers' => json_encode($answerSheet->getAnswers())   ,
            'status' =>   $answerSheet->getStatus(),
            'score' =>   $answerSheet->getScore(),
            'finished_at' => $answerSheet->getFinishedAt()  ,
          
          
        ]);
          /*  return response()->json(
                [
                'success' => true ,
                'message' => 'User created successfully' ,
            
                'data' => [
                    'full_name' => $request->full_name ,
                    'email' => $request->email,
                    'mobile' => $request->mobile ,
                    'password' => $request->password ,
                ],
            ]
        )->setStatusCode(201); */
    }

    public function update(Request $request)
    {
        // $this->validate($request,[
        //      'id' => 'required|numeric' ,
        //      'title' => 'required|string',
        //      'score' => 'required|numeric' ,
        //      'is_active' => 'required|numeric' ,
        //      'quizze_id' => 'required|numeric' ,
        //      'options' => 'required|json' ,
        // ]);

        // if(! $this->questionRepository->find($request->id))
        // {
        //     return $this->respondNotFound('Question not found');
        // }
        // try{

          
        //     $updatedQuestion =  $this->questionRepository->update($request->id,[
                        
        //         'title' => $request->title ,
        //         'score' => $request->score ,
        //         'is_active' => $request->is_active,
        //         'quizze_id' => $request->quizze_id ,
        //         'options' =>$request->options,
                        
        //     ]);

        // }catch(\Exception $e){
        //     return $this->respondInternalError('Question Not Updated.');
        // }

    
        // return $this->respondSuccess('Question updated successfully.' ,[
        //     'title' =>  $updatedQuestion->getTitle() ,
        //     'score' =>   $updatedQuestion->getScore(),
        //     'is_active' =>   $updatedQuestion->getIsActive(),
        //     'quizze_id' =>   $updatedQuestion->getQuizzeId(),
        //     'options' => json_encode($updatedQuestion->getOptions())  ,

            
            
           
        // ]);
    }
   

    public function delete(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|numeric' ,
        ]);
        if(!$this->answerSheetRepository->find($request->id))
        {
            return $this->respondNotFound('There is no answerSheet with this ID.');
        }

        if(!$this->answerSheetRepository->delete($request->id))
        {
            return $this->respondInternalError('There is no answerSheet with this ID.');
        }

        return $this->respondSuccess('answerSheet Deleted  successfully.',[]);
      }
}