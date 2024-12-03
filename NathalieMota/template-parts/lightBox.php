

<div class="lightbox" id="lightbox">
<div class="overlay"></div>
<div class="lightbox-fermer">
    <button id="lightbox-croix">
                <span class="lightbox-line"></span>
                <span class="lightbox-line"></span>
    </button>
</div>
<?php 
        $prev_post = get_previous_post();
        $next_post = get_next_post();
        $photo_precedente_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        $photo_precedente_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
?>
<!-- <?php echo $prev_post->ID ?> -->
 
<div class="lightbox-globale">
    <div class="photo-lightbox-precedente" > 
        <a class="photo-precedente-lien" href="" 
         data-photoprecedente=""  
         data-idprecedente=""
         data-reference=""
         data-categorie=""
         data-nonce="<?php echo wp_create_nonce('photos_lightbox');?>"
         data-action="photos_lightbox"
         data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ) ;?>" >
         <img  src="<?php echo get_template_directory_uri() . '/assets/fleche-gauche.png'?>" alt="fleche gauche"></a>
        <p>Précédente</p>
    </div>  
    <div class="lightbox-content">
        
        <img src="" alt="" id="lightbox-image">
        <div class="lightbox-info">
            <p id="lightbox-reference">reference </p>
            <p id="lightbox-categorie"> categorie</p>
        </div>
    </div>
        <div class="photo-lightbox-suivante" >
            <p>Suivante</p>
            <a class="photo-suivante-lien" href=""
            data-photosuivante=""  
            data-idsuivante=""
            data-reference=""
            data-categorie=""
            data-nonce="<?php echo wp_create_nonce('photos_lightbox');?>"
            data-action="photos_lightbox"
            data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ) ;?>"
            ><img  src="<?php echo get_template_directory_uri() . '/assets/fleche-droite.png'?>" alt="fleche droite"></a>
            
        </div>


            <!-- <button id="prev-btn">&larr; Précédente</button>
            <button id="next-btn">Suivante &rarr;</button> -->
</div>      
    
</div>
