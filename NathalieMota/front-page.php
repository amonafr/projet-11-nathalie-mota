<!-- Page d'accueil du site -->


<?php
// S'assurer que le fichier est appelé dans le contexte de WordPress.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); 

echo '<main class="photo-accueil">';
// Affichage d une photo  dans le hero header
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

<!-- formulaire pour le filtres envoi des paramètres ajax-->
<!-- Les catégories et les formats sont extraits à l'aide des requetes de la BD-->

<section class="photo-album-conteneur">
    <div class="photo-criteres-recherche">
        <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>"  method="POST" class="photos-form-tri">
             <input type="hidden" name="page_id" value="<?php echo get_the_ID(); ?>">
             <input  type="hidden" name="nonce"  value="<?php echo wp_create_nonce( 'photos-tri' ); ?>"> 
             <input type="hidden"   name="action" value="photos-tri"  >

            <div class="criteresP1">
                <select id="categorie" name="categorie">
                     <option value="" hidden>CATEGORIES</option>
                     <option value="" class="empty-option"></option>
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
                   <option value="" hidden>FORMATS</option>
                   <option value="" class="empty-option"></option>
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
                <option value="" hidden>TRIER PAR</option>
                <option value="" class="empty-option"></option>
                <option value="DESC">A partir des plus récentes</option>
                <option value="ASC">A partir des plus anciennes</option>
                </select>
            </div>
        </form>
    </div>
    

<!-- Affichage des photos par defaut à partir des plus récentes -->

<?php
$cletri='DESC';
$categorie='';
$format='';

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
        echo afficher_photos(get_the_ID());
        $derniere_photo=get_the_ID();
    endwhile;
    echo '</div>';
    wp_reset_postdata(); 
else :
    echo 'Aucune photo similaire trouvée.';
endif;

?>
 <!-- bouton charger attribut permettant de stocker les paramètres ajax ainsi que les filtres -->
<!-- les filres sont initialisés au premier chargement mais ils sont mis à jour
à chaque selection nouvelle selection dns le formulaire -->

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
