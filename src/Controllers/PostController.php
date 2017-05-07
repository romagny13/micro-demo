<?php
namespace App\Controllers;

use App\Models\Post;
use MicroPHP\Db\Condition;
use MicroPHP\Route;
use PHPValidator\Helpers\Validations;
use PHPValidator\Helpers\Validator;


class PostController extends Controller
{
    public function index($route){

        // load data
        $posts = Post::all();
        // show view
        return $this->renderer->render('posts/index.twig',[
            'posts' => $posts,
            'active' => 'posts'
        ]);
    }

    public function getCreate($route){
        return $this->renderer->render('posts/create.twig');
    }

    public function postCreate(Route $route){
        $title = $route->data->title;
        $content = $route->data->content;

        $model = [
            'title' => $title,
            'content' => $content
        ];

        $validators = [
            'title' => [Validations::required()],
            'content' => [Validations::required()]
        ];

        $result = Validator::validateModel($validators, $model);
        if($result->hasError){
            $this->flash->addMessage('error', 'Please fix the errors.');
            return $this->renderer->render('posts/create.twig',[
                'errors' => $result->errors,
                'model' => $model
            ]);
        }
        else {
            Post::create([
                'title' => $title,
                'content' => $content,
                'user_id' => $this->auth->user()->id
            ]);
            $this->flash->addMessage('success', 'Post added successfully.');
            $route->router->go('posts.index');
        }
    }

    public function deletePost(Route $route){
        $id = $route->data->id;
        $success = Post::delete(Condition::op('id',$id));
        if($success) {
            $this->flash->addMessage('success', 'Post deleted successfully.');
            $route->router->go('posts.index');
        }
    }
}