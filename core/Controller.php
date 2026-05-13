<?php
class Controller
{
	public function __construct()
	{
		self::ensureSessionStarted();
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

	protected static function ensureSessionStarted(): void
	{
		if (session_status() === PHP_SESSION_NONE) {
			$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? null) == 443);
			ini_set('session.use_strict_mode', '1');
			session_set_cookie_params([
				'lifetime' => 0,
				'path' => '/',
				'secure' => $isHttps,
				'httponly' => true,
				'samesite' => 'Lax',
			]);
			session_start();
		}
	}

	protected static function secretKey(): string
	{
		$key = $_ENV['APP_KEY'] ?? $_SERVER['APP_KEY'] ?? getenv('APP_KEY');

		if (is_string($key) && $key !== '') {
			return $key;
		}

		self::ensureSessionStarted();
		if (empty($_SESSION['runtime_app_key'])) {
			$_SESSION['runtime_app_key'] = bin2hex(random_bytes(32));
			error_log('APP_KEY absent : utilisation d’une clé temporaire de session. Définissez APP_KEY en production.');
		}

		return $_SESSION['runtime_app_key'];
	}

	static function encryptString($value) {
		$key = hash('sha256', self::secretKey(), true);
		$iv = substr(hash('sha256', 'apocalypse-bestiary-ids-' . self::secretKey(), true), 0, 16);
		$encrypted = openssl_encrypt((string)$value, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

		return $encrypted === false ? '' : bin2hex($encrypted);
	}

	static function decryptString($value) {
		if (!is_string($value) || $value === '' || !ctype_xdigit($value) || strlen($value) % 2 !== 0) {
			return false;
		}

		$crypted = hex2bin($value);
		if ($crypted === false) {
			return false;
		}

		$key = hash('sha256', self::secretKey(), true);
		$iv = substr(hash('sha256', 'apocalypse-bestiary-ids-' . self::secretKey(), true), 0, 16);

		return openssl_decrypt($crypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
	}

	protected function requireAdmin(): void
	{
		if (empty($_SESSION['loggedAs']) || $_SESSION['loggedAs'] !== 'admin' || empty($_SESSION['userIsAdmin'])) {
			http_response_code(403);
			header('Content-Type: application/json');
			echo json_encode(['error' => 'Accès refusé']);
			exit;
		}
	}

	protected function validateUploadedImage(array $file, array $allowedExtensions = ['jpg', 'jpeg', 'png']): ?string
	{
		if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
			return null;
		}

		$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		if (!in_array($fileExtension, $allowedExtensions, true)) {
			return null;
		}

		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mimeType = $finfo->file($file['tmp_name']);
		$allowedMimeTypes = [
			'jpg' => ['image/jpeg'],
			'jpeg' => ['image/jpeg'],
			'png' => ['image/png'],
		];

		if (!in_array($mimeType, $allowedMimeTypes[$fileExtension] ?? [], true)) {
			return null;
		}

		return $fileExtension;
	}
	
}
