
    // Attend que le document soit chargé
    document.addEventListener("DOMContentLoaded", function() {
    // Récupère le bouton du dropdown et son menu
    var dropdownBtn = document.getElementById("adminDropdown");
    var dropdownMenu = document.querySelector(".dropdown-menu");

    // Ajoute un écouteur d'événement pour le clic sur le bouton dropdown
    dropdownBtn.addEventListener("click", function(event) {
    // Empêche le comportement par défaut du lien
    event.preventDefault();
    // Affiche ou cache le menu dropdown en fonction de son état actuel
    if (dropdownMenu.classList.contains("show")) {
    dropdownMenu.classList.remove("show");
} else {
    dropdownMenu.classList.add("show");
}
});

    // Ajoute un écouteur d'événement pour fermer le menu dropdown lorsque l'utilisateur clique à l'extérieur
    document.addEventListener("click", function(event) {
    if (!dropdownBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
    dropdownMenu.classList.remove("show");
}
});
});
