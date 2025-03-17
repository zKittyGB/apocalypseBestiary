<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/models/TypeModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';

class TypeController {
	public function getTypeByID() {
		if (empty($_POST["typeID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$typeID = $_POST["typeID"];

		// Envoi des données au modèle
		$typeModel = new TypeModel();

		$type = $typeModel->getTypeByID($typeID);

		return $type;
	}

	public function addType() {
		if (empty($_POST["addElementValue"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$typeName = $_POST["addElementValue"];

		// Envoi des données au modèle
		$typeModel = new TypeModel();

		$insertID = $typeModel->insertType($typeName);

		if(!$insertID) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Type ajouté avec succès !", "elementAdded" => $insertID]);
	}

	public function editTypeName() {
		// Si vide, ou si différent de All et n'est pas un int
		if (empty($_POST["elemID"]) || empty($_POST["value"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$typeName = $_POST["value"];
		$typeID = $_POST["elemID"];

		// Envoi des données au modèle
		$typeModel = new TypeModel();

		$result = $typeModel->editTypeName($typeName, $typeID);
		
		if(!$result) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Type modifié avec succès !"]);
	}

	public function deleteTypes() {
		// Si vide, ou si différent de All et n'est pas un int
		if (empty($_POST["deleteElements"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		// Stock "all" ou l'ID décrypté
		$deleteElements = $_POST["deleteElements"];

		// Envoi des données au modèle
		$typeModel = new TypeModel();

		$result = $typeModel->deleteTypes($deleteElements);

		if(!$result) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Type(s) supprimé(s) avec succès !"]);
	}
}