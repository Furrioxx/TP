<?php

namespace Appy\Src\repository;

use Appy\Src\Core\BaseRepository;
use Appy\Src\model\User;

class UserRepository extends BaseRepository
{
    protected $table = "users";

    public $champs = array(
        '`id`',
        '`name`',
        '`email`',
        '`password`',
        '`created_at`',
    );

    public $champsInsert = array(
        '`name`',
        '`email`',
        '`password`',
        '`created_at`',
    );

    protected function arrayToEntity($datas)
    {
        $users = array();

        foreach ($datas as $key => $value) {

            $user = new User();
            $user->id = $value['id'];
            $user->name = $value['name'];
            $user->email = $value['email'];
            $user->password = $value['password'];
            $user->createdAt = $value['created_at'];

            if (count($datas) > 1) {
                $users[] = $user;
            } else {
                return $user;
            }
        }

        return $users;
    }
}
