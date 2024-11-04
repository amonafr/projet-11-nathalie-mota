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
     <a href="#" class="logo-container">
        <img src="<?php echo get_template_directory_uri() . '/assets/Logo.png'; ?>" alt="Logo" class="logo-img">
      </a>
    <?php  wp_nav_menu(['theme_location' => 'main-menu',
    ]);?>

</nav>




