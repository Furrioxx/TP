<?php

namespace Appy\Src\controller;

use Appy\Src\Core\BaseController;
use Appy\Src\Core\Session;
use Appy\Src\model\User;
use Appy\Src\repository\UserRepository;

class UserController extends BaseController
{

    private $userRepository;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->session = Session::getInstance();
    }

    public function index()
    {
        $users = $this->userRepository->findAll();


        $this->render('users/index.html.twig', array(
            "users" => $users
        ));
    }

    public function add()
    {
        if (isset($_POST['submit'])) {
            $user = new User();
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];

            $this->userRepository->insert($user);

            $this->session::setFlash("success", "Vous avez ajouté un user avec succès");

            $this->redirectTo("users");
        }

        $this->render('users/add.html.twig', array());
    }
}
