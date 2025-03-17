<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/config/database.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/core/Controller.php";

class AreaModel extends Controller
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	static function getAreas(): array
	{
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				areaID,
				areaName,
				areaPicture
			FROM 
				bestiaryAreas
		");


		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($results as $key => $area) {
			$results[$key]->areaID = Controller::encryptString($area->areaID);
		}

		return $results;
	}

	public function getAreaByID($areaID): object
	{
		$areaID = Controller::decryptString($areaID);
		$stmt = $this->db->query("
			SELECT 
				areaID,
				areaName,
				areaPicture
			FROM 
				bestiaryAreas
			WHERE
				areaID = '" . (int)$areaID . "'
		");


		// Récupérer les résultats sous forme d'objets
		$area = $stmt->fetch(PDO::FETCH_OBJ);

		$area->areaID = Controller::encryptString($area->areaID);

		return $area;
	}
}
