document.addEventListener('DOMContentLoaded', function() {

// Variables globales
const lightbox = document.getElementById('lightbox');
const lightboxImage = document.getElementById('lightbox-image');
// const lightboxTitle = document.getElementById('lightbox-title');
const prevBtn = document.querySelector('.photo-precedente-lien');
const nextBtn = document.querySelector('.photo-suivante-lien');
// const lien_lightbox = document.getElementById('lien-light-box');
const lightboxLinks = document.querySelectorAll('.lightbox-link');
const reference=document.getElementById('lightbox-reference');
const categorie=document.getElementById('lightbox-categorie');
let currentIndex = 0;

// Initialiser la lightbox avec les données des photos

    console.log("voici l'url:");
    console.log(prevBtn);
    // lien_lightbox.addEventListener('click', function(event) {
    //     event.preventDefault();
    //     const urlphoto = this.getAttribute('data-urlphoto'); // Utilisation correcte de "this"
    //     lightboxImage.src = urlphoto;
    //     lightbox.style.display = 'flex';
    // });


    
    // Initialiser la lightbox avec les données des photos
    lightboxLinks.forEach((link, index) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const urlphoto = link.getAttribute('data-urlphoto'); 
            const refphoto = link.getAttribute('data-refphoto'); 
            const idphoto = link.getAttribute('data-idphoto'); 
            const categorie_photo = link.getAttribute('data-categorie'); 
            // const url_photo_precedente = link.getAttribute('data-urlprecedente'); 
            // const id_photo_precedente = link.getAttribute('data-idprecedente'); 

            // console.log(url_photo_precedente);
            lightboxImage.src = urlphoto;
            reference.textContent = refphoto;
            categorie.textContent = categorie_photo;
            // prevBtn.setAttribute('data-photoprecedente',url_photo_precedente);
            // prevBtn.setAttribute('data-idprecedente',id_photo_precedente);
            lightbox.style.display = 'flex';
// appel ajax

// changement des attributs des boutons



        });
       
    });

    prevBtn.addEventListener('click', function(event) {
        event.preventDefault();
        const urlphoto = this.getAttribute('data-photoprecedente'); // Utilisation correcte de "this"
        lightboxImage.src = urlphoto;

//appel ajax
//changement de des attributs du bouton



    });




// Fermer la lightbox
function closeLightbox() {
    lightbox.style.display = 'none';
}



// Navigation
// prevBtn.addEventListener('click', () => {
//     currentIndex = (currentIndex - 1 + photos.length) % photos.length;
//     updateLightbox();
// });

// nextBtn.addEventListener('click', () => {
//     currentIndex = (currentIndex + 1) % photos.length;
//     updateLightbox();
// });

// Fermer la lightbox en cliquant sur l'overlay
document.querySelector('.overlay').addEventListener('click', closeLightbox);
document.getElementById('lightbox-croix').addEventListener('click', closeLightbox);

});