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


    