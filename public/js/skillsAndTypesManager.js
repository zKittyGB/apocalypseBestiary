const content = document.querySelector("body.isAdmin .content");
const addElementINPUTS = content.querySelectorAll(".typesDisplayer #addType, body.isAdmin .content .skillsDisplayer #addSkill");
const allButtons = content.querySelectorAll("i[data-action], button[data-action");

addElementINPUTS.forEach((INPUT) => {
	INPUT.addEventListener("input", () => {
		const dataAddElement = INPUT.dataset.element;
		const addButton = content.querySelector(`button[data-element="${dataAddElement}"]`);

		if(INPUT.value != "") {
			addButton.classList.remove("hidden");
		} else {
			addButton.classList.add("hidden");
		}
	})
})

// Attache chaque fonction à chaque bouton présents dans les tables
allButtons.forEach((button) => {
	const action = button.dataset.action;
	button.addEventListener("click", (event) => {
		if(action == "edit" || action == "cancel") {
			displayEditButtons(event)
		} else if(action == "add") {
			addElement(event);
		} else if(action == "validate") {
			editElement(event);
		} else if(action == "delete" || action =="deleteAll") {
			deleteElements(event)
		} else {
			return;
		}
	}) 
})


function addElement(event) {
	const dataAddElement = event.target.dataset.element;
	const INPUT = content.querySelector(`input[data-element="${dataAddElement}"]`);
	const INPUTValue = INPUT.value;
	const typeSELECT = content.querySelector(`select[data-element="skill"]`);
			
	let typeID;
	let URL;

	// Bloque si pas de valeur fourni et si la valeur n'est pas l'une des deux attendu
	if(!INPUTValue && (dataAddElement != "skill" && dataAddElement != "type")) {
		return;
	}

	const formData = new FormData();
	formData.append("addElementValue", INPUTValue);

	if(dataAddElement == "skill") {
		typeID = typeSELECT.value;

		if(!typeID) { return ; }

		formData.append("typeID", typeID);
		URL = "?url=bestiaryManager/addSkill";
	} else {
		URL = "?url=bestiaryManager/addType";
	} 

	// Envoie de l'objet via POST
	fetch(`/bestiary/public/${URL}`, {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { 
				// Création de la ligne à ajouter
				const TBODY = event.target.closest("div[data-container]").querySelector("table tbody");
				const TR = document.createElement("tr");
				const nameTD = document.createElement("td");
				const editTD = document.createElement("td");
				const deleteTD = document.createElement("td");

				nameTD.innerHTML = `<input type="text" value="${INPUTValue}" disabled>`;
				editTD.innerHTML = `
					<i data-action="edit" data-element="${dataAddElement}" class="fa-solid fa-pen-to-square"></i>
					<i data-action="validate" data-element="${dataAddElement}" class="fa-solid fa-check hidden"></i></td>
				`;
				deleteTD.innerHTML = `
					<i data-action="delete" data-element="${dataAddElement}" class="fa-solid fa-trash"></i>
					<i data-action="cancel" data-element="${dataAddElement}" class="fa-solid fa-xmark hidden"></i>
				`;

				TR.appendChild(nameTD);
				TR.appendChild(editTD);
				TR.appendChild(deleteTD);

				if(dataAddElement == "type") {
					TR.dataset.typeid = data.elementAdded;
					TBODY.appendChild(TR);

					// Rajoute le type au selecteur de type dans le skill manager
					const OPTION = document.createElement("option");
					
					OPTION.value = data.elementAdded;
					OPTION.innerHTML = INPUTValue;

					typeSELECT.appendChild(OPTION);

				} else {
					let typeTR = TBODY.querySelector(`tr[data-typeid="${typeID}"]`);
					
					// Si le type n'existe pas (car rattaché à aucune compétence ou tout juste créé)
					if(!typeTR) {
						typeTR = document.createElement("tr");

						typeTR.dataset.typeid = typeID;
						typeTR.classList.add("skillsDisplayer-type");
						typeTR.innerHTML = `<td colspan="3">${data.elementAdded.typeName}</td>`;

						TBODY.appendChild(typeTR);
					}

					TR.dataset.skillid = data.elementAdded.skillID;
					typeTR.insertAdjacentElement("afterend", TR);
					typeSELECT.selectedIndex = 0;					
				}

				const deleteI = deleteTD.querySelector("i[data-action='delete']");
				const validateI = editTD.querySelector("i[data-action='validate']");
				const editI = editTD.querySelector("i[data-action='edit']");
				const cancelI = deleteTD.querySelector("i[data-action='cancel']");
			
				deleteI.addEventListener("click", (event) => { deleteElements(event) });
				editI.addEventListener("click", (event) => { displayEditButtons(event) });
				validateI.addEventListener("click", (event) => { editElement(event) });
				cancelI.addEventListener("click", (event) => { displayEditButtons(event) });

				INPUT.value = "";
				event.target.classList.add("hidden");
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}

function deleteElements(event) {
	const deleteButton = event.target;
	const action = deleteButton.dataset.action;
	const deleteElementType = deleteButton.dataset.element;
	const deleteTBODY = document.querySelector(`body.isAdmin .content div[data-container="${deleteElementType}s"] tbody`);
	const formData = new FormData();

	let URL;
	let message;
	let deleteButtonTR;
	let deleteElemID;

	if(action == "delete") { // On cible un element spécifique, donc récupération de l'ID en fonction du type
		deleteButtonTR = deleteButton.closest("tr");
		// Récupère l'ID et prépare l'URL en fonction du type
		if(deleteElementType == "type") {
			deleteElemID = deleteButtonTR.dataset.typeid;
		} else if(deleteElementType == "skill") {
			deleteElemID = deleteButtonTR.dataset.skillid;
		} else {
			return false;
		}

		message = `Confirmer-vous la supprésion du ${deleteElementType} ?`
		formData.append("deleteElements", deleteElemID);

	} else if(action == "deleteAll") { // En case de deleteAll, pas besoind d'ID, on indique "all", on adapte seulement le message 
		message = `Confirmer-vous la supprésion de tous les ${deleteElementType}s ?`
		formData.append("deleteElements", "all");
	} else {
		return
	}

	// Adapte dynamiquement l'url en fonction du type + mise de la première lettre en uppercase
	URL = `?url=bestiaryManager/delete${deleteElementType.charAt(0).toUpperCase() + deleteElementType.slice(1)}s`;

	// Alerte de confirmation avant de supprimer
	if(window.confirm(message)) {
		// Envoie de l'objet via POST
		fetch(`/bestiary/public/${URL}`, {
			method: "POST", 
			body: formData 
		})
			.then(response => response.json())
			.then(data => {
				if(data.error) {
					console.error("Erreur :", data.error);
				} else { 
					if(action == "delete") { // Suppréssion de la ligne ciblée
						deleteButtonTR.remove();

						if(deleteElementType == "type") { // Supprimer les elements liés au type dans la page de compétences (table + addSelect)
							const typeInSkillTR = document.querySelector(`.content .skillsDisplayer tbody tr[data-typeid="${deleteElemID}"]`);
							const typeSELECT = document.querySelector(".content .skillsDisplayer .skillsDisplayer-addSkillContainer select");
							const typeOPTION = typeSELECT.querySelector(`option[value="${deleteElemID}"]`);
	
							if(typeInSkillTR) {
								if(typeInSkillTR.nextElementSibling) {
									// Supprime tous les TR de compétences jusqu'à arriver à un TR ayant un typeID en dataset
									while (typeInSkillTR.nextElementSibling && !typeInSkillTR.nextElementSibling.hasAttribute("data-typeid")) {
										typeInSkillTR.nextElementSibling.remove();
									}
								}
								// Supprime le TR du type
								typeInSkillTR.remove();	
							}
							
							// Suppréssion de l'OPTIONs = au typeID du selecteur de type dans la partie ajouter une compétence de la page compétences
							if(typeOPTION) {
								typeOPTION.remove();
							}
						}
					} else { // Suppréssion de toutes les lignes du TBODY
						const allTRs = deleteTBODY.querySelectorAll("tr");
						
						// Suppréssion des TR dans la table de la page "Types"
						if(allTRs) {
							allTRs.forEach((TR) => {
								TR.remove();
							})
						}
					
						// Supprime les elements liés au type dans la page de compétences (table + addSelect)
						if(deleteElementType == "type") { 
							const allTRInSkillsContainer = document.querySelectorAll(".content .skillsDisplayer table tbody tr");
							const typeSELECT = document.querySelector(".content .skillsDisplayer .skillsDisplayer-addSkillContainer select");
							const typeOPTIONs = typeSELECT.querySelectorAll(`option:not([value=""])`);

							// Suppréssion des TR dans la table de la page "Compétences"
							if(allTRInSkillsContainer) {
								allTRInSkillsContainer.forEach((TR)=> {
									TR.remove();
								})
							}

							// Suppréssion des OPTIONs du selecteur de type dans la partie ajouter une compétence de la page compétences
							typeOPTIONs.forEach((OPTION) => {
								OPTION.remove();
							})
						}
					}
				}
			})
			.catch(error => console.error("Erreur lors du fetch :", error));
	}
}

function displayEditButtons(event, action=false) {
	let button;

	// Si on force l'appel de la methode, on envoie directement le bouton et non pas l'event listener
	if(action == false) {
		button = event.target;
		action = button.dataset.action;
	} else {
		button = event;
	}
	
	const editButtonTR = button.closest("tr");
	// Selectionne tous les boutons dans la ligne
	const TRButtons = editButtonTR.querySelectorAll("i");
	// Selectionne L'input dans la ligne
	const INPUT = editButtonTR.querySelector("input");


	if(action == "edit") {
		INPUT.dataset.initvalue = INPUT.value;
		INPUT.disabled = false;
	} else if(action == "cancel") {
		INPUT.value = INPUT.dataset.initvalue;
		INPUT.disabled = true;
	} else {
		INPUT.disabled = true;
	}
	
	if(TRButtons) {
		// Inverse la visibilité de tous les boutons
		TRButtons.forEach((button) => {
			button.classList.toggle("hidden");
		})
	}
}

function editElement(event) {
	const editButton = event.target;
	const editElementType = editButton.dataset.element;
	const editButtonTR = editButton.closest("tr");
	const editINPUT = editButtonTR.querySelector("input");

	let editElementID;
	let URL;

	if(editElementType == "type") {
		editElementID = editButtonTR.dataset.typeid;
		URL = "?url=bestiaryManager/editTypeName";
	} else if(editElementType == "skill") {
		editElementID = editButtonTR.dataset.skillid;
		URL = "?url=bestiaryManager/editSkillName";
	}

	const formData = new FormData();
	formData.append("elemID", editElementID);
	formData.append("value", editINPUT.value);

	// Envoie de l'objet via POST
	fetch(`/bestiary/public/${URL}`, {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { 
				// Si l'elment est un type, on met à jour la valeur dans page des competences
				if(editElementType == "type") {
					const typeTDInSkillsTABLE = document.querySelector(`body.isAdmin .content .skillsDisplayer table tbody tr[data-typeid="${editElementID}"] td`);
					const typeSELECT = document.querySelector("body.isAdmin .content .skillsDisplayer select");
					const typeOPTION = typeSELECT.querySelector(`option[value="${editElementID}"]`);

					// Met à jour le TD dans la table
					if(typeTDInSkillsTABLE) {
						typeTDInSkillsTABLE.innerHTML = editINPUT.value;
					}

					// Met à jour la valeur dans le select
					if(typeOPTION) {
						typeOPTION.innerHTML = editINPUT.value;
					}
				}

				// Remet l'interface dans son état originel
				displayEditButtons(event)
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}
