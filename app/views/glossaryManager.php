<?php require_once "partials/header.php"; ?>
<main>
	<h2>Glossaire</h2>
	<div class="content">
		<div class="glossaryContainer">
			<table>
				<thead>
					<tr>
						<th>Mots</th>
						<th colspan="2">Définitions</th>
						<th><i data-action="deleteAll" class="fa-solid fa-trash" aria-label="Supprimer tous les mots du glossaire"></i></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($glossaryWords as $glossaryWord) { ?>
						<tr data-wordid="<?= htmlspecialchars($glossaryWord->glossaryWordID, ENT_QUOTES, 'UTF-8'); ?>">
							<td>
								<input
									data-element="word"
									value="<?= htmlspecialchars($glossaryWord->glossaryWordValue, ENT_QUOTES, 'UTF-8'); ?>"
									disabled
									aria-label="Mot: <?= htmlspecialchars($glossaryWord->glossaryWordValue, ENT_QUOTES, 'UTF-8'); ?>">
							</td>
							<td>
								<input
									data-element="definition"
									value="<?= htmlspecialchars($glossaryWord->glossaryWordDefinition, ENT_QUOTES, 'UTF-8'); ?>"
									disabled
									aria-label="Définition: <?= htmlspecialchars($glossaryWord->glossaryWordDefinition, ENT_QUOTES, 'UTF-8'); ?>">
							</td>
							<td>
								<i
									data-action="edit"
									class="fa-solid fa-pen-to-square"
									aria-label="Modifier ce mot et sa définition"></i>
								<i
									data-action="validate"
									class="fa-solid fa-check hidden"
									aria-label="Valider les modifications"></i>
							</td>
							<td>
								<i
									data-action="delete"
									class="fa-solid fa-trash"
									aria-label="Supprimer ce mot"></i>
								<i
									data-action="cancel"
									class="fa-solid fa-xmark hidden"
									aria-label="Annuler les modifications"></i>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<span class="glossaryContainer-addWordContainer">
				<div class="inputContainer">
					<input
						data-element="word"
						id="addWord"
						type="text"
						placeholder="Mot"
						aria-label="Ajouter un mot au glossaire">
				</div>
				<div class="inputContainer">
					<input
						data-element="definition"
						id="addDefinition"
						type="text"
						placeholder="Définition"
						aria-label="Ajouter une définition pour le mot">
				</div>
				<button
					data-action="add"
					class="btn hidden"
					aria-label="Ajouter ce mot au glossaire">Ajouter</button>
			</span>
		</div>
	</div>
</main>
<?php if ($url == "glossaryManager") { ?>
	<script src='/bestiary/public/js/glossaryManager.js' defer></script>
<?php } ?>
</body>