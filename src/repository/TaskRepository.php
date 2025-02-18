<?php

namespace Appy\Src\repository;

use Appy\Src\Core\BaseRepository;
use Appy\Src\model\Task;

class TaskRepository extends BaseRepository
{
    protected $table = "tasks";

    public $champs = array(
        '`id`',
        '`title`',
        '`description`',
        '`status`',
        '`user_id`',
        '`created_at`',
    );

    public $champsInsert = array(
        '`title`',
        '`description`',
        '`status`',
        '`user_id`',
        '`created_at`',
    );

    protected function arrayToEntity($datas)
    {
        $tasks = array();

        foreach ($datas as $key => $value) {

            $task = new Task();
            $task->id = $value['id'];
            $task->title = $value['title'];
            $task->description = $value['description'];
            $task->status = $value['status'];
            $task->userId = $value['user_id'];
            $task->createdAt = $value['created_at'];

            if (count($datas) > 1) {
                $tasks[] = $task;
            } else {
                return $task;
            }
        }

        return $tasks;
    }
}
