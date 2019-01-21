<?php

namespace App\Sdc\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImpl implements UserRepositoryInterface
{
    public function __construct(){
        $this->user = new User();
    }

    public function retrieveAll(){
        return $this->user->all();
    }

    public function retrieveById(int $id){
        return $this->user->find($id);
    }

    public function save(array $data){
        $this->user->name = $data['name'];
        $this->user->email = $data['email'];
        $this->user->password = Hash::make($data['password']);
        $this->user->save();
    }

    public function update(array $data, int $id)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
}
