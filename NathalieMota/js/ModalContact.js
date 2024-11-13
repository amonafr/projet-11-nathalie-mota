document.addEventListener('DOMContentLoaded', function() {
    var contactLink = document.getElementById('menu-item-54'); 
    // var modal = document.getElementById('contact-modal'); 
    var modal = document.getElementById('contact-modal'); 
    var contactPrincipal=document.getElementById('contact-principal'); 
    console.log("je suis dans la modale" + modal)

    if (contactLink && modal) {
        contactLink.addEventListener('click', function(event) {
            event.preventDefault(); 
            // modal.style.display = 'block'; 
            modal.showModal();
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


