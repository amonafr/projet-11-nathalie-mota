document.addEventListener('DOMContentLoaded', function () {
    // Sélection des éléments
    const flecheGauche = document.querySelector('.photo-fleche_gauche');
    const flecheDroite = document.querySelector('.photo-fleche_droite');
    const photoSuivante = document.querySelector('.photo-suivante');
    const photoPrecedente = document.querySelector('.photo-precedente');

    console.log("je suis dans la navigation");
    // const miniaturePrecedente = document.getElementById('miniature-suivante');
    // const miniatureSuivante = document.getElementById('miniature-precedente');

    const miniatureSuivante= document.getElementById('miniature-suivante');
    const miniaturePrecedente =document.getElementById('miniature-precedente');



    flecheGauche.addEventListener('mouseover', () => {
        // const thumbnailUrl = flecheGauche.getAttribute('data-thumbnail');
        // if (thumbnailUrl) {
            // miniaturePrecedente.style.backgroundImage = `url(${thumbnailUrl})`;
            miniaturePrecedente.style.display = 'block';
        // }
    });

    flecheGauche.addEventListener('mouseout', () => {
        miniaturePrecedente.style.display = 'none';
    });

    flecheDroite.addEventListener('mouseover', () => {
        // const thumbnailUrl = flecheDroite.getAttribute('data-thumbnail');
        // if (thumbnailUrl) {
        //     miniatureSuivante.style.backgroundImage = `url(${thumbnailUrl})`;
            miniatureSuivante.style.display = 'block';
        // }
    });

    flecheDroite.addEventListener('mouseout', () => {
        miniatureSuivante.style.display = 'none';
    });
});