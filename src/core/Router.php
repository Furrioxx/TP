<?php

namespace Appy\Src\Core;

use Appy\Src\controller\ErrorController;
use Appy\Src\controller\UserController;
use Exception;

class Router{

    private $url;

    public function __construct(array $url) {
        $this->url = $url;
    }

    public function dispatch(){
        try {
            switch ($this->url[0]) {
                case "api":
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
            switch ($this->url[0]) {
                case "users":
                    $controller = new UserController;
                    if(!empty($this->url[1])){
                        switch($this->url[1]){
                            case "add":
                                $controller->add();
                                break;
                        }
                    }
                    else{
                        $controller->index();
                    }
                    
                    break;
                default :
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
}