<!-- views/slideshow.php -->
<div class="slideshow-container">
	<?php if(isset($this->slides) && is_array($this->slides)) { ?>
		<?php foreach($this->slides as $slide) { ?>
			<img class="slide"
				data-monsterid="<?= htmlspecialchars($slide->monsterID, ENT_QUOTES, 'UTF-8'); ?>"
				src="/bestiary/public/uploads/monsters/<?= htmlspecialchars($slide->monsterPicture, ENT_QUOTES, 'UTF-8'); ?>"
				alt="<?= htmlspecialchars($slide->monsterName, ENT_QUOTES, 'UTF-8'); ?> - Image du monstre"
				aria-label="Image de <?= htmlspecialchars($slide->monsterName, ENT_QUOTES, 'UTF-8'); ?>">

			<div data-monsterid="<?= htmlspecialchars($slide->monsterID, ENT_QUOTES, 'UTF-8'); ?>">
				<span class="slideshow-container-name" aria-label="Nom du monstre"><?= htmlspecialchars($slide->monsterName, ENT_QUOTES, 'UTF-8'); ?></span>
				<span class="slideshow-container-danger" aria-label="Niveau de danger">Danger <?= htmlspecialchars($slide->dangerValue, ENT_QUOTES, 'UTF-8'); ?></span>
			</div>
		<?php }
	} else { ?>
		<p>Pas de slide enregistrée.</p>
	<?php } ?>
	<div class="searchResults gallery"></div>
</div>

<script src="/bestiary/public/js/slideshow.js" defer></script>