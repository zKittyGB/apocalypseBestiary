const slideshowAndResearch = document.querySelector(".header-slideshow-Research");
const searchINPUT = slideshowAndResearch.querySelector("#search");

searchINPUT.addEventListener("input", () => {
	const searchValue = searchINPUT.value;
	const slideshowContainer = document.querySelector(".slideshow-container");
	const searchResults = slideshowContainer.querySelector(".searchResults");

	searchResults.innerHTML = "";

	if(!searchValue || searchValue == "") {
		searchINPUT.classList.remove("translateBot");
		searchINPUT.classList.add("translateTop");
		searchResults.classList.remove("displaySearchResults");
		searchResults.classList.add("hideSearchResults");
		setTimeout(() => {
			searchResults.classList.remove("hideSearchResults");
			searchINPUT.classList.remove("translateTop");
		}, 300)
		return;
	}

	const formData = new FormData();
	formData.append("searchValue", searchValue);
 
	// Envoie de l'objet via POST
	fetch("/bestiary/public/?url=search", {
		method: "POST", 
		body: formData 
	    })
	    .then(response => response.json())
	    .then(data => {

		if(data.error) {
		    console.error("Erreur :", data.error);
		    return;
		}
		searchINPUT.classList.add("translateBot");
		searchResults.classList.add("displaySearchResults");
	        Object.keys(data).forEach(category => {
			if(Array.isArray(data[category]) && data[category].length > 0) {
				// Ajout du container par catégorie
				const categoryContainer = document.createElement("div");
				const cardsContainer = document.createElement("div");
				const title = document.createElement("h3");
				const categories = {"bestiary": "Bestiaire", "areas": "Zones", "habitats": "Habitations"};

				categoryContainer.classList.add("gallery-categoryContainer");
				cardsContainer.classList.add("gallery-cardsContainer");

				// Ajout de la catégorie en titre
				title.innerHTML = categories[category];
				
				categoryContainer.appendChild(title);
				searchResults.appendChild(categoryContainer);

				data[category].forEach((item, index) => {
					if(index > 5) { return; }
					// Création de la carte
					const card = document.createElement("div");
					const span = document.createElement("span");
					const nameParagraph = document.createElement("p");
					
					card.classList.add("gallery-cardContainer-card");

			                nameParagraph.textContent = item.name;

					// Ajout de l'ID 
					card.dataset.elementid = item.ID;
					
					// Utilise une variable temporaire pour l'image à afficher
					const pictureFolder = (category === "bestiary") ? "monsters" : category;
					card.dataset.type = category;

					// Ajout de l'image 
					const img = document.createElement("img");
					img.src = `/bestiary/public/uploads/${pictureFolder}/${item.picture || 'default.jpg'}`;
					img.alt = `Image de ${item.name}`;
					
					// Ajout des éléments au span
					span.appendChild(nameParagraph);

					// Ajout de l'image et du span à la carte
					card.appendChild(img);
					card.appendChild(span);

					// Ajout de la carte à la section des résultats
					cardsContainer.appendChild(card);
					categoryContainer.appendChild(cardsContainer);

					card.addEventListener("click", (event) => {
						handleClickSearchMatch(event);
					})
				});
			} 
		});
	});
	    
})

function handleClickSearchMatch(event) {
	const clickedElement = event.target;
	const clickedParent = clickedElement.parentElement;
	const elementType = clickedParent.dataset.type;
	const elementID = clickedParent.dataset.elementid;

	// Création dynamique d'un formulaire
	const form = document.createElement("form");
	form.method = "POST";
	form.action = `/bestiary/public/?url=${elementType}`;
	
	// Création d'un input caché pour envoyer elementID
	const input = document.createElement("input");
	input.type = "hidden";
	input.name = "elementID";
	input.value = elementID;
	form.appendChild(input);
	
	// Ajoute le formulaire au body et le soumet
	document.body.appendChild(form);
	form.submit();
}