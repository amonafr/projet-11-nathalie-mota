function updatePhotos() {
    // Récupérer les valeurs des filtres
    const category = document.getElementById('category-filter').value;
    const format = document.getElementById('format-filter').value;
    const date = document.getElementById('date-filter').value;

    // Construire les paramètres pour l'API
    let queryParams = [];
    if (category) queryParams.push(`category=${category}`);
    if (format) queryParams.push(`format=${format}`);
    if (date) queryParams.push(`date=${date}`);
    const queryString = queryParams.join('&');

    // Faire une requête à l'API WordPress
    fetch(`/wp-json/wp/v2/photo?${queryString}`)
        .then(response => response.json())
        .then(data => {
            const photoContainer = document.getElementById('photo-container');
            photoContainer.innerHTML = ''; // Vider les anciennes photos

            // Ajouter les nouvelles photos
            data.forEach(photo => {
                const img = document.createElement('img');
                img.src = photo.image_url; // Modifier selon la structure de tes données
                photoContainer.appendChild(img);
            });
        })
        .catch(error => console.error('Erreur:', error));
}

// Attacher des événements à chaque filtre
document.getElementById('category-filter').addEventListener('change', updatePhotos);
document.getElementById('format-filter').addEventListener('change', updatePhotos);
document.getElementById('date-filter').addEventListener('input', updatePhotos);
