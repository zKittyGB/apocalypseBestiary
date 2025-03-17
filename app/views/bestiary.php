<?php require_once "partials/header.php"; ?>
<main data-targetid="<?= htmlspecialchars($targetID ?? '', ENT_QUOTES, 'UTF-8'); ?>">
	<div class="monsterModal-overlay"></div>
	<div class="monsterModal">
		<i data-action="close" class="fa-solid fa-xmark" aria-label="Fermer"></i>
		<div class="monsterModal-banner">
			<div id="cropperContainer" class="hidden">
				<img id="previewImage" alt="Aperçu de l'image">
			</div>
		</div>
		<h1 data-content="monsterName" aria-label="Nom du monstre"></h1>
		<div class="monsterModal-details">
			<div class="monsterModal-details-content">
				<div data-element="rank">
					<p>Grade : <span data-content="rankValue"></span></p>
				</div>
				<div data-element="danger">
					<p>Danger : <span data-content="dangerValue"></span></p>
				</div>
				<div data-element="type">
					<p>Type : <span data-content="typeName"></span></p>
				</div>
			</div>

			<div class="monsterModal-details-content">
				<div data-element="master">
					<p>Maître : <span data-content="monsterMasterName"></span></p>
				</div>
				<div data-element="area">
					<p>Zone : <span data-content="areaName"></span></p>
				</div>
				<div data-element="habitat">
					<p>Habitat : <span data-content="habitatName"></span></p>
				</div>
			</div>
		</div>
		<div class="monsterModal-body">
			<div class="monsterModal-body-menu">
				<ul>
					<li data-container="descriptions" aria-label="Voir les descriptions"><i class="fa-solid fa-info"></i></li>
					<li data-container="strengthes" aria-label="Voir les forces et faiblesses"><i class="fa-solid fa-hand-fist"></i></li>
				</ul>
			</div>
			<div class="monsterModal-body-content">
				<div data-container="descriptions" class="monsterModal-body-content-sheets">
					<div class="monsterModal-body-content-sheets-textareaContainer">
						<p>Description : </p>
						<span data-content="monsterDescription"></span>
					</div>
					<div class="monsterModal-body-content-sheets-textareaContainer">
						<p>Comportement : </p>
						<span data-content="monsterBehavior"></span>
					</div>
				</div>
				<div data-container="strengthes" class="monsterModal-body-content-sheets">
					<div class="monsterModal-body-content-sheets-skills">
						<p>Compétences :</p>
						<div class="monsterModal-body-content-sheets-skills-container">
							<ul class="monsterModal-body-content-sheets-skills-container-skillsList">
								<li></li>
								<li></li>
								<li></li>
							</ul>
							<ul class="monsterModal-body-content-sheets-skills-container-skillsList">
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
					</div>
					<div class="monsterModal-body-content-sheets-inputNoID">
						<div class="monsterModal-body-content-sheets-strengthes">
							<p>Forces :</p>
							<ul>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<div class="monsterModal-body-content-sheets-weaknesses">
							<p>Faiblesses :</p>
							<ul>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
					</div>
					<div class="monsterModal-body-content-sheets-advice">
						<p>Conseils :</p>
						<span data-content="monsterAdvice"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<h2>Bestiaire</h2>
	<div class="bestiary-content">
		<div class="bestiary-content-filters">
			<div class="bestiary-content-filters-header">
				<span data-action="filters" aria-label="Afficher les filtres">Filtres <i class="fa-solid fa-sliders"></i></span>
				<span data-action="charts" aria-label="Afficher les graphiques">
					<label class="toggle">
						<input id="orgChart" type="checkbox" aria-label="Activer le graphique organisationnel">
						<span class="slider"></span>
					</label>
					<i class="fa-solid fa-sitemap"></i>
				</span>
			</div>
			<div data-state="close" class="bestiary-content-filters-body">
				<div class="bestiarry-content-filters-body-action">
					<i data-action="reinit" class="fa-solid fa-rotate-right" aria-label="Réinitialiser les filtres"></i>
					<i data-action="close" class="fa-solid fa-xmark" aria-label="Fermer les filtres"></i>
				</div>
				<div class="bestiary-content-filters-body-filterList">
					<span>Dangers</span>
					<ul>
						<?php foreach($dangers as $danger) {?>
							<li>
								<input id="danger_<?= htmlspecialchars($danger->dangerID, ENT_QUOTES, 'UTF-8'); ?>" type="checkbox" value="<?= htmlspecialchars($danger->dangerID, ENT_QUOTES, 'UTF-8'); ?>" data-type="dangers" aria-label="Danger: <?= htmlspecialchars($danger->dangerValue, ENT_QUOTES, 'UTF-8'); ?>">
								<label for="danger_<?= htmlspecialchars($danger->dangerID, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($danger->dangerValue, ENT_QUOTES, 'UTF-8'); ?></label>
							</li>
						<?php }?>
					</ul>
				</div>
				<div class="bestiary-content-filters-body-filterList">
					<span>Ranks</span>
					<ul>
						<?php foreach($ranks as $rank) {?>
							<li>
								<input id="rank_<?= htmlspecialchars($rank->rankID, ENT_QUOTES, 'UTF-8'); ?>" type="checkbox" value="<?= htmlspecialchars($rank->rankID, ENT_QUOTES, 'UTF-8'); ?>" data-type="ranks" aria-label="Rang: <?= htmlspecialchars($rank->rankValue, ENT_QUOTES, 'UTF-8'); ?>">
								<label for="rank_<?= htmlspecialchars($rank->rankID, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($rank->rankValue, ENT_QUOTES, 'UTF-8'); ?></label>
							</li>
						<?php }?>
					</ul>
				</div>
				<div class="bestiary-content-filters-body-filterList">
					<span>Zone</span>
					<ul>
						<?php foreach($areas as $area) {?>
							<li>
								<input id="area_<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>" type="checkbox" value="<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>" data-type="areas" aria-label="Zone: <?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?>">
								<label for="area_<?= htmlspecialchars($area->areaID, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($area->areaName, ENT_QUOTES, 'UTF-8'); ?></label>
							</li>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<div id="tree" aria-label="Arbre des monstres"></div>
		<div class="gallery monstersDisplayer">
			<?php foreach($ranks as $rank) { ?>
				<h4><?= htmlspecialchars($rank->rankValue, ENT_QUOTES, 'UTF-8'); ?></h4>
				<div class="gallery-cardContainer">
					<?php
					 if(isset($bestiary[$rank->rankValue])) {
						foreach($bestiary[$rank->rankValue] as $monster) { ?>
							<div 
								class="gallery-cardContainer-card"
								data-monsterid="<?= htmlspecialchars($monster->monsterID, ENT_QUOTES, 'UTF-8'); ?>"
								data-rankid="<?= htmlspecialchars($monster->monsterRankID, ENT_QUOTES, 'UTF-8'); ?>"
								data-areaid="<?= htmlspecialchars($monster->monsterAreaID, ENT_QUOTES, 'UTF-8'); ?>"
								data-dangerid="<?= htmlspecialchars($monster->monsterDangerID, ENT_QUOTES, 'UTF-8'); ?>"
								aria-label="Monstre: <?= htmlspecialchars($monster->monsterName, ENT_QUOTES, 'UTF-8'); ?>"
							>
								<img src="/bestiary/public/uploads/monsters/<?= htmlspecialchars($monster->monsterPicture, ENT_QUOTES, 'UTF-8'); ?>" alt="Image de <?= htmlspecialchars($monster->monsterName, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Image de <?= htmlspecialchars($monster->monsterName, ENT_QUOTES, 'UTF-8'); ?>">
							</div>
						<?php }
					} ?>
				</div>
			<?php } ?>
		</div>
	</div>
</main>
<?php if($url == "bestiary") { ?>
	<script src='/bestiary/public/js/bestiary.js' defer></script>
<?php } ?>
</body>
