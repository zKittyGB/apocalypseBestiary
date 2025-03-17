<?php
class Controller
{
	public function __construct()
	{
		// Vérifie si la session est déjà démarrée avant de l'initialiser
		if (session_status() === PHP_SESSION_NONE) {
			session_start();  // Démarre la session uniquement si elle n'est pas déjà démarrée
		}
	}

	// Cette méthode inclut le fichier de la vue et passe les données à la vue
	public function view($viewName, $data = [])
	{
		// Extrait les données dans des variables individuelles
		extract($data); // Cela transforme un tableau associatif en variables

		// Inclure le fichier de la vue (par exemple: views/home.php)
		include_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/views/" . $viewName . ".php"; 
	}

	// Fonction de débogage (affichage propre des données)
	public static function printr($value)
	{
		echo "<pre class='printr'>";
		print_r($value);
		echo "</pre>";
	}

	static function encryptString($value) {
		return bin2hex(openssl_encrypt($value, "aes128", "afb88c7e103a0caaa96574123da654d5f6bce3aad12d99ab5d6e5fb001b2defa", OPENSSL_RAW_DATA, "a58KlO---!jKil5?"));
	}

	static function decryptString($value) {
		$crypted = hex2bin($value);
		return openssl_decrypt($crypted, "aes128", "afb88c7e103a0caaa96574123da654d5f6bce3aad12d99ab5d6e5fb001b2defa", OPENSSL_RAW_DATA, "a58KlO---!jKil5?");
	}
	
}
