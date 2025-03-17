<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class SafePlaceModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public function getSafePlaces(): array
	{
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				safePlaceID,
				safePlaceName,
				safePlacePicture
			FROM 
				bestiarySafePlaces");

		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($results as $key => $safePlace) {
			$results[$key]->safePlaceID = Controller::encryptString($safePlace->safePlaceID);
		}

		return $results;
	}
	
	public function getSelfPlace($safePlaceID): array
	{
		$db = Database::getInstance();

		// Décrypte l'ID fourni
		$safePlaceID = Controller::decryptString($safePlaceID);

		// Récupère les informations du lieu sur
		$stmt = $db->query("
			SELECT 
				safePlaceID AS ID, 
				safePlaceName AS name,
				safePlacePicture AS picture
			FROM 
				bestiarySafePlaces
			WHERE
				safePlaceID = '" . (int)$safePlaceID . "'
		");
		$safePlace = $stmt->fetch(PDO::FETCH_OBJ);

		// Ré-encrypte l'ID pour le retourner
		$safePlace->safePlaceID = Controller::encryptString($safePlace->ID);

		// Récupère les coordonnées liées à ce lieu sur
		$stmt = $db->query("
			SELECT 
				asAreaID AS areaID,
				asSafePlaceID AS safePlaceID,
				asSafePlaceCoordinates AS safePlaceCoordinates
			FROM 
				bestiaryAreasSafePlaces
			WHERE
				asSafePlaceID = '" . (int)$safePlaceID . "'
		");
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		// Initialise le tableau des coordonnées
		$safePlace->coordinates = [];

		// Parcours les résultats pour regrouper les coordonnées par areaID
		foreach ($results as $result) {
			// On crypte l'areaID pour correspondre à la logique de ton application
			$encryptedAreaID = Controller::encryptString($result->areaID);
			
			// Initialise un tableau si cet areaID n'existe pas encore
			if (!isset($safePlace->coordinates[$encryptedAreaID])) {
				$safePlace->coordinates[$encryptedAreaID] = [];
			}

			// Ajoute les coordonnées
			$safePlace->coordinates[$encryptedAreaID][] = $result->safePlaceCoordinates;
		}

		return (array)$safePlace;
	}

	public function getAreaSafePlaces($areaID): array
	{
		$areaID = Controller::decryptString($areaID);
		
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				asSafePlaceID AS safePlaceID,
				safePlaceName,
				safePlacePicture,
				asSafePlaceCoordinates AS coordinates

			FROM 
				bestiaryAreasSafePlaces
			JOIN bestiarySafePlaces ON safePlaceID = asSafePlaceID
			WHERE
				asAreaID = ".(int)$areaID."
			");

		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($results as $key => $safePlace) {
			$results[$key]->safePlaceID = Controller::encryptString($safePlace->safePlaceID);
		}

		return $results;
	}
	
	public function insertSafePlace($safePlaceName, $coordinates, $fileName): object 
	{
		$safePlaceName = htmlspecialchars($safePlaceName);
		$fileName = htmlspecialchars($fileName);
		$coordinates = $coordinates;
		$areaIDs = [];

		$db = Database::getInstance();

		$stmt = $db->prepare("
			INSERT INTO bestiarySafePlaces (safePlaceName, safePlacePicture)
			VALUES (:safePlaceName, :safePlacePicture)
		");

		$stmt->bindParam(":safePlaceName", $safePlaceName);
		$stmt->bindParam(":safePlacePicture", $fileName);

		$stmt->execute();

		// Récupérer les résultats sous forme d'objets
		$stmt->fetch(PDO::FETCH_OBJ);
		$lastInsertedID = $this->db->lastInsertId();

		// Insertion des liens entre les lieux sur et les zones
		if(is_array($coordinates)) {
			foreach($coordinates as $coordinate) {
				if(isset($coordinate["areaID"])) {
					$areaID = Controller::decryptString($coordinate["areaID"]); 
					
					if (!in_array($areaID, $areaIDs)) {
						$areaIDs[] = Controller::encryptString($areaID);
					}

					$stmtLink = $db->prepare("
						INSERT INTO bestiaryAreasSafePlaces (asAreaID, asSafePlaceID, asSafePlaceCoordinates)
						VALUES (:asAreaID, :asSafePlaceID, :asSafePlaceCoordinates)
					");
					
					$stmtLink->bindParam(":asAreaID", $areaID);
					$stmtLink->bindParam(":asSafePlaceID", $lastInsertedID);
					// Création du JSON avec les coordonnées
					$safePlaceCoordinates = json_encode([
						"xPercent" => $coordinate["xPercent"],
						"yPercent" => $coordinate["yPercent"]
					]);
					$stmtLink->bindParam(":asSafePlaceCoordinates", $safePlaceCoordinates);
				    
					$stmtLink->execute();
				}
			}
		}

		$returnObj = (object) [
			"ID" => Controller::encryptString($lastInsertedID),
			"name" => $safePlaceName,
			"picture" => $fileName,
			"areaIDs" => $areaIDs
		];

		return $returnObj;
	}

	public function updateSafePlace($safePlaceID, $coordinates, $elementName): bool
	{
		$safePlaceID = Controller::decryptString($safePlaceID);
		
		$db = Database::getInstance();
		
		try {
			// Démarrer une transaction
			$db->beginTransaction();
			
			// Mise à jour du nom dans la table bestiarySafeplaces
			if(!empty($elementName)) {
				$stmtUpdate = $db->prepare("
					UPDATE bestiarySafePlaces
					SET safePlaceName = :safePlaceName
					WHERE safePlaceID = :safePlaceID
				");

				$elementName = htmlspecialchars($elementName);
				
				$stmtUpdate->bindParam(":safePlaceName", $elementName);
				$stmtUpdate->bindParam(":safePlaceID", $safePlaceID, PDO::PARAM_INT);

				if (!$stmtUpdate->execute()) {
					$db->rollBack();
					return false;
				}
			}

			// Suppression de toutes les entrées 
			$stmtDelete = $db->prepare("
				DELETE FROM bestiaryAreasSafePlaces 
				WHERE asSafePlaceID = :asSafePlaceID
			");
			$stmtDelete->bindParam(":asSafePlaceID", $safePlaceID, PDO::PARAM_INT);
			$stmtDelete->execute();
			
			// Préparation unique de la requête d'insertion
			$stmtLink = $db->prepare("
				INSERT INTO bestiaryAreasSafePlaces (asAreaID, asSafePlaceID, asSafePlaceCoordinates)
				VALUES (:asAreaID, :asSafePlaceID, :asSafePlaceCoordinates)
			");
			
			// Insertion des nouvelles coordonnées
			if (is_array($coordinates)) {
				foreach ($coordinates as $coordinate) {
					if (isset($coordinate["areaID"])) {
						// Décryptage de l'areaID
						$areaID = Controller::decryptString($coordinate["areaID"]);
						
						// Création du JSON avec les coordonnées
						$safePlaceCoordinates = json_encode([
							"xPercent" => $coordinate["xPercent"],
							"yPercent" => $coordinate["yPercent"]
						]);
						
						// On utilise bindValue pour affecter la valeur actuelle à chaque itération
						$stmtLink->bindValue(":asAreaID", $areaID);
						$stmtLink->bindValue(":asSafePlaceID", $safePlaceID);
						$stmtLink->bindValue(":asSafePlaceCoordinates", $safePlaceCoordinates);
						
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

	public function deleteSafePlace($safePlaceID): bool
	{
		$safePlaceID = Controller::decryptString($safePlaceID);
		
		$db = Database::getInstance();
		
		try {
			// Démarrer une transaction
			$db->beginTransaction();

			// Suppression de toutes les entrées dans la table de liaison des zones
			$stmtDelete = $db->prepare("
				DELETE FROM bestiaryAreasSafePlaces 
				WHERE asSafePlaceID = :asSafePlaceID
			");
			$stmtDelete->bindParam(":asSafePlaceID", $safePlaceID, PDO::PARAM_INT);
			$stmtDelete->execute();

			// Suppression du lieu sur
			$stmtDelete = $db->prepare("
				DELETE FROM bestiarySafePlaces 
				WHERE safePlaceID = :safePlaceID
			");
			
			$stmtDelete->bindParam(":safePlaceID", $safePlaceID, PDO::PARAM_INT);
			$stmtDelete->execute();

			// Valider la transaction
			$db->commit();
			return true;
		} catch (Exception $e) {
			// Rollback en cas d'erreur
			$db->rollBack();
			
			// Ajouter un log pour comprendre l'erreur
			error_log("Erreur lors de la suppression du lieu sur $safePlaceID : " . $e->getMessage());

			return false;
		}
	}
}
