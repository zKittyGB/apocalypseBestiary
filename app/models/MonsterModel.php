<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class MonsterModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public function getBestiary(): array
	{
		$stmt = $this->db->query("
			SELECT 
				monsterID,
				monsterName,
				monsterDangerID,
				dangerValue,
				monsterRankID,
				monsterMasterID,
				rankValue,
				rankOrder,
				rankID,
				monsterAreaID,
				areaName,
				monsterPicture
			FROM 
				bestiaryMonsters
				JOIN bestiaryDangers ON dangerID = monsterDangerID
				JOIN bestiaryRanks ON rankID = monsterRankID
				JOIN bestiaryAreas ON areaID = monsterAreaID
		");

		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		// Organiser les monstres par 'rankValue' dans un tableau associatif
		$groupedByRank = [];

		foreach($results as $key => $monster) {
			// Si le rankValue n'existe pas encore dans le tableau, on l'ajoute avec un tableau vide
			if(!isset($groupedByRank[$monster->rankValue])) {
				$groupedByRank[$monster->rankValue] = [];
			}

			// Ajouter le monstre dans le groupe correspondant à son rankValue
			$groupedByRank[$monster->rankValue][] = $monster;

			$results[$key]->monsterID = Controller::encryptString($monster->monsterID);
			$results[$key]->monsterDangerID = Controller::encryptString($monster->monsterDangerID);
			$results[$key]->monsterMasterID = $monster->monsterMasterID ? Controller::encryptString($monster->monsterMasterID) : null;
			$results[$key]->monsterAreaID = Controller::encryptString($monster->monsterAreaID);
			$results[$key]->monsterRankID = Controller::encryptString($monster->monsterRankID);
			$results[$key]->rankID = Controller::encryptString($monster->rankID);
		}

		return $groupedByRank;
	}

	public function getMonsterByID($monsterID): object
	{
		$monsterID = Controller::decryptString($monsterID);

		$stmt = $this->db->query("
			SELECT 
				monsterID,
				monsterName,
				monsterRankID AS monsterRank,
				monsterMasterID AS monsterMaster,
				rankOrder,
				rankValue,
				monsterPicture,
				monsterTypeID AS monsterType,
				typeName,
				monsterAreaID AS monsterArea,
				areaName,
				monsterDangerID AS monsterDanger,
				dangerValue,
				monsterHabitatID AS monsterHabitat,
				habitatName,
				monsterDescription,
				monsterBehavior,
				monsterStrengthes,
				monsterWeaknesses,
				monsterAdvice
			FROM 
				bestiaryMonsters
			JOIN bestiaryRanks ON monsterRankID = rankID
			JOIN bestiaryAreas ON monsterAreaID = areaID
			JOIN bestiaryTypes ON monsterTypeID = typeID 
			JOIN bestiaryDangers ON monsterDangerID = dangerID 
			JOIN bestiaryHabitats ON monsterHabitatID = habitatID

			WHERE
				monsterID = " . (int)$monsterID . "");

		// Récupérer les résultats sous forme d'objets
		$monster = $stmt->fetch(PDO::FETCH_OBJ);
		if(!empty($monster->monsterMaster)) {
			$stmt = $this->db->query("
			SELECT 
				monsterID,
				monsterName
			FROM 
				bestiaryMonsters
			WHERE
				monsterID = " . (int)$monster->monsterMaster);

			// Récupérer les résultats sous forme d'objets
			$master = $stmt->fetch(PDO::FETCH_OBJ);
		}

		if(!empty($monster)) {
			$monster->monsterID = Controller::encryptString($monster->monsterID);
			$monster->monsterName = htmlspecialchars_decode($monster->monsterName);
			$monster->monsterRank = Controller::encryptString($monster->monsterRank);
			$monster->monsterMaster = $monster->monsterMaster ? Controller::encryptString($monster->monsterMaster) : null;
			$monster->monsterMasterName = $monster->monsterMaster ? $master->monsterName : null;
			$monster->monsterType = Controller::encryptString($monster->monsterType);
			$monster->monsterArea = Controller::encryptString($monster->monsterArea);
			$monster->monsterDanger = Controller::encryptString($monster->monsterDanger);
			$monster->monsterHabitat = Controller::encryptString($monster->monsterHabitat);
			$monster->monsterStrengthes = $monster->monsterStrengthes ? json_decode($monster->monsterStrengthes, true) : [];
			$monster->monsterWeaknesses = $monster->monsterWeaknesses ? json_decode($monster->monsterWeaknesses, true) : [];

			$stmt = $this->db->query("
				SELECT 
					msSkillID AS skillID,
					skillName
				FROM 
					bestiaryMonstersSkills
				JOIN bestiarySkills ON msSkillID = skillID

				WHERE
					msMonsterID = " . (int)$monsterID . "");

			// Récupérer les résultats sous forme d'objets
			$skills = $stmt->fetchAll(PDO::FETCH_OBJ);

			foreach($skills as $key => $skill) {
				$skills[$key]->skillID = Controller::encryptString($skill->skillID);
			}

			$monster->monsterSkills = $skills ? $skills : [];
		}

		return $monster;
	}

	public function getMonstersByAreaID($areaID): array
	{
		$areaID = Controller::decryptString($areaID);

		$stmt = $this->db->prepare("
			SELECT monsterID 
			FROM bestiaryMonsters 
			WHERE monsterAreaID = :areaID
		");

		$stmt->bindParam(":areaID", $areaID, PDO::PARAM_INT);
		$stmt->execute();

		// Récupère sous forme associative
		$results = $stmt->fetchAll();
		$monsters = [];

		foreach($results as $result) {
			$monsterID = $result["monsterID"];

			$monsterID = Controller::encryptString($monsterID);
			$monsters[] = self::getMonsterByID((string)$monsterID);
		}

		return $monsters;
	}

	public function insertMonster(array $monsterData): bool | object
	{
		try {
			$this->db->beginTransaction();

			$stmt = $this->db->prepare("
				INSERT INTO bestiaryMonsters 
				(monsterName, monsterHabitatID, monsterAreaID, monsterDangerID, monsterMasterID, monsterRankID, monsterTypeID, monsterPicture, monsterDescription, monsterBehavior, monsterStrengthes, monsterWeaknesses, monsterAdvice, monsterDateCreation, monsterDateModification) 
				VALUES 
				(:monsterName, :monsterHabitatID, :monsterAreaID, :monsterDangerID, :monsterMasterID, :monsterRankID, :monsterTypeID, :monsterPicture, :monsterDescription, :monsterBehavior, :monsterStrengthes, :monsterWeaknesses, :monsterAdvice, :monsterDateCreation, :monsterDateModification)
			");

			$result = $stmt->execute([
				"monsterName" => htmlspecialchars(ucwords($monsterData["monsterName"])),
				"monsterHabitatID" => (int) Controller::decryptString($monsterData["monsterHabitat"]),
				"monsterAreaID" => (int) Controller::decryptString($monsterData["monsterArea"]),
				"monsterDangerID" => (int) Controller::decryptString($monsterData["monsterDanger"]),
				"monsterRankID" => (int) Controller::decryptString($monsterData["monsterRank"]),
				"monsterMasterID" => !empty($monsterData["monsterMaster"]) ? (int) Controller::decryptString($monsterData["monsterMaster"]) : null,
				"monsterTypeID" => (int) Controller::decryptString($monsterData["monsterType"]),
				"monsterDescription" => !empty($monsterData["monsterDescription"]) ? htmlspecialchars($monsterData["monsterDescription"]) : null,
				"monsterBehavior" => !empty($monsterData["monsterBehavior"]) ? htmlspecialchars($monsterData["monsterBehavior"]) : null,
				"monsterStrengthes" => is_array($monsterData["monsterStrengthes"]) ? json_encode($monsterData["monsterStrengthes"]) : "[]",
				"monsterWeaknesses" => is_array($monsterData["monsterWeaknesses"]) ? json_encode($monsterData["monsterWeaknesses"]) : "[]",
				"monsterAdvice" => !empty($monsterData["monsterAdvice"]) ? htmlspecialchars($monsterData["monsterAdvice"]) : null,
				"monsterPicture" => $monsterData["monsterPicture"],
				"monsterDateCreation" => date("Y-m-d H:i:s"),
				"monsterDateModification" => date("Y-m-d H:i:s")
			]);

			if(!$result) {
				$this->db->rollBack();
				return false;
			}

			$lastInsertedID = $this->db->lastInsertId();
			if(!$lastInsertedID) {
				$this->db->rollBack();
				return false;
			}

			// Insertion des compétences si elles existent
			if(!empty($monsterData["monsterSkills"])) {
				$skills = is_string($monsterData["monsterSkills"]) ? json_decode($monsterData["monsterSkills"], true) : $monsterData["monsterSkills"];

				$stmt = $this->db->prepare("
			    		INSERT INTO bestiaryMonstersSkills (msMonsterID, msSkillID) VALUES (:monsterID, :skillID)
				");

				foreach($skills as $skillID) {
					$result = $stmt->execute([
						"monsterID" => $lastInsertedID,
						"skillID" => (int) Controller::decryptString($skillID)
					]);
					if(!$result) {
						$this->db->rollBack();
						return false;
					}
				}
			}

			$this->db->commit();

			return (object)[
				"monsterID" => Controller::encryptString($lastInsertedID),
				"monsterName" => htmlspecialchars(ucwords($monsterData["monsterName"])),
				"monsterPicture" => $monsterData["monsterPicture"],
				"monsterRank" => $monsterData["monsterRank"],
				"monsterWeaknesses" => $monsterData["monsterWeaknesses"]
			];
		} catch(Exception $e) {
			$this->db->rollBack();
			return false;
		}
	}

	public function updateMonster(string $monsterID, array $monsterData): bool|string
	{
		try {
			$this->db->beginTransaction();

			// Décryptage du monsterID
			$monsterID = (int) Controller::decryptString($monsterID);

			// Préparation des valeurs à mettre à jour
			$updateData = [];
			$setClauses = [];

			// Vérification et mise à jour des champs un par un
			if(isset($monsterData["monsterName"]) && !empty($monsterData["monsterName"])) {
				$setClauses[] = "monsterName = :monsterName";
				$updateData["monsterName"] = htmlspecialchars($monsterData["monsterName"]);
			}

			if(isset($monsterData["monsterHabitat"]) && !empty($monsterData["monsterHabitat"])) {
				$setClauses[] = "monsterHabitatID = :monsterHabitatID";
				$updateData["monsterHabitatID"] = (int) Controller::decryptString($monsterData["monsterHabitat"]);
			}

			if(isset($monsterData["monsterArea"]) && !empty($monsterData["monsterArea"])) {
				$setClauses[] = "monsterAreaID = :monsterAreaID";
				$updateData["monsterAreaID"] = (int) Controller::decryptString($monsterData["monsterArea"]);
			}

			if(isset($monsterData["monsterDanger"]) && !empty($monsterData["monsterDanger"])) {
				$setClauses[] = "monsterDangerID = :monsterDangerID";
				$updateData["monsterDangerID"] = (int) Controller::decryptString($monsterData["monsterDanger"]);
			}

			if(isset($monsterData["monsterRank"]) && !empty($monsterData["monsterRank"])) {
				$setClauses[] = "monsterRankID = :monsterRankID";
				$updateData["monsterRankID"] = (int) Controller::decryptString($monsterData["monsterRank"]);
			}

			if(isset($monsterData["monsterMaster"]) && !empty($monsterData["monsterMaster"])) {
				$setClauses[] = "monsterMasterID = :monsterMasterID";
				$updateData["monsterMasterID"] = (int) Controller::decryptString($monsterData["monsterMaster"]);
			}

			if(isset($monsterData["monsterType"]) && !empty($monsterData["monsterType"])) {
				$setClauses[] = "monsterTypeID = :monsterTypeID";
				$updateData["monsterTypeID"] = (int) Controller::decryptString($monsterData["monsterType"]);
			}

			if(isset($monsterData["monsterDescription"]) && !empty($monsterData["monsterDescription"])) {
				$setClauses[] = "monsterDescription = :monsterDescription";
				$updateData["monsterDescription"] = htmlspecialchars($monsterData["monsterDescription"]);
			}

			if(isset($monsterData["monsterBehavior"]) && !empty($monsterData["monsterBehavior"])) {
				$setClauses[] = "monsterBehavior = :monsterBehavior";
				$updateData["monsterBehavior"] = htmlspecialchars($monsterData["monsterBehavior"]);
			}

			if(isset($monsterData["monsterStrengthes"]) && !empty($monsterData["monsterStrengthes"])) {
				$setClauses[] = "monsterStrengthes = :monsterStrengthes";
				$updateData["monsterStrengthes"] = is_array($monsterData["monsterStrengthes"]) ? json_encode($monsterData["monsterStrengthes"]) : "[]";
			}

			if(isset($monsterData["monsterWeaknesses"]) && !empty($monsterData["monsterWeaknesses"])) {
				$setClauses[] = "monsterWeaknesses = :monsterWeaknesses";
				$updateData["monsterWeaknesses"] = is_array($monsterData["monsterWeaknesses"]) ? json_encode($monsterData["monsterWeaknesses"]) : "[]";
			}

			if(isset($monsterData["monsterAdvice"]) && !empty($monsterData["monsterAdvice"])) {
				$setClauses[] = "monsterAdvice = :monsterAdvice";
				$updateData["monsterAdvice"] = htmlspecialchars($monsterData["monsterAdvice"]);
			}

			// Si aucune donnée à mettre à jour, on annule la transaction
			if(!empty($setClauses)) {
				// Ajout de l'ID du monstre pour la mise à jour
				$setClauseString = implode(", ", $setClauses);
				$updateData["monsterID"] = $monsterID;

				// Requête de mise à jour
				$stmt = $this->db->prepare("
					UPDATE bestiaryMonsters
					SET $setClauseString, monsterDateModification = :monsterDateModification
					WHERE monsterID = :monsterID
				");

				// Ajout de la date de modification
				$updateData["monsterDateModification"] = date("Y-m-d H:i:s");

				// Exécution de la requête de mise à jour
				$result = $stmt->execute($updateData);

				if(!$result) {
					$this->db->rollBack();
					return false;
				}	
			}

			// Mise à jour des compétences si elles sont envoyées
			if(isset($monsterData["monsterSkills"])) {
				$skills = is_string($monsterData["monsterSkills"]) ? json_decode($monsterData["monsterSkills"], true) : $monsterData["monsterSkills"];

				// Suppression des compétences existantes
				$stmt = $this->db->prepare("DELETE FROM bestiaryMonstersSkills WHERE msMonsterID = :monsterID");
				$stmt->execute(["monsterID" => $monsterID]);

				// Ajout des nouvelles compétences
				$stmt = $this->db->prepare("INSERT INTO bestiaryMonstersSkills (msMonsterID, msSkillID) VALUES (:monsterID, :skillID)");
				foreach($skills as $skillID) {
					$result = $stmt->execute([
						"monsterID" => $monsterID,
						"skillID" => (int) Controller::decryptString($skillID)
					]);
					if(!$result) {
						$this->db->rollBack();
						return false;
					}
				}
			}

			$this->db->commit();

			// Retourner l'objet avec les informations mises à jour
			return true;
		} catch(Exception $e) {
			$this->db->rollBack();
			return false;
		}
	}
	public function deleteMonster(string $monsterID): bool
	{
		try {
			$this->db->beginTransaction();

			// Décryptage du monsterID
			$monsterID = (int) Controller::decryptString($monsterID);

			// Suppression des liaisons dans bestiaryMonstersSkills
			$stmt = $this->db->prepare("DELETE FROM bestiaryMonstersSkills WHERE msMonsterID = :monsterID");
			$stmt->execute(["monsterID" => $monsterID]);

			// Mise à jour des monstres ayant ce monsterID comme maître
			$stmt = $this->db->prepare("UPDATE bestiaryMonsters SET monsterMasterID = NULL WHERE monsterMasterID = :monsterID");
			$stmt->execute(["monsterID" => $monsterID]);

			// Suppression du monstre dans bestiaryMonsters
			$stmt = $this->db->prepare("DELETE FROM bestiaryMonsters WHERE monsterID = :monsterID");
			$stmt->execute(["monsterID" => $monsterID]);

			$this->db->commit();

			return true;
		} catch(Exception $e) {
			$this->db->rollBack();
			return false;
		}
	}
}
