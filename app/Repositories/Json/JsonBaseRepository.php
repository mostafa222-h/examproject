<?php
namespace App\Repositories\Json;

use App\Entities\User\UserEntity;
use App\Entities\User\UserJsonEntity;
use App\Models\User;
use App\Repositories\Contracts\RepositoryInterface;
use PhpParser\Node\Expr\AssignOp\Mod;

class JsonBaseRepository implements RepositoryInterface
{
    
    public function create(array $data)
    {
      if(file_exists(base_path() . '/users.json'))
      {
        $users = json_decode(file_get_contents(base_path() . '/users.json'),true);
        $data['id'] = rand(1,1000);
        array_push($users,$data);
        file_put_contents(base_path() . '/users.json',json_encode($users));
      }else
      {
        $users = [];
        $data['id'] = rand(1,1000);
        array_push($users,$data);
        file_put_contents(base_path() . '/users.json',json_encode($users));
      }
     

      return $data ;
    }
    public function update(int $id , array $data)
    {
  
      $users = json_decode(file_get_contents(base_path() . '/users.json'),true);
      foreach($users as $key => $user)
      {
        if($user['id'] == $id)
        {
          $user['full_name'] = $data['full_name'] ?? $user['full_name'];
          $user['mobile'] = $data['mobile'] ?? $user['mobile'];
          $user['email'] = $data['email'] ?? $user['email'] ;
          $user['password'] = $data['password'] ?? $user['password'] ;

          
          unset($users[$key]);
          array_push($users,$user);
          if(file_exists(base_path() . '/users.json'))
          {
            unlink(base_path() . '/users.json');
          }
         
          file_put_contents(base_path() . '/users.json',json_encode($users));
          break;
        }
      }
    }


    public function all(array $where)
    {
        
    }
    public function deleteBy(array $where)
    {
      $users = json_decode(file_get_contents(base_path() . '/users.json'),true);
      foreach($users as $key => $user)
      {
        if($user['id'] == $where['id'])
        {
          unset($users[$key]);
        }
      }
    }
    
      
    
    public function delete(int $id)
    {
      $users = json_decode(file_get_contents(base_path() . '/users.json'),true);
      foreach($users as $key => $user)
      {
        if($user['id'] == $id)
        {
          unset($users[$key]);
          if(file_exists(base_path() . '/users.json'))
          {
            unlink(base_path() . '/users.json');
          }
         
          file_put_contents(base_path() . '/users.json',json_encode($users));
          break;

        }
      }

    }

    public function find(int $id)
    {
      $users = json_decode(file_get_contents(base_path() . '/users.json'),true);
      foreach ($users as $user) {
        if($user['id'] == $id)
        {
          return $user ;
        }
      }

      return [];
     
    }

    public function paginate(string $search = null , int $page , int $pagesize = 20  )
    {
      $users = json_decode(file_get_contents(base_path() . '/users.json'),true);
      if(!is_null($search))
      {
        foreach($users as $key => $user)
        {
          if(array_search($search,$user))
          {
            return $users[$key];
          }

          
        }
      }
      $totalRecords = count($users);
      $totalPages =  ceil($totalRecords / $pagesize) ;
      if($page > $totalPages)
      {
        $page = $totalRecords ;
      }
      if($page < 1)
      {
        $page = 1 ;
      }

      $offset = ($page - 1) * $pagesize ;

      return array_slice($users,$offset,$pagesize);

    }
}