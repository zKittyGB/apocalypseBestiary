<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class TypeModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public function getTypeByID($typeID): object
	{
		$typeID = (int)Controller::decryptString($typeID);

		$stmt = $this->db->query("
			SELECT 
				typeID,
				typeName
			FROM 
				bestiaryTypes
			WHERE
				typeID = ".$typeID);


		// Récupérer les résultats sous forme d'objets
		$type = $stmt->fetch(PDO::FETCH_OBJ);

		$type->typeID = Controller::encryptString($type->typeID);

		return $type;
	}

	static function getTypes(): array
	{
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				typeID,
				typeName
			FROM 
				bestiaryTypes
		");


		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($results as $key => $type) {
			$results[$key]->typeID = Controller::encryptString($type->typeID);
		}

		return $results;
	}

	public function insertType(string $typeName): bool|string 
	{
		$typeName = htmlspecialchars(ucwords($_POST["addElementValue"]));

		// Insérer le nouveau rank
		$insertStmt = $this->db->prepare("
			INSERT INTO bestiaryTypes (typeName) 
			VALUES (:typeName)
		");

		$insertStmt->execute([
			"typeName" => $typeName
		]);
	
		$lastInsertedID = Controller::encryptString($this->db->lastInsertId());

		return $lastInsertedID;
	}
	
	public function editTypeName(string $typeName, string $typeID): bool 
	{
		$typeName = htmlspecialchars(ucwords($_POST["value"]));
		$typeID = (int)Controller::decryptString($_POST["elemID"]);

		// Prépare la requête SQL pour mettre à jour le type
		$stmt = $this->db->prepare("
			UPDATE bestiaryTypes 
			SET typeName = :typeName 
			WHERE typeID = :typeID
		");
	 
		// Exécute la requête avec les paramètres donnés
		$result = $stmt->execute([
			':typeName' => $typeName,
			':typeID' => $typeID
		]);
		
		// Retourne vrai si la mise à jour a réussi, sinon faux
		return $result;
	}

	public function deleteTypes(string|int $deleteType): bool 
	{
		$deleteType = $deleteType === "all" ? $deleteType : (int)Controller::decryptString($deleteType);

		$this->db->beginTransaction(); // Démarrer une transaction
	    
		try {
			if ($deleteType === "all") {
				// Supprimer toutes les types
				$stmt = $this->db->prepare("DELETE FROM bestiaryTypes");
				$stmt->execute();
				
				// Supprimer toutes les compétences puisqu'elles sont liés aux types
				$stmt = $this->db->prepare("DELETE FROM bestiarySkills");
				$stmt->execute();

			} elseif (is_numeric($deleteType)) {
				// Supprimer le type en question
				$deleteStmt = $this->db->prepare("DELETE FROM bestiaryTypes WHERE typeID = :typeID");
				$deleteStmt->execute(["typeID" => $deleteType]);
				
				// Supprimer les compétences rattaché au type en question
				$deleteStmt = $this->db->prepare("DELETE FROM bestiarySkills WHERE skillTypeID = :typeID");
				$deleteStmt->execute(["typeID" => $deleteType]);
			} else {
				throw new Exception("Argument invalide pour deleteElements.");
			}
		
			// Validation de la transaction
			$this->db->commit();
			return true;

		} catch (Exception $e) {
		    // Si une erreur survient, on annule la transaction
		    $this->db->rollBack();
		    error_log("Erreur lors de la suppression de la compétence: " . $e->getMessage());
		    return false;
		}
	}
}
