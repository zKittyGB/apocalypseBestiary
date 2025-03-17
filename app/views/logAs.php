<?php require_once "partials/header.php"; ?>
<main>
	<h2>Connecté en tant que </h2>
	<div class="logAs-content">
		<div class="logAs-content-container">
			<div class="logAs-content-container-inputContainer">
				<input id="user" value="user" type="radio" name="logAs" required aria-label="Utilisateur">
				<label data-logas="user" for="user">Utilisateur</label>
			</div>
			<div class="logAs-content-container-inputContainer">
				<input id="admin" value="admin" type="radio" name="logAs" required aria-label="Administrateur">
				<label data-logas="admin" for="admin">Administrateur</label>
			</div>
		</div>
	</div>
</main>
<?php if ($url == "logAs") { ?>
	<script src='/bestiary/public/js/login.js' defer></script>
<?php } ?>
</body>