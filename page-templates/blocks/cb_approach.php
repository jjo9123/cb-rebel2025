<?php
$columns = get_field('steps');
?>

<section class="step-cols" style="position: relative;">
    <div class="container-xl py-5">
        <!-- Header Row -->
        <div class="row mb-4">
            <div class="col-12 pb-2"><h2>Our Approach</h2></div>
        </div>

        <!-- Data Rows -->
        <div class="row gy-3 gx-0">
            <?php if ($columns): ?>
                <?php $index = 1;?>
                <?php foreach ($columns as $column): ?>
                    <div class="col-lg-6">
                        <div class="card-box step" data-target="read-more-<?php echo $index; ?>">
                            <div class="card-number"><?php echo $index; ?></div>
                            <div class="card-text">
                                <p><?php echo esc_html($column['step']); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card-box read-more-content" id="read-more-<?php echo $index; ?>">
                            <div class="card-text">
                                <p><?php echo esc_html($column['step_rm']); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php $index++; ?>
                <?php endforeach; ?>
                <?php $index = 0; ?>
            <?php endif; ?>
            <div class="row">
            <?php if (get_field('contact_link') ?? null) {
                        $cta = get_field('contact_link');
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
</section>

<!-- Slick Slider Initialization -->
<?php
add_action('wp_footer', function () {
?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    // Get all issue elements
    const stepCards = document.querySelectorAll(".card-box.step");
    stepCards.forEach(card => {
        const targetId = card.dataset.target; // Get target id
        const readMoreContent = document.getElementById(targetId);
        // On hover, show the read-more content
        card.addEventListener("mouseenter", () => {
            if (readMoreContent) {
                readMoreContent.style.opacity = "1";
                readMoreContent.style.visibility = "visible";
            }
        });
        // On mouse leave, hide the read-more content
        card.addEventListener("mouseleave", () => {
            if (readMoreContent) {
                readMoreContent.style.opacity = "0";
                readMoreContent.style.visibility = "hidden";
            }
        });
        // Optional: Add click functionality for persistent toggling
        card.addEventListener("click", () => {
            stepCards.forEach(c => {
                const target = document.getElementById(c.dataset.target);
                if (target && target !== readMoreContent) {
                    target.style.opacity = "0";
                    target.style.visibility = "hidden";
                }
            });
            if (readMoreContent) {
                const isVisible = readMoreContent.style.opacity === "1";
                readMoreContent.style.opacity = isVisible ? "0" : "1";
                readMoreContent.style.visibility = isVisible ? "hidden" : "visible";
            }
        });
    });
});
</script>
<?php
}, 9999);