<?php

namespace App\Models;

use MicroPHP\Db\Model;

class Post extends Model
{
    public function __construct()
    {
        $this->table = 'posts';
        $this->addRelation('users',['user_id'=>'id'],User::class,'user');
    }
}