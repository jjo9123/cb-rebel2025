<?php
$hero_slides = get_field('hero_slides'); // Repeater field containing cloned Hero fields

?>

<section class="hero-slider" style="position: relative;">
    <div class="hero-slider__wrapper">
        <?php if ($hero_slides): ?>
            <?php foreach ($hero_slides as $index => $slide): ?>
                <div class="hero-slide col-black pt-4 pb-3 mb-5" style="background-image: url('<?= wp_get_attachment_url($slide['background']); ?>');">
                    <div class="container-xl h-100">
                        <div class="row h-100">
                            <div class="col-lg-10 d-flex flex-column pt-4 pt-lg-0 align-items-center align-items-md-start justify-content-start justify-content-md-center">
                                
                                <?php if ($index === 0): ?>
                                    <h1 data-aos="fade-right" class="text-center text-md-start"><?= $slide['title'] ?></h1>
                                <?php else: ?>
                                    <h2 data-aos="fade-right" class="text-center text-md-start"><?= $slide['title'] ?></h2>
                                <?php endif; ?>
                                
                                <?php if (!empty($slide['content'])): ?>
                                    <div class="fs-500 fw-600" data-aos="fade-right" data-aos-delay="100"><?= $slide['content'] ?></div>
                                <?php endif; ?>

                                <?php if (!empty($slide['cta'])): ?>
                                    <a class="btn btn-primary mt-4 align-self-center align-self-md-start"
                                       href="<?= $slide['cta']['url'] ?>" 
                                       target="<?= $slide['cta']['target'] ?>" 
                                       data-aos="fade-right" data-aos-delay="200">
                                        <?= $slide['cta']['title'] ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hero slides found.</p>
        <?php endif; ?>
    </div>

    <button class="slick-prev slick-arrow" aria-label="Previous slide">&#10094;</button>
    <button class="slick-next slick-arrow" aria-label="Next slide">&#10095;</button>
</section>





<!-- Slick Slider Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var slickWrapper = document.querySelector('.hero-slider__wrapper');
    var slickPrev = document.querySelector('.slick-prev');
    var slickNext = document.querySelector('.slick-next');
    
    if (slickWrapper && slickPrev && slickNext) {
        $(slickWrapper).slick({
            dots: true,
            arrows: true,
            prevArrow: slickPrev,
            nextArrow: slickNext,
            autoplay: true,
            autoplaySpeed: 5000,
            fade: true,
            cssEase: 'linear'
        });
    }
});
</script>