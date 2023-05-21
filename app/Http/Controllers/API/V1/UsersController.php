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
    public function store(Request $request)
    {
        $this->validate($request,[
            'full_name' => 'required|string|min:3|max:255' ,
            'email' => 'required|email' ,
            'mobile' => 'required|string|digits:11' ,
            'password' => 'required' ,
        ]);
         $this->userRepository->create([
            'full_name' => $request->full_name ,
            'email' => $request->email,
            'mobile' => $request->mobile ,
            'password' => app('hash')->make($request->password)  ,
         ]);

         return $this->respondCreated('User created successfully.' ,[
            'full_name' => $request->full_name ,
            'email' => $request->email,
            'mobile' => $request->mobile ,
            'password' => $request->password ,
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

        $this->userRepository->update($request->id,[
            'email' => $request->email,
            'mobile' => $request->mobile ,
            'password' => app('hash')->make($request->password) 
        ]);

        return $this->respondSuccess('User updated successfully.' ,[
            'full_name' => $request->full_name ,
            'email' => $request->email,
            'mobile' => $request->mobile ,
           
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

        $this->userRepository->update($request->id,[
            'password' => app('hash')->make($request->password) 
        ]);
        return $this->respondSuccess('User Password updated successfully.' ,[
            'full_name' => $request->full_name ,
            'email' => $request->email,
            'mobile' => $request->mobile ,
           
        ]);
    }
}