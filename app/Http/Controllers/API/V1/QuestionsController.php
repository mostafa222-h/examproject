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
        // $this->validate($request,[
        //     'search' => 'nullable|string' ,
        //     'page' => 'required|numeric' ,
        //     'pagesize' => 'nullable|numeric'
        // ]);

        // $quizzes = $this->quizzeRepository->paginate($request->search,$request->page,$request->pagesize ?? 20, ['title','description' , 'start_date','duration']);
        // return $this->respondSuccess('ALL  Quizze',$quizzes);
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
        // $this->validate($request,[
        //      'id' => 'required|numeric' ,
        //      'category_id' => 'required|numeric',
        //      'title' => 'required|string' ,
        //      'description' => 'required|string' ,
        //      'start_date' => 'required|date' ,
        //      'duration' => 'required|date',
        //      'is_active' => 'required|bool'
        // ]);
        // try{

        //     $startDate = Carbon::parse($request->start_date);
        //     $duration = Carbon::parse($request->duration);
   
        //     if($duration->timestamp  < $startDate->timestamp )
        //     {
        //        return $this->respondInvalidValidation('The start date must be greater than the test time.');
        //     }

        //     $updatedQuizz =  $this->quizzeRepository->update($request->id,[
                        
        //         'category_id' => $request->category_id ,
        //         'title' => $request->title ,
        //         'description' => $request->description,
        //         'start_date' => $startDate->format('Y-m-d') ,
        //         'duration' => $duration,
        //         'is_active' => $request->is_active
                        
        //     ]);

        // }catch(\Exception $e){
        //     return $this->respondInternalError('Quizze Not Updated.');
        // }

    
        // return $this->respondSuccess('Quizze updated successfully.' ,[
        //     'category_id' =>  $updatedQuizz->getCategoryId() ,
        //     'title' =>   $updatedQuizz->getTitle(),
        //     'description' =>   $updatedQuizz->getDescription(),
        //     'start_date' =>   $updatedQuizz->getStartDate(),
        //     'duration' => Carbon::parse($updatedQuizz->getDuration())->timestamp  ,
        //     'is_active' => $updatedQuizz->getIsActive()

            
            
           
        // ]);
    }
   

    public function delete(Request $request)
    {
    //     $this->validate($request,[
    //         'id' => 'required|numeric' ,
    //     ]);
    //     if(!$this->quizzeRepository->find($request->id))
    //     {
    //         return $this->respondNotFound('There is no quizze with this ID.');
    //     }

    //     if(!$this->quizzeRepository->delete($request->id))
    //     {
    //         return $this->respondInternalError('There is no quizze with this ID.');
    //     }

    //     return $this->respondSuccess('quizze Deleted  successfully.',[]);
      }
}