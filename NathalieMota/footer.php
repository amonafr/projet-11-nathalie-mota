

<?php get_template_part('template-parts/ModalContact'); ?> 
<?php get_template_part('template-parts/lightBox'); ?> 

<footer class="photo-footer">
<div class="ligne-footer"></div>
<?php
wp_nav_menu([
    'theme_location' => 'footer',
]);

?>
</footer>
<?php wp_footer() ?>
</body>
</html>