<?php require_once "partials/header.php";?>
<main data-targetid="<?= htmlspecialchars($targetID ?? '', ENT_QUOTES, 'UTF-8'); ?>">
	<h2>Cartes</h2>
	<div class="areas-content">
		<div class="areaSelectContainer">
			<select id="areaSelect" aria-label="Sélectionner une zone">
				<?php foreach($areas as $area) { ?>
					<option value="<?= htmlspecialchars($area->areaID ?? '', ENT_QUOTES, 'UTF-8'); ?>" aria-label="<?= htmlspecialchars($area->areaName ?? '', ENT_QUOTES, 'UTF-8'); ?>">
						<?= htmlspecialchars($area->areaName ?? '', ENT_QUOTES, 'UTF-8'); ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="areaContainer">
			<div class="areaContainer-options">
				<div class="areaContainer-options-inputsContainer">
					<div class="areaContainer-options-inputsContainer-inputContainer">
						<input type="checkbox" id="safePlaces" name="safePlaces" checked aria-label="Afficher les lieux sûrs">
						<label for="safePlaces">Lieux sûrs</label>
					</div>
					<div class="areaContainer-options-inputsContainer-inputContainer">
						<label class="custom-checkbox">
							<input type="checkbox" id="habitats" name="habitats" checked aria-label="Afficher les habitats de monstres">
							<label for="habitats">Habitats de monstres</label>
						</label>
					</div>
				</div>
				<div class="areaContainer-options-inputContainer">
					<select id="monsterSelect" aria-label="Sélectionner un monstre"></select>
				</div>
			</div>
			<div class="areaContainer-pictureContainer">
				<img src="" alt="Image de la zone" aria-label="Image de la zone sélectionnée">
			</div>
		</div>
	</div>
</main>
<?php if($url == "areas") { ?>
	<script src='/bestiary/public/js/areas.js' defer></script>
<?php } ?>
</body>
