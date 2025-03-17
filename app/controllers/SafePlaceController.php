<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/models/SafePlaceModel.php';


class SafePlaceController {
	static function getSafePlaces() {
		$safePlaceModel = new SafePlaceModel();
		$safePlaces = $safePlaceModel->getSafePlaces();
		
		echo json_encode($safePlaces);
	}

	public function getSafePlace() {
		if(empty($_POST["safePlaceID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$safePlaceID = $_POST["safePlaceID"];

		// Envoi des données au modèle
		$safePlaceModel = new SafePlaceModel();
		$safePlace = $safePlaceModel->getSelfPlace($safePlaceID);

		if(!empty($safePlace)) {
			echo json_encode(["element" => $safePlace]);
		} else {
			echo json_encode(["error" => "Erreur lors de la récupération"]);
		}
	}

	public function getAreaSafePlaces() {
		header('Content-Type: application/json');
		$areaID = $_GET['areaID'] ? $_GET['areaID'] : null;
		
		if (!$areaID) {
			echo json_encode(['error' => 'Aucun areaID fourni']);
			exit;
		}

		$safePlaceModel = new SafePlaceModel();
		$safePlaces = $safePlaceModel->getAreaSafePlaces($areaID);

		echo json_encode($safePlaces);
	}

	public function addSafePlace() {
		if(empty($_POST["elementName"]) || empty($_FILES["elementPicture"]) || empty($_POST["coordinates"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$safePlaceName = $_POST["elementName"];
		$coordinates = json_decode($_POST["coordinates"], true);
		$file = $_FILES["elementPicture"];
		
		// Vérifier l"extension du fichier
		$allowedExtensions = ["jpg", "jpeg", "png"];
		$fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
	
		if (!in_array($fileExtension, $allowedExtensions)) {
			die(json_encode(["error" => "Format de fichier non autorisé"]));
		}
	
		// Déplacer le fichier
		$uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/bestiary/public/uploads/safePlaces/";
		$fileName = uniqid("safePlaces_") . "." . $fileExtension;
		$filePath = $uploadDir . $fileName;
	
		if (!move_uploaded_file($file["tmp_name"], $filePath)) {
			die(json_encode(["error" => "Échec du déplacement du fichier"]));
		}
		
		// Envoi des données au modèle
		$safePlaceModel = new SafePlaceModel();
		$safePlace = $safePlaceModel->insertSafePlace($safePlaceName, $coordinates, $fileName);
		if(!empty($safePlace)) {
			echo json_encode(["success" => "Lieu sûr ajouté avec succès !", "addedElement" => $safePlace]);
		} else {
			echo json_encode(["error" => "Erreur lors de l'ajout du lieu sûr"]);
		}
	}

	public function updateSafePlace() {
		if(empty($_POST["elementID"]) || empty($_POST["coordinates"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$safePlaceID = $_POST["elementID"];
		$elementName = isset($_POST["elementName"]) ? $_POST["elementName"] : null;
		$coordinates = json_decode($_POST["coordinates"], true);
		
		// Envoi des données au modèle
		$safePlaceModel = new SafePlaceModel();
		$result = $safePlaceModel->updateSafePlace($safePlaceID, $coordinates, $elementName);

		if(!empty($result)) {
			echo json_encode(["success" => "Lieu sûr mit-à-jour avec succès !"]);	
		} else {
			echo json_encode(["error" => "Erreur lors de la mise à jour"]);
		}
	}

	public function deleteSafePlace() {
		if(empty($_POST["elementID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$safePlaceID = $_POST["elementID"];
		
		// Envoi des données au modèle
		$safePlaceModel = new SafePlaceModel();
		$result = $safePlaceModel->deleteSafePlace($safePlaceID);

		if(!empty($result)) {
			echo json_encode(["success" => "Habitat supprimé avec succès !"]);
		} else {
			echo json_encode(["error" => "Erreur lors de la suppression"]);
		}
	}

}