const areaSELECT = document.getElementById("areaSelect");
const targetID = document.querySelector("main").dataset.targetid;
const monsterSELECT = document.getElementById("monsterSelect");

let monstersList = [];

document.addEventListener("DOMContentLoaded", () => {
	const changeEvent = new Event("change");
	if(targetID) {
		areaSELECT.value = targetID;
		areaSELECT.dispatchEvent(changeEvent);
	} else {
		areaSELECT.dispatchEvent(changeEvent);
	}
});

areaSELECT.addEventListener("change", async () => {
	monstersList = [];

	const areaID = areaSELECT.value;
	const data = await getPlaces(areaID);
	const habitats = data.habitats;
	const safePlaces = data.safePlaces;
	const allPins = document.querySelectorAll(".pin");
	const areaIMG = document.querySelector(".areaContainer-pictureContainer img");
	const monsterSELECT = document.getElementById("monsterSelect");

	allPins.forEach((pin) => {
		pin.remove();
	})

	createPin(habitats, "habitat");
	createPin(safePlaces, "safePlace");

	areaIMG.src = `/bestiary/public/uploads/areas/${data.area.areaPicture}`;
	areaIMG.alt = `Image de ${data.area.areaName}`;
	
	monstersList = data.monsters;
	monsterSELECT.innerHTML = "<option value='' hidden>Sélectionnez un monstre</option>";
	monstersList.forEach((monster) => {
		const monsterOption = document.createElement("option");
		monsterOption.value = monster.monsterID;
		monsterOption.textContent = monster.monsterName;
		monsterSELECT.appendChild(monsterOption);
	});
});

monsterSELECT.addEventListener("change", () => {
	const allPinsWithOldPicture = document.querySelectorAll(".pin[data-oldpicture]");
	
	allPinsWithOldPicture.forEach((pin) => {
		pin.style.backgroundImage = pin.dataset.oldpicture;
	});

	if(monsterSELECT.value) {
		const monster = monstersList.find((monster) => monster.monsterID === monsterSELECT.value);
		if(monster) {
			const allPins = document.querySelectorAll(`.pin[data-placeid = ${monster.monsterHabitat}]`);

			allPins.forEach((pin) => {
				pin.dataset.oldpicture = pin.style.backgroundImage;
				pin.style.backgroundImage = `url(/bestiary/public/uploads/monsters/${monster.monsterPicture})`;
				pin.style.backgroundSize = "cover";
				pin.style.backgroundPosition = "center";
			});
		}
	}
});

async function getPlaces(areaID) {
	try {
		const formData = new FormData();
		formData.append("areaID", areaID);
	
		const response = await fetch("/bestiary/public/?url=areas/getPlacesByAreaID", {
			method: "POST",
			body: formData
		});
	
		if(!response.ok) throw new Error("Erreur de requête");
	
		return await response.json();
	} catch(error) {
		console.error("Erreur lors de la récupération des lieux :", error);
		return null;
	}
}
    
    
function createPin(places, type) {
	const areaContainer = document.querySelector(".areaContainer");
	const areaModalIMGContainer = areaContainer.querySelector(".areaContainer-pictureContainer");

	// Pour chaque chaîne JSON de coordonnées dans le groupe
	places.forEach((place) => {
		const coordinate = JSON.parse(place.coordinates);
		// Création d'un élément pour représenter le pin
		const pin = document.createElement("div");
		pin.classList.add("pin");
		
		if(type == "safePlace") {
			pin.dataset.placeid = place.safePlaceID;
			pin.classList.add("safePlace");
			pin.style.backgroundImage = `url(/bestiary/public/uploads/safePlaces/${place.safePlacePicture})`;
			pin.title = place.safePlaceName;
		} else {
			pin.dataset.placeid = place.habitatID;
			pin.classList.add("habitat");
			pin.style.backgroundImage = `url(/bestiary/public/uploads/habitats/${place.habitatPicture})`;
			pin.title = place.habitatName;
		}

		pin.style.backgroundSize = "cover";
		pin.style.backgroundPosition = "center";

		// Positionne le pin en utilisant les pourcentages récupérés
		pin.style.left = `${coordinate.xPercent}%`;
		pin.style.top = `${coordinate.yPercent}%`;

		// Ajoute le pin au conteneur (assure-toi que le conteneur est en position relative)
		areaModalIMGContainer.appendChild(pin);
	});
}