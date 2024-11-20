<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?php wp_title(); ?></title>
        <?php wp_head() ?>
    </head>
<body>
    
<nav class="barre-navigation">
    <div class="logo-container">
     <a href="#" >
        <img src="<?php echo get_template_directory_uri() . '/assets/Logo.png'; ?>" alt="Logo" class="logo-img">
      </a>
    </div>
    <div class="photo-menu-principal">
    <button class="menuBurger">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
    </button>
    <?php  wp_nav_menu(['theme_location' => 'main-menu',
    ]);?>
    </div>

</nav>




