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

    public function test_it_must_throw_a_exception_if_we_dont_send_parameters()
    {
        $response = $this->call('POST','api/v1/users',[ ]);

        $this->assertEquals(422,$response->status());

    }

    public function test_should_update_the_information_of_user()
    {
        $response = $this->call('PUT','api/v1/users',[
            'id' => '1',
            'full_name' => 'Mostafa Hekmati' ,
            'email' => 'mostafa_gbhz@yahoo.com' ,
            'mobile' => '09925961712' ,

        ]);
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message'  ,
           
            'data' => [
                'full_name'  ,
                'email'  ,
                'mobile'  ,
            ],
        ]);
    }

    public function test_it_must_throw_a_exception_if_we_dont_send_parameters_to_update_info()
    {
        $response = $this->call('PUT','api/v1/users',[ ]);

        $this->assertEquals(422,$response->status());

    }
    public function test_should_update_password()
    {
        $response = $this->call('PUT','api/v1/users/change-password',[
            'id' => '904',
            'password' => '33333333' ,
            'password_repeat' => '33333333' ,
           

        ]);
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message'  ,
           
            'data' => [
                'full_name'  ,
                'email'  ,
                'mobile'  ,
            ],
        ]);
    }

    public function test_it_must_throw_a_exception_if_we_dont_send_parameters_to_update_password()
    {
        $response = $this->call('PUT','api/v1/users/change-password',[ ]);

        $this->assertEquals(422,$response->status());

    }

    public function test_should_delete_a_user()
    {
        $response = $this->call('DELETE','api/v1/users',[
            'id' => '805',
        ]);
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message'  ,
           
            'data' => [],
        ]);
    }

    public function test_should_get_users()
    {
        $pagesize = 3 ;
        $response = $this->call('GET','api/v1/users',[
            'page' => '1',
            'pagesize' => $pagesize
        ]);

        $data = json_decode($response->getContent(),true);

        $this->assertEquals($pagesize,count($data['data']));

        $this->assertEquals(200,$response->status());

        $this->seeJsonStructure([
            'success' ,
            'message'  ,
           
            'data',
        ]);
    }



    public function test_should_get_filtered_users()
    {
        $pagesize = 3 ;
        $userEmail = 'mostafa_gbhz@yahoo.com' ;
        $response = $this->call('GET','api/v1/users',[
            'search' =>  $userEmail ,
            'page' => '1',
            'pagesize' => $pagesize
        ]);

        $data = json_decode($response->getContent(),true);

       $this->assertEquals($data['data']['email'], $userEmail);

        $this->assertEquals(200,$response->status());

        $this->seeJsonStructure([
            'success' ,
            'message'  ,
           
            'data',
        ]);
    }
}