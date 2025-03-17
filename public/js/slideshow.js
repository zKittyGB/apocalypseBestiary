document.addEventListener("DOMContentLoaded", function () {
	let slideIndex = 0;

	function showSlides() {
		// Récupération des slides
		const slides = document.querySelectorAll('.slideshow-container .slide');

		// Vérifie s'il y a des slides
		if(slides.length === 0) return; 

		// Boucle pour retirer la classe active à chaque slide
		slides.forEach((slide) => {
			const monsterID = slide.dataset.monsterid;
			slide.classList.remove('active');
			document.querySelector(`.slideshow-container div[data-monsterid='${monsterID}']`).classList.remove('active');
		});

		// Incrémente et retourne à 0 si on a atteint la dernière Slide
		slideIndex++;
		if(slideIndex >= slides.length) {
			slideIndex = 0;
		}

		// Applique la classe active sur la nouvelle slide
		slides[slideIndex].classList.add("active");
		const monsterID = slides[slideIndex].dataset.monsterid;
		document.querySelector(`.slideshow-container div[data-monsterid='${monsterID}']`).classList.add('active');

	}

	// met à jour le slideshow toutes les 3 secondes
	setInterval(showSlides, 6000);

	// Affiche la première slide dès le chargement
	showSlides();
});
