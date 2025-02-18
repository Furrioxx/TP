<?php

namespace Appy\Src\controller;

use Appy\Src\Core\Appy;
use Appy\Src\Core\BaseController;
use Appy\Src\Core\Session;

class LoginController extends BaseController
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

        if (!empty($_POST) and ! empty($_POST['username']) and ! empty($_POST['password'])) {

            $user = $this->auth->login($_POST['username'], $_POST['password'], isset($_POST['remember']));
            if ($user) {
                $session->setFlash("success", "Vous êtes connecté.");
                header("Location: " . WEB_PATH);
            } else {
                $session->setFlash("danger", "Les identifiants sont incorrects !");
            }
        } else {
            if (!empty($_POST)) {
                $session->setFlash("danger", "Vous n'avez pas rempli tous les champs !");
            }
        }
    }

    private function showVue()
    {

        $this->render('auth/login.html.twig', array());
    }
}
