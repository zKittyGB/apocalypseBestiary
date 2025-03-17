<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/models/SlideshowModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';


class SlideshowController extends Controller
{
	private static ?SlideshowController $instance = null;
	private array $slides;

	public function show()
	{
		$slideshowModel = new SlideshowModel();
		$this->slides = $slideshowModel->getSlides();
		
		include $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/views/partials/slideshow.php';
	}

	public function adminDisplayer()
	{
		if(!isset($_SESSION['loggedAs']) || $_SESSION['loggedAs'] !== 'admin') {
			header("Location: http://www.zkittygb.fr/bestiary/public/?url=home");
		}

		$slideshowModel = new SlideshowModel();
		$this->slides = $slideshowModel->getSlides();

		// Affiche la vue login.php
		$this->view('slideshowManager',["slides" => $this->slides]);
	}

	public static function getInstance(): SlideshowController
	{
		if (self::$instance === null) {
			self::$instance = new SlideshowController();
		}
	   	 return self::$instance;
	}

	public function addSlide()
	{
		if (empty($_POST["monsterID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$monsterID = $_POST["monsterID"];

		// Envoi des données au modèle
		$slideshowModel = new SlideshowModel();

		$result = $slideshowModel->insertSlide($monsterID);
		
		if(!$result) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Slide ajouté avec succès !"]);
	}

	public function deleteSlide() 
	{
		if (empty($_POST["monsterID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		// Envoi des données au modèle
		$slideshowModel = new SlideshowModel();

		$result = $slideshowModel->deleteSlide($_POST["monsterID"]);
		
		if(!$result) {
			die(json_encode(["error" => "Erreur lors de la sauvegarde"]));
		}

		echo json_encode(["success" => "Slide supprimée avec succès !"]);
	}


}
