<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Contracts\ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class CategorisController extends ApiController
{
    private $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository ;
    }
    
        
    
   
    public function index(Request $request)
    {
        $this->validate($request,[
            'search' => 'nullable|string' ,
            'page' => 'required|numeric' ,
            'pagesize' => 'nullable|numeric'
        ]);

        $categories = $this->categoryRepository->paginate($request->search,$request->page,$request->pagesize ?? 20, ['name','slug']);
        return $this->respondSuccess('ALL  Category',$categories);
    }
    public function store(Request $request)
    {
        
         $this->validate($request,[
             'name' => 'required|string|min:3|max:255' ,
             'slug' => 'required|string|min:3|max:255' ,
           
                                    ]);

         $created_category = $this->categoryRepository->create([
            'name' => $request->name ,
            'slug' => $request->slug ,
         ]);
       
         return $this->respondCreated('Category created successfully.' ,[
            'name' =>  $created_category->getName() ,
            'slug' =>   $created_category->getSlug(),
          
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
            'name' => 'required|string|min:3|max:255' ,
            'slug' => 'required|string|min:3|max:255' , 
        ]);
        try{

                $category =  $this->categoryRepository->update($request->id,[
                            'name' => $request->name,
                            'slug' => $request->slug ,
                        
                        ]);

        }catch(\Exception $e){
            return $this->respondInternalError('Category Not Updated.');
        }

    
        return $this->respondSuccess('User updated successfully.' ,[
            'name' =>  $category->getName() ,
            'slug' => $category->getSlug(),
            
           
        ]);
    }
   

    public function delete(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|numeric' ,
        ]);
        if(!$this->categoryRepository->find($request->id))
        {
            return $this->respondNotFound('There is no category with this ID.');
        }

        if(!$this->categoryRepository->delete($request->id))
        {
            return $this->respondInternalError('There is no category with this ID.');
        }

        return $this->respondSuccess('Category Deleted  successfully.',[]);
    }
}