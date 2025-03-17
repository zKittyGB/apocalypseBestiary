<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class SkillModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public static function getSkillsByTypes(): array
	{
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				skillID,
				skillName,
				typeName,
				typeID
			FROM 
				bestiarySkills
			JOIN bestiaryTypes ON typeID = skillTypeID
		");

		$skills = $stmt->fetchAll(PDO::FETCH_OBJ);

		$organizedSkills = [];

		foreach ($skills as $skill) {
			if (!isset($organizedSkills[$skill->typeName])) {
				$organizedSkills[$skill->typeName] = (object)[
					'typeID' => Controller::encryptString($skill->typeID),
					'skills' => []
				];
			}

			$organizedSkills[$skill->typeName]->skills[] = (object)[
				'skillID' => Controller::encryptString($skill->skillID),
				'skillName' => $skill->skillName
			];
		}

		return $organizedSkills;
	}

	public function getTypeSkills($typeID): array
	{
		$typeID = Controller::decryptString($typeID);
		
		$stmt = $this->db->query("
			SELECT 
				skillID,
				skillName
			FROM 
				bestiarySkills
			WHERE
				skillTypeID = ".(int)$typeID."
		");

		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($results as $key => $skill) {
			$results[$key]->skillID = Controller::encryptString($skill->skillID);
		}

		return $results;
	}

	public function insertSkill(string $skillName, object $type): bool|object 
	{
		$skillName = htmlspecialchars(ucwords($skillName));

		// Insérer le nouveau skill
		$insertStmt = $this->db->prepare("
			INSERT INTO bestiarySkills (skillName, skillTypeID) 
			VALUES (:skillName, :skillTypeID)
		");

		$insertStmt->execute([
			"skillName" => $skillName,
			"skillTypeID" => (int)Controller::decryptString($type->typeID)
		]);
		
		$returnObj = (object)[
			"skillID" => Controller::encryptString($this->db->lastInsertId()),
			"typeName" => htmlspecialchars($type->typeName)
		];

		return $returnObj;
	}

	public function editSkillName(string $skillName, string $skillID): bool 
	{
		$skillName = htmlspecialchars(ucwords($_POST["value"]));
		$skillID = (int)Controller::decryptString($_POST["elemID"]);

		// Prépare la requête SQL pour mettre à jour le type
		$stmt = $this->db->prepare("
			UPDATE bestiarySkills 
			SET skillName = :skillName 
			WHERE skillID = :skillID
		");
	 
		// Exécute la requête avec les paramètres donnés
		$result = $stmt->execute([
			':skillName' => $skillName,
			':skillID' => $skillID
		]);
		
		// Retourne vrai si la mise à jour a réussi, sinon faux
		return $result;
	}

	public function deleteSkills(string|int $deleteSkill): bool 
	{
		$deleteSkill = $deleteSkill === "all" ? $deleteSkill : (int)Controller::decryptString($deleteSkill);

		if ($deleteSkill === "all") {
			// Supprimer toutes les compétences
			$stmt = $this->db->prepare("DELETE FROM bestiarySkills");
			$result = $stmt->execute();
		} elseif (is_numeric($deleteSkill)) {
			// Supprimer la compétence en question
			$deleteStmt = $this->db->prepare("DELETE FROM bestiarySkills WHERE skillID = :skillID");
			$result = $deleteStmt->execute(["skillID" => $deleteSkill]);
		}
		return $result;
	}
}
