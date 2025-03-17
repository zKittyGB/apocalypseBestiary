const loginBUTTONs = document.querySelectorAll(".login-content-actions button");
const registerBUTTONs = document.querySelectorAll(".register-content-actions button");
const loginAsLABELs = document.querySelectorAll(".logAs-content-container-inputContainer label");
const mailINPUT = document.querySelector("#email");
const passwordINPUT = document.querySelector("#password");
const registerINPUTs = document.querySelectorAll(".register-content input");
const lastNameINPUT = document.querySelector(".register-content input[name='lastName']");
const firstNameINPUT = document.querySelector(".register-content input[name='firstName']");
const registerMailINPUT = document.querySelector(".register-content input[name='registerEmail']");
const registerPasswordINPUT = document.querySelector(".register-content input[name='registerPassword']");
const confirmPasswordINPUT = document.querySelector(".register-content input[name='confirmRegisterPassword']");

registerINPUTs.forEach((INPUT) => {
	INPUT.addEventListener("input", (event) => checkINPUTValidity(event));
});

// Ajouter l'écouteur d'événements sur chaque bouton
loginBUTTONs.forEach((BUTTON) => {
	BUTTON.addEventListener("click", ((event)=> {handleLoginButtons(event)}));
});
// Ajouter l'écouteur d'événements sur chaque bouton
registerBUTTONs.forEach((BUTTON) => {
	BUTTON.addEventListener("click", ((event)=> {handleRegisterButtons(event)}));
});

loginAsLABELs.forEach((LABEL) => {
	LABEL.addEventListener("click", (event) => {
		handleLogAsButtons(event)
	})
})

// Autorise la touche entrée pour valider le "formulaire"
document.addEventListener("keydown", (event) => {
	if(event.key == "Enter" && mailINPUT.value && passwordINPUT.value) {
		// Déclencher le clic sur le second bouton du conteneur actions
		const newEvent = new Event("click");
		loginBUTTONs[1].dispatchEvent(newEvent);
	} else if(event.key == "Enter" && lastNameINPUT.value && firstNameINPUT.value && registerMailINPUT.value && registerPasswordINPUT.value && confirmPasswordINPUT.value) {
		// Déclencher le clic sur le second bouton du conteneur actions
		const newEvent = new Event("click");
		registerBUTTONs[1].dispatchEvent(newEvent);
	}
})

async function handleLoginButtons(event) {
	const BUTTON = event.target;
	const action = BUTTON.dataset.action;

	switch(action) {
		case "register":
			const registerContent = document.querySelector(".register-content");
			const loginContent = document.querySelector(".login-content");

			registerContent.classList.remove("hidden");
			loginContent.classList.add("hidden");

			break;

		case "login":
			const emailInput = document.querySelector(".login-content input[name='email']");
			const passwordInput = document.querySelector(".login-content input[name='password']");

			if(!emailInput || !passwordInput) {
				console.error("Les champs email ou mot de passe sont introuvables.");
				return;
			}

			const email = emailInput.value;
			const password = passwordInput.value;

			const formData = new FormData();
			formData.append("email", email);
			formData.append("password", password);

			try {
				const response = await fetch(
					"https://www.zkittygb.fr/bestiary/public/?url=login/authenticate",
					{
						method: "POST",
						body: formData,
						credentials: "include", // Maintient la session active
					}
				);

				// Vérifier si la réponse est une redirection
				if(response.redirected) {
					window.location.href = response.url;
				} else {
					const result = await response.text();
					console.error("Réponse du serveur :", result);
					alert("Échec de la connexion : vérifiez vos identifiants.");
				}
			} catch(error) {
				console.error("Erreur lors de la requête :", error);
				alert("Une erreur est survenue. Réessayez plus tard.");
			}
			
			break;

		default:
			return;
	}
}

function handleRegisterButtons(event) {
	event.preventDefault();
	const BUTTON = event.target;
	const action = BUTTON.dataset.action;
	const allErrorElements = document.querySelectorAll(".error");

	allErrorElements.forEach((errorElement) => {
		errorElement.classList.remove("active");
		errorElement.innerHTML = "";
	});

	switch(action) {
		case "login":
			const registerContent = document.querySelector(".register-content");
			const loginContent = document.querySelector(".login-content");
		
			registerContent.classList.add("hidden");
			loginContent.classList.remove("hidden");
			break;

		case "register":
			const lastName = lastNameINPUT.value;
			const firstName = firstNameINPUT.value;
			const email = registerMailINPUT.value;
			const password = registerPasswordINPUT.value;
			const confirmPassword = confirmPasswordINPUT.value;

			const formData = new FormData();
			formData.append("lastName", lastName);
			formData.append("firstName", firstName);
			formData.append("email", email);
			formData.append("password", password);
			formData.append("confirmPassword", confirmPassword);

			fetch("https://www.zkittygb.fr/bestiary/public/?url=register", {
				method: "POST", 
				body: formData 
			})
			.then(response => response.json())
			.then(data => {
				if(data.errors && data.errors.length > 0) {
					const errors = data.errors;
					Object.keys(errors).forEach(key => {
						const error = errors[key];
						const errorElement = document.querySelector(`.register-content input[name='${key}'] + span`);
						errorElement.innerHTML = error;
						errorElement.classList.add("active");
					})
				} else if(data.error) {
					alert(data.error);
				} else {
					const H3 = document.querySelector(".register-content-registerContainer h3");
					H3.innerHTML = "Compte créé avec succès !";
				}
			})

		default:
			return;
	}
}

async function handleLogAsButtons(event) {
	const logAs = event.target.dataset.logas;
	const formData = new FormData();

	formData.append("logAs", logAs);

	try {
		const response = await fetch(
			"https://www.zkittygb.fr/bestiary/public/?url=login/authenticateAs",
			{
				method: "POST",
				body: formData,
				credentials: "include", // Maintient la session active
			}
		);

		// Vérifier si la réponse est une redirection
		if(response.redirected) {
			window.location.href = response.url;
		} else {
			const result = await response.text();
			console.error("Réponse du serveur :", result);
			alert("Échec de la connexion : vérifiez vos identifiants.");
		}
	} catch(error) {
		console.error("Erreur lors de la requête :", error);
	}
	
}


function checkINPUTValidity(event) {
	const INPUT = event.target;
	const inputName = INPUT.name;
	const errorElement = INPUT.nextElementSibling;

	// Réinitialise les erreurs
	errorElement.classList.remove("active");
	errorElement.innerHTML = "";

	// Si l'input est vide, ne pas afficher d'erreur
	if(INPUT.value.length === 0) {
		return;
	}

	// Règles de validité
	switch(inputName) {
		case "lastName":
		case "firstName":
			if(!INPUT.value.match(/^[a-zA-ZÀ-ÿ\s-]{2,50}$/)) {
				errorElement.innerHTML = "Nom invalide (lettres et espaces uniquement, 2-50 caractères)";
				errorElement.classList.add("active");
			}
			break;

		case "registerEmail":
			if(!INPUT.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
				errorElement.innerHTML = "Email invalide";
				errorElement.classList.add("active");
			}
			break;

		case "registerPassword":
			if(!INPUT.value.match(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/)) {
				errorElement.innerHTML = "Le mot de passe doit contenir 8-20 caractères, avec au moins une lettre, un chiffre et un caractère spécial";
				errorElement.classList.add("active");
			}
			break;

		case "confirmRegisterPassword":
			const passwordInput = document.querySelector("input[name='registerPassword']");
			if(INPUT.value !== passwordInput.value) {
				errorElement.innerHTML = "Les mots de passe ne correspondent pas";
				errorElement.classList.add("active");
			}
			break;

		default:
			return;
	}
}

