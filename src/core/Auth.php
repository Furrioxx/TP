<?php

namespace Appy\Src\Core;

use Appy\Src\repository\UserRepository;
use DateTime;

class Auth
{

    private $session;
    private $options;
    private $userRepository;

    public function __construct($session, array $options)
    {
        $this->options = $options;
        $this->session = $session;
        $this->userRepository = new UserRepository;
    }

    public function restrict()
    {
        if (!$this->user()) {
            $this->session->write('asked_page', $_SERVER["REQUEST_URI"]);
            //$this->session->setFlash('danger', $this->options['restriction_msg']);
            header("Location: " . $this->options['redirected_url']);
            exit();
        }
    }

    public function user()
    {
        if (!$this->session->read('user')) {
            return false;
        }

        $user = $this->session->read('user');

        return $user;
    }

    public function login($username, $password, $remember = false)
    {
        $user = ConnexionBDD::query('SELECT * FROM users WHERE email = :username ', ['username' => $username])->fetch();
        if ($user and password_verify($password, $user->password)) {

            $this->connect($user);

            if ($remember) {
                $this->remember($user);
            }

            return $user;
        } else {
            return false;
        }
    }

    public function register($username, $password, $name)
    {
        $userInDb = $this->userRepository->findOneBy(["email" => $username]);
        if (!$userInDb) {
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
            ConnexionBDD::query('INSERT INTO users VALUES (null, :name, :email, :password, NOW(), null);', ['name' => $name, "email" => $username, "password" => $passwordHashed]);
            return true;
        }
        return false;
    }


    public function connect($user)
    {
        $this->session->write('user', $user);
    }


    public function connectFromCookie()
    {
        if (isset($_COOKIE['remember']) and !$this->user()) {
            $cookie  = $_COOKIE['remember'];
            $parts   = explode("==", $cookie);
            $user_id = $parts[0];
            $user    = ConnexionBDD::query("SELECT * FROM users WHERE id = ?", [$user_id])->fetch();
            if ($user) {
                $expected = $user->id . "==" . $user->remember_token . sha1($user->username . "toolstacker");
                if ($expected == $cookie) {
                    $this->connect($user);
                }
            } else {
                setcookie("remember", NULL, time() - 10, "/");
            }
        }
    }

    private function remember($user)
    {
        $remember_token = \Appy\Src\Core\Str::random(250);
        ConnexionBDD::query('UPDATE users SET remember_token = ? WHERE id = ?', [$remember_token, $user->id]);
        // COOKIE
        $expire         = mktime(0, 0, 0, date("m"), date("d") + 30, date('Y')); // Le cookie expire après 30 jours
        setcookie("remember", $user->id . "==" . $remember_token . sha1($user->name . "tp"), $expire, '/');
    }


    public function logout()
    {
        setcookie('remember', "", -1, "/");
        $this->session->delete('user');
    }
}
