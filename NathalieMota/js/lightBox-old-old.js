

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
        // const nonce = link.getAttribute('data-nonce');
        // const action = link.getAttribute('data-action');
        // const ajaxurl = link.getAttribute('data-ajaxurl');

         // Mise à jour des éléments de la lightbox
        lightboxImage.src = urlphoto;
        reference.textContent = refphoto;
        categorie.textContent = categorie_photo;
        lightbox.style.display = 'flex';
   
        // Mise à jour des liens précedente suivante
        prevBtn.setAttribute('data-urlphoto', link.getAttribute('data-urlprecedente') || '');
        prevBtn.setAttribute('data-idphoto', link.getAttribute('data-idprecedente') || '');
        prevBtn.setAttribute('data-refphoto', link.getAttribute('data-refprecedente') || '');
        prevBtn.setAttribute('data-categorie', link.getAttribute('data-catprecedente') || '');

        nextBtn.setAttribute('data-urlphoto', link.getAttribute('data-urlsuivante') || '');
        nextBtn.setAttribute('data-idphoto', link.getAttribute('data-idsuivante') || '');
        nextBtn.setAttribute('data-refphoto', link.getAttribute('data-refsuivante') || '');
        nextBtn.setAttribute('data-categorie', link.getAttribute('data-catsuivante') || '');
        
      
     

    });

    
});

prevBtn.addEventListener('click', function(event) {
    event.preventDefault();
    const urlphoto = this.getAttribute('data-urlphoto'); // Utilisation correcte de "this"
    const refphoto=this.getAttribute('data-refphoto');
    const categorie_photo=this.getAttribute('data-categorie');
    lightboxImage.src = urlphoto;
    reference.textContent = refphoto;
    categorie.textContent = categorie_photo;

//appel ajax

        
        // const refphoto = link.getAttribute('data-refphoto'); 
        const idphoto = this.getAttribute('data-idphoto'); 
        console.log("idphoto affichée et refphoto affichée:"+ idphoto + refphoto);

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
                
                const photoSuivante = data.data.photo_suivante;
                

                prevBtn.setAttribute('data-urlphoto', photoPrecedente.url || '');
                prevBtn.setAttribute('data-idphoto', photoPrecedente.id || '');
                prevBtn.setAttribute('data-refphoto', photoPrecedente.reference || '');
                prevBtn.setAttribute('data-categorie', photoPrecedente.categorie || '');
                
                nextBtn.setAttribute('data-urlphoto', photoSuivante.url || '');
                nextBtn.setAttribute('data-idphoto', photoSuivante.id || '');
                nextBtn.setAttribute('data-refphoto', photoSuivante.reference || '');
                nextBtn.setAttribute('data-categorie', photoSuivante.categorie || '');
                // console.log("resultat de ajax 2:");
                // console.log( photoPrecedente.id);
                // console.log("reference ajax2:");
                console.log( "reference précedente ajax2:" + photoPrecedente.reference);
                // console.log("categorie ajax2:");
                // console.log( photoPrecedente.categorie);

            } else {
                console.error('Erreur dans la réponse :', data.data);
            }
            })

        .catch(error => {
            console.error('Erreur AJAX :', error);
        });


});


// fonction pour la fleche photo suivante


nextBtn.addEventListener('click', function(event) {
    event.preventDefault();
    const urlphoto = this.getAttribute('data-urlphoto'); // Utilisation correcte de "this"
    const refphoto=this.getAttribute('data-refphoto');
    const categorie_photo=this.getAttribute('data-categorie');
    lightboxImage.src = urlphoto;
    reference.textContent = refphoto;
    categorie.textContent = categorie_photo;

        //appel ajax
       
        const idphoto = this.getAttribute('data-idphoto'); 
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
                
                const photoSuivante = data.data.photo_suivante;

                prevBtn.setAttribute('data-urlphoto', photoPrecedente.url || '');
                prevBtn.setAttribute('data-idphoto', photoPrecedente.id || '');
                prevBtn.setAttribute('data-refphoto', photoPrecedente.reference || '');
                prevBtn.setAttribute('data-categorie', photoPrecedente.categorie || '');
                
                nextBtn.setAttribute('data-urlphoto', photoSuivante.url || '');
                nextBtn.setAttribute('data-idphoto', photoSuivante.id || '');
                nextBtn.setAttribute('data-refphoto', photoSuivante.reference || '');
                nextBtn.setAttribute('data-categorie', photoSuivante.categorie || '');
                // console.log("resultat de ajax 3:");
                // console.log( photoPrecedente.id);
                // console.log("categorie ajax3:");
                // console.log( photosuivante.categorie);
                console.log("rereference suivante ajax3:");
                console.log( photoSuivante.reference);


            } else {
                console.error('Erreur dans la réponse :', data.data);
            }
            })

        .catch(error => {
            console.error('Erreur AJAX :', error);
        });

});




function closeLightbox() {
    lightbox.style.display = 'none';
}

document.querySelector('.overlay').addEventListener('click', closeLightbox);
document.getElementById('lightbox-croix').addEventListener('click', closeLightbox);

});