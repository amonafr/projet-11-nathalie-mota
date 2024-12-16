// script photo-filtre.js permettant d'appeler la fonction photos_tri via ajax au 
// changement du filtre du formulaire et d'afficher les photos
//met à jour les attributs categorie format et cletri du bouton charger plus

(function ($) {
    $(document).ready(function () {

        // Fonction pour gérer l'envoi AJAX des filtres choisies au niveau du formulaire
        function envoyerAjax() {
            const ajaxurl = $('.photos-form-tri').attr('action');

            // Les données du formulaire
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
                
                if (!body.success) {
                    alert(body.data); 
                    return;
                }

                // Mise à jour de la section album photo avec le HTML envoyé
                $('.photo-album').empty();
                $('.photo-album').append(body.data.html);
                $('#bouton-charger-plus').attr('data-postid',body.data.lastphoto )

                document.dispatchEvent(new Event('contentUpdated'));
            })
            .catch(error => {
                console.error('Erreur lors de l’envoi AJAX :', error);
            });
        }

        // Ecoute des evenements change au niveau des selects
        $('.photos-form-tri select').change(function () {
            const selectedOption = $(this).find('option:selected');
            if (selectedOption.hasClass('empty-option')) {
                $(this).prop('selectedIndex', 0); // Réinitialise la sélection à l'option par défaut
            } 
            envoyerAjax();
        });

    });
})(jQuery);
