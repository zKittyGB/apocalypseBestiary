// Sélectionne tous les éléments <li> du sous-menu
const submenuLIs = document.querySelectorAll("body.isAdmin .submenu[data-menu='main'] li");
const imageINPUT = document.getElementById("monsterPicture");
const previewImage = document.getElementById("previewImage");
const cropperContainer = document.getElementById("cropperContainer");
const modalCloseButton = document.querySelector(".monsterModal i[data-action='close']");
const modalDeleteButton = document.querySelector(".monsterModal i[data-action='delete']");
const modalMenuLIs = document.querySelectorAll(".monsterModal-body-menu li");
const addMonsterButtons = document.querySelectorAll(".gallery-cardContainer-card .addMonster");
const monsterModalAreaSELECT = document.querySelector(".monsterModal #monsterArea");
const typeSELECT = document.querySelector(".monsterModal #monsterType");
const modalBUTTON = document.querySelector(".monsterModal-body-actions button");
const monsterCards = document.querySelectorAll("body.isAdmin .gallery-cardContainer-card");
const monsterModal = document.querySelector(".monsterModal");

document.addEventListener("keydown", (event) => {
	if(event.key === "Escape" && monsterModal.classList.contains("active")) {
		closeMonsterModal();
	}
});

let cropper;

// Déclenche la récupération des compétences en fonction du type sélectionné
typeSELECT.addEventListener("change", (event) => {
	getSkills(event)
})

// Déclenche la récupération des habitats au changement du selecteur
monsterModalAreaSELECT.addEventListener("change", (event) => {
	getHabitats(event);
});

// Déclenche la fermeture de la modale
modalCloseButton.addEventListener("click", closeMonsterModal);
modalDeleteButton.addEventListener("click", deleteMonster);

// Gestion du boouton suivant/terminé dans l'admin modal
if(monsterCards) {
	monsterCards.forEach((card) => {
		card.addEventListener("click", (event) => {
			handleMonsterCard(event);
		})
	})
}

imageINPUT.addEventListener("change", function (event) {
	const file = event.target.files[0];
	
	if(file) {
		cropperContainer.classList.remove("hidden");
		
		const reader = new FileReader();
		reader.onload = function (e) {
			previewImage.src = e.target.result;
	
			// Une fois l'image chargée, on initialise Cropper.js
			if(cropper) {
				cropper.destroy();
			}
			cropper = new Cropper(previewImage, {
				viewMode: 2,
				autoCropArea: 1,
				movable: true,
				zoomable: true,
				scalable: false,
				rotatable: false
			});
			
		};
		reader.readAsDataURL(file);
	}
});

function closeMonsterModal() {
	const modalMonster = document.querySelector(".monsterModal");
	const allSELECTs = modalMonster.querySelectorAll("select");
	const allINPUTs = modalMonster.querySelectorAll("input");
	const allTEXTAREAs = modalMonster.querySelectorAll("textarea");
	const allSkillLists = modalMonster.querySelectorAll(".monsterModal-body-content-sheets-skills-container-skillsList");
	const monsterDetailsLI = monsterModal.querySelector(".monsterModal-body-menu li.active");
	const monsterDetailsContainer = monsterModal.querySelector(".monsterModal-body div[data-container].active");
	const datasetInitValues = modalMonster.querySelectorAll("[data-initvalue]");

	// Supprime chaque attribut initvalue
	datasetInitValues.forEach((element) => {
		element.removeAttribute("data-initvalue");
	})

	monsterDetailsLI.classList.remove("active");
	monsterDetailsContainer.classList.remove("active");

	allSELECTs.forEach((SELECT) => {
		SELECT.value = "";
		if(SELECT.id == "monsterHabitat") {
			SELECT.textContent = "<option value='' hidden>Choisir un habitat</option>";
		}
	})
	allINPUTs.forEach((INPUT) => {
		INPUT.value = "";
	})
	allTEXTAREAs.forEach((TEXTAREA) => {
		TEXTAREA.value = "";
	})
	allSkillLists.forEach((SKILLLIST) => {
		SKILLLIST.textContent = "";
	})

	cropperContainer.classList.add("hidden");
	if(cropper) {
		cropper.destroy();
		cropper = null;
	}
	previewImage.src = "";

	modalMonster.classList.remove("active");
}

modalMenuLIs.forEach((LI) => {
	LI.addEventListener("click", (event) => {
		const activeLIs = document.querySelectorAll(".monsterModal-body-menu li.active");
		const activeContainers = document.querySelectorAll(".monsterModal-body-content-sheets.active");
		const containerToDisplay = event.target.dataset.container;
		const newActiveContainer = document.querySelector(`.monsterModal-body-content-sheets[data-container="${containerToDisplay}"]`)

		if(activeLIs) {
			// Retire la classe d'affichage sur les autres LI et container (jamais plus de 1, mais le foreach peut éviter d'éventuel bug)
			activeLIs.forEach((activeLI) => {
				activeLI.classList.remove("active");
			})

			activeContainers.forEach((activeContainer) => {
				activeContainer.classList.remove("active");
			})
		}

		event.target.classList.add("active");
		newActiveContainer.classList.add("active");
	})
})

addMonsterButtons.forEach((addButton) => {
	addButton.addEventListener("click", (event) => {
		const rankID = event.target.dataset.rankid;
		const rankOrder = event.target.dataset.rankorder;
		const monsterModal = document.querySelector(".monsterModal");
		const monsterDetailsLI = monsterModal.querySelector(".monsterModal-body-menu li");
		const monsterDetailsContainer = monsterModal.querySelector(".monsterModal-body div[data-container='descriptions']");
		const rankSELECT = monsterModal.querySelector("#monsterRank");
		const selectedOPTION = rankSELECT.querySelector(`option[value="${rankID}"]`);
		const masterSELECT = monsterModal.querySelector("#monsterMaster");

		// Préselectionne l'option du rank en fonction du bouton "ajouter" cliqué
		selectedOPTION.selected = true;
		
		modalBUTTON.textContent = "Ajouter monstre";
		modalBUTTON.dataset.action = "addMonster";

		// Affiche la modal et le premier onglet de la modale
		monsterDetailsLI.classList.add("active");
		monsterDetailsContainer.classList.add("active");
		monsterModal.classList.add("active");

		updateDisplayByRankValue(rankOrder, masterSELECT);

		// Ajoute la fonction de mise à jour de l'interface sur le changement du rank select
		rankSELECT.addEventListener("change", () => {
			const selectedOPTION = rankSELECT.options[rankSELECT.selectedIndex];
			const newRankOrder = selectedOPTION.dataset.rankorder;
			updateDisplayByRankValue(newRankOrder, masterSELECT)
		})

		
	})
})

function updateDisplayByRankValue(rankOrder, masterSELECT) {
	const allOPTIONs = masterSELECT.querySelectorAll("option[data-rankorder]");
	
	allOPTIONs.forEach((OPTION) => {
		OPTION.hidden = false;
	})

	// Si le rank n'est pas le plus haut on adapte le span d'appartenance
	if(rankOrder > 1) {
		// Rank le plus élevé, il ne peut donc pas avoir de maitre
		masterSELECT.parentElement.classList.remove("hidden");
		masterSELECT.classList.remove("hidden");

		const rankOrderInt = parseInt(rankOrder, 10);

		// Cache les options du selecteur de tous les monstres n'étant pas égaux au rank -1
		const cantBeMasterOPTIONs = masterSELECT.querySelectorAll(`option:not([data-rankorder="${rankOrderInt - 1}"])`);
		
		cantBeMasterOPTIONs.forEach((OPTION) => {
			if(OPTION.value != "") {
				OPTION.hidden = true;
			}
		})
	} else { 
		// Rank le plus élevé, il ne peut donc pas avoir de maitre
		masterSELECT.parentElement.classList.add("hidden");
		masterSELECT.classList.add("hidden");
	}
}

/**
 * Récupère la liste des habitats en fonction de la zone et met à jour le select habitat
 * @param {Event} event - Événement de clic
 */
function getHabitats(event) {
	const areaID = event.target.value;

	if(!areaID) {
		console.error("Erreur : Aucun ID de zone fourni.");
		return;
	}
    
	fetch(`/bestiary/public/?url=habitats/getAreaHabitats&areaID=${areaID}`)
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { // Si la requête a réussi
				const habitatsSELECT = document.querySelector(".monsterModal #monsterHabitat");
				
				// Vide le selecteur
				habitatsSELECT.textContent = "";

				// Création de l'option vide
				const OPTION = document.createElement("option");
				
				OPTION.value = "";
				OPTION.textContent = "Sélectionner un habitat";
				OPTION.selected = true;
				OPTION.hidden = true;

				// Ajout de l'option dans le DOM
				habitatsSELECT.appendChild(OPTION);

				// Création des options pour chaque résultat obtenu
				data.forEach((habitat) => {
					const existingOption = habitatsSELECT.querySelector(`option[value="${habitat.habitatID}"]`);
					if(!existingOption) {
						const OPTION = document.createElement("option");
						
						OPTION.value = habitat.habitatID;
						OPTION.textContent = habitat.habitatName;

						habitatsSELECT.appendChild(OPTION);
					}
				})
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}

/**
 * Récupère la liste des compétences en fonction du type de monstre sélectionné
 * @param {Event} event - Événement de clic
 */
function getSkills(event) {
	const typeID = event.target.value;

	if(!typeID) {
		console.error("Erreur : Aucun ID de zone fourni.");
		return;
	}
    
	fetch(`/bestiary/public/?url=skills/getTypeSkills&typeID=${typeID}`)
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { // Si la requête a réussi
				const skillsContainers = document.querySelectorAll(".monsterModal-body-content-sheets-skills-container-skillsList");
				skillsContainers.forEach((container) => {
					container.textContent = "";
				})
				if(data) {
					let count = 1;
					data.forEach((skill) => {
						const inputContainer = document.createElement("div");
						const INPUT = document.createElement("input");
						const LABEL = document.createElement("label");
	
						LABEL.textContent = decodeHtmlEntities(skill.skillName);
						LABEL.for = `skill_${skill.skillID}`;
						INPUT.id = `skill_${skill.skillID}`;
						INPUT.dataset.skillid = skill.skillID;
						INPUT.dataset.initvalue = "false";
						INPUT.type = "checkbox";
						INPUT.value = skill.skillID;
						inputContainer.classList.add("inputContainer");
	
						inputContainer.appendChild(LABEL);
						inputContainer.appendChild(INPUT);

						if(count <= 3) {
							skillsContainers[0].appendChild(inputContainer);
						} else {
							skillsContainers[1].appendChild(inputContainer);
						}
					})
				}
				
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}

modalBUTTON.addEventListener("click", () => {
	if(modalBUTTON.dataset.action === "update") {
		updateMonster();
	} else {
		addMonster();
	}
});

function addMonster() {
	const modalMonster = document.querySelector(".monsterModal");
	const allSELECTs = modalMonster.querySelectorAll("select");
	const allINPUTsText = modalMonster.querySelectorAll("input[type='text']");
	const allTEXTAREAs = modalMonster.querySelectorAll("textarea");
	const allCheckedINPUTs = modalMonster.querySelectorAll("input[type='checkbox']:checked");
	// Vérifie que tous les élements required soit complete
	const requiredElements = modalMonster.querySelectorAll("[required]:not(.hidden)");
	const emptyRequiredElements = [];

	requiredElements.forEach((element) => {
		if(element.value == ""){
			const elementLABEL = element.closest("div").querySelector("label");
			
			emptyRequiredElements.push(element);
			elementLABEL.classList.add("requiredError");
			element.classList.add("requiredError");

			element.addEventListener("input", () => {
				elementLABEL.classList.remove("requiredError");
				element.classList.remove("requiredError");
			})
		}
	})

	// Bloque si des inputs obligés non rempli
	if(emptyRequiredElements.length > 0) {
		return;
	}

	const monsterData = {monsterSkills: [], monsterStrengthes: [], monsterWeaknesses: []};

	allSELECTs.forEach((SELECT) => {
		monsterData[SELECT.id] = SELECT.value;
	})

	allINPUTsText.forEach((INPUT) => {
		if(INPUT.id) {
			monsterData[INPUT.id] = INPUT.value;
		} else {
			const INPUTdataset = INPUT.dataset.type;
			monsterData[INPUTdataset].push(INPUT.value);
		}
	})

	allTEXTAREAs.forEach((TEXTAREA) => {
		monsterData[TEXTAREA.id] = TEXTAREA.value;
	})

	allCheckedINPUTs.forEach((CHECKEDINPUT) => {
		monsterData["monsterSkills"].push(CHECKEDINPUT.dataset.skillid);
	})

	const formData = new FormData();
	// Ajouter les autres données du monstre
	Object.keys(monsterData).forEach(key => {
		if(key === "monsterSkills" || key === "monsterStrengthes" || key === "monsterWeaknesses") {
			formData.append(key, JSON.stringify(monsterData[key]));
		} else {
			formData.append(key, monsterData[key]);
		}
	});

	// Vérification de l'image 
	if(cropper) {
		cropper.getCroppedCanvas().toBlob((blob) => {
			if(blob) {
				formData.append("monsterPicture", blob, "cropped_image.png");

				// Envoie de l'objet via POST
				fetch(`/bestiary/public/?url=bestiaryManager/addMonster`, {
					method: "POST", 
					body: formData 
				})
					.then(response => response.json())
					.then(data => {
						if(data.error) {
							console.error("Erreur :", data.error);
						} else { 
							const monster = data.monster;
							const monsterRank = monster.monsterRank;
							const monsterID = monster.monsterID;
							const rankContainer = document.querySelector(`.content div[data-rankid="${monsterRank}"]`);

							 // Créer l'élément div principal
							const cardDiv = document.createElement("div");
							const img = document.createElement("img");
							const nameSpan = document.createElement("span");

							cardDiv.classList.add("gallery-cardContainer-card");
							cardDiv.dataset.rankid = monsterRank; 
							cardDiv.dataset.monsterid = monsterID; 

							// Créer l'image
							img.src = `/bestiary/public/uploads/monsters/${monster.monsterPicture}`;
							img.alt = `Image de ${monster.monsterName}`;

							// Créer le span pour le nom
							nameSpan.textContent = monster.monsterName;

							cardDiv.appendChild(img);
							cardDiv.appendChild(nameSpan);
							rankContainer.appendChild(cardDiv);
							cardDiv.addEventListener("click", (event) => {
								handleMonsterCard(event);
							})
							closeMonsterModal();

						}
					})
					.catch(error => console.error("Erreur lors du fetch :", error));
			}
		}, "image/png");
	}
}

function updateMonster() {
	const modalMonster = document.querySelector(".monsterModal");
	const monsterID = modalMonster.dataset.id;
	const datasetInitValues = modalMonster.querySelectorAll("[data-initvalue]");
	const changedValues = {"monsterSkills": [], "monsterStrengthes": [], "monsterWeaknesses": []};
	const formData = new FormData();
	const strengthes = document.querySelectorAll(".monsterModal-body-content-sheets-strengthes input");
	const weaknesses = document.querySelectorAll(".monsterModal-body-content-sheets-weaknesses input");

	// Compare chaque élement initvalue avec son valeur actuelle
	datasetInitValues.forEach((element) => {
		if(element.type !== "checkbox") {
			const initValue = element.dataset.initvalue;
			const currentValue = element.value;
		    
			// ID de l'input en clé et valeur en association
			if(initValue !== currentValue) {
			    changedValues[element.id] = currentValue;
			}
		} else {
			if(element.checked) {
				changedValues["monsterSkills"].push(element.dataset.skillid);
			}
		}
	})

	strengthes.forEach((strength) => {
		if(strength.dataset.initvalue !== strength.value) {
			changedValues["monsterStrengthes"].push(strength.value);
		}
	})

	weaknesses.forEach((weakness) => {
		if(weakness.dataset.initvalue !== weakness.value) {
			changedValues["monsterWeaknesses"].push(weakness.value);
		}
	})

	formData.append("monsterID", monsterID); 

	// Ajouter les autres données du monstre
	Object.keys(changedValues).forEach(key => {
		if(key === "monsterSkills" || key === "monsterStrengthes" || key === "monsterWeaknesses") {
			formData.append(key, JSON.stringify(changedValues[key]));
		} else {
			formData.append(key, changedValues[key]);
		}
	});

	// Envoie de l'objet via POST
	fetch("/bestiary/public/?url=bestiaryManager/updateMonster", {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { 
				Object.keys(changedValues).forEach(key => {
					if(key !== "monsterSkills" && key !== "monsterStrengthes" && key !== "monsterWeaknesses" && key !== "") {
						console.log(key)
						document.querySelector(`#${key}`).dataset.initvalue = changedValues[key]; 
					}
				});
				alert("Les modifications ont bien été enregistrées !");
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
			
	
}

function deleteMonster() {
	const modalMonster = document.querySelector(".monsterModal");
	const monsterID = modalMonster.dataset.id;
	const formData = new FormData();
	console.log("patate")
	formData.append("monsterID", monsterID); 

	if(!confirm("Confirmez-vous la suppréssion du monstre ?")) {
		return;
	}
	// Envoie de l'objet via POST
	fetch(`/bestiary/public/?url=bestiaryManager/deleteMonster`, {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			console.log(data)
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { 
				const card = document.querySelector(`.gallery-cardContainer-card[data-monsterid="${monsterID}"]`);
				card.remove();
				closeMonsterModal();

			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
			
	
}

// Vérifie si des éléments <li> du sous-menu existent avant d'ajouter des écouteurs d'événements
if(submenuLIs) {
	submenuLIs.forEach((LI) => {
		LI.addEventListener("click", (event) => {
			displayContainer(event); // Appelle la fonction pour afficher le bon container
		});
	});
}

/**
 * Affiche le bon container en fonction du menu cliqué
 * @param {Event} event - Événement de clic
 */
function displayContainer(event) {
	// Vérifie qu'aucun inute tableau ne soit en cours d'edition
	const allCancelButtons = document.querySelectorAll("body.isAdmin .content i[data-action='cancel']:not(.hidden)");
	const allAddBUTTONs = document.querySelectorAll("body.isAdmin .content button[data-action='add']:not(.hidden)");

	if(allCancelButtons.length > 0 || allAddBUTTONs.length > 0) {
		if(window.confirm("Certains changements ne seront pas sauvegardé, continuer ?")) {
			// Si on était dans une edition
			if(allCancelButtons.length > 0) {
				allCancelButtons.forEach((button) => {
					displayEditButtons(button, action="cancel");
				})
			}

			// Si se sont les boutons d'ajout
			if(allAddBUTTONs.length > 0) {
				allAddBUTTONs.forEach((button) => {
					const parentButton = button.parentElement;
					parentButton.querySelector("input").value = "";
					button.classList.add("hidden");
				})
			}
		} else {
			return;
		}
	}


	const dataContainer = event.target.dataset.container; // Récupère l'attribut data-container de l'élément cliqué
	const NAVMenu = event.target.closest("nav");
	// Sélectionne tous les éléments actifs dans le sous-menu
	const allActiveMenus = NAVMenu.querySelectorAll(".active");
	const typeMenu = NAVMenu.dataset.menu;


	// Sélectionne tous les containers actifs associés au sous-menu
	const allActiveContainers = (typeMenu == "main" 
		? document.querySelectorAll("body.isAdmin:has(.submenu) div.active") 
		: document.querySelectorAll(".adminModal-content-addMonster-part div.active"));

	// Sélectionne le nouveau container à afficher en fonction du data-container récupéré
	const newActiveContainer = document.querySelector(`body.isAdmin:has(.submenu) div[data-container='${dataContainer}']`);

	// Supprime la classe active de tous les containers actifs
	allActiveContainers.forEach((container) => {
		container.classList.remove("active");
	});

	// Supprime la classe active de tous les éléments de menu actifs
	allActiveMenus.forEach((menu) => {
		menu.classList.remove("active");
	});

	// Ajoute la classe active à l'élément du menu cliqué
	event.target.classList.add("active");

	// Ajoute la classe active au container correspondant au menu cliqué
	newActiveContainer.classList.add("active");
}

/**
 * Récupère les infos d'un monstre par son ID
 * @param {Event} event - Événement de clic
 */
function handleMonsterCard(event) {
	// Trouve l'élément parent contenant l'ID du monstre
	const divParent = event.target.closest("[data-monsterid]");
	
	if(!divParent) { return };
	
	const monsterID = divParent.dataset.monsterid;
	const formData = new FormData();

	if(!monsterID) { return };
	
	formData.append("monsterID", monsterID)
	// Envoi des données via une requête POST
	fetch(`/bestiary/public/?url=bestiaryManager/getMonster`, {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { 
				// Récupération des éléments du modal
				const monsterModal = document.querySelector(".monsterModal");
				const monsterModalAreaSELECT = monsterModal.querySelector("#monsterArea");
				const rankSELECT = monsterModal.querySelector("#monsterRank");
				const typeSELECT = monsterModal.querySelector("#monsterType");
				const habitatSELECT = monsterModal.querySelector("#monsterHabitat"); 
				const masterSELECT = monsterModal.querySelector("#monsterMaster");
				const previewImage = monsterModal.querySelector("#previewImage");
				const cropperContainer = monsterModal.querySelector("#cropperContainer");
				const skillContainer = monsterModal.querySelector(".monsterModal-body-content-sheets-skills-container");
				const autoInsertElements = ["monsterAdvice", "monsterBehavior", "monsterDescription", "monsterName","monsterMaster", "monsterRank", "monsterArea", "monsterType", "monsterDanger"];
				const monsterDetailsLI = monsterModal.querySelector(".monsterModal-body-menu li");
				const monsterDetailsContainer = monsterModal.querySelector(".monsterModal-body div[data-container='descriptions']");

				monsterModal.dataset.id = monsterID;

				modalBUTTON.textContent = "Modifier";
				modalBUTTON.dataset.action = "update";

				monsterDetailsLI.classList.add("active");
				monsterDetailsContainer.classList.add("active");

				updateDisplayByRankValue(data.monster.rankOrder, masterSELECT);

				// Insère chaque valeur dans les INPUTs et ajoute un dataset pour comparer avec la valeur initiale
				Object.entries(data.monster).forEach(([key, value]) => {
					if(autoInsertElements.includes(key)) {
						const inputElement = monsterModal.querySelector(`#${key}`);
						if(inputElement) {
							inputElement.value = decodeHtmlEntities(value);
							inputElement.dataset.initvalue = decodeHtmlEntities(value);
							inputElement.setAttribute("aria-label", key.replace("monster", "")); // Ajout d'aria-label
						}
					}
				});

				// Déclenche un événement "change" pour mettre à jour les éléments dynamiques
				[monsterModalAreaSELECT, rankSELECT, typeSELECT].forEach(select => {
					if(select) {
						select.dispatchEvent(new Event("change"));
					}
				});

				// Ajout d'un délai pour la mise à jour du DOM
				setTimeout(() => {
					// Met à jour l'habitat après l'événement "change"
					habitatSELECT.value = data.monster.monsterHabitat;
					habitatSELECT.dataset.initvalue = data.monster.monsterHabitat;
						habitatSELECT.setAttribute("aria-label", "Habitat du monstre");
					
					// Vérifie et coche les compétences du monstre
					if(data.monster.monsterSkills.length > 0) {
						data.monster.monsterSkills.forEach((skill) => {
							const skillCheckbox = skillContainer.querySelector(`input[data-skillid="${skill.skillID}"]`);
							if(skillCheckbox) {
								skillCheckbox.checked = true;
								skillCheckbox.dataset.initvalue = "true";
								skillCheckbox.setAttribute("aria-label", `Compétence : ${skill.skillID}`);
							}
						})
					}
				}, 200);

				// Met à jour l'image du monstre
				previewImage.src = `/bestiary/public/uploads/monsters/${data.monster.monsterPicture}`;
				previewImage.dispatchEvent(new Event("change"));
				previewImage.setAttribute("alt", `Image de ${data.monster.monsterName}`);

				// Ajout des forces et faiblesses du monstre
				if(data.monster.monsterStrengthes.length > 0 && data.monster.monsterStrengthes.length < 4) {
					data.monster.monsterStrengthes.forEach((strength, index) => {
						const UL = document.querySelector(".monsterModal-body-content-sheets-strengthes ul");
						const LI = UL.querySelector(`li:nth-child(${index + 1})`); 
						const INPUT = LI.querySelector("input");
						INPUT.value = strength;
						INPUT.dataset.initvalue = strength;
						INPUT.setAttribute("aria-label", `Force ${index + 1}`);
					})
					data.monster.monsterWeaknesses.forEach((weakness, index) => {
						const UL = document.querySelector(".monsterModal-body-content-sheets-weaknesses ul");
						const LI = UL.querySelector(`li:nth-child(${index + 1})`); 
						const INPUT = LI.querySelector("input");
						INPUT.value = weakness;
						INPUT.dataset.initvalue = weakness;
						INPUT.setAttribute("aria-label", `Faiblesse ${index + 1}`);
					})
				}

				// Affiche la zone de recadrage et active la modal
				cropperContainer.classList.remove("hidden");
				monsterModal.classList.add("active");
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
};

function decodeHtmlEntities(str) {
	let txt = document.createElement("textarea");
	txt.innerHTML = str;
	return txt.value;
}