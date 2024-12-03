

document.addEventListener('DOMContentLoaded', function() {

const lightbox = document.getElementById('lightbox');
const lightboxImage = document.getElementById('lightbox-image');
const prevBtn = document.querySelector('a.photo-precedente-lien');
const nextBtn = document.querySelector('.photo-suivante-lien');
const lightboxLinks = document.querySelectorAll('.lightbox-link');
const reference=document.getElementById('lightbox-reference');
const categorie=document.getElementById('lightbox-categorie');

lightboxLinks.forEach((link, index) => {
    link.addEventListener('click', (event) => {
        event.preventDefault();

        // Récupération des attributs du lien
        const urlphoto = link.getAttribute('data-urlphoto'); 
        const refphoto = link.getAttribute('data-refphoto'); 
        const idphoto = link.getAttribute('data-idphoto'); 
        const categorie_photo = link.getAttribute('data-categorie'); 
        const nonce = link.getAttribute('data-nonce');
        const action = link.getAttribute('data-action');
        const ajaxurl = link.getAttribute('data-ajaxurl');

        // Mise à jour des éléments de la lightbox
        lightboxImage.src = urlphoto;
        reference.textContent = refphoto;
        categorie.textContent = categorie_photo;
        lightbox.style.display = 'flex';
   
        // Appel AJAX
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            
            body: new URLSearchParams({
                action: action,
                nonce: nonce,
                photo_id: idphoto,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const photoPrecedente = data.data.photo_precedente;
                // console.log("resultat de ajax:");
                // console.log( photoPrecedente.id);
                // console.log("rereference:");
                // console.log( photoPrecedente.reference);
                // console.log("categorie:");
                // console.log( photoPrecedente.categorie);
                const photoSuivante = data.data.photo_suivante;
                // Mise à jour des attributs des boutons précédent et suivant
                prevBtn.setAttribute('data-photoprecedente', photoPrecedente.url || '');
                prevBtn.setAttribute('data-idprecedente', photoPrecedente.id || '');
                prevBtn.setAttribute('data-reference', photoPrecedente.reference || '');
                prevBtn.setAttribute('data-categorie', photoPrecedente.categorie || '');
                
                nextBtn.setAttribute('data-photosuivante', photoSuivante.url || '');
                nextBtn.setAttribute('data-idsuivante', photoSuivante.id || '');
                nextBtn.setAttribute('data-reference', photoSuivante.reference || '');
                nextBtn.setAttribute('data-categorie', photoSuivante.categorie || '');
            } else {
                console.error('Erreur dans la réponse :', data.data);
            }
        })
        .catch(error => {
            console.error('Erreur AJAX :', error);
        });
    
    });
});

prevBtn.addEventListener('click', function(event) {
    event.preventDefault();
    const urlphoto = this.getAttribute('data-photoprecedente'); // Utilisation correcte de "this"
    lightboxImage.src = urlphoto;
    const refphoto=this.getAttribute('data-reference');
    reference.textContent = refphoto;
    const categorie_photo=this.getAttribute('data-categorie');
    categorie.textContent = categorie_photo;

//appel ajax

        
        // const refphoto = link.getAttribute('data-refphoto'); 
        const idphoto = this.getAttribute('data-idprecedente'); 
        // const categorie_photo = link.getAttribute('data-categorie'); 
        const nonce = this.getAttribute('data-nonce');
        const action = this.getAttribute('data-action');
        const ajaxurl = this.getAttribute('data-ajaxurl');



fetch(ajaxurl, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    
    body: new URLSearchParams({
        action: action,
        nonce: nonce,
        photo_id: idphoto,
    })
})

        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const photoPrecedente = data.data.photo_precedente;
                console.log("resultat de ajax 2:");
                console.log( photoPrecedente.id);
                const photoSuivante = data.data.photo_suivante;
                console.log("rereference ajax2:");
                console.log( photoPrecedente.reference);
                console.log("categorie ajax2:");
                console.log( photoPrecedente.categorie);

                prevBtn.setAttribute('data-photoprecedente', photoPrecedente.url || '');
                prevBtn.setAttribute('data-idprecedente', photoPrecedente.id || '');
                prevBtn.setAttribute('data-reference', photoPrecedente.reference || '');
                prevBtn.setAttribute('data-categorie', photoPrecedente.categorie || '');
                
                nextBtn.setAttribute('data-photosuivante', photoSuivante.url || '');
                nextBtn.setAttribute('data-idsuivante', photoSuivante.id || '');
                nextBtn.setAttribute('data-reference', photoSuivante.reference || '');
                nextBtn.setAttribute('data-categorie', photoSuivante.categorie || '');





            } else {
                console.error('Erreur dans la réponse :', data.data);
            }
            })

        .catch(error => {
            console.error('Erreur AJAX :', error);
        });





//changement de des attributs du bouton
});


// fonction pour la fleche photo suivante


nextBtn.addEventListener('click', function(event) {
    event.preventDefault();
    const urlphoto = this.getAttribute('data-photosuivante'); // Utilisation correcte de "this"
    lightboxImage.src = urlphoto;
    const refphoto=this.getAttribute('data-reference');
    reference.textContent = refphoto;
    const categorie_photo=this.getAttribute('data-categorie');
    categorie.textContent = categorie_photo;

//appel ajax

        
        // const refphoto = link.getAttribute('data-refphoto'); 
        const idphoto = this.getAttribute('data-idsuivante'); 
        // const categorie_photo = link.getAttribute('data-categorie'); 
        const nonce = this.getAttribute('data-nonce');
        const action = this.getAttribute('data-action');
        const ajaxurl = this.getAttribute('data-ajaxurl');



fetch(ajaxurl, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    
    body: new URLSearchParams({
        action: action,
        nonce: nonce,
        photo_id: idphoto,
    })
})

        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const photoPrecedente = data.data.photo_precedente;
                // console.log("resultat de ajax 3:");
                // console.log( photoPrecedente.id);
                const photoSuivante = data.data.photo_suivante;
                // console.log("rereference ajax3:");
                // console.log( photoPrecedente.reference);
                // console.log("categorie ajax3:");
                // console.log( photoPrecedente.categorie);

                prevBtn.setAttribute('data-photoprecedente', photoPrecedente.url || '');
                prevBtn.setAttribute('data-idprecedente', photoPrecedente.id || '');
                prevBtn.setAttribute('data-reference', photoPrecedente.reference || '');
                prevBtn.setAttribute('data-categorie', photoPrecedente.categorie || '');
                
                nextBtn.setAttribute('data-photosuivante', photoSuivante.url || '');
                nextBtn.setAttribute('data-idsuivante', photoSuivante.id || '');
                nextBtn.setAttribute('data-reference', photoSuivante.reference || '');
                nextBtn.setAttribute('data-categorie', photoSuivante.categorie || '');


            } else {
                console.error('Erreur dans la réponse :', data.data);
            }
            })

        .catch(error => {
            console.error('Erreur AJAX :', error);
        });





//changement de des attributs du bouton
});


// fin fonction photo suivante

function closeLightbox() {
    lightbox.style.display = 'none';
}

document.querySelector('.overlay').addEventListener('click', closeLightbox);
document.getElementById('lightbox-croix').addEventListener('click', closeLightbox);





});