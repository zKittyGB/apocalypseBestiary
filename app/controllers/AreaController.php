<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/core/Controller.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/AreaModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/MonsterModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/HabitatModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/SafePlaceModel.php";


class AreaController extends Controller
{
	private array $habitats;
	private array $safePlaces;
	private array $areas;
	private array $monsters;

	public function userDisplayer()
	{
		if(isset($_SESSION["loggedAs"]) && $_SESSION["loggedAs"] == "admin") {
			header("Location: http://www.zkittygb.fr/bestiary/public/?url=areasManager");
			exit;
		}
		
		$targetID = isset($_POST["elementID"]) ? $_POST["elementID"] : null;

		$areaModel = new AreaModel();
		$this->areas = $areaModel::getAreas();
		
		// Affiche la vue home.php
		$this->view("areas", ["areas" => $this->areas, "targetID" => $targetID]);
	}

	public function getPlacesByAreaID() {
		if(empty($_POST["areaID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$areaID = $_POST["areaID"];

		$areaModel = new AreaModel();
		$area = $areaModel->getAreaByID($areaID);

		$monsterModel = new MonsterModel();
		$this->monsters = $monsterModel->getMonstersByAreaID($areaID);

		$habitatModel = new HabitatModel();
		$this->habitats = $habitatModel->getAreaHabitats($areaID);
		
		$safePlaceModel = new SafePlaceModel();
		$this->safePlaces = $safePlaceModel->getAreaSafePlaces($areaID);
			
		echo json_encode(["area" => $area, "monsters" => $this->monsters, "habitats" => $this->habitats, "safePlaces" => $this->safePlaces]);
	}

	public function adminDisplayer()
	{
		if(!isset($_SESSION["loggedAs"]) || $_SESSION["loggedAs"] !== "admin") {
			header("Location: http://www.zkittygb.fr/bestiary/public/?url=areas");
			exit;
		}
		
		$areaModel = new AreaModel();
		$this->areas = $areaModel::getAreas();

		$habitatModel = new HabitatModel();
		$this->habitats = $habitatModel->getHabitats();

		$safePlaceModel = new SafePlaceModel();
		$this->safePlaces = $safePlaceModel->getSafePlaces();

		if(count($this->areas) != 0) {
			foreach($this->areas as $area) {
				$area->habitats = $habitatModel->getAreaHabitats($area->areaID);
				$area->safePlaces = $safePlaceModel->getAreaSafePlaces($area->areaID);
			}
		}

		// Affiche la vue home.php
		$this->view("areasManager", ["areas" => $this->areas, "habitats" => $this->habitats, "safePlaces" => $this->safePlaces]);
	}

	static function getAreas() 
	{
		$areaModel = new AreaModel();
		$areas = $areaModel->getAreas();

		echo json_encode(["areas" => $areas]);
	}

	public function getAreaByID() 
	{
		if (empty($_POST["areaID"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$areaID = $_POST["areaID"];
		$areaModel = new AreaModel();
		$area = $areaModel->getAreaByID($areaID);

		echo json_encode(["area" => $area]);
	}
}
