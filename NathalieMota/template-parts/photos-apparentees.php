
<?php
$categories = get_the_terms(get_the_ID(), 'categorie');
if ($categories && !is_wp_error($categories)) {
    $category_slug = $categories[0]->slug;
}




$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 2,
    'post__not_in' => array(get_the_ID()), 
    'tax_query' => array(
        array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category_slug,
        ),
    ),
    'orderby' => 'rand', 
);

$photos_apparentees = new WP_Query($args);

if ($photos_apparentees->have_posts()) :
    echo '<div class="photos-apparentees-detail"> ';
    while ($photos_apparentees->have_posts()) : $photos_apparentees->the_post();
        echo '<div class="photo-app-conteneur">';
            $reference_photo_app = get_post_meta( get_the_ID(), 'reference', true );
         
            $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        // ************************   
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            if ($prev_post) {
                $photo_precedente_url = get_the_post_thumbnail_url($prev_post->ID, 'large');
            }
            if ($next_post) {
                $photo_suivante_url = get_the_post_thumbnail_url($next_post->ID, 'large');
            }
// **********************


            if (has_post_thumbnail()) {
                the_post_thumbnail('meduim',['class' => 'photo-app']);
             }
            // echo '<div class="legende-photo" style="background-image: url(' . get_template_directory_uri() . '/assets/icon-oeil.png)">';
            echo '<div class="legende-photo">';
            // echo '<a href="#" data-urlphoto="'. esc_url($photo_url) .'"  data-idphoto="' . get_the_ID() . '" data-categorie="'. $category_slug . '" data-refphoto="' . $reference_photo_app . '" data-urlprecedente="'. $photo_precedente_url .'"  id="lien-light-box" class="lightbox-link"><img class="fullscreen" src="' . get_template_directory_uri() . '/assets/Icon_fullscreen.png" alt="icone fullscreen" class="icon-fullscreen" id="icone-light-box"></a>';
                // data-urlprecedente="'. $photo_precedente_url .'" 
                // data-idprecedente="'.$prev_post->ID.'"  
                // data-ajaxurl="'. admin_url( 'admin-ajax.php' ) .'"  
                                // data-nonce="'. wp_create_nonce('photos_lightbox'). '"


                echo '<a href="#" 
                data-urlphoto="'. esc_url($photo_url) .'"  
                data-idphoto="' . get_the_ID() . '" 
                data-categorie="'. $category_slug . '" 
                data-refphoto="' . $reference_photo_app . '" 
                data-nonce="'. wp_create_nonce('photos_lightbox'). '"
                data-action="photos_lightbox"
                data-ajaxurl="'. admin_url( 'admin-ajax.php' ) .'"
                id="lien-light-box" class="lightbox-link">
                <img  src="' . get_template_directory_uri() . '/assets/Icon_fullscreen.png" alt="icone fullscreen" class="icon-fullscreen fullscreen" id="icone-light-box"></a>';
               
                echo '<a href="'. get_permalink(get_the_ID()) .'"><img class="oeil-icon" src="' . get_template_directory_uri() . '/assets/icon-oeil.png" alt="icone oeil" class="lien-oeil-icon"></a>';
                echo '<div class="legende-photo-texte">';   
                    echo '<p>' . $reference_photo_app . '</p>';
                    echo '<p>' . $category_slug .'</p>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    endwhile;
    echo '</div>';
    wp_reset_postdata(); // Réinitialise les données du post
else :
    echo 'Aucune photo similaire trouvée.';
endif;


?>











