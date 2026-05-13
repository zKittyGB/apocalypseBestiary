<?php
class Router
{
	protected $routes = [];

	public function __construct()
	{
		$this->routes = require_once "../config/routes.php";
		$this->startSession();
	}

	public function run()
	{
		$url = isset($_GET["url"]) ? rtrim($_GET["url"], "/") : "home";

		if (array_key_exists($url, $this->routes)) {
			if ($this->isAdminRoute($url) && !$this->isAdminSession()) {
				$this->denyAdminRoute();
				return;
			}

			$controllerName = $this->routes[$url]["controller"];
			$method = $this->routes[$url]["method"];

			$controllerFile = "../app/controllers/" . $controllerName . ".php";

			if (file_exists($controllerFile)) {
				require_once $controllerFile;
				$controller = new $controllerName();
				if (method_exists($controller, $method)) {
					$controller->$method();
				} else {
					http_response_code(404);
					echo "Méthode introuvable.";
				}
			} else {
				http_response_code(404);
				echo "Contrôleur introuvable.";
			}
		} else {
			http_response_code(404);
			echo "404 - Page non trouvée.";
		}
	}


	private function denyAdminRoute(): void
	{
		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
			header('Location: /bestiary/public/?url=home');
			return;
		}

		http_response_code(403);
		header('Content-Type: application/json');
		echo json_encode(['error' => 'Accès refusé']);
	}

	private function isAdminRoute(string $url): bool
	{
		return str_contains($url, 'Manager');
	}

	private function isAdminSession(): bool
	{
		return !empty($_SESSION['userIsAdmin']) && isset($_SESSION['loggedAs']) && $_SESSION['loggedAs'] === 'admin';
	}

	private function startSession(): void
	{
		if (session_status() === PHP_SESSION_NONE) {
			$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? null) == 443);
			ini_set('session.use_strict_mode', '1');
			session_set_cookie_params([
				'lifetime' => 0,
				'path' => '/',
				'secure' => $isHttps,
				'httponly' => true,
				'samesite' => 'Lax',
			]);
			session_start();
		}
	}
}
