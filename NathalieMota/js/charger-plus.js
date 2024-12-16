// script permettant au clic du bouton charger plus, l'envoi des paramètres 
// et l'execution de la fonction photos_plus via un appel ajax
//et de mettre à jour la page d'accueil

(function ($) {
    $(document).ready(function () {

        $('#bouton-charger-plus').click(function (e) {

            e.preventDefault();

            const ajaxurl = $(this).attr('data-ajaxurl');
            const data = {
                action: $(this).attr('data-action'),
                nonce: $(this).attr('data-nonce'),
                postid: $(this).attr('data-postid'),
                cletri: $(this).attr('data-cletri'),
                categorie:$(this).attr('data-categorie'),
                format:$(this).attr('data-format'),

            };

            $('.message-erreur').remove();

            console.log(ajaxurl);
            console.log(data);

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

                console.log("voici le retour :");
                console.log(body.data.html);
                if (body.data.html){
                $('.photo-album').append(body.data.html); 
                }
                else{
                    $('.photo-charger-plus').append(body.data.messageerreur);
                }
                if (body.data.lastphoto){
                        $('#bouton-charger-plus').attr('data-postid', body.data.lastphoto);
                    }

                console.log("Nouveau postid :", body.data.lastphoto);
                console.log("le postid envoyé par js:", body.data.postid);
                document.dispatchEvent(new Event('contentUpdated'));
            });
        });
        
    });
})(jQuery);