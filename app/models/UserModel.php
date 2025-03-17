<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/config/database.php";

class UserModel
{
	private PDO $db;

	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	public function getUserByEmail(string $email): ?object
	{
		$stmt = $this->db->prepare("SELECT * FROM bestiaryUsers WHERE userMail = :email LIMIT 1");
		$stmt->execute(["email" => $email]);
		$user = $stmt->fetch(PDO::FETCH_OBJ);

		// Retourne null si aucun utilisateur trouvé
		return $user ? $user : null; 
	}

	public function register($lastName, $firstName, $email, $password): bool|array
	{
		// Vérifier si l"email existe déjà
		$stmt = $this->db->prepare("SELECT userID FROM bestiaryUsers WHERE userMail = :userMail");
		$stmt->execute([":userMail" => $email]);
		if ($stmt->fetch()) {
		  	return ["error" => "Email déjà utilisé"];
		}
	
		// Hasher le mot de passe
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	
		// Insérer l"utilisateur en base
		$stmt = $this->db->prepare("INSERT INTO bestiaryUsers (userLastName, userFirstName, userMail, userPassword) VALUES (:userLastName, :userFirstName, :userMail, :userPassword)"); 
		
		return $stmt->execute([
			":userLastName" => $lastName,
			":userFirstName" => $firstName,
			":userMail" => $email,
			":userPassword" => $hashedPassword
		]);
	}
}
