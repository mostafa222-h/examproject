<?php
namespace API\V1\Users;

use App\Repositories\Contracts\UserRepositoryInterface;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersTest extends TestCase
{
    //use DatabaseMigrations;
    public function setUp():void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
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
        $user = $this->createUsers()[0];
        $response = $this->call('PUT','api/v1/users',[
            'id' => (string)$user->getId(),
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
        $user = $this->createUsers()[0];
        $response = $this->call('PUT','api/v1/users/change-password',[
            'id' => (string) $user->getId,
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
        $user = $this->createUsers()[0];
        $response = $this->call('DELETE','api/v1/users',[
            'id' =>  (string)$user->getId(),
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
        $this->createUsers(30);
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
        foreach($data['data'] as $user)
        {
            $this->assertEquals($user['email'], $userEmail);
        }
       

        $this->assertEquals(200,$response->status());

        $this->seeJsonStructure([
            'success' ,
            'message'  ,
           
            'data',
        ]);
    }

    private function createUsers(int $count = 1): array
    {
        $userRepository = $this->app->make(UserRepositoryInterface::class);
        $userData = [
            'full_name' => 'examtest',
            'email' => 'examtest@gmail.com' ,
            'mobile' => '09391112222' ,
        ];
        $users = [];
        foreach(range(0,$count) as $item)
        { 
            $users[] = $userRepository->create($userData);
        }

        return $users;
        
    }
}