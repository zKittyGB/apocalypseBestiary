<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/bestiary/app/controllers/SlideshowController.php";

// Sanitize and validate URL
$url = isset($_GET["url"]) ? htmlspecialchars($_GET["url"]) : null;

// Sanitize user first name and last name
$userFirstName = isset($_SESSION["userFirstName"]) ? htmlspecialchars($_SESSION["userFirstName"]) : null;

if($userFirstName) {
	$isAdmin = $_SESSION["userIsAdmin"];
	$userLastName = isset($_SESSION["userLastName"]) ? htmlspecialchars($_SESSION["userLastName"]) : null;
}

// Créer une instance du contrôleur Slideshow si aucune n'existe
$slideshowController = SlideshowController::getInstance();

// Condition d'administration
$isAdminCondition = (isset($_SESSION["loggedAs"]) && $_SESSION["loggedAs"] == "admin");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="https://www.zkittygb.fr/bestiary/public/images/favicon.png" type="image/x-icon">
	<title>Bestiaire de l'apocalypse</title>
	<link rel="stylesheet" type="text/css" href="/bestiary/public/css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<?php if($url == "login" || $url == "logAs" || $url == "register") { ?>
		<link rel="stylesheet" type="text/css" href="/bestiary/public/css/login.css">
	<?php } ?>
	<?php if($isAdminCondition) { ?>
		<link rel="stylesheet" type="text/css" href="/bestiary/public/css/admin.css">
		<!-- Cropper.js (CSS & JS via CDN) -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
	<?php } ?>
	<?php if($url == "glossary") { ?>
		<link rel="stylesheet" type="text/css" href="/bestiary/public/css/glossary.css">
	<?php } ?>
	<?php if($url == "areas") { ?>
		<link rel="stylesheet" type="text/css" href="/bestiary/public/css/areas.css">
	<?php } ?>
	<?php if($url == "slideshowManager") { ?>
		<link rel="stylesheet" type="text/css" href="/bestiary/public/css/slideshowManager.css">
	<?php } ?>
	<?php if($url == "bestiary" || $url == "bestiaryManager") { ?>
		<link rel="stylesheet" type="text/css" href="/bestiary/public/css/monsterManager.css">
	<?php } ?>
	<?php if($url == "areasManager") { ?>
		<link rel="stylesheet" type="text/css" href="/bestiary/public/css/areasManager.css">
	<?php } ?>
	<?php if($url == "bestiary") { ?>
		<link rel="stylesheet" type="text/css" href="/bestiary/public/css/bestiary.css">
		<!-- Inclure le CSS de Balkan OrgChart -->
		<script src="https://cdn.balkan.app/orgchart.js"></script>
	<?php } ?>
	<script src='/bestiary/public/js/menu.js' defer></script>
</head>

<body data-page="<?= $url; ?>" class="<?= $isAdminCondition ? 'isAdmin' : ''; ?>">
	<header class="header">
		<div class="header-banner">
			<a href="http://www.zkittygb.fr/" aria-label="Retour à l'accueil"><img src="/bestiary/public/images/logo.png" alt="logo"></a>
			<h1>Le bestiaire <span>de l'apocalypse</span></h1>
		</div>
		<div class="header-menu-border"></div>
		<div class="header-menu">
			<nav>
				<ul>
					<?php if(!isset($_SESSION["loggedAs"]) || $_SESSION["loggedAs"] == "user") { ?>
						<li>
							<h2 class="<?= $url == "bestiary" ? 'active' : ''; ?>"><a href="http://www.zkittygb.fr/bestiary/public/?url=bestiary" aria-label="Voir le bestiaire">Bestiaire</a></h2>
						</li>
						<li>
							<h2 class="<?= $url == "areas" ? 'active' : ''; ?>"><a href="http://www.zkittygb.fr/bestiary/public/?url=areas" aria-label="Voir les cartes">Cartes</a></h2>
						</li>
						<li>
							<h2 class="<?= $url == "glossary" ? 'active' : ''; ?>"><a href="http://www.zkittygb.fr/bestiary/public/?url=glossary" aria-label="Voir le glossaire">Glossaire</a></h2>
						</li>
					<?php } else { ?>
						<li>
							<h2 class="<?= $url == "slideshowManager" ? 'active' : ''; ?>"><a href="http://www.zkittygb.fr/bestiary/public/?url=slideshowManager" aria-label="Gérer les slideshows">Slideshow</a></h2>
						</li>
						<li>
							<h2 class="<?= $url == "bestiaryManager" ? 'active' : ''; ?>"><a href="http://www.zkittygb.fr/bestiary/public/?url=bestiaryManager" aria-label="Gérer le bestiaire">Bestiaire</a></h2>
						</li>
						<li>
							<h2 class="<?= $url == "areasManager" ? 'active' : ''; ?>"><a href="http://www.zkittygb.fr/bestiary/public/?url=areasManager" aria-label="Gérer les cartes">Maps</a></h2>
						</li>
						<li>
							<h2 class="<?= $url == "glossaryManager" ? 'active' : ''; ?>"><a href="http://www.zkittygb.fr/bestiary/public/?url=glossaryManager" aria-label="Gérer le glossaire">Glossaire</a></h2>
						</li>
					<?php }
					if(!$userFirstName) { ?>
						<li class="header-menu-login">
							<h2><a href="http://www.zkittygb.fr/bestiary/public/?url=login" aria-label="Se connecter">Connexion</a></h2>
						</li>
					<?php } else { ?>
						<li class="header-menu-logout">
							<h2><a href="http://www.zkittygb.fr/bestiary/public/?url=logout" aria-label="Se déconnecter">Déconnexion</a></h2>
						</li>
					<?php } ?>
				</ul>
			</nav>
		</div>
		<i data-state="close" class="fa-solid fa-bars fa-2xl" aria-label="Menu"></i>
		<?php if($url == "slideshowManager" || !$isAdminCondition) { ?>
			<div class="header-slideshow-Research">
				<?php
				// Afficher le slideshow dans le header
				$slideshowController->show();
				?>
				<div class="search-container">
					<input id="search" type="text" placeholder="Rechercher" aria-label="Rechercher">
					<label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
				</div>
			</div>
		<?php } ?>
		<?php if(!$userFirstName) { ?>
			<a href="http://www.zkittygb.fr/bestiary/public/?url=login" aria-label="Se connecter"><i id="login" class="fa-solid fa-user fa-2xl"></i></a>
		<?php } else { ?>
			<div id="userName" aria-label="Profil de l'utilisateur">
				<span><?= $userFirstName . " " . strtoupper(substr($userLastName, 0, 1)) . "."; ?><i class="fa-solid fa-gear"></i></span>
				<div id="logout"><a href="http://www.zkittygb.fr/bestiary/public/?url=logout" aria-label="Se déconnecter">Se déconnecter</a></div>
			</div>
		<?php } ?>
	</header>
	<?php if(!$isAdminCondition) { ?>
		<script src='/bestiary/public/js/research.js' defer></script>
	<?php } ?>
</body>

</html>