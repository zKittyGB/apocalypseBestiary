<?php
$envFile = dirname(__DIR__) . '/.env';
if (is_readable($envFile)) {
	foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
		$line = trim($line);
		if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
			continue;
		}

		[$key, $value] = array_map('trim', explode('=', $line, 2));
		$value = trim($value, "\"'");
		$_ENV[$key] = $_ENV[$key] ?? $value;
		$_SERVER[$key] = $_SERVER[$key] ?? $value;
	}
}

$environment = getenv('APP_ENV') ?: ($_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'production');
$debug = in_array(strtolower($environment), ['local', 'development', 'dev'], true);

ini_set('display_errors', $debug ? '1' : '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

// Dans le fichier public/index.php
include_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Router.php';

// Démarrer le routeur
$router = new Router();
$router->run();
?>
