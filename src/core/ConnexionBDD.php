<?php

namespace Appy\Src\Core;

use Exception;
use PDO;
use PDOException;

class ConnexionBDD
{

    /**
     * L'instance
     * @var object $instance
     */
    private static $instance = NULL;

    /**
     * @static getInstance() Renvoie l'instance existante ou pas
     * @return object l'instance
     */
    public static function getInstance($encodage = 'utf8')
    {

        if (is_null(self::$instance)) {
            return self::ConnexionBdd($encodage);
        } else {
            return self::$instance;
        }
    }

    /**
     * @static connexionBDD() Créé une instance
     * @return object l'instance
     */

    private static function ConnexionBdd($encodage)
    {

        try {
            self::$instance = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

            /** Le pilote MySQL utilisera les versions bufferisées de l'API MySQL. */
            self::$instance->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

            /** Active la simulation des requétes préparées. */
            self::$instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

            /** Renvoie par défaut un objet */
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            /** Force l'encodage en UTF-8 */
            self::$instance->exec("SET CHARACTER SET $encodage");

            return self::$instance;
        } catch (PDOException $e) {
            throw new Exception("Echec de connexion à la base de données !<br/>" . $e->getMessage() . "");
        }
    }

    /**
     * Execute une requête préparée ou pas
     *
     * @param $query
     * @param bool|array $params
     * @return PDOStatement
     */
    public static function query($query, $params = FALSE)
    {
        try {
            if ($params) {
                $req = Connexionbdd::getInstance()->prepare($query);
                $req->execute($params);
            } else {
                $req = Connexionbdd::getInstance()->query($query);
            }
            return $req;
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la fonction " . __METHOD__ . " de la classe " . __CLASS__ . " !<br/>" . $e->getMessage() . "");
        }
    }

    public static function lastInsertId()
    {
        try {
            return Connexionbdd::getInstance()->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la fonction " . __METHOD__ . " de la classe " . __CLASS__ . " !<br/>" . $e->getMessage() . "");
        }
    }

    public static function count($query)
    {
        try {
            $res = Connexionbdd::getInstance()->query($query);
            return intval($res->fetchColumn());
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la fonction " . __METHOD__ . " de la classe " . __CLASS__ . " !<br/>" . $e->getMessage() . "");
        }
    }

    /**
     * Ferme la connexion à la BDD
     */
    public static function ferme()
    {
        if (!is_null(self::$instance)) {
            self::$instance = null;
        }
    }
}
