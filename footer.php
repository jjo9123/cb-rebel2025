<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
?>
</div> <!-- end page -->
<div id="footer-top"></div>
<footer>
    <div class="footer container-xl pt-5 pb-4">
        <div class="row g-4">
            <div class="col-lg-2">
                <img src="<?=get_stylesheet_directory_uri()?>/img/unda-logo--wo.svg"
                    class="footer__logo" alt="Unda">
            </div>
            <div class="col-lg-3">
                <div class="footer__address">
                    <?=get_field('contact_address','options')?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="fw-700">Give us a call on:</div>
                <?=contact_phone()?>
                <div class="fw-700">Email us at:</div>
                <?=contact_email()?>
            </div>
            <div class="col-lg-2">
                <?=wp_nav_menu(array('theme_location' => 'footer_menu1'))?>
            </div>
            <div class="col-lg-2">
                <?=wp_nav_menu(array('theme_location' => 'footer_menu2'))?>
            </div>
        </div>
    </div>
    </div>
    <div class="colophon">
        <div class="container-xl py-2">
            <div class="d-flex gap-1 flex-wrap justify-content-between">
                <div class="col-md-10 text-center text-md-start">
                    &copy; <?=date('Y')?>  Unda Consulting Ltd. Registered in England, no 09360091. Registered Office 125 Noak Hill Road, Billericay, Essex, CM12 9UJ
                </div>
                <div class="col-md-2 w-100 w-md-auto d-flex align-items-center justify-content-center justify-content-md-end flex-wrap gap-1">
                    <a href="/privacy-policy/">Privacy</a> &amp; <a href="/cookie-policy/">Cookies</a> | 
                    <a href="https://www.chillibyte.co.uk/" rel="nofollow noopener" target="_blank" class="cb"
                        title="Digital Marketing by Chillibyte"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>