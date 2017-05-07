<?php

namespace App\Models;
use MicroPHP\Db\Condition;
use MicroPHP\Db\Db;
use MicroPHP\Db\Model;

class User extends Model
{
    public function __construct()
    {
        $this->table = 'users';

        // $this->addRelation('users',['user_id'=>'id'],User::class,'user');

       // $this->addRelation_0_n('posts', ['user_id' => 'id'],Post::class, 'posts');
    }

    public function addRelation_0_n($table, $primaryAndForeignKeyPairs, $model, $propertyName){
        // o-1 1-1 -> fetch
        // 0-n 1-n -> fetchAll

        if(isset($this->{'id'})) {
//            $posts = self::prepare('select * from posts where user_id =:id')
//                ->setParam(':id', $this->{'id'})
//                ->fetchAllWithClass(Post::class);
            // columns to select of target table
            // target table
            // where condtion fk(s) target table === pk source table(this)
            // fetch or fetchall

          $posts =  Db::getInstance()
                ->select()
                ->from('posts')
                ->where(Condition::op('user_id',$this->{'id'}))
                ->fetchAll(Post::class);

            var_dump($posts);
        }

    }

    public function fillPosts(){
        $posts =  Db::getInstance()
            ->select()
            ->from('posts')
            ->where(Condition::op('user_id',$this->{'id'}))
            ->fetchAll(Post::class);

        var_dump($posts);
    }
}