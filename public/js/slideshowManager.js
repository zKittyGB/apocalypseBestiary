const contentCardContainer = document.querySelector("body.isAdmin .content .gallery-cardContainer");
const contentAllCards = contentCardContainer.querySelectorAll(".gallery-cardContainer-card");
const closeModalButton = document.querySelector("body.isAdmin .addSlideModal .addSlideModal-close");

contentAllCards.forEach((card) => {
	card.addEventListener("click",() => { 
		handleCard(card);
	})
})

closeModalButton.addEventListener("click", closeAddSlideModal);

function handleCard(card) {
	const action = card.querySelector("[data-action]").dataset.action;
	
	// On vérifie d'avoir une action et qu'elle corresponde à l'un ou l'autre
	if(!action || (action != "delete" && action != "add")) { return; }

	if(action == "delete") {
		if(window.confirm("Supprimer la créature du slideshow ?")) { // Demande la confirmation à l'utilisateur
			const formData = new FormData();
			const monsterID = card.dataset.monsterid;

			if(!monsterID) { return }

			formData.append("monsterID", monsterID);
			fetchUpdateSlide(action, formData, card);
		} else {
			return
		}
	} else { // Cas d'ajout d'une slide
		fullFillAddModal(action)
	}
	return;
}

function closeAddSlideModal() {
	const addSlideModal = document.querySelector("body.isAdmin .addSlideModal");
	const modalGallery = addSlideModal.querySelector(".gallery");

	addSlideModal.classList.remove("active");
	modalGallery.innerHTML = "";
}

function fullFillAddModal(action) {
	// On vérifie d'avoir une action et qu'elle corresponde à l'un ou l'autre
	if(!action || action != "add") { return; }
	const monsterCards = document.querySelectorAll(".gallery-cardContainer-card[data-monsterid]");
	const existingSlides = [];

	// Stock les monstre IDs des slides existants
	monsterCards.forEach((card) => {
		const monsterID = card.dataset.monsterid;
		if(monsterID) {
			existingSlides.push(monsterID);
		}
	})

	// Envoie de l'objet via POST
	fetch(`/bestiary/public/?url=slideshowManager/getBestiary`)
	.then(response => response.json())
	.then(data => {
		if(data.error) {
			console.error("Erreur :", data.error);
		} else { 
			const addSlideModal = document.querySelector("body.isAdmin .addSlideModal");
			const galleryModal = addSlideModal.querySelector(".gallery");

			addSlideModal.classList.add("active");

			Object.values(data.bestiary).forEach((category) => {
				category.forEach((monster) => {
					// On vérifie que le monstre n'est pas déjà présent dans les slides
					if(existingSlides.includes(monster.monsterID)) { return; }
					const modalCard = document.createElement("div");
					const modalCardIMG = document.createElement("img");
				
					modalCard.classList.add("gallery-cardContainer-card");
					modalCard.dataset.monsterid = monster.monsterID;
					modalCard.dataset.monstername = monster.monsterName;
					
					modalCardIMG.src = `/bestiary/public/uploads/monsters/${monster.monsterPicture}`;
					modalCardIMG.alt = `Image de ${monster.monsterName}`;

					modalCard.appendChild(modalCardIMG);
					galleryModal.appendChild(modalCard)

					modalCard.addEventListener("click", () => {
						if(window.confirm(`Ajouter ${monster.monsterName}`)) {
							const formData = new FormData();
							const monsterID = modalCard.dataset.monsterid;

							if(!monsterID) { return }
			
							formData.append("monsterID", monsterID);
							fetchUpdateSlide(action, formData, modalCard);
						} else {
							return;
						}
					})
				});

			
			});
			    
		} 
	})
	.catch(error => console.error("Erreur lors du fetch :", error));
}

function fetchUpdateSlide(action, formData, triggeredCard=null) {
	// On vérifie d'avoir une action et qu'elle corresponde à l'un ou l'autre
	if(!action || (action != "delete" && action != "add")) { return; }

	// Envoie de l'objet via POST
	fetch(`/bestiary/public/?url=slideshowManager/${action}Slide`, {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
				console.error("Erreur :", data.error);
			} else { 
				if(action == "delete") {
					triggeredCard.remove();
				} else {
					// Création d'une nouvelle carte à ajouter dans la gallery du content
					const newCard = document.createElement("div");
					const newCardIMG = document.createElement("img");
					const newCardSPAN = document.createElement("span");

					newCard.classList.add("gallery-cardContainer-card");
					newCard.dataset.monsterid = triggeredCard.dataset.monsterid;
					
					newCardIMG.src = triggeredCard.querySelector("img").src;
					newCardIMG.alt =  triggeredCard.querySelector("img").alt;

					newCardSPAN.dataset.action = "delete";
					newCardSPAN.innerHTML = `
						<p>${triggeredCard.dataset.monstername}</p>
						<i class="fa-solid fa-trash"></i>
					`;

					newCard.appendChild(newCardIMG);
					newCard.appendChild(newCardSPAN);
					contentCardContainer.appendChild(newCard);

					newCard.addEventListener("click", () => {
						handleCard(newCard);
					});

					closeAddSlideModal();
				}
			} 
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}