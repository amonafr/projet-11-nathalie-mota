/*
 script permettant d'afficher la modale de contact au clic sur l'option 
de menu contact et au clic sur le bouton contact 
*/

document.addEventListener('DOMContentLoaded', function() {
    var contactLink = document.getElementById('menu-item-54'); 
    var modal = document.getElementById('contact-modal'); 
    var contactPrincipal=document.getElementById('contact-principal'); 
    var contactbouton=document.getElementById('contact-button');

    if (contactLink && modal) {
        contactLink.addEventListener('click', function(event) {
            event.preventDefault(); 
            modal.showModal();
            document.getElementById('ref-photo').value = '';
            contactPrincipal.style.display = 'block'; 

        });
    }

    if (contactbouton) {
        contactbouton.addEventListener('click', function(event) {
            event.preventDefault(); 
            let reference = this.dataset.reference;
            console.log(reference);
            modal.showModal();
            document.getElementById('ref-photo').value = reference;
            contactPrincipal.style.display = 'block'; 

        });
    }

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            // modal.style.display = 'none';
            modal.close();
            contactPrincipal.style.display = 'none';

        }
    });
});


