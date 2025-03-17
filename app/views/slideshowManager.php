<?php require_once "partials/header.php"; ?>
<main>
	<h2>Slideshow</h2>
	<div class="content">
		<div class="gallery">
			<div class="gallery-cardContainer">
				<div class="gallery-cardContainer-card">
					<span data-action="add" class="addSlide" aria-label="Ajouter une nouvelle slide">Ajouter</span>
				</div>
				<?php if(isset($slides)) {
					foreach($slides as $slide) { ?>
						<div class="gallery-cardContainer-card" data-monsterid="<?= $slide->monsterID; ?>" aria-label="Slide de <?= htmlspecialchars($slide->monsterName); ?>">
							<img src="/bestiary/public/uploads/monsters/<?= htmlspecialchars($slide->monsterPicture); ?>" alt="Image de <?= htmlspecialchars($slide->monsterName); ?>" aria-label="Image de <?= htmlspecialchars($slide->monsterName); ?>">
							<span data-action="delete" aria-label="Supprimer cette slide">
								<p><?= htmlspecialchars($slide->monsterName); ?></p>
								<i class="fa-solid fa-trash" aria-hidden="true"></i>
							</span>
						</div>
				<?php }
				} ?>
			</div>
		</div>
	</div>
	<div class="addSlideModal">
		<i class="fa-solid fa-xmark addSlideModal-close" aria-label="Fermer la modale"></i>
		<h2>Ajout une slide</h2>
		<div class="gallery"></div>
	</div>
</main>
<?php if($url == "slideshowManager") { ?>
	<script src='/bestiary/public/js/slideshowManager.js' defer></script>
<?php } ?>
</body>