<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Contracts\ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\QuizzeRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class QuizzesController extends ApiController
{
    private $questionRepository;
    private $quizzeRepository ; 
    public function __construct(QuestionRepositoryInterface $questionRepository , QuizzeRepositoryInterface $quizzeRepository )
    {
        $this->questionRepository = $questionRepository ;

        $this->quizzeRepository = $quizzeRepository ;
    }
    
        
    
   
    public function index(Request $request)
    {
        $this->validate($request,[
            'search' => 'nullable|string' ,
            'page' => 'required|numeric' ,
            'pagesize' => 'nullable|numeric'
        ]);

        $quizzes = $this->questionRepository->paginate($request->search,$request->page,$request->pagesize ?? 20, ['title','score' , 'is_active','options','quizze_id']);
        return $this->respondSuccess('ALL  Questions ',$quizzes);
    }
    public function store(Request $request)
    {
        
         $this->validate($request,[
             'title' => 'required|string',
             'score' => 'required|numeric' ,
             'is_active' => 'required|numeric' ,
             'quizze_id' => 'required|numeric' ,
             'options' => 'required|json' ,
           
                                    ]);

         if(! $this->quizzeRepository->find($request->quizze_id))
         {
            return $this->respondForbidden('There is no Quizze.');
         }                           
        

         $created_question = $this->questionRepository->create([
            'title' => $request->title ,
            'score' => $request->score ,
            'is_active' => $request->is_active,
            'quizze_id' => $request->quizze_id ,
            'options' =>$request->options,
         ]);
       
         return $this->respondCreated('Question created successfully.' ,[
            'title' =>  $created_question->getTitle() ,
            'score' =>   $created_question->getScore(),
            'is_active' =>   $created_question->getIsActive(),
            'quizze_id' =>   $created_question->getQuizzeId(),
            'options' => json_encode($created_question->getOptions())  ,
          
          
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
        $this->validate($request,[
             'id' => 'required|numeric' ,
             'title' => 'required|string',
             'score' => 'required|numeric' ,
             'is_active' => 'required|numeric' ,
             'quizze_id' => 'required|numeric' ,
             'options' => 'required|json' ,
        ]);

        if(! $this->questionRepository->find($request->id))
        {
            return $this->respondNotFound('Question not found');
        }
        try{

          
            $updatedQuestion =  $this->questionRepository->update($request->id,[
                        
                'title' => $request->title ,
                'score' => $request->score ,
                'is_active' => $request->is_active,
                'quizze_id' => $request->quizze_id ,
                'options' =>$request->options,
                        
            ]);

        }catch(\Exception $e){
            return $this->respondInternalError('Question Not Updated.');
        }

    
        return $this->respondSuccess('Question updated successfully.' ,[
            'title' =>  $updatedQuestion->getTitle() ,
            'score' =>   $updatedQuestion->getScore(),
            'is_active' =>   $updatedQuestion->getIsActive(),
            'quizze_id' =>   $updatedQuestion->getQuizzeId(),
            'options' => json_encode($updatedQuestion->getOptions())  ,

            
            
           
        ]);
    }
   

    public function delete(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|numeric' ,
        ]);
        if(!$this->questionRepository->find($request->id))
        {
            return $this->respondNotFound('There is no question with this ID.');
        }

        if(!$this->questionRepository->delete($request->id))
        {
            return $this->respondInternalError('There is no question with this ID.');
        }

        return $this->respondSuccess('question Deleted  successfully.',[]);
      }
}