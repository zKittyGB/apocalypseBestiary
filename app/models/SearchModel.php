<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/app/controllers/MonsterController.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/app/controllers/AreaController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/app/controllers/HabitatController.php';

class SearchModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public function getMatches($searchValue): object
	{
		// Retrait des esapces superflux
		$searchValue = "%".trim($searchValue)."%";
		
		$stmt = $this->db->prepare("
			SELECT 
				monsterID AS ID,
				monsterName AS name,
				monsterPicture AS picture,
				'monster' AS type 
			FROM 
				bestiaryMonsters 
			WHERE 
				monsterName LIKE ? 
		
			UNION
		
			SELECT 
				areaID AS ID,
				areaName AS name,
				areaPicture AS picture,
				'area' AS type 
			FROM 
				bestiaryAreas 
			WHERE 
				areaName LIKE ? 
		
			UNION
		
			SELECT 
				habitatID AS ID,
				habitatName AS name,
				habitatPicture AS picture,
				'habitat' AS type
			FROM 
				bestiaryHabitats 
			WHERE 
				habitatName LIKE ? 
		
			ORDER BY name ASC
			LIMIT 20
		");
	
	   	 // Passer la même valeur pour chaque `?`
		$stmt->execute([$searchValue, $searchValue, $searchValue]);
		
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		$filteredResults = (object)[
			"bestiary" => [],
			"skills" => [],
			"areas" => [],
			"habitats" => []
		];
		
		if(!empty($results)) {
			// Boucle sur les résultats pour récupérer les objets complets
			foreach ($results as $key => $result) {
				$results[$key]->ID = Controller::encryptString($result->ID);
				switch ($result->type) {
					case "monster":
						$filteredResults->bestiary[] = $result;
						break;
					case "area":
						$filteredResults->areas[] = $result;
						break;
					case "habitat":
						$filteredResults->habitats[] = $result;
						break;
				}
			}
		}

		return $filteredResults;
	}
}