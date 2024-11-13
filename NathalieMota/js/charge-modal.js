(function ($) {
    $(document).ready(function () {
  

      $('#contact-button').click(function (e) {
            e.preventDefault();
            let reference = $(this).data('reference');
            console.log(reference);
            console.log("le bouton est cliqué");
            console.log(ajax_object.ajax_url);

// ********************code ajax_
            $.ajax({
                    url: ajax_object.ajax_url,
                    method: 'POST',
                    data: {
                    action: 'charger_contact_popup',
                    reference: reference
                            },
                success: function(response) {
                    // console.log(responseText)
                 // Ajouter la popup dans le DOM
                    // $('body').append(response);
                    $('body').prepend(response);
                    $("#ref-photo").val(reference);

                 // Afficher la popup
                    // $('#contact-modal').fadeIn();
                    $('#contact-modal').show();
                    $('#contact-principal').show();

////***************** */
                    $(window).on('click', function(event) {
                        if ((event.target === $('#contact-principal').get(0))
                            && (event.target != $($('#contact-modal')).get(0))) 
                        {
                            $('#contact-modal').fadeOut();
                            $('#contact-principal').fadeOut();
                        }
                    });



////************* */

    }


});

// ***************code ajax

            
        });
        
    });
})(jQuery);