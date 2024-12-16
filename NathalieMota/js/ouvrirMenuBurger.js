// script gérant l'affichage et la fermeture du menu au clic sur le menu burger

document.addEventListener('DOMContentLoaded', function() {
    const menuBurger = document.querySelector('.menuBurger');

    if (!menuBurger) {
        console.error('menuBurger est null. Vérifiez que l’élément existe dans le DOM.');
        return;
    }
    
    const barreNavigation = document.querySelector('header.barre-navigation');
    const Menuprincipal = document.getElementById('menu-menu-principal');
    const lines = document.querySelectorAll('.menuBurger .line');

    // Event listener sur le menu burger
    menuBurger.addEventListener('click', function() {
        Menuprincipal.classList.toggle('menu-ouvert');
        lines[0].classList.toggle('rotate-down');  
        lines[1].classList.toggle('hide');         
        lines[2].classList.toggle('rotate-up');    
    });
    if (menuBurger.getAttribute('aria-expanded') === 'true') {
        menuBurger.setAttribute('aria-expanded', 'false');
    } else {
        menuBurger.setAttribute('aria-expanded', 'true');
    }

});