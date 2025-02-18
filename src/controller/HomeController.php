<?php

namespace Appy\Src\controller;

use Appy\Src\Core\BaseController;

class HomeController extends BaseController
{


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('home/index.html.twig', array());
    }
}
