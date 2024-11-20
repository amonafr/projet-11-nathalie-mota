<p class="texte-photos-apparentess">Vous aimerez AUSSI</p>
<?php
$categories = get_the_terms(get_the_ID(), 'categorie');
if ($categories && !is_wp_error($categories)) {
    $category_slug = $categories[0]->slug;
}

$id-photo-visualisee=get_the_ID();
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
        // echo '<div class="photo-app-conteneur">';
        if ($id-photo-visualisee != get_the_ID())
        {
        if (has_post_thumbnail()) {
                $thumbnail_url = get_the_post_thumbnail_url(null, 'medium');
            // the_post_thumbnail('meduim',['class' => 'photo-app']);
                echo '<div class="photo-app-conteneur" style="background-image: url(' . esc_url($thumbnail_url) . '")';
        //    echo '<div class="legende-photo">';
                $reference = get_post_meta( get_the_ID(), 'reference', true );
                echo '<p>' . $reference . '</p>';
                echo '<p>' . $category_slug .'</p>';
            echo '</div>';

        }
    }
    endwhile;
    echo '</div>';
    wp_reset_postdata(); // Réinitialise les données du post
else :
    echo 'Aucune photo similaire trouvée.';
endif;







?>










