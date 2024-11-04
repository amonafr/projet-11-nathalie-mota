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
    
}
add_action('wp_enqueue_scripts', 'NathalieMota_enqueue_styles');

function NathalieMota_add_space_mono_font() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    wp_enqueue_style('space-mono-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', [], null);
}
add_action('wp_head', 'NathalieMota_add_space_mono_font');
