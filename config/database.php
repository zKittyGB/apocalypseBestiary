<?php

class Database
{
	private static ?PDO $instance = null;

	public static function getInstance(): PDO
	{
		if (self::$instance === null) {
			self::$instance = self::createConnection();
		}

		return self::$instance;
	}

	private static function createConnection(): PDO
	{
		self::loadEnvFile();

		$host = self::env('DB_HOST');
		$dbName = self::env('DB_NAME');
		$user = self::env('DB_USER');
		$password = self::env('DB_PASSWORD');
		$charset = self::env('DB_CHARSET', 'utf8mb4');

		if ($host && $dbName && $user !== null && $password !== null) {
			$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $host, $dbName, $charset);
			return new PDO($dsn, $user, $password, self::pdoOptions());
		}

		$configFile = self::env('DB_CONFIG_FILE', '/include/db.php');
		if (is_readable($configFile)) {
			require $configFile;

			if (isset($pdo) && $pdo instanceof PDO) {
				self::hardenConnection($pdo);
				return $pdo;
			}
		}

		error_log('Configuration de base de données manquante ou invalide.');
		throw new RuntimeException('Configuration de base de données indisponible.');
	}

	private static function loadEnvFile(): void
	{
		$envFile = dirname(__DIR__) . '/.env';
		if (!is_readable($envFile)) {
			return;
		}

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

	private static function env(string $key, ?string $default = null): ?string
	{
		$value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

		return ($value === false || $value === '') ? $default : $value;
	}

	private static function pdoOptions(): array
	{
		return [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			PDO::ATTR_EMULATE_PREPARES => false,
		];
	}

	private static function hardenConnection(PDO $pdo): void
	{
		foreach (self::pdoOptions() as $attribute => $value) {
			$pdo->setAttribute($attribute, $value);
		}
	}
}
