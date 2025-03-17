<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/models/UserModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/core/Controller.php";

class UserController extends Controller
{
	public function index()
	{
		// Affiche la vue login.php
		$this->view("login");
	}

	public function logAs()
	{
		if ($_SESSION["userIsAdmin"] != 1) {
			header("Location: https://www.zkittygb.fr/bestiary/public/?url=home");
		}

		// Affiche la vue login.php
		$this->view("logAs");
	}

	public function authenticate()
	{
		$model = new UserModel();

		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$email = $_POST["email"] ?? "";
			$password = $_POST["password"] ?? "";

			$user = $model->getUserByEmail($email);

			if ($user && password_verify($password, $user->userPassword)) {
				// Connexion réussie
				$_SESSION["userID"] = $user->userID;
				$_SESSION["userFirstName"] = $user->userFirstName;
				$_SESSION["userLastName"] = $user->userLastName;
				$_SESSION["userIsAdmin"] = $user->userIsAdmin;

				if ($_SESSION['userIsAdmin']) {
					header("Location: https://www.zkittygb.fr/bestiary/public/?url=logAs");
				} else {
					header("Location: https://www.zkittygb.fr/bestiary/public/?url=home");
				}
			} else {
				$_SESSION["login_error"] = "Email ou mot de passe incorrect.";
				header("Location: https://www.zkittygb.fr/bestiary/public/?url=login");
			}
		}
	}

	public function authenticateAs()
	{
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			// Vérifie si la valeur est bien envoyée
			if (!isset($_POST["logAs"]) || $_SESSION["userIsAdmin"] == 0) {
				$_SESSION["login_error"] = "Veuillez choisir un mode de connexion.";
				header("Location: https://www.zkittygb.fr/bestiary/public/?url=login");
				exit;
			}

			$logAs = $_POST["logAs"]; // "user" ou "admin"

			// Stocker le choix dans la session
			$_SESSION["loggedAs"] = $logAs;

			// Redirection selon le choix
			if ($logAs === "admin") {
				header("Location: https://www.zkittygb.fr/bestiary/public/?url=slideshowManager");
			} else {
				header("Location: https://www.zkittygb.fr/bestiary/public/?url=home");
			}
			exit;
		}
	}

	public function logout()
	{
		// Supprime toutes les variables de session
		$_SESSION = [];

		// Détruirt complètement la session, y compris le cookie de session
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				"",
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}

		// Détruit la session
		session_destroy();

		// Redirige vers la page de login ou une autre page
		header("Location: https://www.zkittygb.fr/bestiary/public/?url=home");
		exit;
	}

	public function register() {
		if (empty($_POST["lastName"]) || empty($_POST["firstName"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["confirmPassword"])) {
			http_response_code(400);
			echo json_encode(["success" => false, "error" => "Données manquantes"]);
			return;
		}
	    
		$lastName = trim($_POST["lastName"]);
		$firstName = trim($_POST["firstName"]);
		$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
		$password = $_POST["password"];
		$confirmPassword = $_POST["confirmPassword"];
		$errors = [];

		// Regex pour nom et prénom (2-50 lettres + espaces)
		if(!preg_match("/^[a-zA-ZÀ-ÿ\s-]{2,50}$/", $lastName)) {
			$errors["lastName"] = "Nom invalide (lettres et espaces uniquement, 2-50 caractères)"; 
		}

		if(!preg_match("/^[a-zA-ZÀ-ÿ\s-]{2,50}$/", $firstName)) {
			$errors["firstName"] = "Prénom invalide (lettres et espaces uniquement, 2-50 caractères)";
		}

		// Vérifie la validité du mail
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors["registerEmail"] = "Email invalide";
		}

		// Regex pour un mot de passe sécurisé (8-20 caractères, au moins une lettre, un chiffre et un caractère spécial)
		if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/", $password)) {
			$errors["registerPassword"] = "Le mot de passe doit contenir 8-20 caractères, avec au moins une lettre, un chiffre et un caractère spécial";
		}

		// Vérifie la concordance des mots de passe
		if($password !== $confirmPassword) {
			$errors["confirmRegisterPassword"] = "Les mots de passe ne correspondent pas";
		}

		if(!empty($errors)) {
			echo json_encode(["success" => false, "errors" => $errors]);
			exit;
		}
		// Création de l'utilisateur via le modèle
		$UserModel = new UserModel();
		$result = $UserModel->register($lastName, $firstName, $email, $password);

		if(isset($result["error"])) {
			$errors["registerEmail"] = $result["error"];
			echo json_encode(["success" => false, "errors" => $errors]);
			exit;
		}

		echo json_encode(["success" => "Compte créé avec succès"]);
	}
}
