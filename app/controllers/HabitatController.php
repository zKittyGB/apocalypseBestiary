<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/models/HabitatModel.php';


class HabitatController {
	static function getHabitats() {
		$habitatModel = new HabitatModel();
		$habitats = $habitatModel->getHabitats();

		echo json_encode($habitats);
	}

	public function getHabitat() {
		if(empty($_POST["habitatID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$habitatID = $_POST["habitatID"];

		// Envoi des données au modèle
		$habitatModel = new HabitatModel();
		$habitat = $habitatModel->getHabitat($habitatID);

		if(!empty($habitat)) {
			echo json_encode(["element" => $habitat]);
		} else {
			echo json_encode(["error" => "Erreur lors de la récupération"]);
		}
	}

	public function getAreaHabitats() {
		header('Content-Type: application/json');
		$areaID = $_GET['areaID'] ? $_GET['areaID'] : null;
		
		if (!$areaID) {
			echo json_encode(['error' => 'Aucun areaID fourni']);
			exit;
		}

		$habitatModel = new HabitatModel();
		$habitats = $habitatModel->getAreaHabitats($areaID);

		echo json_encode($habitats);
	}

	public function addHabitat() {
		if(empty($_POST["elementName"]) || empty($_FILES["elementPicture"]) || empty($_POST["coordinates"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$habitatName = $_POST["elementName"];
		$coordinates = json_decode($_POST["coordinates"], true);
		$file = $_FILES["elementPicture"];
		
		// Vérifier l"extension du fichier
		$allowedExtensions = ["jpg", "jpeg", "png"];
		$fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
	
		if (!in_array($fileExtension, $allowedExtensions)) {
			die(json_encode(["error" => "Format de fichier non autorisé"]));
		}
	
		// Déplacer le fichier
		$uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/bestiary/public/uploads/habitats/";
		$fileName = uniqid("habitats_") . "." . $fileExtension;
		$filePath = $uploadDir . $fileName;
	
		if (!move_uploaded_file($file["tmp_name"], $filePath)) {
			die(json_encode(["error" => "Échec du déplacement du fichier"]));
		}
		
		// Envoi des données au modèle
		$habitatModel = new HabitatModel();
		$habitat = $habitatModel->insertHabitat($habitatName, $coordinates, $fileName);
		if(!empty($habitat)) {
			echo json_encode(["success" => "Habitat ajouté avec succès !", "addedElement" => $habitat]);
		} else {
			echo json_encode(["error" => "Erreur lors de l'ajout de l'habitat"]);
		}
	}

	public function updateHabitat() {
		if(empty($_POST["elementID"]) || empty($_POST["coordinates"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$habitatID = $_POST["elementID"];
		$elementName = isset($_POST["elementName"]) ? $_POST["elementName"] : null;
		$coordinates = json_decode($_POST["coordinates"], true);
		
		// Envoi des données au modèle
		$habitatModel = new HabitatModel();
		$result = $habitatModel->updateHabitat($habitatID, $coordinates, $elementName);

		if(!empty($result)) {
			echo json_encode(["success" => "Habitat mit-à-jour avec succès !"]);
		} else {
			echo json_encode(["error" => "Erreur lors de la mise à jour"]);
		}
	}

	public function deleteHabitat() {
		if(empty($_POST["elementID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$habitatID = $_POST["elementID"];
		
		// Envoi des données au modèle
		$habitatModel = new HabitatModel();
		$result = $habitatModel->deleteHabitat($habitatID);

		if(!empty($result)) {
			echo json_encode(["success" => "Habitat supprimé avec succès !"]);
		} else {
			echo json_encode(["error" => "Erreur lors de la suppression"]);
		}
	}

}