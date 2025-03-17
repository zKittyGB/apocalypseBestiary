const menuBUTTON = document.querySelector("header i[data-state]");

menuBUTTON.addEventListener("click", showMenu);

// Gestion de l"affichage du menu mobile en fonction du dataset state
function showMenu() {
	const state = menuBUTTON.dataset.state;
	const headerMenu = document.querySelector("header .header-menu");
	const headerMenuBorder = document.querySelector("header .header-menu-border");

	switch(state) {
		case "close":
				headerMenu.classList.add("display");
				headerMenuBorder.classList.add("display");
				menuBUTTON.dataset.state = "open";
			break;
		
		case "open":
				headerMenu.classList.remove("display");
				headerMenuBorder.classList.remove("display");
				menuBUTTON.dataset.state = "close";
			break;
	}
}