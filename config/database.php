<?php

class Database
{
	private static ?PDO $instance = null;

	public static function getInstance(): PDO
	{
		if (self::$instance === null) {
			try {
				$host = "zkittyabangbang.mysql.db";
				$dbname = "zkittyabangbang"; 
				$username = "zkittyabangbang"; 
				$password = "Patate2TesMorts";
				$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

				self::$instance = new PDO($dsn, $username, $password, [
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Affiche les erreurs SQL
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retourne des tableaux associatifs
					PDO::ATTR_EMULATE_PREPARES => false, // Améliore la sécurité des requêtes préparées
				]);
			} catch (PDOException $e) {
				die("Erreur de connexion à la base de données : " . $e->getMessage());
			}
		}

		return self::$instance;
	}
}
