<?php
$columns = get_field('boxes');
$heading = get_field('heading');

if ($columns):
?>

<section class="boxes-detail" style="position: relative;">
    <div class="container-xl py-2">
        <div class="row">
            <div class="col-12 mx-auto pb-4">
                <h2><?php echo $heading; ?></h2>
            </div>
        </div>
    <div class="acf-boxes-container container-xl">
        <?php foreach (array_chunk($columns, 4) as $row_index => $row_boxes): ?>
            <div class="acf-boxes-group" data-row="<?php echo $row_index; ?>">
                <div class="acf-boxes-row">
                <?php foreach ($row_boxes as $box_index => $box): ?>
                    <div class="acf-box" data-row="<?php echo $row_index; ?>" data-box="<?php echo $box_index; ?>">
                    <div class="acf-box-title">
                        <h4><?php echo wp_kses($box['title'], array('br' => array(), 'strong' => array(), 'em' => array())); ?></h4>

                        <p><?php echo wp_kses_post($box['detail']); ?></p>
                        </div>
                        <div class="dots">
                            <img src="/wp-content/themes/cb-rebel2025/img/rebel-dot.svg" alt="dot">
                        </div>
                        
                        <!-- Hidden on desktop, shown on mobile -->
                        <div class="acf-hover-content-mobile" data-box="<?php echo $box_index; ?>">
                            <div class="acf-hover-content">
                                <?php echo wp_kses_post($box['content']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                </div>

                <?php foreach ($row_boxes as $box_index => $box): ?>
                    <div class="acf-hover-content-row" data-row="<?php echo $row_index; ?>" data-box="<?php echo $box_index; ?>">
                        <div class="acf-hover-content">
                            <?php echo wp_kses_post($box['content']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
</section>

<?php endif; ?>

<!-- Slick Slider Initialization -->
<?php
add_action('wp_footer', function () {
?>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    function isMobile() {
        return window.innerWidth <= 767;
    }

    let lastActiveContent = null;
    let hideTimeout = null;

    function enableHover(block) {
        block.querySelectorAll(".acf-box").forEach(box => {
            box.addEventListener("mouseenter", function () {
                if (isMobile()) return;

                const rowIndex = this.getAttribute("data-row");
                const boxIndex = this.getAttribute("data-box");
                const newContent = block.querySelector(`.acf-hover-content-row[data-row="${rowIndex}"][data-box="${boxIndex}"]`);

                if (newContent) {
                    if (hideTimeout) {
                        clearTimeout(hideTimeout); // Prevent premature hiding
                        hideTimeout = null;
                    }

                    if (lastActiveContent && lastActiveContent !== newContent) {
                        lastActiveContent.style.opacity = "0"; // Begin fade-out
                        lastActiveContent.style.padding = "0px 20px"; // Reset padding before hiding
                        lastActiveContent.classList.remove("active");
                    }

                    newContent.classList.add("active");
                    newContent.style.opacity = "1";
                    newContent.style.visibility = "visible";

                    lastActiveContent = newContent;
                }
            });

            box.addEventListener("mouseleave", function () {
                if (lastActiveContent) {
                    hideTimeout = setTimeout(() => {
                        if (!block.querySelector(".acf-box:hover")) {
                            lastActiveContent.style.opacity = "0"; // Start fade-out
                            
                            setTimeout(() => {
                                lastActiveContent.style.padding = "0px 20px"; // Remove padding
                                lastActiveContent.classList.remove("active");
                                lastActiveContent.style.visibility = "hidden"; // Fully hide after animation
                                lastActiveContent = null;
                            }, 1000); // Matches transition duration
                        }
                    }, 400); // Short delay before hiding
                }
            });
        });
    }

    function applyBehavior() {
        document.querySelectorAll(".boxes-detail .acf-boxes-container").forEach(block => {
            if (!isMobile()) {
                enableHover(block);
            }
        });
    }

    applyBehavior();
    window.addEventListener("resize", applyBehavior);
});

</script>

<?php
}, 9999);