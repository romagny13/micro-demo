<?php
namespace App\Controllers;

use App\Models\User;
use MicroPHP\Db\Condition;
use MicroPHP\Route;
use PHPValidator\Helpers\Validations;
use PHPValidator\Helpers\Validator;

class AuthController extends Controller
{
    public function getSignup($route){
        return $this->renderer->render('auth/signup.twig');
    }

    public function postSignup(Route $route){
        $username =  $route->data->username;
        $email = $route->data->email;
        $password = $route->data->password;
        $confirm_password = $route->data->confirm_password;
        
        $model = [
            'username' =>  $username,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $confirm_password
        ];

        $validators = [
            'username' => [Validations::required(), Validations::minLength()],
            'email' => [Validations::required(), Validations::email(), Validations::custom(function ($value) use($email) {
                $user = User::find(Condition::op('email',$email));
                return $user === null;
            }, 'A user with this email is already registered.')],
            'password' => [Validations::required()],
            'confirm_password' => [Validations::required(),Validations::custom(function($value) use($password){
                return $value === $password;
            },'Password and confirm password do not match.')]
        ];

        $result = Validator::validateModel($validators, $model);
        if($result->hasError){
            $this->flash->addError('Please fix the errors.');
            return $this->renderer->render('auth/signup.twig',[
                'errors' => $result->errors,
                'model' => $model
            ]);
        }
        else {
            $success = User::create([
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password,PASSWORD_DEFAULT)
            ]);
            
            $this->flash->addSuccess('You\'re now registered.');
            $route->router->go('home');
        }
    }

    public function getSignin($route){
        return $this->renderer->render('auth/signin.twig');
    }

    public function postSignin(Route $route){
        $email = $route->data->email;
        $password = $route->data->password;

        $model = [
            'email' => $email,
            'password' => $password
        ];

        $validators = [
            'email' => [Validations::required(), Validations::email()],
            'password' => [Validations::required()]
        ];

        $result = Validator::validateModel($validators, $model);
        if($result->hasError){
            $this->flash->addError('Please fix the errors.');
            $this->renderer->render('auth/signin.twig',[
                'errors' => $result->errors,
                'model' => $model
            ]);
        }
        else {
            if($this->auth->check($email,$password)){
                $this->flash->addSuccess('You\'re now logged in.');
                $route->router->go('home');
            }
            else {
                $this->flash->addError('Invalid email or password.');
                return $this->renderer->render('auth/signin.twig',[
                    'model' => $model
                ]);
            }
        }
    }

    public function getSignout($route){
        $this->auth->logout();
        return $route->router->go('home');
    }

}