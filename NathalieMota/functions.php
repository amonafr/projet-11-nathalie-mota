<?php
add_theme_support( 'title-tag' );

function NathalieMota_register_my_menu() {
    register_nav_menu( 'main-menu' ,__( 'Menu principal', 'NathalieMota' ) );
    register_nav_menu( 'footer' ,__( 'Footer', 'NathalieMota' ) );
}
add_action( 'after_setup_theme', 'NathalieMota_register_my_menu' );

function NathalieMota_enqueue_styles() {
    wp_enqueue_style( 'NathalieMota-style', get_stylesheet_uri());
    wp_enqueue_style('NMStyle', get_template_directory_uri() . '/styles/NMstyle.css');
    wp_enqueue_script('ModalContact', get_template_directory_uri() . '/js/ModalContact.js');
    wp_enqueue_script('navigationPhoto', get_template_directory_uri() . '/js/navigationPhoto.js');
    wp_enqueue_script( 
        'chargerPlus', 
        get_template_directory_uri() . '/js/charger-plus.js', [ 'jquery' ], 
      '1.0', 
      true 
   );
   wp_enqueue_script( 
    'chargertri', 
    get_template_directory_uri() . '/js/photos-tri.js', [ 'jquery' ], 
  '1.0', 
  true 
);

   
    // if( is_single() ) {
    // wp_enqueue_script('charge-modal', get_template_directory_uri() . '/js/charge-modal.js',[ 'jquery' ],'1.0',true );
    // wp_localize_script('charge-modal', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
// }
}
add_action('wp_enqueue_scripts', 'NathalieMota_enqueue_styles');

function NathalieMota_add_space_mono_font() {
    // echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    // echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    wp_enqueue_style('space-mono-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', [], null);
}
add_action('wp_head', 'NathalieMota_add_space_mono_font');





// function charger_contact_popup() {
//     if ( isset( $_POST['reference'] ) ) {
//         $reference = sanitize_text_field( $_POST['reference'] );

//         include locate_template( 'template-parts/ModalContact.php' );
//     }
//     // echo "je suis dans la fonction charger_contact_popup" ;
//     wp_die();
// }
// add_action( 'wp_ajax_charger_contact_popup', 'charger_contact_popup' );
// add_action( 'wp_ajax_nopriv_charger_contact_popup', 'charger_contact_popup' );


add_action( 'wp_ajax_photo_charger_plus', 'photo_charger_plus' );
add_action( 'wp_ajax_nopriv_photo_charger_plus', 'photo_charger_plus' );

function photo_charger_plus() {
  
	// Vérification de sécurité
  	if( 
		! isset( $_REQUEST['nonce'] ) or 
       	! wp_verify_nonce( $_REQUEST['nonce'], 'photo_charger_plus' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
  	}
    
    // On vérifie que l'identifiant a bien été envoyé
    if( ! isset( $_POST['postid'] ) ) {
    	wp_send_json_error( "L'identifiant de la photo est manquant.", 400 );
  	}

  	// Récupération des données du bouton
  	$post_id = intval( $_POST['postid'] );
    
	// Vérifier que la photo est publié, et public
	if( get_post_status( $post_id ) !== 'publish' ) {
    	wp_send_json_error( "cette page est non accessible.", 403 );
	}

  	// Utilisez sanitize_text_field() pour les chaines de caractères.
    $cletri = sanitize_text_field( $_POST['cletri'] );


// la requete wpquery

// Récupérer la date de l'article avec cet ID
$date_de_reference = get_post_field('post_date', $post_id);
$args = [
    'post_type' => 'photo', // Type de contenu (articles)
    'posts_per_page' => 8, // Nombre d'articles à afficher
    'orderby' => 'date', // Trier par date
    'order' => $cletri, // Ordre décroissant (du plus récent au plus ancien)
    'date_query' => [
        [
            'before' => $date_de_reference, // Articles publiés après cette date
            'inclusive' => false, // Exclure la date exacte de l'article avec cet ID
        ],
    ],
];
$html='';
$photos_chargees = new WP_Query($args);

if ($photos_chargees->have_posts()) :
    // echo '<div class="photo-album"> ';
    while ($photos_chargees->have_posts()) : $photos_chargees->the_post();
        $html.= '<div class="photo-album-image">';
            $reference_photo_album = get_post_meta( get_the_ID(), 'reference', true );
        //  a supprimer
           $categories = get_the_terms(get_the_ID(), 'categorie');
        if ($categories && !is_wp_error($categories)) {
                $categorie_photo_album = $categories[0]->slug;
                };

        // a supprimer

        if ( has_post_thumbnail() ) {
            $html .= get_the_post_thumbnail( get_the_ID(), 'medium', [ 'class' => 'photo-album-img' ] );
        }

        $html .= '<div class="legende-photo">';
        $html .= '<a href="#"><img class="fullscreen" src="' . esc_url( get_template_directory_uri() . '/assets/Icon_fullscreen.png' ) . '" alt="icone fullscreen"></a>';
        $html .= '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '"><img class="oeil-icon" src="' . esc_url( get_template_directory_uri() . '/assets/icon-oeil.png' ) . '" alt="icone oeil"></a>';
        $html .= '<div class="legende-photo-texte">';
        $html .= '<p>' . esc_html( $reference_photo_album ) . '</p>';
        $html .= '<p>' . esc_html( $categorie_photo_album ) . '</p>';
        $html .= '</div></div></div>';
    endwhile;
    $html.='</div>';
    wp_reset_postdata(); // Réinitialise les données du post
else :
    $html .= '<p>Aucune photo similaire trouvée.</p>';
endif;

// la requete wpquery
 	
  	// Envoyer les données au navigateur
      wp_send_json_success([
        'html' => $html,
    ]);
    wp_die();
}


function photos_tri() {
    // Vérification du nonce
    // check_ajax_referer('photos-tri', 'nonce');
    if( 
		! isset( $_REQUEST['nonce'] ) or 
       	! wp_verify_nonce( $_REQUEST['nonce'], 'photos-tri' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
  	}
      if( ! isset( $_POST['page_id'] ) ) {
    	wp_send_json_error( "L'identifiant de la page est manquant.", 400 );
  	}




    // Récupération des paramètres
    $page_id = isset($_POST['page_id']) ? intval($_POST['page_id']) : 0;
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $cletri = isset($_POST['cletri']) ? sanitize_text_field($_POST['cletri']) : '';
    if (empty($cletri))
    {
        $cletri='DESC';
    }
    // Logique pour récupérer les données selon ces critères
    // Par exemple :
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'tax_query' => [],
        'orderby' => 'date',
        'order' => $cletri,
    ];

    if (!empty($categorie)) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie,
        ];
    }

    if (!empty($format)) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        ];
    }
    $html='';
    $photos_chargees = new WP_Query($args);
    
    if ($photos_chargees->have_posts()) :
        // echo '<div class="photo-album"> ';
        while ($photos_chargees->have_posts()) : $photos_chargees->the_post();
            $html.= '<div class="photo-album-image">';
                $reference_photo_album = get_post_meta( get_the_ID(), 'reference', true );
            //  a supprimer
               $categories = get_the_terms(get_the_ID(), 'categorie');
            if ($categories && !is_wp_error($categories)) {
                    $categorie_photo_album = $categories[0]->slug;
                    };
    
            // a supprimer
    
            if ( has_post_thumbnail() ) {
                $html .= get_the_post_thumbnail( get_the_ID(), 'medium', [ 'class' => 'photo-album-img' ] );
            }
    
            $html .= '<div class="legende-photo">';
            $html .= '<a href="#"><img class="fullscreen" src="' . esc_url( get_template_directory_uri() . '/assets/Icon_fullscreen.png' ) . '" alt="icone fullscreen"></a>';
            $html .= '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '"><img class="oeil-icon" src="' . esc_url( get_template_directory_uri() . '/assets/icon-oeil.png' ) . '" alt="icone oeil"></a>';
            $html .= '<div class="legende-photo-texte">';
            $html .= '<p>' . esc_html( $reference_photo_album ) . '</p>';
            $html .= '<p>' . esc_html( $categorie_photo_album ) . '</p>';
            $html .= '</div></div></div>';
        endwhile;
        $html.='</div>';
        wp_reset_postdata(); // Réinitialise les données du post
    else :
        $html .= '<p>Aucune photo similaire trouvée.</p>';
    endif;
    
    // la requete wpquery
         
          // Envoyer les données au navigateur
          wp_send_json_success([
            'html' => $html,
        ]);



// ***************************************************
    // Récupération des posts
    // $query = new WP_Query($args);

    // if ($query->have_posts()) {
    //     ob_start();

    //     while ($query->have_posts()) {
    //         $query->the_post();
            // Affichez le contenu des photos comme vous le souhaitez
    //         echo '<div>' . get_the_title() . '</div>';
    //     }

    //     $data = ob_get_clean();
    //     wp_send_json_success($data);
    // } else {
    //     wp_send_json_error('Aucune photo trouvée.');
    // }
// ***************************************************
    wp_die();
}
add_action('wp_ajax_photos-tri', 'photos_tri');
add_action('wp_ajax_nopriv_photos-tri', 'photos_tri');
