<?php
class Router
{
	protected $routes = [];

	public function __construct()
	{
		$this->routes = require_once "../config/routes.php";
	}

	public function run()
{
    $url = isset($_GET["url"]) ? rtrim($_GET["url"], "/") : "home";
//     var_dump($url); // Ajoute ceci pour voir quelle URL est réellement analysée

    if (array_key_exists($url, $this->routes)) {
        $controllerName = $this->routes[$url]["controller"];
        $method = $this->routes[$url]["method"];

        $controllerFile = "../app/controllers/" . $controllerName . ".php";

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                echo "Méthode introuvable.";
            }
        } else {
            echo "Contrôleur introuvable.";
        }
    } else {
        echo "404 - Page non trouvée.";
    }
}

	
}
