<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Dans le fichier public/index.php
include_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Router.php';

// Démarrer le routeur
$router = new Router();
$router->run();
?>
