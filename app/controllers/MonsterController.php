<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/core/Controller.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/MonsterModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/RankModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/SkillModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/DangerModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/AreaModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/TypeModel.php";


class MonsterController extends Controller
{
	private array $bestiary;
	private array $ranks;
	private array $skills;
	private array $dangers;
	private array $areas;
	private array $types;

	public function userDisplayer()
	{
		if(isset($_SESSION["loggedAs"]) && $_SESSION["loggedAs"] == "admin") {
			header("Location: http://www.zkittygb.fr/bestiary/public/?url=bestiaryManager");
			exit;
		}

		$targetID = isset($_POST["elementID"]) ? $_POST["elementID"] : null;

		$monsterModel = new MonsterModel();
		$this->bestiary = $monsterModel->getBestiary();

		$rankModel = new RankModel();
		$this->ranks = $rankModel::getRanks();

		$dangerModel = new DangerModel();
		$this->dangers = $dangerModel::getDangers();

		$areaModel = new AreaModel();
		$this->areas = $areaModel::getAreas();

		// Affiche la vue home.php
		$this->view("bestiary", ["bestiary" => $this->bestiary, "ranks" => $this->ranks, "dangers" => $this->dangers, "areas" => $this->areas, "targetID" => $targetID]);
	}

	public function adminDisplayer()
	{
		if(!isset($_SESSION["loggedAs"]) || $_SESSION["loggedAs"] !== "admin") {
			header("Location: http://www.zkittygb.fr/bestiary/public/?url=home");
			exit;
		}

		$monsterModel = new MonsterModel();
		$this->bestiary = $monsterModel->getBestiary();

		$rankModel = new RankModel();
		$this->ranks = $rankModel::getRanks();

		$skillModel = new SkillModel();
		$this->skills = $skillModel::getSkillsByTypes();

		$dangerModel = new DangerModel();
		$this->dangers = $dangerModel::getDangers();

		$areaModel = new AreaModel();
		$this->areas = $areaModel::getAreas();

		$typeModel = new TypeModel();
		$this->types = $typeModel::getTypes();

		// Affiche la vue home.php
		$this->view("bestiaryManager", ["bestiary" => $this->bestiary, "ranks" => $this->ranks, "skillsByTypes" => $this->skills, "dangers" => $this->dangers, "areas" => $this->areas, "types" => $this->types]);
	}

	static function getBestiary()
	{
		$monsterModel = new MonsterModel();
		$bestiary = $monsterModel->getBestiary();

		echo json_encode(["bestiary" => $bestiary]);
	}

	public function getMonsterByID()
	{
		if(empty($_POST["monsterID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$monsterID = $_POST["monsterID"];
		$monsterModel = new MonsterModel();
		$monster = $monsterModel->getMonsterByID($monsterID);

		echo json_encode(["monster" => $monster]);
	}

	public function addMonster()
	{
		if($_SERVER["REQUEST_METHOD"] === "POST") {
			$requiredElements = ["monsterName", "monsterHabitat", "monsterDanger", "monsterArea", "monsterRank", "monsterType"];
			foreach ($requiredElements as $element) {
				if(empty($_POST[$element])) {
					die(json_encode(["error" => "Données manquantes"]));
				}
			}

			// Vérifier si un fichier est envoyé et le traiter
			if(empty($_FILES["monsterPicture"])) {
				die(json_encode(["error" => "Données manquantes"]));
			}

			$file = $_FILES["monsterPicture"];

			// Vérifier l"extension du fichier
			$allowedExtensions = ["jpg", "jpeg", "png"];
			$fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

			if(!in_array($fileExtension, $allowedExtensions)) {
				die(json_encode(["error" => "Format de fichier non autorisé"]));
			}

			// Déplacer le fichier
			$uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/bestiary/public/uploads/monsters/";
			$newFileName = uniqid("monster_") . "." . $fileExtension;
			$filePath = $uploadDir . $newFileName;

			if(!move_uploaded_file($file["tmp_name"], $filePath)) {
				die(json_encode(["error" => "Échec du déplacement du fichier"]));
			}

			// Ajouter le chemin du fichier aux données
			$_POST["monsterPicture"] = "/bestiary/public/uploads/" . $newFileName;

			// Préparation des autres data
			$monsterData = [
				"monsterName" => $_POST["monsterName"],
				"monsterHabitat" => $_POST["monsterHabitat"],
				"monsterDanger" => $_POST["monsterDanger"],
				"monsterArea" => $_POST["monsterArea"],
				"monsterRank" => $_POST["monsterRank"],
				"monsterMaster" => $_POST["monsterMaster"],
				"monsterType" => $_POST["monsterType"],
				"monsterSkills" => $_POST["monsterSkills"],
				"monsterDescription" => $_POST["monsterDescription"],
				"monsterBehavior" => $_POST["monsterBehavior"],
				"monsterStrengthes" => json_decode($_POST["monsterStrengthes"], true),
				"monsterWeaknesses" => json_decode($_POST["monsterWeaknesses"], true),
				"monsterAdvice" => $_POST["monsterAdvice"],
				"monsterPicture" => $newFileName, // Path de l"image
			];


			// Envoi des données au modèle
			$monsterModel = new MonsterModel();
			$monster = $monsterModel->insertMonster($monsterData);
			if(!empty($monster)) {
				echo json_encode(["success" => "Monstre ajouté avec succès !", "monster" => $monster]);
			} else {
				echo json_encode(["error" => "Erreur lors de l'ajout du monstre", "monster" => $monster]);
			}
		}
	}
	public function updateMonster()
	{
		if($_SERVER["REQUEST_METHOD"] === "POST") {
			// Vérification de la présence du monsterID
			if(empty($_POST["monsterID"])) {
				die(json_encode(["error" => "Identifiant du monstre manquant"]));
			}

			$monsterID = $_POST["monsterID"];

			// Vérification qu'il y a au moins un champ à mettre à jour
			$fieldsToUpdate = ["monsterName", "monsterHabitat", "monsterDanger", "monsterArea", "monsterRank", "monsterType", "monsterMaster", "monsterSkills", "monsterDescription", "monsterBehavior", "monsterStrengthes", "monsterWeaknesses", "monsterAdvice"];
			$updateData = [];

			// Parcours des éléments et ajout uniquement des éléments qui ont été modifiés
			foreach ($fieldsToUpdate as $field) {
				if(!empty($_POST[$field])) {
					$updateData[$field] = $_POST[$field];
				}
			}

			// Si aucune donnée n'est envoyée, on arrête la requête
			if(empty($updateData)) {
				die(json_encode(["error" => "Aucune donnée à mettre à jour"]));
			}

			// Traitement des données attendu en tant que tableau
			if(isset($updateData["monsterSkills"])) {
				$updateData["monsterSkills"] = json_decode($updateData["monsterSkills"], true);
			}

			if(isset($updateData["monsterStrengthes"])) {
				$updateData["monsterStrengthes"] = json_decode($updateData["monsterStrengthes"], true);
			}

			if(isset($updateData["monsterWeaknesses"])) {
				$updateData["monsterWeaknesses"] = json_decode($updateData["monsterWeaknesses"], true);
			}

			// Envoi des données au modèle pour mise à jour
			$monsterModel = new MonsterModel();
			$updatedMonster = $monsterModel->updateMonster($monsterID, $updateData);

			if($updatedMonster) {
				echo json_encode(["success" => "Monstre mis à jour avec succès !"]);
			} else {
				echo json_encode(["error" => "Erreur lors de la mise à jour du monstre"]);
			}
		}
	}
	public function deleteMonster()
	{
		if($_SERVER["REQUEST_METHOD"] === "POST") {
			// Vérification de la présence du monsterID
			if(empty($_POST["monsterID"])) {
				die(json_encode(["error" => "Identifiant du monstre manquant"]));
			}

			$monsterID = $_POST["monsterID"];

			// Envoi des données au modèle pour mise à jour
			$monsterModel = new MonsterModel();
			$updatedMonster = $monsterModel->deleteMonster($monsterID);

			if($updatedMonster) {
				echo json_encode(["success" => "Monstre supprimé avec succès !"]);
			} else {
				echo json_encode(["error" => "Erreur lors de la suppréssion du monstre"]);
			}
		}
	}
}
