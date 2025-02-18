<?php

namespace Appy\Src\Core;

class BaseController
{

    protected $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader(BASE_PATH . 'src/template');
        $this->twig = new \Twig\Environment($this->loader);
        $assetFunction = new \Twig\TwigFunction('asset', function ($path) {
            echo WEB_PATH . "assets/" . $path;
        });
        $webpathFucntion = new \Twig\TwigFunction('path', function ($path) {
            echo WEB_PATH . $path;
        });
        $this->twig->addFunction($assetFunction);
        $this->twig->addFunction($webpathFucntion);
    }

    public function render(string $tempalteName, array $params = null)
    {
        $params["logo"] = WEB_PATH . "/assets/img/logo.png";
        $params["flash"] = Session::getInstance()::getFlashes();
        $params["user"] = Appy::getAuth()->user();
        echo $this->twig->render($tempalteName, $params);
    }

    public function redirectTo($path)
    {
        header("Location: " . WEB_PATH . $path);
        exit();
    }
}
