document.addEventListener('DOMContentLoaded', function() {
    var contactLink = document.getElementById('menu-item-54'); // utilisez l’ID approprié
    var modal = document.getElementById('contact-modal'); // ID de la modale

    if (contactLink && modal) {
        contactLink.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche le chargement de la page
            modal.style.display = 'block'; // Affiche la modale
        });
    }

    // Ferme la modale quand l’utilisateur clique à l’extérieur ou sur un bouton de fermeture
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});


