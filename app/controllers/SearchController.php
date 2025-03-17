<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/bestiary/app/models/SearchModel.php';

class SearchController {
	public function getMatches() 
	{
		if (empty($_POST["searchValue"])) {
			die(json_encode(["error" => "Données manquantes"]));
		}

		$searchValue = $_POST["searchValue"];

		$searchModel = new SearchModel();
		$matches = $searchModel->getMatches($searchValue);

		echo json_encode($matches);
	}
}