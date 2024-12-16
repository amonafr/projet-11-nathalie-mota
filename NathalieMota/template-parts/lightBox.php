<!-- lightbox affiché au clic sur le lien haut à droite des photos via le 
 script lightBox.js -->
 
<div class="lightbox" id="lightbox">
        <div class="overlay"></div>
        <div class="lightbox-fermer">
                <button id="lightbox-croix">
                    <span class="lightbox-line"></span>
                    <span class="lightbox-line"></span>
                </button>
        </div>
   
        <div class="photo-lightbox-precedente" > 
            <a class="photo-precedente-lien" href="#">

             <img  src="<?php echo get_template_directory_uri() . '/assets/fleche-gauche.png'?>" alt="fleche gauche"></a>
            <p>Précédente</p>
        </div> 
        <div class="photo-lightbox-suivante" >
            <p>Suivante</p>
            <a class="photo-suivante-lien" href="#"><img  src="<?php echo get_template_directory_uri() . '/assets/fleche-droite.png'?>" alt="fleche droite"></a>
            
        </div>
        <div class="lightbox-globale">
            <div class="lightbox-content">
            
                <img src="" alt="" id="lightbox-image">
                <div class="lightbox-info">
                    <p id="lightbox-reference">reference </p>
                    <p id="lightbox-categorie"> categorie</p>
                </div>
            </div>
            
        </div>      
        
    </div>