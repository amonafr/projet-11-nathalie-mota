<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?php wp_title(); ?></title>
        <?php wp_head() ?>
    </head>
<body>
    
<header class="barre-navigation">
    <div class="haut-menu">
    <div class="logo-container">
     <a href="<?php echo home_url(); ?>" >
        <img src="<?php echo get_template_directory_uri() . '/assets/Logo.png'; ?>" alt="Logo" class="logo-img">
      </a>
    </div>
    
    <button id="menuMobile" class="menuBurger">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
    </button>
    </div>
    <nav class="photo-menu-principal">
    <?php  wp_nav_menu(['theme_location' => 'main-menu',
    ]);?>
    </nav>

</header>




