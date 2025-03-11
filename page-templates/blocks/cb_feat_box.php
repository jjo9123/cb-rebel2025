<?php
$background = get_field('background');
$background_url = $background ? wp_get_attachment_image_url($background, 'full') : '';
?>

<section class="feature-wrapper"> 
    <div class="feature" style="background-image: url('<?= esc_url($background_url) ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="feat">
        <div class="container-xl h-100">
            <div class="row h-100">
                <div class="col-12 d-flex flex-column pt-4 pt-lg-0 align-items-center align-items-md-start justify-content-start justify-content-md-center">
                                                    
                    <?php
                    $d = 0;
                    if (get_field('content') ?? null) {
                        $d+=100;
                        ?>
                    <div class="feat-content"><?=get_field('content')?></div>
                        <?php
                    }
                    if (get_field('link') ?? null) {
                        $cta = get_field('link');
                        $d+=100;
                        ?>
                    <a class="btn btn-primary mt-4 align-self-center align-self-md-start" href="<?=$cta['url']?>" target="<?=$cta['target']?>"><?=$cta['title']?>
                    <span class="arrow-circle"></span>
                    </a>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
                </div>
    </div>
</section>