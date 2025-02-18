<?php

namespace Appy\Src\Core;

use Appy\Src\controller\ErrorController;
use Appy\Src\controller\HomeController;
use Appy\Src\controller\UserController;
use Appy\Src\controller\LoginController;
use Appy\Src\controller\RegisterController;
use Exception;

class Router
{

    private $url;

    public function __construct(array $url)
    {
        $this->url = $url;
    }

    public function dispatch()
    {
        try {
            switch ($this->url[0]) {
                case "api":
                    break;
                case "login":
                    $this->AuthDispatcher();
                    break;
                case "register":
                    $this->AuthDispatcher();
                    break;
                case "logout":
                    $this->AuthDispatcher();
                    break;
                default:
                    $this->WebDispatcher();
                    break;
            }
        } catch (Exception $e) {
            $erreur = [
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];
            print_r($erreur);
        }
    }


    private function WebDispatcher()
    {
        try {
            Appy::getAuth()->restrict();
            switch ($this->url[0]) {
                case "home":
                    $controller = new HomeController;
                    $controller->index();
                    break;
                case "users":
                    $controller = new UserController;
                    if (!empty($this->url[1])) {
                        switch ($this->url[1]) {
                            case "add":
                                $controller->add();
                                break;
                        }
                    } else {
                        $controller->index();
                    }

                    break;
                default:
                    $controller = new ErrorController;
                    $controller->notFound();
                    break;
            }
        } catch (Exception $e) {
            $erreur = [
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];
            print_r($erreur);
        }
    }

    private function AuthDispatcher()
    {
        try {
            switch ($this->url[0]) {
                case "login":
                    $controller = new LoginController();
                    break;
                case "register":
                    $controller = new RegisterController();
                    break;
                case "logout":
                    Appy::getAuth()->logout();
                    header("Location: " . WEB_PATH);
                    break;
            }
        } catch (Exception $e) {
            $erreur = [
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];
            print_r($erreur);
        }
    }
}
