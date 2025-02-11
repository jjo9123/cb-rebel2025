<?php
$hero_slides = get_field('feat_slides'); // Repeater field containing cloned Hero fields

?>

<section class="feat-slider" style="position: relative;">
    <div class="feat-slider__wrapper">
        <?php if ($hero_slides): ?>
            <?php foreach ($hero_slides as $index => $slide): ?>
                <div class="feat-slide col-black pt-4 pb-3 mb-5" style="background-image: url('<?= wp_get_attachment_url($slide['background']); ?>');background-position: center;">
                    <div class="container-xl h-100">
                        <div class="row h-100">
                            <div class="col-lg-10 d-flex flex-column pt-4 pt-lg-0 align-items-center align-items-md-start justify-content-start justify-content-md-center">
                                                              
                                <h2 data-aos="fade-right" class="text-center text-md-start"><?= $slide['title'] ?></h2>
                                
                                <?php if (!empty($slide['content'])): ?>
                                    <div class="fs-300 fw-600" data-aos="fade-right" data-aos-delay="100"><?= $slide['content'] ?></div>
                                <?php endif; ?>
                                
                    
                                <?php if (!empty($slide['cta'])): ?>
                                    
                                    <a class="btn btn-primary mt-4 align-self-center align-self-md-start" href="<?=$slide['cta']['url']?>" target="<?=$slide['cta']['target']?>"><?=$slide['cta']['title']?>
                                    <span class="arrow-circle"></span>
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
<?php
add_action('wp_footer', function () {
?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.feat-slider__wrapper').forEach(function (slickWrapper) {
            var slickPrev = slickWrapper.closest('.feat-slider').querySelector('.slick-prev');
            var slickNext = slickWrapper.closest('.feat-slider').querySelector('.slick-next');

            if (slickPrev && slickNext) {
                $(slickWrapper).slick({
                    dots: true,
                    arrows: true,
                    prevArrow: slickPrev,
                    nextArrow: slickNext,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    fade: true,
                    cssEase: 'linear'
                }).on('setPosition', function () {
                    setEqualHeightForAllSliders();
                });
            }
        });

        // Function to set equal height for all slick sliders
        function setEqualHeightForAllSliders() {
            document.querySelectorAll('.feat-slider').forEach(slider => {
                let maxHeight = 0;

                // Find the tallest slide inside the current slider
                let slides = slider.querySelectorAll('.slick-slide > div > div.feat-slide'); // Adjust selector if needed
                slides.forEach(slide => {
                    slide.style.height = 'auto';
                    let slideHeight = slide.offsetHeight;
                    if (slideHeight > maxHeight) {
                        maxHeight = slideHeight;
                    }
                });

                // Apply the tallest height to all slides inside the current slider
                slides.forEach(slide => {
                    slide.style.height = maxHeight + 'px';
                });
            });
        }

        setEqualHeightForAllSliders();

        // Listen for slide changes and resize events
        document.querySelectorAll('.slick-slider').forEach(slider => {
            slider.addEventListener('transitionend', setEqualHeightForAllSliders);
        });

        window.addEventListener('resize', setEqualHeightForAllSliders);
    });
    </script>

<?php
}, 9999);
?>