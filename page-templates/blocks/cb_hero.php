<?php
$background = get_field('background');
$background_url = $background ? wp_get_attachment_image_url($background, 'full') : '';
?>

<section class="hero pt-4 pb-3 mb-5" 
    style="background-image: url('<?= esc_url($background_url) ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container-xl h-100">
        <div class="row h-100">
            <div class="col-lg-10 d-flex flex-column pt-4 pt-lg-0 align-items-center align-items-md-start justify-content-start justify-content-md-center">
                <h1 data-aos="fade-right" class="text-center text-md-start"><?=get_field('title')?></h1>
                <?php
                $d = 0;
                if (get_field('content') ?? null) {
                    $d+=100;
                    ?>
                <div class="fs-300 fw-600" data-aos="fade-right" data-aos-delay="<?=$d?>"><?=get_field('content')?></div>
                    <?php
                }
                if (get_field('cta') ?? null) {
                    $cta = get_field('cta');
                    $d+=100;
                    ?>
                <a class="btn btn-primary mt-4 align-self-center align-self-md-start" href="<?=$cta['url']?>" target="<?=$cta['target']?>" data-aos="fade-right" data-aos-delay="<?=$d?>"><?=$cta['title']?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>