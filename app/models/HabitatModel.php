<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class HabitatModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public function getHabitats(): array
	{
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				habitatID,
				habitatName,
				habitatPicture
			FROM 
				bestiaryHabitats");

		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($results as $key => $habitat) {
			$results[$key]->habitatID = Controller::encryptString($habitat->habitatID);
		}

		return $results;
	}
	
	public function getHabitat($habitatID): array
	{
		$db = Database::getInstance();

		// Décrypte l'ID fourni
		$habitatID = Controller::decryptString($habitatID);

		// Récupère les informations de l'habitat
		$stmt = $db->query("
			SELECT 
				habitatID AS ID, 
				habitatName AS name,
				habitatPicture AS picture
			FROM 
				bestiaryHabitats
			WHERE
				habitatID = '" . (int)$habitatID . "'
		");
		$habitat = $stmt->fetch(PDO::FETCH_OBJ);

		// Ré-encrypte l'ID pour le retourner
		$habitat->habitatID = Controller::encryptString($habitat->ID);

		// Récupère les coordonnées liées à cet habitat
		$stmt = $db->query("
			SELECT 
				ahAreaID AS areaID,
				ahHabitatID AS habitatID,
				ahHabitatCoordinates AS habitatCoordinates
			FROM 
				bestiaryAreasHabitats
			WHERE
				ahHabitatID = '" . (int)$habitatID . "'
		");
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		// Initialise le tableau des coordonnées
		$habitat->coordinates = [];

		// Parcours les résultats pour regrouper les coordonnées par areaID
		foreach ($results as $result) {
			// On crypte l'areaID pour correspondre à la logique de ton application
			$encryptedAreaID = Controller::encryptString($result->areaID);
			
			// Initialise un tableau si cet areaID n'existe pas encore
			if (!isset($habitat->coordinates[$encryptedAreaID])) {
				$habitat->coordinates[$encryptedAreaID] = [];
			}

			// Ajoute les coordonnées
			$habitat->coordinates[$encryptedAreaID][] = $result->habitatCoordinates;
		}

		return (array)$habitat;
	}

	public function getAreaHabitats($areaID): array
	{
		$areaID = Controller::decryptString($areaID);
		
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				ahHabitatID AS habitatID,
				habitatName,
				habitatPicture,
				ahHabitatCoordinates AS coordinates
			FROM 
				bestiaryAreasHabitats
			JOIN bestiaryHabitats ON habitatID = ahHabitatID
			WHERE
				ahAreaID = ".(int)$areaID."
			");

		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($results as $key => $habitat) {
			$results[$key]->habitatID = Controller::encryptString($habitat->habitatID);
		}

		return $results;
	}
	
	public function insertHabitat($habitatName, $coordinates, $fileName): object
	{
		$coordinates = $coordinates;
		$areaIDs = [];

		$db = Database::getInstance();

		$stmt = $db->prepare("
			INSERT INTO bestiaryHabitats (habitatName, habitatPicture)
			VALUES (:habitatName, :habitatPicture)
		");

		$stmt->bindParam(":habitatName", $habitatName);
		$stmt->bindParam(":habitatPicture", $fileName);

		$stmt->execute();

		// Récupérer les résultats sous forme d'objets
		$stmt->fetch(PDO::FETCH_OBJ);
		$lastInsertedID = $this->db->lastInsertId();

		// Insertion des liens entre les habitats et les zones
		if(is_array($coordinates)) {
			foreach($coordinates as $coordinate) {
				if(isset($coordinate["areaID"])) {
					$areaID = Controller::decryptString($coordinate["areaID"]); 
					
					if (!in_array($areaID, $areaIDs)) {
						$areaIDs[] = Controller::encryptString($areaID);
					}

					$stmtLink = $db->prepare("
						INSERT INTO bestiaryAreasHabitats (ahAreaID, ahHabitatID, ahHabitatCoordinates)
						VALUES (:ahAreaID, :ahHabitatID, :ahHabitatCoordinates)
					");
					
					$stmtLink->bindParam(":ahAreaID", $areaID);
					$stmtLink->bindParam(":ahHabitatID", $lastInsertedID);
					// Création du JSON avec les coordonnées
					$habitatCoordinates = json_encode([
						"xPercent" => $coordinate["xPercent"],
						"yPercent" => $coordinate["yPercent"]
					]);
					$stmtLink->bindParam(":ahHabitatCoordinates", $habitatCoordinates);
				    
					$stmtLink->execute();
				}
			}
		}

		$returnObj = (object) [
			"ID" => Controller::encryptString($lastInsertedID),
			"name" => $habitatName,
			"picture" => $fileName,
			"areaIDs" => $areaIDs
		];

		return $returnObj;
	}

	public function updateHabitat($habitatID, $coordinates, $elementName): bool
	{
		$habitatID = Controller::decryptString($habitatID);
		
		$db = Database::getInstance();
		
		try {
			// Démarrer une transaction
			$db->beginTransaction();
			
			// Mise à jour du nom dans la table bestiaryHabitats
			if(!empty($elementName)) {
				$stmtUpdate = $db->prepare("
					UPDATE bestiaryHabitats
					SET habitatName = :habitatName
					WHERE habitatID = :habitatID
				");

				$elementName = htmlspecialchars($elementName);
				
				$stmtUpdate->bindParam(":habitatName", $elementName);
				$stmtUpdate->bindParam(":habitatID", $habitatID, PDO::PARAM_INT);

				if (!$stmtUpdate->execute()) {
					$db->rollBack();
					return false;
				}
			}

			// Suppression de toutes les entrées 
			$stmtDelete = $db->prepare("
				DELETE FROM bestiaryAreasHabitats 
				WHERE ahHabitatID = :ahHabitatID
			");
			$stmtDelete->bindParam(":ahHabitatID", $habitatID, PDO::PARAM_INT);
			$stmtDelete->execute();
			
			// Préparation unique de la requête d'insertion
			$stmtLink = $db->prepare("
				INSERT INTO bestiaryAreasHabitats (ahAreaID, ahHabitatID, ahHabitatCoordinates)
				VALUES (:ahAreaID, :ahHabitatID, :ahHabitatCoordinates)
			");
			
			// Insertion des nouvelles coordonnées
			if (is_array($coordinates)) {
				foreach ($coordinates as $coordinate) {
					if (isset($coordinate["areaID"])) {
						// Décryptage de l'areaID
						$areaID = Controller::decryptString($coordinate["areaID"]);
						
						// Création du JSON avec les coordonnées
						$habitatCoordinates = json_encode([
							"xPercent" => $coordinate["xPercent"],
							"yPercent" => $coordinate["yPercent"]
						]);
						
						// On utilise bindValue pour affecter la valeur actuelle à chaque itération
						$stmtLink->bindValue(":ahAreaID", $areaID);
						$stmtLink->bindValue(":ahHabitatID", $habitatID);
						$stmtLink->bindValue(":ahHabitatCoordinates", $habitatCoordinates);
						
						if (!$stmtLink->execute()) {
							// En cas d'erreur, annule la transaction et retourne false
							$db->rollBack();
							return false;
						}
					}
				}
			}
			
			// Validation de la transaction
			$db->commit();
			return true;
		} catch (Exception $e) {
			$db->rollBack();
			return false;
		}
	}

	public function deleteHabitat($habitatID): bool
	{
		$habitatID = Controller::decryptString($habitatID);
		
		$db = Database::getInstance();
		
		try {
			// Démarrer une transaction
			$db->beginTransaction();

			// Vérifier si des monstres sont liés à cet habitat
			$stmtCheck = $db->prepare("
				SELECT COUNT(*) FROM bestiaryMonsters WHERE monsterHabitatID = :habitatID
			");
			$stmtCheck->bindParam(":habitatID", $habitatID, PDO::PARAM_INT);
			$stmtCheck->execute();
			$monstersCount = $stmtCheck->fetchColumn();

			// Si des monstres existent, les dissocier de cet habitat
			if ($monstersCount > 0) {
				$stmtUpdate = $db->prepare("
					UPDATE bestiaryMonsters
					SET monsterHabitatID = NULL
					WHERE monsterHabitatID = :habitatID
				");
				$stmtUpdate->bindParam(":habitatID", $habitatID, PDO::PARAM_INT);

				if (!$stmtUpdate->execute()) {
					$db->rollBack();
					return false;
				}
			}

			// Suppression de toutes les entrées dans la table de liaison des zones
			$stmtDelete = $db->prepare("
				DELETE FROM bestiaryAreasHabitats 
				WHERE ahHabitatID = :habitatID
			");
			$stmtDelete->bindParam(":habitatID", $habitatID, PDO::PARAM_INT);
			$stmtDelete->execute();

			// Suppression de l'habitat lui-même
			$stmtDelete = $db->prepare("
				DELETE FROM bestiaryHabitats 
				WHERE habitatID = :habitatID
			");
			
			$stmtDelete->bindParam(":habitatID", $habitatID, PDO::PARAM_INT);
			$stmtDelete->execute();

			// Valider la transaction
			$db->commit();
			return true;
		} catch (Exception $e) {
			// Rollback en cas d'erreur
			$db->rollBack();
			
			// Ajouter un log pour comprendre l'erreur
			error_log("Erreur lors de la suppression de l'habitat $habitatID : " . $e->getMessage());

			return false;
		}
	}
}
