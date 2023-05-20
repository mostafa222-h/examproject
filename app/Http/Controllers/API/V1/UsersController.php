<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function store()
    {
        return response()->json(
            [
            'success' => true ,
            'message' => 'User created successfully' ,
           
            'data' => [
                'full_name' => 'Mostafa Hekmati' ,
                'email' => 'mostafa_gbhz@yahoo.com' ,
                'mobile' => '09925961712' ,
                'password' => '12345678' ,
            ],
        ]
    )->setStatusCode(201);
    }
}