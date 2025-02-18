<?php

namespace Appy\Src\controller;

use Appy\Src\Core\BaseController;
use Appy\Src\Core\Session;
use Appy\Src\model\Task;
use Appy\Src\model\User;
use Appy\Src\repository\TaskRepository;

class TaskController extends BaseController
{

    private $taskRepository;
    private $session;
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->taskRepository = new TaskRepository();
        $this->session = Session::getInstance();
        $this->user = $this->session->read('user');
    }

    public function index()
    {
        $tasks = $this->taskRepository->findBy(['user_id' => $this->user->id]);

        $this->render('tasks/index.html.twig', array(
            "tasks" => $tasks
        ));
    }

    public function add()
    {

        if (isset($_POST['submit'])) {
            $task = new Task();
            $task->title = $_POST['title'];
            $task->description = $_POST['description'];
            $task->status = $_POST['status'];
            $task->userId = $this->user->id;
            $task->createdAt = date('Y-m-d H:i:s');

            $this->taskRepository->insert($task);

            $this->session::setFlash("success", "Vous avez ajouté une task avec succès");

            $this->redirectTo("tasks");
        }

        $this->render('tasks/add.html.twig', array());
    }

    public function edit($id)
    {
        if ($task = $this->taskRepository->findOneBy(["id" => $id])) {
            if (isset($_POST['submit'])) {

                $task = $this->taskRepository->findOneBy(["id" => $id]);
                $task->title = $_POST['title'];
                $task->description = $_POST['description'];
                $task->status = $_POST['status'];

                $this->taskRepository->update($task);

                $this->session::setFlash("success", "Vous avez modifier une task avec succès");

                $this->redirectTo("tasks");
            }

            $this->render('tasks/edit.html.twig', array(
                "task" => $task
            ));
        } else {
            $this->session::setFlash("danger", "Aucune task n'a été trouvé avec cet id");
            $this->redirectTo("tasks");
        }
    }

    public function delete($id)
    {
        if ($task = $this->taskRepository->findOneBy(["id" => $id])) {
            $this->taskRepository->delete($task);

            $this->redirectTo('tasks');
        } else {
            $this->session::setFlash("danger", "Aucune task n'a été trouvé avec cet id");
            $this->redirectTo("tasks");
        }
    }
}
