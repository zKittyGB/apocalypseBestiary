<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bestiary/core/Controller.php';


class HomeController extends Controller
{
	public function index()
	{
		if(isset($_SESSION['loggedAs']) && $_SESSION['loggedAs'] == 'admin') {
			header("Location: http://www.zkittygb.fr/bestiary/public/?url=slideshowManager");
			exit;
		}

		// Affiche la vue home.php
		$this->view('home');
	}
}
