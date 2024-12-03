document.addEventListener('DOMContentLoaded', function() {
    // const menuBurger = document.getElementById('menuMobile');
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
        // if (Menuprincipal.classList.contains('menu-ouvert')) {
        //     Menuprincipal.style.display = 'block';

        // } else{
        //     Menuprincipal.style.display = 'none';
        // }  
        console.log(Menuprincipal);
        console.log("je suis dans ouvrir menu burger");
        lines[0].classList.toggle('rotate-down');  // première ligne
        lines[1].classList.toggle('hide');         // ligne du milieu
        lines[2].classList.toggle('rotate-up');    // troisième ligne
    });
    if (menuBurger.getAttribute('aria-expanded') === 'true') {
        menuBurger.setAttribute('aria-expanded', 'false');
    } else {
        menuBurger.setAttribute('aria-expanded', 'true');
    }



});