<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/models/GlossaryModel.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/core/Controller.php";

class GlossaryController extends Controller {
	
	public function userDisplayer()
	{
		if(isset($_SESSION["loggedAs"]) && $_SESSION["loggedAs"] == "admin") {
			header("Location: http://www.zkittygb.fr/bestiary/public/?url=glossaryManager");
			exit;
		}

		$glossaryWords = $this->getGlossary();

		// Affiche la vue home.php
		$this->view('glossary', ["glossaryWords" => $glossaryWords]);
	}
	public function adminDisplayer()
	{
		if(!isset($_SESSION["loggedAs"]) || $_SESSION["loggedAs"] !== "admin") {
			header("Location: http://www.zkittygb.fr/bestiary/public/?url=home");
			exit;
		}

		$glossaryWord = $this->getGlossary();

		// Affiche la vue home.php
		$this->view('glossaryManager', ["glossaryWords" => $glossaryWord]);
	}

	public function getGlossary() 
	{
		$glossaryModel = new GlossaryModel();
		return $glossaryModel->getGlossary();
	}

	public function addWord() 
	{
		if (empty($_POST["wordValue"]) || empty($_POST["definitionValue"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$wordValue = $_POST["wordValue"];
		$definitionValue = $_POST["definitionValue"];

		// Envoi des données au modèle
		$glossaryModel = new GlossaryModel();

		$wordID = $glossaryModel->insertWord($wordValue, $definitionValue);
		
		if(!$wordID) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Compétence ajoutée avec succès !", "wordID" => $wordID]);
	}

	public function editGlossaryWord() 
	{
		// Si vide, ou si différent de All et n'est pas un int
		if (empty($_POST["wordID"]) || empty($_POST["wordValue"] || empty($_POST["definitionValue"]))) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$wordID = $_POST["wordID"];
		$wordValue = $_POST["wordValue"];
		$definitionValue = $_POST["definitionValue"];

		// Envoi des données au modèle
		$glossaryModel = new GlossaryModel();

		$result = $glossaryModel->editGlossaryWord($wordID, $wordValue, $definitionValue);
		
		if(!$result) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Mot du glossaire modifié avec succès !"]);
	}

	public function deleteWords() 
	{
		// Si vide, ou si différent de All et n'est pas un int
		if ((empty($_POST["wordID"]) && $_POST["action"] != "deleteAll") || ($_POST["action"]!= "delete" && $_POST["action"]!= "deleteAll")) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		// Stock "all" ou l'ID décrypté
		$deleteElements = !empty($_POST["wordID"]) ? $_POST["wordID"] : "deleteAll";

		// Envoi des données au modèle
		$glossaryModel = new GlossaryModel();

		$result = $glossaryModel->deleteWords($deleteElements);

		if(!$result) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Compétence(s) supprimée(s) avec succès !"]);
	}
}