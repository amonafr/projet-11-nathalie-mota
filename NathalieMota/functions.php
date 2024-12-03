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
    wp_enqueue_script('ouvrirMenuBurger', get_template_directory_uri() . '/js/ouvrirMenuBurger.js',[],'1.0',true);
    wp_enqueue_script('lightBox', get_template_directory_uri() . '/js/lightBox.js',[],'1.0',true);


    
    wp_enqueue_script( 
        'chargerPlus', 
        get_template_directory_uri() . '/js/charger-plus.js', [ 'jquery' ], 
      '1.0', 
      true 
   );
   wp_enqueue_script( 
    'photo-filtre', 
    get_template_directory_uri() . '/js/photo-filtre.js', [ 'jquery' ], 
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
    if (empty($cletri))
    {
        $cletri='DESC';
    }
    $categorie='';
    $format='';
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    // la requete wpquery
    // post_id contient la dernière page chargée
    $date_de_reference = get_post_field('post_date', $post_id);
    // $New_photo_de_reference=get_the_ID();

    $msg='';

//ancienne requete qui marche

// $args = [
//     'post_type' => 'photo', 
//     'posts_per_page' => 8, 
//     'orderby' => 'date', 
//     'order' => $cletri, 
//     'date_query' => [
//         [
//             'before' => $date_de_reference, 
//             'inclusive' => false, 
//         ],
//     ],
// ];

// nouvelle requette tenant compte des select

// $args = [
//     'post_type' => 'photo',
//     'posts_per_page' => 8,
//     'tax_query' => [],
//     'orderby' => 'date',
//     'order' => $cletri,
//     'date_query' => [
//         [
//             'before' => $date_de_reference, 
//             'inclusive' => false, 
//         ],
//     ],
    
// ];
if ($cletri==='DESC'){
    $args = [
            'post_type' => 'photo',
            'posts_per_page' => 8,
            'tax_query' => [],
            'orderby' => 'date',
            'order' => $cletri,
            'date_query' => [
                [
                    'before' => $date_de_reference, 
                    'inclusive' => false, 
                ],
            ],
            
        ];
} elseif ($cletri==='ASC')
{
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'tax_query' => [],
        'orderby' => 'date',
        'order' => $cletri,
        'date_query' => [
            [
                'after' => $date_de_reference, 
                'inclusive' => false, 
            ],
        ],
        
    ];

}


// $args = [
//     'post_type' => 'photo',
//     'posts_per_page' => 8,
//     'tax_query' => [],
//     'orderby' => 'date',
//     'order' => $cletri, // Garder la valeur de tri ici
//     'date_query' => [
//         [
//             $cletri === 'DESC' ? 'before' : 'after' => $date_de_reference,
//             'inclusive' => false, 
//         ],
//     ],
// ];


if (isset($categorie) && !empty($categorie) && ($categorie !=''))
 {
    $args['tax_query'][] = [
        'taxonomy' => 'categorie',
        'field' => 'slug',
        'terms' => $categorie,
    ];
    
}

if (isset($categorie) && !empty($format) && ($format !='')) {
    $args['tax_query'][] = [
        'taxonomy' => 'format',
        'field' => 'slug',
        'terms' => $format,
    ];
}



// fin nouvelle requette tenant compte des select

$html='';
$ref_derniere_photo=0;
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
        $ref_derniere_photo=get_the_ID();  // ref_derniere_photo contient l ID de la dernière page chargee
    endwhile;
    $html.='</div>';
    
        
    wp_reset_postdata(); // Réinitialise les données du post
else :
    $html .= '<p>Aucune photo similaire trouvée.</p>';
endif;
// fin la requete wpquery
  	// Envoyer les données au navigateur
      if (!empty($html) && !empty($ref_derniere_photo)) {
        wp_send_json_success([
            'html' => $html,
            'lastphoto' => $ref_derniere_photo,
            'postid' => $post_id,
        ]);
    } else {
        $html='<p class="message-erreur"> Plus de photo à charger'. $msg .'</p>';
        wp_send_json_success([
                'messageerreur' => $html,
            ]);


        // wp_send_json_error('Données manquantes');
    }
    //envoyer données
    //   wp_send_json_success([
    //     'html' => $html,
        // 'lastphoto'=>$ref_derniere_photo,
    // ]);
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
            $ref_derniere_photo=get_the_ID();
        endwhile;
        $html.='</div>';
        wp_reset_postdata(); 
    else :
        $html .= '<p>Aucune photo similaire trouvée.</p>';
    endif;
    
         
        wp_send_json_success([
            'html' => $html,
            'lastphoto' => $ref_derniere_photo,
        ]);



    wp_die();
}
add_action('wp_ajax_photos-tri', 'photos_tri');
add_action('wp_ajax_nopriv_photos-tri', 'photos_tri');




// fonction lightbox
function photos_lightbox() 
{

    
    // Vérification de la sécurité
    if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'photos_lightbox')) {
        wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403);
    }

    if (!isset($_POST['photo_id'])) {
        wp_send_json_error("L'identifiant de la photo est manquant.", 400);
    }

    $photo_id = intval($_POST['photo_id']);

    // Query pour récupérer la photo actuelle
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'p' => $photo_id
    );

    $photos_chargees = new WP_Query($args);

    $photo_precedente_url = '';
    $photo_suivante_url = '';
    $photo_precedente_id = 0;
    $photo_suivante_id = 0;

    if ($photos_chargees->have_posts()) {
        while ($photos_chargees->have_posts()) : $photos_chargees->the_post();

            $prev_post = get_previous_post();
            $next_post = get_next_post();

            if ($prev_post) {
                $photo_precedente_id = $prev_post->ID;
                $photo_precedente_url = get_the_post_thumbnail_url($prev_post->ID, 'large');
                $photo_precedente_ref = get_post_meta( $prev_post->ID, 'reference', true );
                $categories = get_the_terms($prev_post->ID, 'categorie');
                if ($categories && !is_wp_error($categories)) {
                        $photo_precedente_cat = $categories[0]->slug;
                        };
                  }
            if ($next_post) {
                $photo_suivante_id = $next_post->ID;
                $photo_suivante_url = get_the_post_thumbnail_url($next_post->ID, 'large');
                $photo_suivante_ref = get_post_meta( $next_post->ID, 'reference', true );
                $categories = get_the_terms($next_post->ID, 'categorie');
                if ($categories && !is_wp_error($categories)) {
                        $photo_suivante_cat = $categories[0]->slug;
                        };
            }

        endwhile;
        wp_reset_postdata();
    }

    wp_send_json_success([
        'photo_precedente' => [
            'id' => $photo_precedente_id,
            'url' => $photo_precedente_url,
            'reference'=>$photo_precedente_ref,
            'categorie'=>$photo_precedente_cat,
        ],
        'photo_suivante' => [
            'id' => $photo_suivante_id,
            'url' => $photo_suivante_url,
            'reference'=> $photo_suivante_ref,
            'categorie'=>$photo_suivante_cat,

        ],
    ]);
}

// add_action('wp_ajax_photos_lightbox', 'photos_lightbox');
// add_action('wp_ajax_nopriv_photos_lightbox', 'photos_lightbox');

add_action('wp_ajax_photos_lightbox', 'photos_lightbox');
add_action('wp_ajax_nopriv_photos_lightbox', 'photos_lightbox');


function photos_lightboxold() 
{
    if( 
		! isset( $_REQUEST['nonce'] ) or 
       	! wp_verify_nonce( $_REQUEST['nonce'], 'photos-tri' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
  	}
      if( ! isset( $_POST['photo_id'] ) ) {
    	wp_send_json_error( "L'identifiant de la page est manquant.", 400 );
  	}
      $page_id = isset($_POST['photo_id']) ? intval($_POST['photo_id']) : 0;


// Query pour récupérer les photos du CPT "photo"
$args = array(
    'post_type'      => 'photo',
    'posts_per_page' => 1,
    'p'              => $photo_id 
);
$photos_chargees = new WP_Query($args);

// ***********************************
            
if ($photos_chargees->have_posts()) :
    // echo '<div class="photo-album"> ';
    while ($photos_chargees->have_posts()) : $photos_chargees->the_post();
 
        $prev_post = get_previous_post();
        $next_post = get_next_post();
        if( $prev_post){
            $photo_precedente_url = get_the_post_thumbnail_url(get_the_ID(), 'large');

        }
        if( $next_post){
            $photo_suivante_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }
    endwhile;
    wp_reset_postdata(); 
else :
    $html .= '<p>Aucune photo similaire trouvée.</p>';
endif;

     
wp_send_json_success([
        'html' => $html,
        'photo_precedente' => $photo_precedente_url,
        'photo_suivante' => $photo_suivante_url,
    ]);

wp_die();      
}

// add_action('wp_ajax_photos_lightbox', 'photos_lightbox');
// add_action('wp_ajax_nopriv_photos_lightbox', 'photos_lightbox');