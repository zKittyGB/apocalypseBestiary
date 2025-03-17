<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class GlossaryModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public function getGlossary(): array
	{
		$stmt = $this->db->query("
			SELECT 
				glossaryWordID,
				glossaryWordValue,
				glossaryWordDefinition				
			FROM 
				bestiaryGlossaryWords
		");

		// Récupérer les résultats sous forme d'objets
		$glossary = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach($glossary as $key => $definition) {
			$glossary[$key]->glossaryWordID = Controller::encryptString($definition->glossaryWordID);
		}

		return $glossary;
	}

	public function insertWord(string $wordValue, string $definitionValue): bool|string {
		$stmt = $this->db->prepare("
			INSERT INTO bestiaryGlossaryWords (glossaryWordValue, glossaryWordDefinition, glossaryWordDateCreation, glossaryWordDateModification) 
			VALUES (:glossaryWordValue, :glossaryWordDefinition, :glossaryWordDateCreation, :glossaryWordDateModification)
		");
	
		$result = $stmt->execute([
			"glossaryWordValue" => htmlspecialchars(ucwords($wordValue)),
			"glossaryWordDefinition" => htmlspecialchars(ucwords($definitionValue)),
			"glossaryWordDateCreation" => date("Y-m-d H:i:s"),
			"glossaryWordDateModification" => date("Y-m-d H:i:s")
		]);

		if(!$result) {
			return false;
		}
		
		// Récupérer l'ID du monstre inséré
		$lastInsertedID = Controller::encryptString($this->db->lastInsertId());
		
		return $lastInsertedID;
	}

	public function editGlossaryWord(string $wordID, string $wordValue, string $definitionValue): bool 
	{
		$wordID = (int)Controller::decryptString($wordID);

		// Prépare la requête SQL pour mettre à jour les valeurs
		$stmt = $this->db->prepare("
			UPDATE bestiaryGlossaryWords 
			SET glossaryWordValue = :glossaryWordValue, 
				glossaryWordDefinition = :glossaryWordDefinition, 
				glossaryWordDateModification = :glossaryWordDateModification
			WHERE glossaryWordID = :glossaryWordID
	      	");
	  
		// Exécute la requête avec les paramètres donnés
		$result = $stmt->execute([
			":glossaryWordValue" => $wordValue,
			":glossaryWordDefinition" => $definitionValue,
			":glossaryWordDateModification" => date("Y-m-d H:i:s"),
			":glossaryWordID" => $wordID
		]);
		
		// Retourne vrai si la mise à jour a réussi, sinon faux
		return $result;
	}

	public function deleteWords(string $deleteElements): bool 
	{
		if ($deleteElements === "deleteAll") {
			// Supprimer toutes les compétences
			$stmt = $this->db->prepare("DELETE FROM bestiaryGlossaryWords");
			$result = $stmt->execute();
		} else {
			// Supprimer la compétence en question
			$deleteStmt = $this->db->prepare("DELETE FROM bestiaryGlossaryWords WHERE glossaryWordID = :glossaryWordID");
			$result = $deleteStmt->execute(["glossaryWordID" => (int)Controller::decryptString($deleteElements)]);
		}

		return $result;
	}
}
