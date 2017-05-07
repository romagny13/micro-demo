<?php

namespace App\Auth;

use App\Models\User;
use MicroPHP\Db\Condition;

class Auth
{
    public function user(){
        if($this->isLogged()) {
            $id = $_SESSION['user'];
            return User::find(Condition::op('id',$id));
        }
    }

    public function isLogged(){
        return isset($_SESSION['user']);
    }

    public function logUser($user)
    {
        $_SESSION['user'] = $user->id;
    }

    public function logout(){
        unset($_SESSION['user']);
    }

    public function check($email,$password){
        $user = User::find(Condition::op('email', $email));
        if($user){
            if(password_verify($password,$user->password)){
                $this->logUser($user);
                return true;
            }
        }
        return false;
    }

    public function authorize($role = 'admin'){
        $user = $this->user();
        return $user && $user->role === $role;
    }

    public function canAddPost(){
        $user = $this->user();
        return $user && ($user->role === 'admin' || $user->role === 'author');
    }

    public function canEditPost($post){
        $user = $this->user();
        return $user && ($user->id === $post->user_id || $user->role === 'admin');
    }

}