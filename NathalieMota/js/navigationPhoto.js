/*
script permettant d'afficher les photos miniatures suivante et précedente 
au clic sur les flèches au niveau de la single photo 
*/

document.addEventListener('DOMContentLoaded', function () {
    const flecheGauche = document.querySelector('.photo-fleche_gauche');
    const flecheDroite = document.querySelector('.photo-fleche_droite');
    const miniatureSuivante= document.getElementById('miniature-suivante');
    const miniaturePrecedente =document.getElementById('miniature-precedente');


    if (flecheGauche) {
        flecheGauche.addEventListener('mouseover', () => {
            miniaturePrecedente.style.display = 'block';
        });  
        flecheGauche.addEventListener('mouseout', () => {
            miniaturePrecedente.style.display = 'none';
        });
    }
    if (flecheDroite) {
        flecheDroite.addEventListener('mouseover', () => {
             miniatureSuivante.style.display = 'block';
        });
   
        flecheDroite.addEventListener('mouseout', () => {
             miniatureSuivante.style.display = 'none';
        });
    }
});