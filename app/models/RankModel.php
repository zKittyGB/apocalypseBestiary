<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class RankModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	static function getRanks(): array
	{
		$db = Database::getInstance();

		$stmt = $db->query("
			SELECT 
				rankID,
				rankValue,
				rankOrder
			FROM 
				bestiaryRanks
		");

		// Récupérer les résultats sous forme d'objets
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);

		// Trier les monstres par 'rankOrder'
		usort($results, function ($a, $b) {
			return $a->rankOrder <=> $b->rankOrder; 
		});

		foreach($results as $key => $rank) {
			$results[$key]->rankID =  Controller::encryptString($rank->rankID);

		}

		return $results;		
	}

	public function insertRank(string $rankValue, int $rankOrder): bool|string {
		$rankValue = htmlspecialchars(ucwords($_POST["rankValue"]));
		$rankOrder = (int)$_POST["rankOrder"];

		// Vérifie si un rankOrder existe déjà
		$stmt = $this->db->prepare("
			SELECT rankID FROM bestiaryRanks WHERE rankOrder = :rankOrder
		");

		$stmt->execute(["rankOrder" => $rankOrder]);
		$existingRank = $stmt->fetch(PDO::FETCH_OBJ);
	
		if ($existingRank) {
			// Décaler les rangs existants (ex: si on insère à 2, tous ceux ≥ 2 doivent prendre +1)
			$updateStmt = $this->db->prepare("
				UPDATE bestiaryRanks 
				SET rankOrder = rankOrder + 1 
				WHERE rankOrder >= :rankOrder
			");
			$updateStmt->execute(['rankOrder' => $rankOrder]);
		}
	
		// Insérer le nouveau rank
		$insertStmt = $this->db->prepare("
			INSERT INTO bestiaryRanks (rankValue, rankOrder) 
			VALUES (:rankValue, :rankOrder)
		");

		$insertStmt->execute([
			"rankValue" => $rankValue,
			"rankOrder" => $rankOrder
		]);
	
		$lastInsertedID = Controller::encryptString($this->db->lastInsertId());

		return $lastInsertedID;
	}
	
	public function deleteRanks(string|int $deleteElements): bool {
		$this->db->beginTransaction(); // Démarrer une transaction
	    
		try {
			if ($deleteElements === "all") {
				// Supprimer tous les ranks
				$stmt = $this->db->prepare("DELETE FROM bestiaryRanks");
				$stmt->execute();
			} elseif (is_numeric($deleteElements)) {
				// Trouver le rankOrder du rank à supprimer
				$stmt = $this->db->prepare("SELECT rankOrder FROM bestiaryRanks WHERE rankID = :rankID");
				$stmt->execute(["rankID" => $deleteElements]);
				$rank = $stmt->fetch(PDO::FETCH_OBJ);
		
				if (!$rank) {
				throw new Exception("Le rang spécifié n'existe pas.");
				}
		
				$rankOrder = $rank->rankOrder;
		
				// Supprimer le rank en question
				$deleteStmt = $this->db->prepare("DELETE FROM bestiaryRanks WHERE rankID = :rankID");
				$deleteStmt->execute(["rankID" => $deleteElements]);
		
				// Décaler les ranks restants
				$updateStmt = $this->db->prepare("
					UPDATE bestiaryRanks 
					SET rankOrder = rankOrder - 1 
					WHERE rankOrder > :rankOrder
				");
				$updateStmt->execute(["rankOrder" => $rankOrder]);
	    
			} else {
				throw new Exception("Argument invalide pour deleteElements.");
			}
		
			// Validation de la transaction
			$this->db->commit();
			return true;

		} catch (Exception $e) {
		    // Si une erreur survient, on annule la transaction
		    $this->db->rollBack();
		    error_log("Erreur lors de la suppression du rang: " . $e->getMessage());
		    return false;
		}
	}
	
	public function updateRankOrder(int $rankID, string $action): bool {
		$this->db->beginTransaction(); // Démarrer une transaction
	    
		try {
			// Récupérer les informations du rang actuel
			$stmt = $this->db->prepare("SELECT rankOrder FROM bestiaryRanks WHERE rankID = :rankID");
			$stmt->execute(['rankID' => $rankID]);
			$currentRank = $stmt->fetch(PDO::FETCH_ASSOC);
		
			if (!$currentRank) {
				throw new Exception("Rang introuvable.");
			}
		
			$currentOrder = (int) $currentRank['rankOrder'];
		
			// Déterminer le nouvel ordre
			if ($action === 'up') {
				$newOrder = $currentOrder - 1;
			} elseif ($action === 'down') {
				$newOrder = $currentOrder + 1;
			} else {
				throw new Exception("Action invalide.");
			}
		
			// Vérifier si un rang existe à la position cible
			$stmt = $this->db->prepare("SELECT rankID FROM bestiaryRanks WHERE rankOrder = :newOrder");
			$stmt->execute(['newOrder' => $newOrder]);
			$swappedRank = $stmt->fetch(PDO::FETCH_ASSOC);
		
			if (!$swappedRank) {
				throw new Exception("Impossible de déplacer, aucun rang à la position cible.");
			}
		
			$swappedRankID = (int) $swappedRank['rankID'];
		
			// Met à jour l'orde pour le rang ciblé à l'origine
			$stmt = $this->db->prepare("UPDATE bestiaryRanks SET rankOrder = :newOrder WHERE rankID = :rankID");
			$stmt->execute(['newOrder' => $newOrder, 'rankID' => $rankID]);
		
			// Met à jour l'ordre pour le rang qui se fait remplacer
			$stmt = $this->db->prepare("UPDATE bestiaryRanks SET rankOrder = :currentOrder WHERE rankID = :swappedRankID");
			$stmt->execute(['currentOrder' => $currentOrder, 'swappedRankID' => $swappedRankID]);
		
			// Valider la transaction
			$this->db->commit();
			return true;
		} catch (Exception $e) {
			// Annuler la transaction en cas d'erreur
			$this->db->rollBack();
			error_log("Erreur lors de la mise à jour du rang: " . $e->getMessage());
			return false;
		}
	}
	    
	
}
