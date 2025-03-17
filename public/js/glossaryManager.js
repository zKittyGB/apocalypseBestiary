const wordINPUT = document.querySelector("body.isAdmin .content .glossaryContainer-addWordContainer #addWord");
const definitionINPUT = document.querySelector("body.isAdmin .glossaryContainer-addWordContainer #addDefinition");
const addBUTTON = document.querySelector("body.isAdmin .glossaryContainer-addWordContainer button");
const deleteButtons = document.querySelectorAll("body.isAdmin .glossaryContainer table i[data-action='delete'], body.isAdmin .glossaryContainer table i[data-action='deleteAll']");
const editAndCancelButtons = document.querySelectorAll("body.isAdmin .glossaryContainer table i[data-action='edit'], body.isAdmin .glossaryContainer table i[data-action='cancel']");
const validateButtons = document.querySelectorAll("body.isAdmin .glossaryContainer table i[data-action='validate']");

// Déclenche l'affichage du boutton d'ajout
wordINPUT.addEventListener("input", () => {
	displayAddButton(wordINPUT, definitionINPUT);
});
definitionINPUT.addEventListener("input", () => {
	displayAddButton(wordINPUT, definitionINPUT);
});

// Déclenche la gestion de l'ajout d'une définition
addBUTTON.addEventListener("click", () => {
	handleAddButton(wordINPUT, definitionINPUT);
})

deleteButtons.forEach((button) => {
	button.addEventListener("click", (event) => {
		handleDeleteButton(event);
	})
})

editAndCancelButtons.forEach((button) => {
	button.addEventListener("click", (event) => {
		displayEditWordButtons(event);
	})
})

validateButtons.forEach((button) => {
	button.addEventListener("click", (event) => {
		editGlossaryWord(event);
	})
})

function displayAddButton(wordINPUT, definitionINPUT) {
	if(wordINPUT.value != "" && definitionINPUT.value != "") {
		addBUTTON.classList.remove("hidden");
	} else {
		addBUTTON.classList.add("hidden");
	}
}

function displayEditWordButtons(event, action=null) {
	const editTR = event.target.closest("tr");
	const TRButtons = editTR.querySelectorAll("i");
	const INPUTs = editTR.querySelectorAll("input");

	if(!action) {
		action = event.target.dataset.action;
	} 

	if(TRButtons) {
		// Inverse la visibilité de tous les boutons
		TRButtons.forEach((button) => {
			button.classList.toggle("hidden");
		})
	}

	if(action == "edit") {
		INPUTs.forEach((input) => {
			input.dataset.initvalue = input.value;
			input.disabled = false;
		})
	} else if(action == "cancel") {
		INPUTs.forEach((input) => {
			input.value = input.dataset.initvalue;
			input.disabled = true;
		})
	} else if(action = "validate") {
		INPUTs.forEach((input) => {
			input.disabled = true;
		})
	}
}

function handleAddButton(wordINPUT, definitionINPUT) {
	const wordValue = wordINPUT.value;
	const definitionValue = definitionINPUT.value;

	if(wordValue == "" || definitionValue == "") {
		return;
	}

	const formData = new FormData();
	formData.append("wordValue", wordValue);
	formData.append("definitionValue", definitionValue);
 
	// Envoie de l'objet via POST
	fetch("/bestiary/public/?url=glossaryManager/addGlossaryWord", {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
		if(data.error) {
			console.error("Erreur :", data.error);
		} else {
			const glossaryTBODY = document.querySelector("body.isAdmin .content .glossaryContainer table tbody");

			const TR = document.createElement("tr");
			const wordTD = document.createElement("td");
			const definitionTD = document.createElement("td");
			const editTD = document.createElement("td");
			const deleteTD = document.createElement("td");

			TR.dataset.wordid = data.wordID;
			wordTD.innerHTML = `<input data-element="word" value="${wordValue}" disabled>`;
			definitionTD.innerHTML =  `<input data-element="definition" value="${definitionValue}" disabled>`;

			editTD.innerHTML = '<i data-action="edit" class="fa-solid fa-pen-to-square"></i><i data-action="validate" class="fa-solid fa-check hidden"></i></td>';
			deleteTD.innerHTML = '<i data-action="delete" class="fa-solid fa-trash"></i><i data-action="cancel" class="fa-solid fa-xmark hidden"></i>';

			TR.appendChild(wordTD);
			TR.appendChild(definitionTD);
			TR.appendChild(editTD);
			TR.appendChild(deleteTD);
			glossaryTBODY.appendChild(TR);

			const validateButton = editTD.querySelector("i[data-action='validate']");
			const editButton = editTD.querySelector("i[data-action='edit']");
			const deleteButton = deleteTD.querySelector("i[data-action='delete']");
			const cancelButton = deleteTD.querySelector("i[data-action='cancel']");

			// Ajout de la méthode de suppréssion
			deleteButton.addEventListener("click", (event) => {
				handleDeleteButton(event);
			})
			
			// Ajout de la méthode d'affichage de l'edition
			editButton.addEventListener("click", (event) => {
				displayEditWordButtons(event);
			})
			cancelButton.addEventListener("click", (event) => {
				displayEditWordButtons(event);
			})
			
			validateButton.addEventListener("click", (event) => {
				editGlossaryWord(event);
			})

			wordINPUT.value = "";
			definitionINPUT.value = "";
			addBUTTON.classList.add("hidden");
		} 
	})
	.catch(error => console.error("Erreur lors du fetch :", error));
}

function handleDeleteButton(event) {
	const glossaryTBODY = document.querySelector("body.isAdmin .content .glossaryContainer table tbody");
	const action = event.target.dataset.action;
	const buttonTR = event.target.closest("tr");
	const formData = new FormData();
	
	let message;
	
	formData.append("action", action);

	if(action == "delete") {
		const wordID = buttonTR.dataset.wordid;
		formData.append("wordID", wordID);
		message = "Confirmer la suppréssion d'un mot ?";
	} else { 
		message = "Confirmer la suppréssion de tous les mots ?";

		// Si la table est vide on arrrête le traitement
		if(glossaryTBODY.querySelectorAll("tr").length < 1) {
			return;
		}
	}
	if(window.confirm(message)) {
		// Envoie de l'objet via POST
		fetch("/bestiary/public/?url=glossaryManager/deleteGlossaryWords", {
			method: "POST", 
			body: formData 
		})
			.then(response => response.json())
			.then(data => {
				if(data.error) {
					console.error("Erreur :", data.error);
				} else {
					if(action == "delete") {
						buttonTR.remove();
					} else {
						glossaryTBODY.innerHTML = "";
					}
				}
			})
			.catch(error => console.error("Erreur lors du fetch :", error));
	}
}

function editGlossaryWord(event) {
	const buttonTR = event.target.closest("tr");
	const wordValue = buttonTR.querySelector("input[data-element='word']").value;
	const definitionValue = buttonTR.querySelector("input[data-element='definition']").value;
	const wordID = buttonTR.dataset.wordid;

	const formData = new FormData();
	
	formData.append("wordID", wordID);
	formData.append("wordValue", wordValue);
	formData.append("definitionValue", definitionValue);

	// Envoie de l'objet via POST
	fetch("/bestiary/public/?url=glossaryManager/editGlossaryWord", {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else {
				displayEditWordButtons(event, "validate");
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}