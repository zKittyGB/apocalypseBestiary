const addButton = document.querySelectorAll(".gallery-cardContainer-card .addHabitat, .gallery-cardContainer-card .addSafePlace");
const areaModal = document.querySelector(".areaModal");
const areaModalIMGs = areaModal.querySelectorAll(".areaModal-content-pictureContainer-add img");
const previewImage = document.getElementById("previewImage");
const cropperContainer = document.getElementById("cropperContainer");
const imageINPUT = document.getElementById("addElementPicture");
const mapLIs = document.querySelectorAll(".areaModal-content-pictureContainer-list li");
const validateAddButton = document.querySelector(".areaModal-body-actions button");
const closeModalButton = document.querySelector(".areaModal i[data-action='close']");
const deleteModalButton = document.querySelector(".areaModal i[data-action='delete']");
const addMethodButtons = document.querySelectorAll(".areaModal-addMethod > div[data-method]");
const existingElements = areaModal.querySelectorAll(".existingElement .gallery-cardContainer-card");
const galleryCards = document.querySelectorAll(".areasManager-content .gallery-cardContainer-card");
const menuLIs = document.querySelectorAll(".submenu li");

// Variable globale pour stocker les coordonnées(en %) sur la map lors de l'ajut d'un habitat
let clickCoordinates = [];
let cropper;

// Gestion des boutons
validateAddButton.addEventListener("click", handleValidateAddButton);
deleteModalButton.addEventListener("click", deleteElement);
closeModalButton.addEventListener("click", closeAreaModal);

// Fermeture de la modale via le clavier
document.addEventListener("keydown", (event) => {
	if(event.key === "Escape" && areaModal.classList.contains("active")) {
		closeAreaModal();
	}
});

// Gestion du clic sur une carte autre que l'ajout d'un habitat
galleryCards.forEach((card) => {
	card.addEventListener("click", (event) => {
		if(!card.querySelector(".addHabitat") && !card.querySelector(".addSafePlace")) {
			handleClickCard(event);
		}
	})
});

addButton.forEach((addButton) => {
	addButton.addEventListener("click", (event) => {
		const areaID = event.target.dataset.areaid;
		const type = event.target.dataset.type;
		const areaModalLI = areaModal.querySelector(`li[data-areaid="${areaID}"]`);
		const areaModalImg = areaModal.querySelector(`img[data-areaid="${areaID}"]`);
		const addMethodContainer = document.querySelector(".areaModal-addMethod");
		const existingElement = document.querySelector(".existingElement");
		const existingElements = existingElement.querySelectorAll(".gallery-cardContainer-card");
		const sameTypeExistingElements = existingElement.querySelectorAll(`.gallery-cardContainer-card[data-type="${type}"]`);

		// Affiche le choix de la methode d'ajout selon si des elements existent déjà pour ce type
		if(existingElements.length > 0) {
			if(existingElement.dataset.type != type) {
				existingElement.classList.add("hidden"); 
			} else {
				existingElement.classList.remove("hidden");
			}

			if(sameTypeExistingElements.length > 0) {
				// Cache par défaut l'élement des élements existants
				existingElement.classList.remove("hidden");

				// Affiche le contenu de la modale
				addMethodContainer.classList.add("active");
			}
		}

		// Ajout du type en dataset à la modale
		areaModal.dataset.type = type;
		areaModal.dataset.areaid = areaID;
		
		
		areaModalLI.classList.add("active");
		areaModalImg.classList.add("active");

		addMethodButtons.forEach((addMethodButton) => {
			addMethodButton.classList.remove("hidden");
		})

		areaModal.classList.add("active");
	});
})

// Gestion du bouton de création d'un nouveau ou d'un élément existant
addMethodButtons.forEach((addMethodButton) => {
	addMethodButton.addEventListener("click", (event) => {
		const addMethodContainer = document.querySelector(".areaModal-addMethod");
		const method = event.target.dataset.method;

		if(method === "new") {
			// Passe par la création complète d'un habitat
			addButton.forEach(() => {
				addMethodContainer.classList.remove("active");
			})
		} else {
			// Affiche la liste des éléments existants
			addButton.forEach(() => {
				const existingElement = document.querySelector(".existingElement");

				existingElement.classList.add("active");

				// Cache les boutons
				addMethodButtons.forEach((addMethodButton) => {
					addMethodButton.classList.add("hidden");
				})
			})
		}
	})
})

// Gestion du clic sur un élément existant
existingElements.forEach((element) => {
	element.addEventListener("click", async (event) => {
		const areaModal = document.querySelector(".areaModal");
		const addMethodContainer = areaModal.querySelector(".areaModal-addMethod");
		const card = event.target.closest(".gallery-cardContainer-card");
		const elementType = card.dataset.type;
		let elementID;
		let data;
		clickCoordinates = [];

		if(elementType === "habitats") {
			elementID = card.dataset.habitatid;
			data = await getHabitat(elementID);
		} else {
			elementID = card.dataset.safeplaceid;
			data = await getSafePlace(elementID);
		}

		areaModal.dataset.existingelement = elementID;


		// Ajoute les coordonnées à l'élément
		if(data) {
			const areaModalIMGContainer = areaModal.querySelector(".areaModal-content-pictureContainer-add");
			const defaultAreaID = areaModal.dataset.areaid;
			const inputName = areaModal.querySelector("#addElementName");
			const previewImage = areaModal.querySelector("#previewImage");
			const cropperContainer = areaModal.querySelector("#cropperContainer");

			// Met à jour le nom de l'élément
			inputName.value = data.element.name;
			inputName.dataset.value = data.element.name;

			cropperContainer.classList.remove("hidden");

			if(elementType === "habitats") {
				previewImage.src = `/bestiary/public/uploads/habitats/${data.element.picture}`;
			} else {
				previewImage.src = `/bestiary/public/uploads/safePlaces/${data.element.picture}`;
			}


			// Utilise Object.entries pour itérer sur les clés et valeurs de l'objet coordinates
			Object.entries(data.element.coordinates).forEach(([areaID, coordinatesGroup]) => {
				// Pour chaque chaîne JSON de coordonnées dans le groupe
				coordinatesGroup.forEach((coordinateString, index) => {
					const coordinate = JSON.parse(coordinateString);
					// Création d'un élément pour représenter le pin
					const pin = document.createElement("div");
					pin.classList.add("pin");

					if(defaultAreaID != areaID) {
						pin.classList.add("hidden");
					}

					// Stocke l'indice et l'areaID dans des data-attributes
					pin.dataset.index = index;
					pin.dataset.areaid = areaID;
					
					// Positionne le pin en utilisant les pourcentages récupérés
					pin.style.left = `${coordinate.xPercent}%`;
					pin.style.top = `${coordinate.yPercent}%`;

					// Ajoute le pin au conteneur (assure-toi que le conteneur est en position relative)
					areaModalIMGContainer.appendChild(pin);
					
					pin.addEventListener("click", (event) => {
						const index = event.target.dataset.index;
						clickCoordinates.splice(index, 1);
						pin.remove();
					})

					// Stocke les coordonnées dans le tableau global
					clickCoordinates.push({ "xPercent": coordinate.xPercent, "yPercent": coordinate.yPercent, "areaID": areaID });
				});
			});
		}

		// Cache par défaut l'élément des éléments existants
		addMethodContainer.classList.remove("active");
	});
});

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

areaModalIMGs.forEach((areaModalIMG) => {
	// Écoute du clic sur l'image de la modale
	areaModalIMG.addEventListener("click", (event) => {
		// Récupération de la position et de la taille de l'image
		const rect = areaModalIMG.getBoundingClientRect();
		const areaID = event.target.dataset.areaid;

		// Calcul des coordonnées du clic par rapport à l'image
		const x = event.clientX - rect.left;
		const y = event.clientY - rect.top;

		// Conversion en pourcentage
		const xPercent = (x / rect.width) * 100;
		const yPercent = (y / rect.height) * 100;

		// Stockage des coordonnées pour les réutiliser après le choix du fichier
		clickCoordinates.push({ "xPercent": xPercent, "yPercent": yPercent, "areaID": areaID });

		// Si un fichier est sélectionné et que les coordonnées existent, ajout d' un "pin" sur l'image
		if(xPercent && yPercent) {
			// Créer un élément pour représenter le pin
			const pin = document.createElement("div");
			pin.classList.add("pin");
			
			pin.dataset.index = clickCoordinates.length - 1;
			pin.dataset.areaid = areaID;

			pin.style.left = `${xPercent}%`;
			pin.style.top = `${yPercent}%`;

			areaModalIMG.parentElement.appendChild(pin);

			pin.addEventListener("click", (event) => {
				const index = event.target.dataset.index;
				clickCoordinates.splice(index, 1);
				pin.remove();
			})
		}
	});
});

menuLIs.forEach((menuLI) => {
	menuLI.addEventListener("click", (event) => {
		const menuLI = event.target;
		const container = menuLI.dataset.container;
		const activeContainer = document.querySelector(`.areasDisplayer[data-container="${container}"]`);
		const allContainers = document.querySelectorAll(".areasDisplayer");

		menuLIs.forEach((menuLI) => {
			menuLI.querySelector("h3").classList.remove("active");
		})
		
		allContainers.forEach((container) => {
			container.classList.remove("active");
		})

		menuLI.classList.add("active");
		activeContainer.classList.add("active");
	})
})

mapLIs.forEach((mapLI) => {
	mapLI.addEventListener("click", (event) => {
		const allActiveLIs = document.querySelectorAll(".areaModal-content-pictureContainer-list li.active");
		const allActiveIMG = document.querySelectorAll(".areaModal-content-pictureContainer img.active");
		const areaID = event.target.dataset.areaid;
		const newActiveIMG = document.querySelector(`.areaModal-content-pictureContainer img[data-areaid="${areaID}"]`);
		const allPinS = document.querySelectorAll(".pin");

		allPinS.forEach((pin) => {
			if(pin.dataset.areaid != areaID) {
				pin.classList.add("hidden");
			} else {
				pin.classList.remove("hidden");
			}
		})

		// Retrait de la classe active de tous les éléments actifs
		allActiveLIs.forEach((activeLI) => {
			activeLI.classList.remove("active");
		})

		// Retrait de la classe active de tous les éléments actifs
		allActiveIMG.forEach((activeLI) => {
			activeLI.classList.remove("active");
		})
		
		newActiveIMG.classList.add("active");
		mapLI.classList.add("active");
	})
})

/**
 * Récupère un habitat par son ID
 * @param {string} habitatID - L'ID de l'habitat
 */
async function getHabitat(habitatID) {
	if(!habitatID) return null;
    
	const formData = new FormData();
	formData.append("habitatID", habitatID);
    
	const response = await fetch(`/bestiary/public/?url=areasManager/getHabitat`, {
		method: "POST", 
		body: formData 
	});
	const data = await response.json();
	if(data.error) {
		console.error("Erreur :", data.error);
		return null;
	}
	return data;
}

/**
 * Récupère un safePlace par son ID
 * @param {string} safePlaceID - L'ID du safePlace
 */
async function getSafePlace(safePlaceID) {
	if(!safePlaceID) return null;
    
	const formData = new FormData();
	formData.append("safePlaceID", safePlaceID);
    
	const response = await fetch(`/bestiary/public/?url=areasManager/getSafePlace`, {
		method: "POST", 
		body: formData 
	});
	const data = await response.json();
	if(data.error) {
		console.error("Erreur :", data.error);
		return null;
	}
	return data;
}

function handleClickCard(event) {
	const areaID = event.target.closest("[data-areaid]").dataset.areaid;
	const elementType = event.target.closest("[data-type]").dataset.type;
	const areaModalImg = areaModal.querySelector(`img[data-areaid="${areaID}"]`);

	let elementID;
	let existingElement;

	// Ajout du type en dataset à la modale
	areaModal.dataset.type = elementType;
	areaModal.dataset.areaid = areaID;

	// Récupération de l'ID en fonction du type
	if(elementType === "habitats") {
		elementID = event.target.closest("[data-habitatid]").dataset.habitatid;
	} else {
		elementID = event.target.closest("[data-type]").dataset.safeplaceid;
	}

	// Ajout de l'ID de l'élément existant
	areaModal.dataset.existingelement = elementID;

	const clickEvent = new Event("click");

	if(elementType === "habitats") {
		existingElement = document.querySelector(`.existingElement [data-habitatid="${elementID}"]`);
	} else {
		existingElement = document.querySelector(`.existingElement [data-safeplaceid="${elementID}"]`);
	}
	existingElement.dispatchEvent(clickEvent);

	areaModalImg.classList.add("active");
	areaModal.classList.add("active");
}

function closeAreaModal() {
	const areaModal = document.querySelector(".areaModal");
	const areaModalActives = areaModal.querySelectorAll(".active");
	const INPUTName = areaModal.querySelector("#addElementName");
	const allPins = document.querySelectorAll(".pin");
	const existingElement = document.querySelector(".existingElement");

	// Suppréssion des pins
	allPins.forEach((pin) => {
		pin.remove();
	})

	// Nettoyage des données
	INPUTName.value = "";
	INPUTName.dataset.value = "";

	// Retrait de la classe active de tous les éléments actifs
	areaModalActives.forEach((activeElement) => {
		activeElement.classList.remove("active");
	})

	// Réinitialise la zone image
	cropperContainer.classList.add("hidden");
	if(cropper) {
		cropper.destroy();
		cropper = null;
	}
	previewImage.src = "";
	
	// Retire le data-existingelement de la modale
	areaModal.dataset.existingelement = "";

	// Cache la modale
	areaModal.classList.remove("active");
	existingElement.classList.remove("active");
	clickCoordinates = [];
}

function handleValidateAddButton() {
	const areaModal = document.querySelector(".areaModal");
	const addType = areaModal.dataset.type;
	const existingElement = areaModal.dataset.existingelement;
	if(!existingElement) {
		addElement(addType);
	} else {
		updateElement(existingElement, addType);
	}
}

function addElement(addType) {
	const elementName = document.getElementById("addElementName").value;
	const formData = new FormData();

	if(!elementName) {
		alert("Veuillez entrer un nom pour l'élément");
		return;
	}

	let pathEnd;
	if(addType == "safePlaces") { 
		pathEnd = "addSafePlace";
	} else {
		pathEnd = "addHabitat";
	}

	formData.append("elementName", elementName);
	formData.append("coordinates", JSON.stringify(clickCoordinates));

	// Vérification de l'image 
	if(cropper) {
		cropper.getCroppedCanvas().toBlob((blob) => {
			if(blob) {
				formData.append("elementPicture", blob, "cropped_image.png");
				fetch(`/bestiary/public/?url=areasManager/${pathEnd}`, {
					method: "POST", 
					body: formData 
				})
					.then(response => response.json())
					.then(data => {
						if(data.error) {
							console.error("Erreur :", data.error);
						} else { 
							// Création d'une carte si elle n'existe pas
							let existingElement;
							data.addedElement.areaIDs.forEach((areaID) => {
								let areaContainer;
								if(addType === "safePlaces") {
									areaContainer = document.querySelector(`.gallery[data-container="safePlaces"] .gallery-cardContainer[data-areaid="${areaID}"]`);
								} else {
									areaContainer = document.querySelector(`.gallery[data-container="habitats"] .gallery-cardContainer[data-areaid="${areaID}"]`);
								}
								
								const existingElementContainer = document.querySelector(".existingElement");
								const card = document.createElement("div");
								let existingElement;
								// Vérifie si l'élément existe déjà en fonction de son type
								if(addType === "safePlaces") {
									existingElement = areaContainer.querySelector(`[data-safeplaceid="${data.addedElement.ID}"]`);
								} else {
									existingElement = areaContainer.querySelector(`[data-habitatid="${data.addedElement.ID}"]`);
								}
								
								// Passe si l'élément existe déjà
								if(existingElement) {
									return;
								}

								card.classList.add("gallery-cardContainer-card");
								
								// Adapte le Dataset en fonction du type de l'élément ajouté
								if(addType === "safePlaces") {
									card.dataset.safeplaceid = data.addedElement.ID; 
								} else {
									card.dataset.habitatid = data.addedElement.ID;
								}

								// Ajout des dataset
								if(addType === "safePlaces") {
									card.dataset.safeplaceid = data.addedElement.ID; 
									card.dataset.type = "safePlaces";
								} else {
									card.dataset.habitatid = data.addedElement.ID; 
									card.dataset.type = "habitats";
								}
								
							      
								// Crée l'élément image
								const img = document.createElement("img");

								if(addType === "safePlaces") {
									img.src = `/bestiary/public/uploads/safePlaces/${data.addedElement.picture}`;
								} else {
									img.src = `/bestiary/public/uploads/habitats/${data.addedElement.picture}`;
								}

								img.alt = `Image de ${data.addedElement.name}`;
							      
								// Crée le conteneur pour le texte et l'icône
								const span = document.createElement("span");
							      
								// Crée le paragraphe avec le nom de l'habitat
								const p = document.createElement("p");
								p.textContent = data.addedElement.name;
							      
								// Crée l'icône (par exemple avec FontAwesome)
								const icon = document.createElement("i");
								icon.classList.add("fa-solid", "fa-pen");
							      
								// Ajoute les éléments au DOM
								span.appendChild(p);
								span.appendChild(icon);
							      
								card.appendChild(img);
								card.appendChild(span);

								card.addEventListener("click", (event) => {
									handleClickCard(event);
								})
								
								areaContainer.appendChild(card);

								// Clone la carte
								const cloneCard = card.cloneNode(true);

								existingElementContainer.appendChild(cloneCard);
								// Déclenche la fermeture de la modale
								closeAreaModal();
							})
						}
					})
					.catch(error => console.error("Erreur lors du fetch :", error));
			}
		}, "image/png");
	}
}

function updateElement(elementID, addType) {
	const elementNameINPUT = document.getElementById("addElementName");
	let elementName = null;

	// Vérifie si le nom a changé
	if(elementNameINPUT.value != elementNameINPUT.dataset.value) {
		elementName = elementNameINPUT.value;
	}

	const formData = new FormData();

	let pathEnd;
	
	if(addType == "safePlaces") { 
		pathEnd = "updateSafePlace";
	} else {
		pathEnd = "updateHabitat";
	}

	if(elementName) {
		formData.append("elementName", elementName);
	}
	formData.append("elementID", elementID);
	formData.append("coordinates", JSON.stringify(clickCoordinates));

	fetch(`/bestiary/public/?url=areasManager/${pathEnd}`, {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { 
				// Déclenche la fermeture de la modale
				closeAreaModal();
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}


function deleteElement() {
	const areaModal = document.querySelector(".areaModal");
	const deleteType = areaModal.dataset.type;
	const elementID = areaModal.dataset.existingelement;

	if(!window.confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")) {
		return;
	}

	const formData = new FormData();

	let pathEnd;
	
	if(deleteType == "safePlaces") { 
		pathEnd = "deleteSafePlace";
	} else {
		pathEnd = "deleteHabitat";
	}
	
	formData.append("elementID", elementID);

	fetch(`/bestiary/public/?url=areasManager/${pathEnd}`, {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { 
				// Supprime toutes les cartes de la gallerie
				let allCards;
				if(deleteType == "safePlaces") { 
					allCards = document.querySelectorAll(`.gallery-cardContainer-card[data-safeplaceid="${elementID}"]`);
				} else {
					allCards = document.querySelectorAll(`.gallery-cardContainer-card[data-habitatid="${elementID}"]`);
				}

				allCards.forEach((card) => {
					card.remove();
				})

				// Déclenche la fermeture de la modale
				closeAreaModal();
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}