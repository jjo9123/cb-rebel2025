<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" class="<?= esc_attr(get_field('bg_colour') ?: '') ?>">
<?php
    the_post();    
    the_content(); 
    ?>
</main>
<?php
get_footer();