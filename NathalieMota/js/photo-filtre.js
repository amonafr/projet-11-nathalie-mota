(function ($) {
    $(document).ready(function () {

        // Fonction pour gérer l'envoi AJAX
        function envoyerAjax() {
            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $('.photos-form-tri').attr('action');

            // Les données de notre formulaire
            const data = {
                action: $('.photos-form-tri').find('input[name=action]').val(),
                nonce: $('.photos-form-tri').find('input[name=nonce]').val(),
                page_id: $('.photos-form-tri').find('input[name=page_id]').val(),
                categorie: $('.photos-form-tri').find('select[name=categorie]').val(),
                format: $('.photos-form-tri').find('select[name=format]').val(),
                cletri: $('.photos-form-tri').find('select[name=cletri]').val(),
            };
            $('#bouton-charger-plus').attr('data-categorie', $('.photos-form-tri').find('select[name=categorie]').val());
            $('#bouton-charger-plus').attr('data-format', $('.photos-form-tri').find('select[name=format]').val());
            $('#bouton-charger-plus').attr('data-cletri', $('.photos-form-tri').find('select[name=cletri]').val());
            $('.message-erreur').remove();



console.log(data);
            // Requête AJAX via Fetch
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
                // Gérer la réponse
                if (!body.success) {
                    alert(body.data); // Afficher un message d'erreur
                    return;
                }

                // Mettre à jour l'album photo avec le HTML renvoyé
                $('.photo-album').empty();
                $('.photo-album').append(body.data.html);
                $('#bouton-charger-plus').attr('data-postid',body.data.lastphoto )

                document.dispatchEvent(new Event('contentUpdated'));
            })
            .catch(error => {
                console.error('Erreur lors de l’envoi AJAX :', error);
            });
        }

        // Attacher des événements change aux selects
        $('.photos-form-tri select').change(function () {
            envoyerAjax();
        });

    });
})(jQuery);
