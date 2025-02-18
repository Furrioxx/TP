<?php

//classe de lancement de l'application

namespace Appy\Src\Core;

class Appy
{

    private static $session;

    public static function run()
    {
        self::$session = Session::getInstance();

        //self::getAuth()->connectFromCookie();

        self::runRouter();
    }

    private static function runRouter()
    {
        if (!empty($_GET['route'])) {
            $url = explode("/", $_GET['route']);
            $router = new Router($url);
            $router->dispatch();
        }
    }

    // public static function getAuth()
    // {
    //     return new Auth(
    //         self::$session,
    //         array(
    //             'restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page !",
    //             'redirected_url'  => WEB_PATH . "login"
    //         )
    //     );
    // }
}
