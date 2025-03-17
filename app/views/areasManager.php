<?php require_once "partials/header.php"; ?>
<main>
	<div class="areaModal-overlay"></div>
	<div class="areaModal">
		<div class="areaModal-addMethod">
			<div data-method="new" aria-label="Créer un nouveau">Créer un nouveau</div>
			<div data-method="list" aria-label="Utiliser un existant">Utiliser un existant</div>
			<div class="existingElement gallery areasDisplayer" aria-label="Liste des lieux existants">
				<h3>Liste des lieux existants</h3>
				<?php foreach($habitats as $habitat) { ?>
					<div data-type="habitats" data-habitatid="<?= htmlspecialchars($habitat->habitatID, ENT_QUOTES, 'UTF-8'); ?>" class="gallery-cardContainer-card">
						<img src="/bestiary/public/uploads/habitats/<?= htmlspecialchars($habitat->habitatPicture, ENT_QUOTES, 'UTF-8'); ?>" alt="Image de <?= htmlspecialchars($habitat->habitatName, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Image de <?= htmlspecialchars($habitat->habitatName, ENT_QUOTES, 'UTF-8'); ?>">
						<span>
							<p><?= htmlspecialchars($habitat->habitatName, ENT_QUOTES, 'UTF-8'); ?></p>
						</span>
					</div>
				<?php } ?>
				<?php foreach($safePlaces as $safePlace) { ?>
					<div data-type="safePlaces" data-safeplaceid="<?= htmlspecialchars($safePlace->safePlaceID, ENT_QUOTES, 'UTF-8'); ?>" class="gallery-cardContainer-card">
						<img src="/bestiary/public/uploads/safePlaces/<?= htmlspecialchars($safePlace->safePlacePicture, ENT_QUOTES, 'UTF-8'); ?>" alt="Image de <?= htmlspecialchars($safePlace->safePlaceName, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Image de <?= htmlspecialchars($safePlace->safePlaceName, ENT_QUOTES, 'UTF-8'); ?>">
						<span>
							<p><?= htmlspecialchars($safePlace->safePlaceName, ENT_QUOTES, 'UTF-8'); ?></p>
						</span>
					</div>
				<?php } ?>
			</div>
		</div>
		<i data-action="close" class="fa-solid fa-xmark" aria-label="Fermer la fenêtre"></i>
		<div class="areaModal-banner">
			<input type="file" id="addElementPicture" accept=".jpg, .jpeg, .png" required aria-label="Télécharger une image de l'élément">
			<label for="addElementPicture" aria-label="Télécharger votre image">
				<span>Télécharger votre image</span>
				<i class="fa-solid fa-upload" aria-hidden="true"></i>
				<span>Formats autorisés : .jpg, .jpeg, .png</span>
			</label>
			<div id="cropperContainer" class="hidden" aria-hidden="true">
				<img id="previewImage" alt="Aperçu de l'image">
			</div>
			<input type="hidden" id="monsterCroppedImageData">
		</div>
		<div class="areaModal-content">
			<i data-action="delete" class="fa-solid fa-trash" title="Supprimer l'élément" aria-label="Supprimer l'élément"></i>
			<h3><input type="text" id="addElementName" placeholder="Nom de la zone" aria-label="Nom de la zone"></h3>
			<div class="areaModal-content-pictureContainer">
				<ul class="areaModal-content-pictureContainer-list">
					<?php foreach($areas as $area) { ?>
						<li data-areaid="<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Zone: <?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?></li>
					<?php  } ?>
				</ul>
				<div class="areaModal-content-pictureContainer-add" aria-label="Ajouter une image à la zone">
					<?php foreach($areas as $area) { ?>
						<img data-areaid="<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>" src="/bestiary/public/uploads/areas/<?= htmlspecialchars($area->areaPicture, ENT_QUOTES, 'UTF-8'); ?>" alt="Image de <?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Image de <?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?>">
					<?php  } ?>
					<span class="addElementInfos">Cliquez sur la map pour ajouter</span>
				</div>
			</div>
		</div>
		<div class="areaModal-body-actions">
			<button aria-label="Ajouter un habitat">Ajouter habitat</button>
		</div>
	</div>
	<h2>Maps</h2>
	<nav class="submenu" data-menu="main" aria-label="Sous-menu des cartes">
		<ul>
			<li>
				<h3 class="active" data-container="habitats" aria-label="Afficher les habitats">Habitats</h3>
			</li>
			<li>
				<h3 data-container="safePlaces" aria-label="Afficher les zones de sécurité">Zones de sécurités</h3>
			</li>
		</ul>
	</nav>
	<div class="areasManager-content">
		<div class="gallery areasDisplayer active" data-container="habitats">
			<?php foreach($areas as $area) { ?>
				<h4><?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?></h4>
				<div data-areaid="<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>" class="gallery-cardContainer">
					<div class="gallery-cardContainer-card">
						<span data-type="habitats" data-areaname="<?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?>" data-areaid="<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>" class="addHabitat" aria-label="Ajouter un habitat">Ajouter</span>
					</div>
					<?php if(count($area->habitats) > 0) {
						$habitatInserted = [];
						foreach($area->habitats as $habitat) {
							if(in_array($habitat->habitatID, $habitatInserted)) {
								continue;
							}
							$habitatInserted[] = $habitat->habitatID;
					?>
							<div data-habitatid="<?= htmlspecialchars($habitat->habitatID, ENT_QUOTES, 'UTF-8'); ?>" data-type="habitats" class="gallery-cardContainer-card">
								<img src="/bestiary/public/uploads/habitats/<?= htmlspecialchars($habitat->habitatPicture, ENT_QUOTES, 'UTF-8'); ?>" alt="Image de <?= htmlspecialchars($habitat->habitatName, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Image de <?= htmlspecialchars($habitat->habitatName, ENT_QUOTES, 'UTF-8'); ?>">
								<span>
									<p><?= htmlspecialchars($habitat->habitatName, ENT_QUOTES, 'UTF-8'); ?></p>
									<i class="fa-solid fa-pen" aria-label="Modifier"></i>
								</span>
							</div>
					<?php }
					} ?>
				</div>
			<?php } ?>
		</div>
		<div class="gallery areasDisplayer" data-container="safePlaces">
			<?php foreach($areas as $area) { ?>
				<h4><?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?></h4>
				<div data-areaid="<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>" class="gallery-cardContainer">
					<div class="gallery-cardContainer-card">
						<span data-type="safePlaces" data-areaname="<?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?>" data-areaid="<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>" class="addSafePlace" aria-label="Ajouter une zone de sécurité">Ajouter</span>
					</div>
					<?php if(count($area->safePlaces) > 0) {
						$safePlacesInserted = [];
						foreach($area->safePlaces as $safePlace) {
							if(in_array($safePlace->safePlaceID, $safePlacesInserted)) {
								continue;
							}
							$safePlacesInserted[] = $safePlace->safePlaceID;
					?>
							<div data-safePlaceid="<?= htmlspecialchars($safePlace->safePlaceID, ENT_QUOTES, 'UTF-8'); ?>" data-type="safePlaces" class="gallery-cardContainer-card">
								<img src="/bestiary/public/uploads/safePlaces/<?= htmlspecialchars($safePlace->safePlacePicture, ENT_QUOTES, 'UTF-8'); ?>" alt="Image de <?= htmlspecialchars($safePlace->safePlaceName, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Image de <?= htmlspecialchars($safePlace->safePlaceName, ENT_QUOTES, 'UTF-8'); ?>">
								<span>
									<p><?= htmlspecialchars($safePlace->safePlaceName, ENT_QUOTES, 'UTF-8'); ?></p>
									<i class="fa-solid fa-pen" aria-label="Modifier"></i>
								</span>
							</div>
					<?php }
					} ?>
				</div>
			<?php } ?>
		</div>
	</div>
</main>

<?php if($url == "areasManager") { ?>
	<script src='/bestiary/public/js/areasManager.js' defer></script>
<?php } ?>
</body>