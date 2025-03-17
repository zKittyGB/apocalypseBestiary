<?php require_once "partials/header.php"; ?>
<main>	
<div class="monsterModal-overlay"></div>
<div class="monsterModal">
	<i data-action="delete" class="fa-solid fa-trash" aria-label="Supprimer"></i>
	<i data-action="close" class="fa-solid fa-xmark" aria-label="Fermer"></i>
	<div class="monsterModal-banner">
		<input type="file" id="monsterPicture" accept=".jpg, .jpeg, .png" required aria-label="Télécharger une image de monstre">
		<label for="monsterPicture">
			<span>Télécharger votre image</span>
			<i class="fa-solid fa-upload" aria-label="Icône de téléchargement"></i>
			<span>Formats autorisés : .jpg, .jpeg, .png</span>
		</label>
		<div id="cropperContainer" class="hidden" aria-hidden="true">
			<img id="previewImage" alt="Aperçu de l'image">
		</div>
		<input type="hidden" id="monsterCroppedImageData">
	</div>
	<h3><input id="monsterName" type="text" placeholder="Nom" required aria-label="Nom du monstre" /></h3>
	<div class="monsterModal-details">
		<div class="monsterModal-details-content">
			<div data-element="rank">
				<label for="monsterRank">Grade :</label>
				<select id="monsterRank" required aria-label="Choisir un grade">
					<option value="" hidden>Choisir un grade</option>
					<?php foreach($ranks as $rank) { ?>
						<option data-rankorder="<?= $rank->rankOrder; ?>" value="<?= $rank->rankID; ?>"><?= $rank->rankValue; ?></option>
					<?php } ?>
				</select>
			</div>
			<div data-element="danger">
				<label for="monsterDanger">Danger :</label>
				<select id="monsterDanger" required aria-label="Choisir un niveau de danger">
					<option value="" hidden>Choisir un niveau</option>
					<?php foreach($dangers as $danger) { ?>
						<option value="<?= $danger->dangerID; ?>"><?= $danger->dangerValue; ?></option>
					<?php } ?>
				</select>
			</div>
			<div data-element="type">
				<label for="monsterType">Type :</label>
				<select id="monsterType" required aria-label="Choisir un type de monstre">
					<option value="" hidden>Choisir un type</option>
					<?php foreach($types as $type) { ?>
						<option value="<?= $type->typeID; ?>"><?= $type->typeName; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="monsterModal-details-content">
			<div data-element="master">
				<label for="monsterMaster">Maître :</label>
				<select id="monsterMaster" required aria-label="Choisir un maître">
					<option value="" hidden>Choisir un maître</option>
					<?php foreach($bestiary as $rank) {
						foreach($rank as $monster) { ?>
							<option data-rankorder="<?= $monster->rankOrder; ?>" value="<?= $monster->monsterID; ?>"><?= $monster->monsterName; ?></option>
						<?php }
					} ?>
				</select>
			</div>
			<div data-element="area">
				<label for="monsterArea">Zone :</label>
				<select id="monsterArea" required aria-label="Choisir une zone">
					<option value="" hidden>Choisir une zone</option>
					<?php foreach($areas as $area) { ?>
						<option value="<?= $area->areaID; ?>"><?= $area->areaName; ?></option>
					<?php } ?>
				</select>
			</div>
			<div data-element="habitat">
				<label for="monsterHabitat">Habitat :</label>
				<select id="monsterHabitat" required aria-label="Choisir un habitat">
					<option value="" hidden>Choisir un habitat</option>
				</select>
			</div>
		</div>
	</div>
	<div class="monsterModal-body">
		<div class="monsterModal-body-menu">
			<ul>
				<li data-container="descriptions" aria-label="Voir les descriptions"><i class="fa-solid fa-info"></i></li>
				<li data-container="strengthes" aria-label="Voir les forces et compétences"><i class="fa-solid fa-hand-fist"></i></li>
			</ul>
		</div>
		<div class="monsterModal-body-content">
			<div data-container="descriptions" class="monsterModal-body-content-sheets">
				<div class="monsterModal-body-content-sheets-textareaContainer">
					<label for="monsterDescription">Description :</label>
					<textarea id="monsterDescription" required aria-label="Décrire le monstre"></textarea>
				</div>
				<div class="monsterModal-body-content-sheets-textareaContainer">
					<label for="monsterBehavior">Comportement :</label>
					<textarea id="monsterBehavior" aria-label="Décrire le comportement du monstre"></textarea>
				</div>
			</div>
			<div data-container="strengthes" class="monsterModal-body-content-sheets">
				<div class="monsterModal-body-content-sheets-skills">
					<p>Compétences :</p>
					<div class="monsterModal-body-content-sheets-skills-container">
						<div class="monsterModal-body-content-sheets-skills-container-skillsList"></div>
						<div class="monsterModal-body-content-sheets-skills-container-skillsList"></div>
					</div>
				</div>
				<div class="monsterModal-body-content-sheets-inputNoID">
					<div class="monsterModal-body-content-sheets-strengthes">
						<p>Forces :</p>
						<ul>
							<li><i class="fa-solid fa-plus" aria-label="Ajouter une force"></i><input type="text" data-type="monsterStrengthes" aria-label="Décrire une force"></li>
							<li><i class="fa-solid fa-plus" aria-label="Ajouter une force"></i><input type="text" data-type="monsterStrengthes" aria-label="Décrire une force"></li>
							<li><i class="fa-solid fa-plus" aria-label="Ajouter une force"></i><input type="text" data-type="monsterStrengthes" aria-label="Décrire une force"></li>
						</ul>
					</div>
					<div class="monsterModal-body-content-sheets-weaknesses">
						<p>Faiblesses :</p>
						<ul>
							<li><i class="fa-solid fa-plus" aria-label="Ajouter une faiblesse"></i><input type="text" data-type="monsterWeaknesses" aria-label="Décrire une faiblesse"></li>
							<li><i class="fa-solid fa-plus" aria-label="Ajouter une faiblesse"></i><input type="text" data-type="monsterWeaknesses" aria-label="Décrire une faiblesse"></li>
							<li><i class="fa-solid fa-plus" aria-label="Ajouter une faiblesse"></i><input type="text" data-type="monsterWeaknesses" aria-label="Décrire une faiblesse"></li>
						</ul>
					</div>
				</div>
				<div class="monsterModal-body-content-sheets-advice">
					<label for="monsterAdvice">Conseils :</label>
					<textarea id="monsterAdvice" aria-label="Donner des conseils pour combattre le monstre"></textarea>
				</div>
			</div>
		</div>
		<div class="monsterModal-body-actions">
			<button aria-label="Ajouter un nouveau monstre">Ajouter monstre</button>
		</div>
	</div>
</div>

<h2>Bestiaire</h2>
<nav class="submenu" data-menu="main">
	<ul>
		<li><h3 class="active" data-container="monsters" aria-label="Afficher les créatures">Créatures</h3></li> 
		<li><h3 data-container="ranks" aria-label="Afficher les grades">Grade</h3></li>
		<li><h3 data-container="types" aria-label="Afficher les types">Types</h3></li>
		<li><h3 data-container="skills" aria-label="Afficher les compétences">Compétences</h3></li>
	</ul>
</nav>
<div class="content">
	<div class="gallery monstersDisplayer active" data-container="monsters" aria-label="Galerie des créatures">
		<?php foreach($ranks as $rank) { ?>
			<h4><?= htmlspecialchars($rank->rankValue); ?></h4>
			<div data-rankid="<?= $rank->rankID; ?>" class="gallery-cardContainer" aria-label="Container des cartes de créatures">
				<div class="gallery-cardContainer-card">
					<span data-rankvalue="<?= $rank->rankValue; ?>" data-rankid="<?= $rank->rankID; ?>" data-rankorder="<?= $rank->rankOrder; ?>" class="addMonster" aria-label="Ajouter un monstre">Ajouter</span>
				</div>
				<?php if(isset($bestiary[$rank->rankValue])) {
					foreach($bestiary[$rank->rankValue] as $monster) { ?>
						<div data-monsterid="<?= $monster->monsterID; ?>" class="gallery-cardContainer-card" aria-label="Carte de <?= htmlspecialchars($monster->monsterName); ?>">
							<img src="/bestiary/public/uploads/monsters/<?= htmlspecialchars($monster->monsterPicture); ?>" alt="Image de <?= htmlspecialchars($monster->monsterName); ?>" />
							<span>
								<p><?= htmlspecialchars($monster->monsterName); ?></p>
								<i class="fa-solid fa-pen" aria-label="Éditer le monstre"></i>
							</span>
						</div>
				<?php }
				} ?>
			</div>
		<?php } ?>
	</div>
	<div class="ranksDisplayer" data-container="ranks" aria-label="Liste des grades">
		<h5>Liste des grades</h5>
		<table>
			<thead>
				<tr>
					<td class="rankDisplayer-rankLegend" aria-label="Rang">Rang</td>
					<td colspan="3" aria-label="Nom">Nom</td>
					<td><i data-action="deleteAll" class="fa-solid fa-trash" aria-label="Supprimer tous les grades"></i></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($ranks as $rank) { ?>
					<tr data-rankid="<?= $rank->rankID; ?>" aria-label="Grade <?= htmlspecialchars($rank->rankValue); ?>">
						<td class="ranksDisplayer-rankOrder"><?= htmlspecialchars($rank->rankOrder); ?></td>
						<td class="ranksDisplayer-rankValue"><?= htmlspecialchars($rank->rankValue); ?></td>
						<td><i data-action="down" class="fa-solid fa-arrow-down" aria-label="Descendre le grade"></i></td>
						<td><i data-action="up" class="fa-solid fa-arrow-up" aria-label="Monter le grade"></i></td>
						<td><i data-action="delete" class="fa-solid fa-trash" aria-label="Supprimer le grade"></i></td>
					</tr>
				<?php } ?>
				<tr data-action="addRank" aria-label="Ajouter un grade">
					<td><input id="addRankOrder" type="number" value="<?= count($ranks) +1 ?>" aria-label="Numéro de rang"></td>
					<td colspan="3"><input id="addRankValue" type="text" placeholder="Ajouter un grade" aria-label="Nom du grade"></td>
					<td><i data-action="validation" class="fa-solid fa-check hidden" aria-label="Valider l'ajout du grade"></i></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="typesDisplayer" data-container="types" aria-label="Liste des types">
		<h5>Liste des types</h5>
		<table>
			<thead>
				<tr>
					<td colspan="2" aria-label="Nom">Nom</td>
					<td><i data-action="deleteAll" data-element="type" class="fa-solid fa-trash" aria-label="Supprimer tous les types"></i></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($types as $type) { ?>
					<tr data-typeid="<?= $type->typeID; ?>" aria-label="Type <?= htmlspecialchars($type->typeName); ?>">
						<td><input type="text" value="<?= htmlspecialchars($type->typeName); ?>" disabled aria-label="Nom du type"></td>
						<td>
							<i data-action="edit" data-element="type" class="fa-solid fa-pen-to-square" aria-label="Éditer le type"></i>
							<i data-action="validate" data-element="type" class="fa-solid fa-check hidden" aria-label="Valider le type"></i>
						</td>
						<td>
							<i data-action="delete" data-element="type" class="fa-solid fa-trash" aria-label="Supprimer le type"></i>
							<i data-action="cancel" data-element="skill" class="fa-solid fa-xmark hidden" aria-label="Annuler l'ajout du type"></i>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<span class="typesDisplayer-addTypeContainer">
			<div class="inputContainer"> 
				<input data-element="type" id="addType" type="text" placeholder="Ajouter un type" aria-label="Ajouter un type">
			</div>
			<button data-action="add" data-element="type" class="btn hidden" aria-label="Ajouter un nouveau type">Ajouter</button>
		</span>
	</div>

	<div class="skillsDisplayer" data-container="skills" aria-label="Liste des compétences">
		<h5>Liste des compétences</h5>
		<table>
			<thead>
				<tr class="red">
					<td colspan="2" aria-label="Nom">Nom</td>
					<td><i data-action="deleteAll" data-element="skill" class="fa-solid fa-trash" aria-label="Supprimer toutes les compétences"></i></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($skillsByTypes as $key => $type) { ?>
					<tr data-typeid="<?= $type->typeID; ?>" class="skillsDisplayer-type" aria-label="Type de compétence : <?= htmlspecialchars($key); ?>">
						<td colspan="3"><?= htmlspecialchars($key); ?></td>
					</tr>
					<?php foreach($type->skills as $skill) { ?>
						<tr data-skillid="<?= $skill->skillID; ?>" class="skillsDisplayer-skill" aria-label="Compétence <?= htmlspecialchars($skill->skillName); ?>">
							<td><input type="text" value="<?= htmlspecialchars($skill->skillName); ?>" disabled aria-label="Nom de la compétence"></td>
							<td>
								<i data-action="edit" data-element="skill" class="fa-solid fa-pen-to-square" aria-label="Éditer la compétence"></i>
								<i data-action="validate" data-element="skill" class="fa-solid fa-check hidden" aria-label="Valider la compétence"></i>
							</td>
							<td>
								<i data-action="delete" data-element="skill" class="fa-solid fa-trash" aria-label="Supprimer la compétence"></i>
								<i data-action="cancel" data-element="skill" class="fa-solid fa-xmark hidden" aria-label="Annuler l'ajout de la compétence"></i>
							</td>
						</tr>
					<?php }
				}?>
			</tbody>
		</table>
		<span class="skillsDisplayer-addSkillContainer">
			<div class="inputContainer"> 
				<input data-element="skill" id="addSkill" type="text" placeholder="Ajouter une compétence" aria-label="Nom de la compétence">
				<select data-element="skill" id="selectType" aria-label="Sélectionner un type de compétence">
					<option value="" hidden>Sélectionner un type</option>
					<?php foreach($types as $type) { ?>
						<option value="<?= $type->typeID; ?>"><?= $type->typeName; ?></option>
					<?php }?>
				</select>
			</div>
			<button data-action="add" data-element="skill" class="btn hidden" aria-label="Ajouter une nouvelle compétence">Ajouter</button>
		</span>
	</div>
</div>

</main>
<?php if($url == "bestiaryManager") { ?>
	<script src='/bestiary/public/js/monsterManager.js' defer></script>
	<script src='/bestiary/public/js/rankManager.js' defer></script>
	<script src='/bestiary/public/js/skillsAndTypesManager.js' defer></script>
<?php } ?>
</body>