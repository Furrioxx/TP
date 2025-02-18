<?php

require __DIR__ . '/../vendor/autoload.php';

define('WEB_PATH', str_replace("public/index.php", '', $_SERVER['SCRIPT_NAME']));
define('BASE_PATH', substr_replace(dirname(__FILE__), "", -6)); // On retire le "public" du chemin

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$env = $_ENV['APP_ENV'];

// Charger le bon fichier .env
$dotenvFile = match ($env) {
    "development" => '.env.development',
    "production" => '.env.production',
    "recette" => ".env.recette"
};

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, $dotenvFile);
$dotenv->load();

\Appy\Src\Core\Appy::run();

exit();
