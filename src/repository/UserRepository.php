<?php

namespace Appy\Src\repository;

use Appy\Src\Core\BaseRepository;
use Appy\Src\model\User;

class UserRepository extends BaseRepository{
    protected $table = "users";

    public $champs = array(
        '`id`',
        '`name`',
        '`email`',
    );

    public $champsInsert = array(
        '`name`',
        '`email`'
    );

    protected function arrayToEntity($datas)
    {
        $users = array();

        foreach ($datas as $key => $value)
        {

            $user = new User();
            $user->id = $value['id'];
            $user->name = $value['name'];
            $user->email = $value['email'];

            if(count($datas) > 1){
                $users[] = $user;
            }else{
                return $user;
            }
            
        }

        return $users;
    }
}