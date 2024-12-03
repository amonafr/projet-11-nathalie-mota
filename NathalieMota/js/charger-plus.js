(function ($) {
    $(document).ready(function () {

        // Chargment des commentaires en Ajax
        $('#bouton-charger-plus').click(function (e) {
           

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>

            // Les données de notre formulaire
			// ⚠️ Ne changez pas le nom "action" !
            
            // const ajaxurl = $(this).data('ajaxurl');

            // const data = {
            //     action: $(this).data('action'), 
            //     nonce:  $(this).data('nonce'),
            //     postid: $(this).data('postid'),
            //     cletri: $(this).data('cletri'),
                
            // }

            const ajaxurl = $(this).attr('data-ajaxurl');
            const data = {
                action: $(this).attr('data-action'),
                nonce: $(this).attr('data-nonce'),
                postid: $(this).attr('data-postid'), // Relecture dynamique à chaque clic
                cletri: $(this).attr('data-cletri'),
                categorie:$(this).attr('data-categorie'),
                format:$(this).attr('data-format'),

            };

            $('.message-erreur').remove();


            // Pour vérifier qu'on a bien récupéré les données
            console.log(ajaxurl);
            console.log(data);

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

                // Et en cas de réussite
                // $(this).hide(); // Cacher le formulaire
                console.log("voici le retour :");
                console.log(body.data.html);
                if (body.data.html){
                $('.photo-album').append(body.data.html); // Et afficher le HTML
                }
                else{
                    $('.photo-charger-plus').append(body.data.messageerreur);
                }
                if (body.data.lastphoto){
                        $('#bouton-charger-plus').attr('data-postid', body.data.lastphoto);
                        // ref_derniere_photo=body.data.lastphoto;
                    }

                console.log("Nouveau postid :", body.data.lastphoto);
                console.log("le postid envoyé par js:", body.data.postid);
                document.dispatchEvent(new Event('contentUpdated'));
            });
        });
        
    });
})(jQuery);