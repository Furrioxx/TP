<?php

namespace Appy\Src\controller;

use Appy\Src\Core\Appy;
use Appy\Src\Core\BaseController;
use Appy\Src\Core\Session;

class RegisterController extends BaseController
{

    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = Appy::getAuth();

        if ($this->auth->user()) {
            header("Location: " . WEB_PATH);
            exit();
        }

        $this->checkPOST();

        $this->showVue();
    }

    private function checkPOST()
    {
        $session = Session::getInstance();

        if (!empty($_POST) and ! empty($_POST['username']) and ! empty($_POST['password']) and ! empty($_POST['name'])) {

            $isRegister = $this->auth->register($_POST['username'], $_POST['password'], $_POST['name']);
            if ($isRegister) {
                $session->setFlash("success", "Vous êtes inscris.");
                header("Location: " . WEB_PATH);
            } else {
                $session->setFlash("danger", "Une erreur s'est produite !");
            }
        } else {
            if (!empty($_POST)) {
                $session->setFlash("danger", "Vous n'avez pas rempli tous les champs !");
            }
        }
    }

    private function showVue()
    {
        $this->render('auth/register.html.twig', array());
    }
}
