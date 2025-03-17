<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/models/SkillModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/app/controllers/TypeController.php';

class SkillController {
	public function getTypeSkills() 
	{
		header('Content-Type: application/json');
		
		$typeID = $_GET['typeID'] ? $_GET['typeID'] : null;

		if (!$typeID) {
			echo json_encode(['error' => 'Aucun typeID fourni']);
			exit;
		}

		$skillModel = new SkillModel();
		$skills = $skillModel->getTypeSkills($typeID);

		echo json_encode($skills);
	}

	public function addSkill() 
	{
		if (empty($_POST["addElementValue"]) || empty($_POST["typeID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$skillName = $_POST["addElementValue"];
		$typeID = $_POST["typeID"];

		// Vérifie que le type existe en DB
		$typeController = new TypeController();
		$type = $typeController->getTypeByID($typeID);

		if(!$type) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		// Envoi des données au modèle
		$skillModel = new SkillModel();

		$skill = $skillModel->insertSkill($skillName, $type);
		
		if(!$skill) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Compétence ajoutée avec succès !", "elementAdded" => $skill]);
	}

	public function editSkillName() 
	{
		// Si vide, ou si différent de All et n'est pas un int
		if (empty($_POST["elemID"]) || empty($_POST["value"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$skillName = $_POST["value"];
		$skillID = $_POST["elemID"];

		// Envoi des données au modèle
		$skillModel = new SkillModel();

		$result = $skillModel->editSkillName($skillName, $skillID);
		
		if(!$result) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Compétence modifiée avec succès !"]);
	}

	public function deleteSkills() 
	{
		// Si vide, ou si différent de All et n'est pas un int
		if (empty($_POST["deleteElements"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		// Stock "all" ou l'ID décrypté
		$deleteElements = $_POST["deleteElements"];

		// Envoi des données au modèle
		$skillModel = new SkillModel();

		$result = $skillModel->deleteSkills($deleteElements);

		if(!$result) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Compétence(s) supprimée(s) avec succès !"]);
	}
}