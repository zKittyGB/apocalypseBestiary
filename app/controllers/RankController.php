<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/models/RankModel.php';


class RankController extends Controller
{
	public function addRank() {
		if (empty($_POST["rankValue"]) || empty($_POST["rankOrder"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$rankValue = $_POST["rankValue"];
		$rankOrder = (int)$_POST["rankOrder"];

		// Envoi des données au modèle
		$rankModel = new RankModel();

		$insertID = $rankModel->insertRank($rankValue, $rankOrder);
		
		if(!$insertID) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Grade ajouté avec succès !", "rankID" => $insertID]);
	}

	public function deleteRanks() {
		// Si vide, ou si différent de All et n'est pas un int
		if (empty($_POST["deleteElements"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		// Stock "all" ou l'ID décrypté
		$deleteElements = $_POST["deleteElements"] === "all" ? $_POST["deleteElements"] : (int)Controller::decryptString($_POST["deleteElements"]);

		// Envoi des données au modèle
		$rankModel = new RankModel();

		$rankModel->deleteRanks($deleteElements);

		echo json_encode(["success" => "Grade supprimé avec succès !"]);
	}

	public function updateRankOrder() {
		// Si vide, ou si différent de All et n'est pas un int
		if (empty($_POST["rankID"]) || ($_POST["action"] != "up" && $_POST["action"] != "down")) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$rankID = (int)Controller::decryptString($_POST["rankID"]);
		$action = $_POST["action"];

		// Envoi des données au modèle
		$rankModel = new RankModel();

		$rankModel->updateRankOrder($rankID, $action);

		echo json_encode(["success" => "Grades modifiés avec succès !"]);
	}
}
