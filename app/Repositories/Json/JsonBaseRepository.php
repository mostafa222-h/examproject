<?php
namespace App\Repositories\Json;

use App\Models\User;
use App\Repositories\Contracts\RepositoryInterface;
use PhpParser\Node\Expr\AssignOp\Mod;

class JsonBaseRepository implements RepositoryInterface
{
    
    public function create(array $data)
    {
      if(file_exists('users.json'))
      {
        $users = json_decode(file_get_contents('users.json'),true);
        $data['id'] = rand(1,1000);
        array_push($users,$data);
        file_put_contents('users.json',json_encode($users));
      }else
      {
        $users = [];
        $data['id'] = rand(1,1000);
        array_push($users,$data);
        file_put_contents('users.json',json_encode($users));
      }
     

      
    }
    public function update(int $id , array $data)
    {
      
    }


    public function all(array $where)
    {
        
    }
    
    public function delete(array $where)
    {
    }

    public function find(int $id)
    {
       
    }
}