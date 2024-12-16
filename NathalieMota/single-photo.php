<!-- Page permettant d'afficher une photo avec deux photos de même catégorie -->

<?php get_header(); ?>

<main class="single-photo-container">

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();  ?>
    
    <!-- Affichage de l'image mise en avant -->
    <section class="photo-globale">
        
        <div class="photo-info">
            <h2 class="photo-title"><?php the_title(); ?></h2>
            <div class="photo-details">
                <?php

                $reference = get_post_meta( get_the_ID(), 'reference', true );
                $categories = get_the_terms( get_the_ID(), 'categorie' );
                $formats = get_the_terms( get_the_ID(), 'format' );
                $type = get_post_meta( get_the_ID(), 'type', true );
                $annee=get_the_date('Y');
           
                ?>

                <p class="photo-label">Référence : <?php echo esc_html( $reference ); ?></p>
                <p class="photo-label">Catégorie : <?php foreach ( $categories as $category ) {
                            echo esc_html( $category->name ) . ' ';  } ?> </p>
                <p class="photo-label">Format : <?php foreach ( $formats as $format ) { 
                    echo esc_html( $format->name ) . ' ';} ?> </p>
                <p class="photo-label">Type : <?php echo esc_html( $type ); ?></p>
                <p class="photo-label">Année : <?php echo esc_html( $annee ); ?></p>
            </div><!-- fin photo-details -->

            <div class="petite-separation">
            </div>
           

        </div> <!-- fin photo-info -->
        <div class="photo-image">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'full',['class' => 'responsive-img'] ); ?>
            <?php endif; ?>
        </div>
    </section>
    <section class="photo-contact-navigation">
            <div class="photo-bouton">
                <p>Cette photo vous intéresse ?</p>
                <input type="button" id="contact-button" data-reference="<?php echo esc_attr( $reference ); ?>" value="Contact">
            </div>
            <div class="photo-navigation">
                <?php 
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                ?>
                <div class="photo-suivante" id="miniature-suivante">
                    <?php if ($next_post): ?>
                        <?php echo get_the_post_thumbnail($next_post->ID, 'thumbnail', ['class' => 'img-photo-suivante']); ?>
                    <?php endif; ?>
                </div>
                <div class="photo-precedente" id="miniature-precedente">
                    <?php if ($prev_post): ?>
                        <?php echo get_the_post_thumbnail($prev_post->ID, 'thumbnail', ['class' => 'img-photo-suivante']); ?>
                    <?php endif; ?>
                </div> 
                <div class="photo-fleche" >
                    <?php if ($prev_post): ?>
                     <a class="photo-fleche_gauche" href="<?php echo get_permalink($prev_post->ID); ?>"><img  src="<?php echo get_template_directory_uri() . '/assets/fleche-gauche.png'?>" alt="fleche gauche"></a>
		            <?php endif; ?>
                    <?php if ($next_post): ?>
                     <a class="photo-fleche_droite" href="<?php echo get_permalink($next_post->ID); ?>"><img  src="<?php echo get_template_directory_uri() . '/assets/fleche-droite.png'?>" alt="fleche droite"></a>
                    <?php endif; ?>
                </div>
            </div>
            
    </section>
    <section id="photos-apparentees" class="photos-apparentees">
        <div class="grande-separation"></div>
        <p class="texte-photos-apparentess">Vous aimerez AUSSI</p>
        <?php get_template_part('template-parts/photos-apparentees');?>
    </section>
    <?php
        endwhile;
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>

