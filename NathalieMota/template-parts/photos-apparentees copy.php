<p class="texte-photos-apparentess">Vous aimerez AUSSI</p>
<?php
$categories = get_the_terms(get_the_ID(), 'categorie');
if ($categories && !is_wp_error($categories)) {
    $category_slug = $categories[0]->slug;
}


// $categorie= foreach ( $categories as $category ) {
//     echo esc_html( $category->name ) . ' ';  }  


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
            if (has_post_thumbnail()) {
                the_post_thumbnail('meduim',['class' => 'photo-app']);
             }
            echo '<div class="legende-photo" style="background-image: url(' . get_template_directory_uri() . '/assets/icon-oeil.png)">';
                echo '<a href="#"><img class="fullscreen" src="' . get_template_directory_uri() . '/assets/Icon_fullscreen.png" alt="icone fullscreen" class="icon-fullscreen"></a>';
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











