
/*
Ce script permet d'afficher, de fermer  la lightbox et de naviguer dans
les photos de la page. Les photos en mémoire sont réinitialisées lorsque le contenu est 
mis à jour soit par les filtres soit par le bouton charger plus
*/

document.addEventListener('DOMContentLoaded', function () {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const prevBtn = document.querySelector('a.photo-precedente-lien');
    const nextBtn = document.querySelector('.photo-suivante-lien');
    const reference = document.getElementById('lightbox-reference');
    const categorie = document.getElementById('lightbox-categorie');
    const overlay = document.querySelector('.overlay');
    let photos = [];
    let currentIndex = 0;

    function initLightboxEvents() {
    // Réinitialiser les photos supprime les anciens lisners au changement de filtre
        const oldLinks = document.querySelectorAll('.lightbox-link');
        oldLinks.forEach(link => {
        link.removeEventListener('click', openLightboxHandler);
        });

        photos = [];

    // Rechercher tous les liens lightbox actuels
        const lightboxLinks = document.querySelectorAll('.lightbox-link');

        lightboxLinks.forEach((link, index) => {
            const photo = {
                url: link.dataset.urlphoto,
                reference: link.dataset.refphoto,
                categorie: link.dataset.categorie,
            };
            photos.push(photo);
            link.addEventListener('click', openLightboxHandler);

        });
    }
    function openLightboxHandler(event) {
        event.preventDefault();
        currentIndex = Array.from(document.querySelectorAll('.lightbox-link')).indexOf(event.currentTarget);
        openLightbox();
    }

    function openLightbox() {
        updateLightbox();
        lightbox.style.display = 'flex';
    }

    function closeLightbox() {
        lightbox.style.display = 'none';
    }

    // Mettre à jour le contenu de la lightbox
    function updateLightbox() {
        const photo = photos[currentIndex];
        lightboxImage.src = photo.url;
        reference.textContent = photo.reference;
        categorie.textContent = photo.categorie;
    }

    // Navigation
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            currentIndex = (currentIndex - 1 + photos.length) % photos.length;
            updateLightbox();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            currentIndex = (currentIndex + 1) % photos.length;
            updateLightbox();
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeLightbox);
    }
    document.getElementById('lightbox-croix').addEventListener('click', function(e) {
        e.preventDefault();
        closeLightbox();
    });

    // Initialiser les événements pour la première fois
    initLightboxEvents();

    document.addEventListener('contentUpdated', function () {
        initLightboxEvents();
    });

});
