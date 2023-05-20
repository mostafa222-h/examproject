<?php
namespace API\V1\Users;

use Tests\TestCase;

class UsersTest extends TestCase
{
    public function test_should_create_a_new_user()
    {
        //start coding  the test from the paths section.
        $response = $this->call('POST','api/v1/users',[
            'full_name' => 'Mostafa Hekmati' ,
            'email' => 'mostafa_gbhz@yahoo.com' ,
            'mobile' => '09925961712' ,
            'password' => '12345678' ,

        ]);

        $this->assertEquals(201,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message'  ,
           
            'data' => [
                'full_name'  ,
                'email'  ,
                'mobile'  ,
                'password'  ,
            ],
        ]);
    }
}