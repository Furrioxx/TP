<?php

namespace Appy\Src\Core;

class Session
{
    static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function __construct()
    {
        session_name(sha1($_ENV['APPLI_NOM']));
        session_start();
    }

    public static function setFlash($key, $message)
    {
        $_SESSION['flash'][$key] = $message;
    }

    public static function hasFlashes()
    {
        return isset($_SESSION['flash']);
    }

    public static function getFlashes()
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }

        return NULL;
    }

    public static function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function read($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }
}
