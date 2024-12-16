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
    wp_enqueue_script('chargerPlus',get_template_directory_uri() . '/js/charger-plus.js', [ 'jquery' ],'1.0', true);
    wp_enqueue_script('photo-filtre',get_template_directory_uri() . '/js/photo-filtre.js', [ 'jquery' ],'1.0',true);
}

add_action('wp_enqueue_scripts', 'NathalieMota_enqueue_styles');

function NathalieMota_add_space_mono_font() {
    wp_enqueue_style('space-mono-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', [], null);
}
add_action('wp_head', 'NathalieMota_add_space_mono_font');


add_action( 'wp_ajax_photo_charger_plus', 'photo_charger_plus' );
add_action( 'wp_ajax_nopriv_photo_charger_plus', 'photo_charger_plus' );

//  fonction d'affichage d une photo 
function afficher_photos($id)
{
   $html='';
    $html.= '<div class="photo-album-image">';
    $reference_photo_album = get_post_meta( $id, 'reference', true );
        $photo_url = get_the_post_thumbnail_url($id, 'large');

       $categories = get_the_terms($id, 'categorie');
    if ($categories && !is_wp_error($categories)) {
            $categorie_photo_album = $categories[0]->slug;
            };

    if ( has_post_thumbnail() ) {
        $html .= get_the_post_thumbnail( $id, 'medium', [ 'class' => 'photo-album-img' ] );
    }

    $html .= '<div class="legende-photo">';
    $html .= '<a href="#"  data-urlphoto="'. esc_url($photo_url) .'"  data-refphoto="' . $reference_photo_album . '" data-categorie="'. $categorie_photo_album . '"  id="lien-light-box" class="lightbox-link"><img class="fullscreen" src="' . esc_url( get_template_directory_uri() . '/assets/Icon_fullscreen.png' ) . '" alt="icone fullscreen"></a>';
    $html .= '<a href="' . esc_url( get_permalink( $id ) ) . '"><img class="oeil-icon" src="' . esc_url( get_template_directory_uri() . '/assets/icon-oeil.png' ) . '" alt="icone oeil"></a>';
    $html .= '<div class="legende-photo-texte">';
    $html .= '<p>' . esc_html( $reference_photo_album ) . '</p>';
    $html .= '<p>' . esc_html( $categorie_photo_album ) . '</p>';
    $html .= '</div></div></div>';

return $html;

}

//fonction executé à la suite du  clic sur le bouton afficher plus via un appel ajax
// elle reçoit en paramètre l'id de la derniere photo affiché ainsi que les filtres
//saisies sur le formulaire

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
    $msg='';
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $date_de_reference = get_post_field('post_date', $post_id);

    // requete d'interrogation des données tenant compte des filtres quand ils sont saisies
    
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

    $html='';
    $ref_derniere_photo=0;
    $photos_chargees = new WP_Query($args);

if ($photos_chargees->have_posts()) :
    while ($photos_chargees->have_posts()) : $photos_chargees->the_post();
        $html.= afficher_photos(get_the_ID());
        $ref_derniere_photo=get_the_ID();  // ref_derniere_photo contient l ID de la dernière page chargee
    endwhile;
    $html.='</div>';
        wp_reset_postdata(); 
else :
    $html .= '<p>Aucune photo similaire trouvée.</p>';
endif;

  	// Envoi des données au navigateur
if (!empty($html) && !empty($ref_derniere_photo)) {
        wp_send_json_success([
            'html' => $html,
            'lastphoto' => $ref_derniere_photo,
            'postid' => $post_id,
        ]);
 } 
 else {
        $html='<p class="message-erreur"> Plus de photo à charger'. $msg .'</p>';
        wp_send_json_success([
                'messageerreur' => $html,
            ]);
        
        }
    
    wp_die();
}

// fonction executée lors de l'appel ajax fait lors de la selection d'un filtre 
// dans le formulaire la requete pour récuperer les données filtrées selon 
//reçoit les paramètres categorie format clé de tri 

function photos_tri() {
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
        while ($photos_chargees->have_posts()) : $photos_chargees->the_post();
            $html.= afficher_photos(get_the_ID());
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



