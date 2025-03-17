<?php require_once "partials/header.php"; ?>
<main>
	<h2>Bestiaire</h2>
	<div class="glossary-content">
		<?php foreach($glossaryWords as $glossaryWord) { ?>
			<h3><?= htmlspecialchars($glossaryWord->glossaryWordValue, ENT_QUOTES, 'UTF-8'); ?></h3>
			<span><?= htmlspecialchars($glossaryWord->glossaryWordDefinition, ENT_QUOTES, 'UTF-8'); ?></span>
		<?php } ?>
	</div>
</main>
</body>