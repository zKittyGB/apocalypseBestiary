const modalCloseButton = document.querySelector(".monsterModal i[data-action='close']");
const monsterCards = document.querySelectorAll("body .gallery-cardContainer-card");
const monsterModal = document.querySelector(".monsterModal");
const modalMenuLIs = document.querySelectorAll(".monsterModal-body-menu li");
const filtersButton = document.querySelector(".bestiary-content-filters-header [data-action='filters']");
const filters = document.querySelectorAll(".bestiary-content-filters input[type='checkbox']");
const reinitFilters = document.querySelector(".bestiary-content-filters i[data-action='reinit']");
const closeFilters = document.querySelector(".bestiary-content-filters i[data-action='close']");

document.addEventListener("keydown", (event) => {
	if(event.key === "Escape" && monsterModal.classList.contains("active")) {
		closeMonsterModal();
	}
});

filtersButton.addEventListener("click", displayFiltersMenu);

function displayFiltersMenu() {
	const filtersBody = document.querySelector(".bestiary-content-filters-body");
	const bodyState = filtersBody.dataset.state;

	if(bodyState == "close") {
		filtersBody.classList.add("expand_medium");
		filtersBody.dataset.state = "open";
	} else {
		filtersBody.classList.remove("expand_medium");
		filtersBody.classList.add("revese_expand_medium");
		setTimeout(() => {
			filtersBody.classList.remove("revese_expand_medium");
			filtersBody.dataset.state = "close";
		}, 300)

	}
}

filters.forEach((filter) => {
	filter.addEventListener("change",handleFilters)
})

// Gestion des filtres checkboxes
function handleFilters() {
	const filtersChecked = document.querySelectorAll(".bestiary-content-filters input[type='checkbox']:checked");
	const filtersValues = {
		"dangers": [],
		"ranks": [],
		"areas": []
	};

	// Remplit l'objet filtersValues avec les valeurs des cases cochées
	filtersChecked.forEach((filterChecked) => {
		const type = filterChecked.dataset.type;
		const filterValue = filterChecked.value;
		if(filtersValues[type]) {
			filtersValues[type].push(filterValue);
		}
	});

	const cards = document.querySelectorAll(".gallery-cardContainer-card");
	cards.forEach((card) => {
		const monsterDanger = card.dataset.dangerid;
		const monsterRank = card.dataset.rankid;
		const monsterArea = card.dataset.areaid;
	    
		// Vérifie si la carte correspond à au moins un des filtres
		const matchesAnyFilter = (
			(filtersValues.dangers.includes(monsterDanger)) ||
			(filtersValues.ranks.includes(monsterRank)) ||
			(filtersValues.areas.includes(monsterArea))
		);
	    
		// Vérifie s'il y a au moins un filtre appliqué
		const hasActiveFilters = (
			filtersValues.dangers.length > 0 ||
			filtersValues.ranks.length > 0 ||
			filtersValues.areas.length > 0
		);
	    
		// Si un filtre est actif et que la carte correspond à au moins un filtre, on affiche
		if(!hasActiveFilters || matchesAnyFilter) {
		  	  card.classList.remove("hidden");
		} else {
		   	 card.classList.add("hidden");
		}

		// Cache tous les titres n'ayant pas de carte visible
		document.querySelectorAll(".gallery").forEach((gallery) => {
			gallery.querySelectorAll("h4").forEach((h4) => {
				const cardContainer = h4.nextElementSibling; // Récupère la div juste après h4
				if(cardContainer && cardContainer.classList.contains("gallery-cardContainer")) {
					const visibleCards = cardContainer.querySelectorAll(".gallery-cardContainer-card:not(.hidden)");
					// Cache le h4 si toutes les cartes sont cachées
					if(visibleCards.length === 0) {
						h4.classList.add("hidden");
						cardContainer.classList.add("hidden");
					} else {
						h4.classList.remove("hidden");
						cardContainer.classList.remove("hidden");
					}
				}
			});
		});
	});
}

// Réinitialisation des filtres
reinitFilters.addEventListener("click", () => {
	const filtersChecked = document.querySelectorAll(".bestiary-content-filters input[type='checkbox']:checked");

	filtersChecked.forEach((filterChecked) => {
		filterChecked.checked = false;
	});

	handleFilters();
});

closeFilters.addEventListener("click", () => {
	displayFiltersMenu();
});

// Gestion du boouton suivant/terminé dans l'admin modal
if(monsterCards) {
	monsterCards.forEach((card) => {
		card.addEventListener("click", (event) => {
			handleMonsterCard(event);
		})
	})
}

modalCloseButton.addEventListener("click", (event) => {
	closeMonsterModal();
});

function closeMonsterModal() {
	const modalMonster = document.querySelector(".monsterModal");
	const allSkillListLIs = modalMonster.querySelectorAll(".monsterModal-body-content-sheets-skills-container-skillsList li");
	const monsterDetailsLI = monsterModal.querySelector(".monsterModal-body-menu li.active");
	const monsterDetailsContainer = monsterModal.querySelector(".monsterModal-body div[data-container].active");

	monsterDetailsLI.classList.remove("active");
	monsterDetailsContainer.classList.remove("active");

	allSkillListLIs.forEach((LI) => {
		LI.innerHTML = "";
	})
	
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


/**
 * Récupère les infos d'un monstre par son ID
 * @param {Event} event - Événement de clic
 */
function handleMonsterCard(event) {
	const divParent = event.target.closest("[data-monsterid]");
	const skillsContainer = document.querySelector(".monsterModal-body-content-sheets-skills");
	skillsContainer.classList.remove("hidden");

	if(!divParent) { return };
	
	const monsterID = divParent.dataset.monsterid;
	const formData = new FormData();
	
	if(!monsterID) { return };
	
	formData.append("monsterID", monsterID)
	// Envoie de l'objet via POST
	fetch("/bestiary/public/?url=bestiaryManager/getMonster", {
		method: "POST", 
		body: formData 
	})
	.then(response => response.json())
	.then(data => {
		if(data.error) {
			console.error("Erreur :", data.error);
		} else { 
				const monsterModal = document.querySelector(".monsterModal");
				const previewImage = monsterModal.querySelector("#previewImage");
				const cropperContainer = monsterModal.querySelector("#cropperContainer");
				const autoInsertElements = ["monsterAdvice", "monsterBehavior", "monsterDescription", "monsterName","monsterMasterName",  "habitatName", "rankValue", "areaName", "typeName", "dangerValue"];  
				const monsterDetailsLI = monsterModal.querySelector(".monsterModal-body-menu li");
				const monsterDetailsContainer = monsterModal.querySelector(".monsterModal-body div[data-container='descriptions']");

				monsterDetailsLI.classList.add("active");
				monsterDetailsContainer.classList.add("active");

				// Si des compétences sont définies, met à jour les checkboxes
				if(data.monster.monsterSkills.length > 0) {
					data.monster.monsterSkills.forEach((skill, index) => {
						const UL = document.querySelector(".monsterModal-body-content-sheets-skills-container-skillsList");
						const LI = UL.querySelector(`li:nth-child(${index + 1})`);	
						LI.innerHTML = skill.skillName;
					})
				} else {
					const skillsContainer = document.querySelector(".monsterModal-body-content-sheets-skills");
					skillsContainer.classList.add("hidden");
				}

				Object.entries(data.monster).forEach(([key, value]) => {
					if(autoInsertElements.includes(key)) {
						const elementContainer = monsterModal.querySelector(`[data-content="${key}"]`);
						if(elementContainer) {
							elementContainer.innerHTML = value;
						}
					}
				});

				previewImage.src = `/bestiary/public/uploads/monsters/${data.monster.monsterPicture}`;

				// Ajout des forces et faiblesses
				if(data.monster.monsterStrengthes.length > 0 && data.monster.monsterStrengthes.length < 4) {
					data.monster.monsterStrengthes.forEach((strength, index) => {
						const UL = document.querySelector(".monsterModal-body-content-sheets-strengthes ul");
						const LI = UL.querySelector(`li:nth-child(${index + 1})`);	
						
						LI.innerHTML = strength;
					})
					data.monster.monsterWeaknesses.forEach((weakness, index) => {
						const UL = document.querySelector(".monsterModal-body-content-sheets-weaknesses ul");
						const LI = UL.querySelector(`li:nth-child(${index + 1})`);	
						
						LI.innerHTML = weakness;
					})
						
				}

				cropperContainer.classList.remove("hidden");
				monsterModal.classList.add("active");
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
};

function initChart() {
	// Envoie de l'objet via POST
	fetch("/bestiary/public/?url=bestiary/getBestiary", {
		method: "POST"
	})
	.then(response => response.json())
	.then(data => {
		if(data.error) {
			console.error("Erreur :", data.error);
		} else {
			const bestiary = data.bestiary;

			// Création des tags
			const tags = {};

			// Fonction pour créer des tags pour chaque groupe
			Object.keys(bestiary).forEach(category => {

				// Crée un tag général pour chaque catégorie
				const groupTag = `${category}-group`;
				if(!tags[groupTag]) {
					tags[groupTag] = {
						template: "group",
					};
				}

				// Crée un tag spécifique pour chaque sous-groupe
				bestiary[category].forEach(monster => {
					const monsterTag = `${category}-${monster.monsterName.toLowerCase().replace(/\s+/g, '-')}`;

					// Ajoute un tag si nécessaire
					if(!tags[monsterTag]) {
						tags[monsterTag] = {
							subTreeConfig: {
								columns: 2 
							}
						};

						// Logique pour ajuster les colonnes en fonction de la catégorie ou du nombre de monstres
						if(category === 'Lieutenants') {
							tags[monsterTag].subTreeConfig.columns = 2; // Si c'est un lieutenant, 2 colonnes
						} else if(category === 'Élus') {
							tags[monsterTag].subTreeConfig.columns = 1; // 1 colonne pour Élus
						} else if(category === 'Divins') {
							tags[monsterTag].subTreeConfig.columns = 3; // 3 colonnes pour Divins
						}
					}
				});
			});

			// Création des noeuds pour OrgChart
			const nodes = [];
			const parentsMap = {}; 

			// Première boucle pour ajouter les monstres sans parents
			Object.keys(bestiary).forEach(category => {
				bestiary[category].forEach(monster => {
					const node = {
						id: monster.monsterID,
						name: monster.monsterName,
						title: monster.rankValue, // Par exemple, "Lieutenants"
						img: `/bestiary/public/uploads/monsters/${monster.monsterPicture}`, // Image si disponible
						tags: [`${category}-${monster.monsterName.toLowerCase().replace(/\s+/g, '-')}`],
						description: `${category} - ${monster.dangerValue}`,
					};

					// Si le monstre a un parent, on le met dans le tableau des parents
					if(monster.monsterMasterID) {
						if(!parentsMap[monster.monsterMasterID]) {
							parentsMap[monster.monsterMasterID] = []; // Crée un tableau pour les enfants
						}
						parentsMap[monster.monsterMasterID].push(node); // Lien entre le parent et l'enfant
					} else {
						nodes.push(node); // Si pas de parent, on l'ajoute directement dans le tableau des racines
					}
				});
			});

			// Assignation des enfants aux parents
			Object.keys(parentsMap).forEach(parentId => {
				const parentNode = nodes.find(node => node.id === parentId); // Trouve le parent dans les racines
				if(parentNode && parentsMap[parentId]) {
					// Associe les enfants du parent à son parent (dans pid)
					parentsMap[parentId].forEach(childNode => {
						childNode.pid = parentNode.id; // Ajout du parent ID 
					});
					nodes.push(...parentsMap[parentId]); // Ajout des enfants dans l'arborescence
				}
			});

			// Création de l'instance OrgChart
			let options = getOptions();
			let chart = new OrgChart(document.getElementById("tree"), {
				mouseScrool: OrgChart.action.zoom,
				scaleInitial: options.scaleInitial,
				enableAI: true,
				mode: "dark",
				enableSearch: false,
				template: "olivia",
				enableDragDrop: false,
				nodeMouseClick: OrgChart.action.edit,
				nodeBinding: {
					imgs: "img",
					field_0: "name",
					field_1: "title",
					img_0: "img",
				},
				tags: tags, 
			});

			// Chargement des noeuds dans OrgChart
			chart.load(nodes);

			// Fonction pour obtenir les options (mise à l'échelle)
			function getOptions() {
				const searchParams = new URLSearchParams(window.location.search);
				let fit = searchParams.get('fit');
				let scaleInitial = 0.2;
				if(fit == 'yes') {
					scaleInitial = OrgChart.match.boundary;
				}
				return { scaleInitial };
			}	
		}
	});
}

initChart()
const orgChartINPUT = document.getElementById("orgChart");

orgChartINPUT.addEventListener("change", () => {
	const tree = document.getElementById("tree");
	const filters = document.querySelector("span[data-action='filters']");
	const gallery = document.querySelector(".bestiary-content .gallery");
	const filtersBody = document.querySelector(".bestiary-content-filters-body");

	if(orgChartINPUT.checked) {
		tree.classList.add("active");
		filters.classList.add("hidden");
		gallery.classList.add("hidden");
		filtersBody.classList.add("hidden");
	} else {
		tree.classList.remove("active");
		filters.classList.remove("hidden");
		gallery.classList.remove("hidden");
		filtersBody.classList.remove("hidden");
	}
})

document.addEventListener("DOMContentLoaded", function() {
	// Récupère l'ID cible depuis le dataset de <main>
	const mainElement = document.querySelector("main");
	
	if(!mainElement) return;
	
	const targetID = mainElement.dataset.targetid;

	if(!targetID) { return; }
	
	// Recherche l'élément correspondant dans la galerie
	const target = document.querySelector(`.gallery div[data-monsterid='${targetID}']`);

	if(!target) return;
    
	// Crée un événement de type "click"
	const clickEvent = new Event("click", {
		bubbles: true,
		cancelable: true
	});
	
	// Déclenche l'événement sur l'élément ciblé
	target.dispatchEvent(clickEvent);
});