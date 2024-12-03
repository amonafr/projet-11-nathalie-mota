document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const prevBtn = document.querySelector('a.photo-precedente-lien');
    const nextBtn = document.querySelector('.photo-suivante-lien');
    const lightboxLinks = document.querySelectorAll('.lightbox-link');
    const reference = document.getElementById('lightbox-reference');
    const categorie = document.getElementById('lightbox-categorie');

    let photos = [];
    let currentIndex = 0;

    // Initialiser la lightbox avec les données des photos
    lightboxLinks.forEach((link, index) => {
        const photo = {
            url: link.dataset.urlphoto,
            reference: link.dataset.refphoto,
            categorie: link.dataset.categorie,
        };
        photos.push(photo);

        link.addEventListener('click', (event) => {
            event.preventDefault();
            currentIndex = index;
            openLightbox();
        });
    });

    // Ouvrir la lightbox
    function openLightbox() {
        updateLightbox();
        lightbox.style.display = 'flex';
    }

    // Fermer la lightbox
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
            e.stopPropagation();
            currentIndex = (currentIndex - 1 + photos.length) % photos.length;
            updateLightbox();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            currentIndex = (currentIndex + 1) % photos.length;
            updateLightbox();
        });
    }

    // Fermer la lightbox en cliquant sur l'overlay
    const overlay = document.querySelector('.overlay');
    if (overlay) {
        overlay.addEventListener('click', closeLightbox);
    }
    document.getElementById('lightbox-croix').addEventListener('click', closeLightbox);

});
