<?php
/**
 * The header for the theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package lc-tideywebb
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta
        charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    
    <?php
    if (is_front_page()) {
        ?>
    <script type="application/ld+json">

    </script>
    <?php
    }
    if (!is_user_logged_in()) {
        if (get_field('ga_property', 'options')) {
            ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async
        src="https://www.googletagmanager.com/gtag/js?id=<?=get_field('ga_property', 'options')?>">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config',
            '<?=get_field('ga_property', 'options')?>'
        );
    </script>
            <?php
        }
        if (get_field('gtm_property', 'options')) {
            ?>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer',
            '<?=get_field('gtm_property', 'options')?>'
        );
    </script>
    <!-- End Google Tag Manager -->
        <?php
    }
}
if (get_field('google_site_verification', 'options')) {
    echo '<meta name="google-site-verification" content="' . get_field('google_site_verification', 'options') . '" />';
}
if (get_field('bing_site_verification', 'options')) {
    echo '<meta name="msvalidate.01" content="' . get_field('bing_site_verification', 'options') . '" />';
}
?>
    <?php wp_head(); ?>
    <meta name="google-site-verification" content="4W-KMZmlmLkobQbWLvM7uoxlOnabbV5vxhKhhdoSv0g" />
</head>

<body <?php body_class(); ?>
    <?php understrap_body_attributes(); ?>>
    <?php
    if (!is_user_logged_in()) {
        if (get_field('gtm_property', 'options')) {
        ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe
        src="https://www.googletagmanager.com/ns.html?id=<?=get_field('gtm_property', 'options')?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <?php
        }
    }
do_action('wp_body_open');
?>
    <header class="navholder" id="navholder">
    <div id="wrapper-navbar" class="fixed-top">
        <nav id="navbar" class="navbar navbar-expand-lg" aria-labelledby="main-nav-label">
            <div class="container-xl">
                <!-- Logo -->
                <a href="/">
                    <img class="header__logo" src="<?= get_stylesheet_directory_uri() ?>/img/gradient-logo.svg" alt="Home" width="317" height="93">
                </a>

                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler input-button" id="navToggle" data-bs-toggle="collapse" data-bs-target="#primaryNav" type="button" aria-label="Navigation">
                    <i class="fa fa-navicon"></i>
                </button>

                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse navbars" id="primaryNav">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary_nav',
                            'container'       => false,
                            'menu_class'      => 'navbar-nav w-100 justify-content-end gap-2 align-items-center',
                            'fallback_cb'     => '',
                            'menu_id'         => 'main-menu',
                            'depth'           => 2,
                            'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                        )
                    );
                    ?>

                    <!-- Contact Information (Visible only on Desktop) -->
                    <div class="contact-info d-none d-lg-flex gap-3 align-items-center">
                        <?= do_shortcode('[contact_email_icon]') ?>
                        <?= do_shortcode('[social_in_icon]') ?>
                    </div>

                    <!-- Contact Information inside the Mobile Menu (Visible only on Mobile) -->
                    <div class="mobile-contact-info d-lg-none mt-3 text-center">
                        <hr>
                        <p class="mb-1"><?= do_shortcode('[contact_email_icon]') ?></p>
                        <p><?= do_shortcode('[social_in_icon]') ?></p>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>