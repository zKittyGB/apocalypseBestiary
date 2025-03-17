<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/config/database.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/core/Controller.php";

class DangerModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	static function getDangers(): array
	{
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				dangerID,
				dangerValue
			FROM 
				bestiaryDangers
		");

		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($results as $key => $danger) {
			$results[$key]->dangerID = Controller::encryptString($danger->dangerID);
		}
		
		return $results;
	}
}
