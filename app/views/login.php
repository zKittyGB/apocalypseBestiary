<?php require_once "partials/header.php"; ?>
<main>
	<h2>connexion</h2>
	<div class="login-content">
		<?php if (!empty($_SESSION['login_error'])): ?>
			<p class="error"><?= htmlspecialchars($_SESSION['login_error']); ?></p>
			<?php unset($_SESSION['login_error']); ?>
		<?php endif; ?>

		<div class="login-content-logContainer">
			<h3>Complétez vos identifiants</h3>
			<div class="inputContainer">
				<label for="email">Email :</label>
				<input id="email" type="email" name="email" required aria-label="Email">
			</div>
			<div class="inputContainer">
				<label for="password">Mot de passe :</label>
				<input id="password" type="password" name="password" required aria-label="Mot de passe">
			</div>
			<div class="login-content-actions">
				<button data-action="register" class="btn" aria-label="S'enregistrer">S'enregistrer</button>
				<button data-action="login" class="btn" aria-label="Se connecter">Se connecter</button>
			</div>
		</div>
	</div>
	<div class="register-content hidden">
		<div class="register-content-registerContainer">
			<h3>Complétez votre compte</h3>
			<div class="inputContainer-flex">
				<div class="inputContainer">
					<label for="lastName">Nom :</label>
					<input id="lastName" type="text" name="lastName" required aria-label="Nom">
					<span class="error lastNameError"></span>
				</div>
				<div class="inputContainer">
					<label for="firstName">Prénom :</label>
					<input id="firstName" type="text" name="firstName" required aria-label="Prénom">
					<span class="error firstNameError"></span>
				</div>
			</div>
			<div class="inputContainer">
				<label for="registerEmail">Email :</label>
				<input id="registerEmail" type="email" name="registerEmail" required aria-label="Email d'enregistrement">
				<span class="error emailError"></span>
			</div>
			<div class="inputContainer">
				<label for="registerPassword">Mot de passe :</label>
				<input id="registerPassword" type="password" name="registerPassword" required aria-label="Mot de passe d'enregistrement">
				<span class="error passwordError"></span>
			</div>
			<div class="inputContainer">
				<label for="confirmRegisterPassword">Confirmez votre mot de passe :</label>
				<input id="confirmRegisterPassword" type="password" name="confirmRegisterPassword" required aria-label="Confirmation du mot de passe">
				<span class="error confirmRegisterPassword"></span>
			</div>
			<div class="register-content-actions">
				<button data-action="login" class="btn" aria-label="Se connecter">Connexion</button>
				<button data-action="register" class="btn" aria-label="Valider l'inscription">Valider</button>
			</div>
		</div>
	</div>
</main>
<?php if ($url == "login") { ?>
	<script src='/bestiary/public/js/login.js' defer></script>
<?php } ?>
</body>