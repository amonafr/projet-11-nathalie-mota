<?php
// Sécurité : Assurez-vous que le fichier est appelé dans le contexte de WordPress.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); 

echo '<main class="photo-accueil">';

$args = [
    'post_type' => 'photo', 
    'orderby'        => 'rand',
    'posts_per_page' => 1, 
];
$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
<?php $query->the_post(); ?>
    <section class="photo-hero-header" 
    style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>')">
        <h1 class="titre-site"> photographe event</h1>
    </section>
   
<?php else : ?>
    <p>Aucune photo disponible pour le moment.</p>
<?php endif;

wp_reset_postdata(); ?>


<section class="photo-album-conteneur">
    <div class="photo-criteres-recherche">
        <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>"  method="POST" class="photos-form-tri">
        <input type="hidden" name="page_id" value="<?php echo get_the_ID(); ?>">
        <input 
            type="hidden" 
            name="nonce" 
            value="<?php echo wp_create_nonce( 'photos-tri' ); ?>"
        > 
        <input
            type="hidden"
            name="action"   
            value="photos-tri"
        >

        <div class="criteresP1">
            <select id="categorie" name="categorie">
                <option value="">Catégories</option>
                <?php
                $categories = get_terms( array(
                        'taxonomy'   => 'categorie',
                        'hide_empty' => true, 
                                         ) );
                foreach ( $categories as $category ) {
                echo '<option value="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
                                                    }
                ?>

            </select>

            <select id="format" name="format">
                <option value="">Formats</option>
                <?php
                $formats = get_terms( array(
                        'taxonomy'   => 'format',
                        'hide_empty' => true, // N'afficher que les catégories avec des posts
                                         ) );
                foreach ( $formats as $format ) {
                echo '<option value="' . esc_attr( $format->slug ) . '">' . esc_html( $format->name ) . '</option>';
                                                    }
                ?>
            </select>
        </div>
        <div class="criteresP2">
            <select id="cletri" name="cletri">Formats
                <option value="">Trier par</option>
                <option value="DESC">Récents->anciens</option>
                <option value="ASC">Anciens->Récents</option>
            </select>
        </div>
        </form>
    </div>
    
<!-- a supprimer -->

<!-- <?php
$categorie='';
$format='';
if ( isset( $_POST['categorie'] ) || isset( $_POST['format'] ) || isset( $_POST['cletri'] ) ) {
    $categorie = isset( $_POST['categorie'] ) ? sanitize_text_field( $_POST['categorie'] ) : '';
    $format = isset( $_POST['format'] ) ? sanitize_text_field( $_POST['format'] ) : '';
    $cletri = isset( $_POST['cletri'] ) ? sanitize_text_field( $_POST['cletri'] ) : '';

} else
{
$cletri='DESC';
    
}

?> -->

<!-- <script>
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();  
            document.querySelector('.photo-criteres-recherche form').submit(); // Soumet le formulaire
        }
    });
</script> -->

<!-- a supprimer -->



<!-- partie réutilisée -->
<?php
$cletri='DESC';

$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 8,
    'orderby' => 'date', 
    'order' => $cletri
);

$photos_apparentees = new WP_Query($args);

if ($photos_apparentees->have_posts()) :
    echo '<div class="photo-album"> ';
    while ($photos_apparentees->have_posts()) : $photos_apparentees->the_post();
        echo '<div class="photo-album-image">';
            $reference_photo_album = get_post_meta( get_the_ID(), 'reference', true );
            $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
       
           $categories = get_the_terms(get_the_ID(), 'categorie');
        if ($categories && !is_wp_error($categories)) {
                $categorie_photo_album = $categories[0]->slug;
                };


            if (has_post_thumbnail()) {
                the_post_thumbnail('meduim',['class' => 'photo-album-img']);
             }
            // echo '<div class="legende-photo" style="background-image: url(' . get_template_directory_uri() . '/assets/icon-oeil.png)">';
            echo '<div class="legende-photo">';
                echo '<a href="#" data-urlphoto="'. esc_url($photo_url) .'" 
                                  data-refphoto="' . $reference_photo_album . '" 
                                  data-categorie="'. $categorie_photo_album . '" 
                                  id="lien-light-box" class="lightbox-link"><img class="fullscreen" src="' . get_template_directory_uri() . '/assets/Icon_fullscreen.png" alt="icone fullscreen" class="icon-fullscreen" id="icone-light-box"></a>';

                // echo '<a href="#"><img class="fullscreen" src="' . get_template_directory_uri() . '/assets/Icon_fullscreen.png" alt="icone fullscreen" class="icon-fullscreen"></a>';
                echo '<a href="'. get_permalink(get_the_ID()) .'"><img class="oeil-icon" src="' . get_template_directory_uri() . '/assets/icon-oeil.png" alt="icone oeil" class="lien-oeil-icon"></a>';
                echo '<div class="legende-photo-texte">';   
                    echo '<p>' . $reference_photo_album . '</p>';
                    echo '<p>' . $categorie_photo_album .'</p>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        $derniere_photo=get_the_ID();
    endwhile;
    echo '</div>';
    wp_reset_postdata(); 
else :
    echo 'Aucune photo similaire trouvée.';
endif;

?>


<div class="photo-charger-plus">
 
    <input 
        type="button" 
        id="bouton-charger-plus" 
        data-postid="<?php echo $derniere_photo; ?>"
        data-cletri="<?php echo $cletri; ?>"
        data-nonce="<?php echo wp_create_nonce('photo_charger_plus'); ?>"
        data-action="photo_charger_plus"
        data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>"  
        data-categorie="<?php echo $categorie; ?>" 
        data-format="<?php echo $format; ?>"
        value="Charger plus">
</div>


</section>


</main>
<?php get_footer(); ?>
