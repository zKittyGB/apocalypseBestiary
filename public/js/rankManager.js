const ranksDisplayer = document.querySelector("body.isAdmin .ranksDisplayer");
const INPUTRankName = ranksDisplayer.querySelector("table #addRankValue");
const INPUTRankOrder = ranksDisplayer.querySelector("table #addRankOrder");
const rankTBODY = INPUTRankName.closest("tbody");
const validationI = rankTBODY.querySelector("i[data-action='validation']");
const deleteIs = ranksDisplayer.querySelectorAll("table i[data-action='delete'], i[data-action='deleteAll']");
const arrowIs = ranksDisplayer.querySelectorAll("table i[data-action='down'], i[data-action='up']")

// Affiche / cache l'icone de validation
INPUTRankName.addEventListener("input", () => {
	if(INPUTRankName.value && INPUTRankOrder.value) {
		validationI.classList.remove("hidden");
	} else {
		validationI.classList.add("hidden");
	}
})

// Listener pour vérifier que l'utilisateur ne puisse pas dépasser le plus haut rank +1 dans ceux existant
INPUTRankOrder.addEventListener("input", () => {
	const allRanks = rankTBODY.querySelectorAll("tr:not([data-action='addRank'])");
	const highestExistingRank = allRanks.length ? allRanks.length : 0;
	
	if(INPUTRankOrder.value > highestExistingRank || INPUTRankOrder.value == "0") {
		INPUTRankOrder.value = highestExistingRank +1;
	}

	if(INPUTRankName.value && INPUTRankOrder.value) {
		validationI.classList.remove("hidden");
	} else {
		validationI.classList.add("hidden");
	}
})

// Création d'un nouveau rank
validationI.addEventListener("click", () => {
	const formData = new FormData();
	const rankOrder = INPUTRankOrder.value;
	const rankValue = INPUTRankName.value;
	const addRankRow = rankTBODY.querySelector("tr[data-action='addRank']");
    
	formData.append("rankOrder", rankOrder);
	formData.append("rankValue", rankValue);
    
	// Envoie de l'objet via POST
	fetch(`/bestiary/public/?url=bestiaryManager/addRank`, {
	    method: "POST", 
	    body: formData 
	})
	.then(response => response.json())
	.then(data => {
		if(data.error) {
			console.error("Erreur :", data.error);
		} else { 
			// Mise à jour des rangs existants s'ils ont été décalés
			const rows = Array.from(rankTBODY.querySelectorAll("tr:not([data-action='addRank'])"));
			rows.forEach(row => {
				const cell = row.querySelector("td:first-child"); // RankOrder column
				if(parseInt(cell.innerText) >= rankOrder) {
					cell.innerText = parseInt(cell.innerText) + 1; // Décaler de +1
				}
			});
			
			const newRow = document.createElement("tr");

			// Création la nouvelle ligne
			newRow.dataset.rankid = data.rankID;

			newRow.innerHTML = `
				<td class="ranksDisplayer-rankOrder">${rankOrder}</td>
				<td class="ranksDisplayer-rankValue">${rankValue}</td>
				<td><i data-action='down' class="fa-solid fa-arrow-down"></i></td>
				<td><i data-action='up' class="fa-solid fa-arrow-up"></i></td>
				<td><i data-action="delete" class="fa-solid fa-trash"></i></td>
			`;
	
			// Trouve ou insérer la nouvelle ligne
			let inserted = false;
			for(let row of rows) {
				let currentRank = parseInt(row.querySelector("td:first-child").innerText);
				if(currentRank > rankOrder) {
					rankTBODY.insertBefore(newRow, row);
					inserted = true;
					break;
				}
			}
			
			// Si c'est le plus grand rankOrder, l'ajouter avant le TR d'ajout
			if(!inserted) {
				rankTBODY.insertBefore(newRow, addRankRow);
			}
	
			const allRanks = rankTBODY.querySelectorAll("tr:not([data-action='addRank'])");
			const highestExistingRank = allRanks.length ? allRanks.length : 0;
			const deleteI = newRow.querySelector("i[data-action='delete']");
			const arrowIs = newRow.querySelectorAll("i[data-action='down'], i[data-action='up']");

			// Réinitialiser l'input d'ajout
			INPUTRankOrder.value = parseInt(highestExistingRank) + 1;
			INPUTRankName.value = "";

			// Rattache les listner aux nouveaux icones
			deleteI.addEventListener("click", (event) => {
				deleteRanks(event);
			})

			arrowIs.forEach((I) => {
				I.addEventListener("click", (event) => {
					updateRankOrder(event);
				})
			})
		}
	})
	.catch(error => console.error("Erreur lors du fetch :", error));
});

deleteIs.forEach((I) => {
	I.addEventListener("click", (event) => {
		deleteRanks(event);
	})
})

/**
 * Supprime un rank et met à jour l'affichage
 * @param {event}  - Element déclencheur de l'action
 */
function deleteRanks(event) {
	const action = event.target.dataset.action;
	
	if(!action) {
		return false;
	}

	const formData = new FormData();
	let rankID = null;
	let deletedRankOrder = event.target.closest("tr").querySelector("td:first-child").innerHTML;
	let message = "";

	switch(action) {
		case "delete":
			rankID = event.target.closest("tr").dataset.rankid;
			message = "Confirmer-vous la supprésion du grade ?"
			formData.append("deleteElements", rankID);
			break;

		case "deleteAll":
			message = "Confirmer-vous la supprésion de tous les grades ?"
			formData.append("deleteElements", "all");
			break;		
	}

	// Alerte de confirmation avant de supprimer
	if(window.confirm(message)) {
		// Envoie de l'objet via POST
		fetch(`/bestiary/public/?url=bestiaryManager/deleteRanks`, {
			method: "POST", 
			body: formData 
		})
			.then(response => response.json())
			.then(data => {
					if(data.error) {
						console.error("Erreur :", data.error);
					} else { 		
						if(rankID) {
							// Suppression d'un seul élément
							const rankTR = rankTBODY.querySelector(`tr[data-rankid='${rankID}']`);
							rankTR.remove();
							// Sélectionne tous les <tr> ayant un rankID 
							const rankRows = rankTBODY.querySelectorAll("tr[data-rankid]");
							
							rankRows.forEach((row) => {
								const rankOrderCell = row.querySelector("td.ranksDisplayer-rankOrder");
								if(rankOrderCell) {
									let currentRank = parseInt(rankOrderCell.textContent, 10);

									// Si le rankOrder était supérieur à celui supprimé, on le réduit de 1
									if(currentRank > deletedRankOrder) {
										rankOrderCell.textContent = currentRank - 1;
									}
								}
							});	
						} else {
							// Suppression de tous les éléments
							const allRanksTR = rankTBODY.querySelectorAll("tr:not([data-action='addRank'])");
							allRanksTR.forEach((TR) => {
								TR.remove();
							})
						}
						const allRanks = rankTBODY.querySelectorAll("tr:not([data-action='addRank'])");
						const highestExistingRank = allRanks.length ? allRanks.length : 0;
						
						// Réinitialiser l'input d'ajout
						INPUTRankOrder.value = parseInt(highestExistingRank) + 1;
					}
				})
				.catch(error => console.error("Erreur lors du fetch :", error));
	}

}

arrowIs.forEach((I) => {
	I.addEventListener("click", (event) => {
		updateRankOrder(event);
	})
})

/**
 * Met à jour les rankOrder après suppression d'un seul élément
 * @param {event}  - Element déclencheur de l'action
 */
function updateRankOrder(event) {
	const allRanks = rankTBODY.querySelectorAll("tr:not([data-action='addRank'])");
	const highestExistingRank = allRanks.length ? allRanks.length : 0;
	const action = event.target.dataset.action;
	const row = event.target.closest("tr");
	const rankID = row.closest("tr").dataset.rankid;
	const rankOrderCell = row.querySelector(".ranksDisplayer-rankOrder");
	const currentOrder = parseInt(rankOrderCell.textContent);

	// Arrête le traitement si l'ordre du rang est le 1 er ou le dernier
	if((currentOrder == 1 && action == "up")|| (currentOrder == highestExistingRank && action =="down")) {
		return;
	}

	const formData = new FormData();
	
	formData.append("rankID", rankID);
	formData.append("action", action);

	// Envoie de l'objet via POST
	fetch(`/bestiary/public/?url=bestiaryManager/updateRankOrder`, {
		method: "POST", 
		body: formData 
	})
		.then(response => response.json())
		.then(data => {
			if(data.error) {
			  	  console.error("Erreur :", data.error);
			} else {
				// Récupérer la ligne qui a le rankOrder cible
				let targetRow = null;
				rankTBODY.querySelectorAll("tr").forEach(tr => {
						const rankOrderEl = tr.querySelector(".ranksDisplayer-rankOrder");
						if(rankOrderEl && parseInt(rankOrderEl.textContent) === (action === "up" ? currentOrder - 1 : currentOrder + 1)) {
							targetRow = tr;
						}
				});
			
				if(!targetRow) {
					console.error("Aucune ligne trouvée pour échanger l'ordre");
					return;
				}
			
				// Échange visuellement les `rankOrder`
				const targetRankOrderCell = targetRow.querySelector(".ranksDisplayer-rankOrder");
				const targetOrder = parseInt(targetRankOrderCell.textContent);
				rankOrderCell.textContent = targetOrder;
				targetRankOrderCell.textContent = currentOrder;
			
				// Réorganiser les lignes dans le DOM
				if(action === "up") {
					rankTBODY.insertBefore(row, targetRow);
				} else if(action === "down") {
					rankTBODY.insertBefore(targetRow, row);
				}
			}
		})
		.catch(error => console.error("Erreur lors du fetch :", error));
}