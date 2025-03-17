<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class SlideshowModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public function getSlides(): array {
		$stmt = $this->db->query("
			SELECT 
				m.monsterName, 
				m.monsterPicture, 
				m.monsterID,
				d.dangerValue
			FROM 
				bestiarySlides bs
				JOIN bestiaryMonsters m ON bs.slideMonsterID = m.monsterID
				JOIN bestiaryDangers d ON m.monsterDangerID = d.dangerID");
				
		$slides = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($slides as $key => $slide) {
			$slides[$key]->monsterID = Controller::encryptString($slide->monsterID);
		}

		return $slides;
	}

	public function insertSlide(string $monsterID): bool 
	{
		$monsterID = (int)Controller::decryptString($monsterID);

		// Ajoute le nouveau slide ayant le monsterID
		$insertStmt = $this->db->prepare("
			INSERT INTO bestiarySlides (slideMonsterID) 
			VALUES (:monsterID)
		");

		return $insertStmt->execute([
			"monsterID" => $monsterID,
		]);
	}

	public function deleteSlide(string $monsterID): bool 
	{
		$monsterID = (int)Controller::decryptString($monsterID);
		
		// Supprimer la slide ayant le monsterID
		$deleteStmt = $this->db->prepare("DELETE FROM bestiarySlides WHERE slideMonsterID = :monsterID");
		$result = $deleteStmt->execute(["monsterID" => $monsterID]);
		
		return $result;
	}
}
