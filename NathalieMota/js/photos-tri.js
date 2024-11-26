(function ($) {
    $(document).ready(function () {

        // Chargment des commentaires en Ajax
        $('.photos-form-tri').submit(function (e) {

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).attr('action');

            // Les données de notre formulaire
			// ⚠️ Ne changez pas le nom "action" !
            const data = {
                action: $(this).find('input[name=action]').val(), 
                nonce:  $(this).find('input[name=nonce]').val(),
                page_id: $(this).find('input[name=page_id]').val(),
                categorie: $(this).find('select[name=categorie]').val(),
                format: $(this).find('select[name=format]').val(),
                cletri: $(this).find('select[name=cletri]').val(),
            }

            // Pour vérifier qu'on a bien récupéré les données
            // console.log(ajaxurl);
            // console.log(data);

            // Requête Ajax en JS natif via Fetch
            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                body: new URLSearchParams(data),
            })
            .then(response => response.json())
            .then(body => {
                console.log(body);

                // En cas d'erreur
                if (!body.success) {
                    alert(response.data);
                    return;
                }
                $('.photo-album').empty();
                // Et en cas de réussite
                // $(this).hide(); // Cacher le formulaire
                $('.photo-album').append(body.data.html); // Et afficher le HTML
            });
        });
        
    });
})(jQuery);