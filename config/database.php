<?php

class Database
{
	private static ?PDO $instance = null;

	public static function getInstance(): PDO
	{
		if (self::$instance === null) {
			require __DIR__ . '/../../../../include/db.php';
			self::$instance = $pdo;
		}

		return self::$instance;
	}
}
