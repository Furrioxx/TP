<?php

namespace Appy\Src\controller;

use Appy\Src\Core\BaseController;

class ErrorController extends BaseController{


    public function __construct() {
        parent::__construct();
    }

    public function notFound(){

        $this->render('error/404.html.twig', array(
        ));
    }

}