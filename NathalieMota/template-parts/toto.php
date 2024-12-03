<?php
// Query pour récupérer les photos du CPT "photo"
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => -1,
);
$query = new WP_Query($args);

if ($query->have_posts()) : ?>
    <div class="gallery">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php
            // Récupérer l'image attachée au post
            $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $photo_title = get_the_title();
            ?>
            <div class="photo-item">
                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_title); ?>" class="thumbnail">
                <a href="#" class="lightbox-link" data-photo="<?php echo esc_url($photo_url); ?>" data-title="<?php echo esc_attr($photo_title); ?>">🖼️ Voir en grand</a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
