<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Contracts\ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends ApiController
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
        
    }
    public function index(Request $request)
    {
        $this->validate($request,[
            'search' => 'nullable|string' ,
            'page' => 'required|numeric' ,
            'pagesize' => 'nullable|numeric'
        ]);

        $users = $this->userRepository->paginate($request->search,$request->page,$request->pagesize ?? 20);
        return $this->respondSuccess('ALL USERS',$users);
    }
    public function store(Request $request)
    {
         $this->validate($request,[
             'full_name' => 'required|string|min:3|max:255' ,
             'email' => 'required|email' ,
             'mobile' => 'required|string|digits:11' ,
             'password' => 'required' ,
                                    ]);
         $newUser =  $this->userRepository->create([
                    'full_name' => $request->full_name ,
                    'email' => $request->email,
                    'mobile' => $request->mobile ,
                    'password' => app('hash')->make($request->password)  ,
                ]);

         return $this->respondCreated('User created successfully.' ,[
            'full_name' => $newUser->getFullName() ,
            'email' =>  $newUser->getEmail(),
            'mobile' => $newUser->getMobile() ,
            'password' => $newUser->getPassword() ,
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

    public function updateInfo(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|string' ,
            'full_name' => 'required|string|min:3|max:255' ,
            'email' => 'required|email' ,
            'mobile' => 'required|string|digits:11' ,
            
        ]);

      $user =  $this->userRepository->update($request->id,[
            'email' => $request->email,
            'mobile' => $request->mobile ,
            'password' => app('hash')->make($request->password) 
        ]);

        return $this->respondSuccess('User updated successfully.' ,[
            'full_name' => $user->getFullName() ,
            'email' => $user->getEmail(),
            'mobile' => $user->getMobile() ,
           
        ]);
    }
    public function updatePassword(Request $request)
    {
        //dd("aa");
        $this->validate($request,[
            'id' => 'required' ,
            'password' => 'min:6|required_with:password_repeat|same:password_repeat' ,
            'password_repeat' => 'min:6' ,
        ]);

        try{
               $user = $this->userRepository->update($request->id,[
                   'password' => app('hash')->make($request->password) 
               ]);
        }catch(\Exception $e)
        {
            return $this->respondInternalError('The user could not be updated.');
        }

       
        return $this->respondSuccess('User Password updated successfully.' ,[
            'full_name' =>  $user->getFullName() ,
            'email' => $user->getEmail(),
            'mobile' => $user->getMobile() ,
           
        ]);
    }

    public function delete(Request $request)
    {
        $this->validate($request,[
            'id' => 'required' ,
        ]);

        if($this->userRepository->find($request->id))
        {
            return $this->respondNotFound('There is no user with this ID.');
        }

        if(! $this->userRepository->delete($request->id))
        {
            return $this->respondInternalError('There is an error, please try again.');
        }

       

        return $this->respondSuccess('User Deleted  successfully.',[]);


    }
}