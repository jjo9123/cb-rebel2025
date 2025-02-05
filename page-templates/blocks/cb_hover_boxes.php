<?php
$columns = get_field('boxes');
$heading = get_field('heading');

if ($columns):
?>

<section class="boxes" style="position: relative;">
    <div class="container py-5">
        <div class="row">
            <div class="col-12 mx-auto pb-4">
                <h2><?php echo $heading; ?></h2>
            </div>
        </div>
    <div class="acf-boxes-container">
        <?php foreach (array_chunk($columns, 4) as $row_index => $row_boxes): ?>
            <div class="acf-boxes-group" data-row="<?php echo $row_index; ?>">
                <div class="acf-boxes-row">
                    <?php foreach ($row_boxes as $box_index => $box): ?>
                        <div class="acf-box" data-row="<?php echo $row_index; ?>" data-box="<?php echo $box_index; ?>">
                            <div class="acf-box-title"><h4><?php echo esc_html($box['title']); ?></h4></div>
                            <div class="dots">
                                <img src="/wp-content/themes/cb-rebel2025/img/rebel-dot.svg" alt="dot">
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
        return window.innerWidth <= 767; // Detect mobile screen width
    }

    function reset(block) {
        block.querySelectorAll(".acf-hover-content-row").forEach(content => {
            if (!content.classList.contains("active")) {
                content.style.opacity = "0";
                content.style.visibility = "hidden";
            }
        });
    }

    function enableHover(block) {
    block.querySelectorAll(".acf-box").forEach(box => {
        box.addEventListener("mouseenter", function () {
            if (isMobile()) return; // Disable hover on mobile
            
            reset(block); // Reset previous selections
            const rowIndex = this.getAttribute("data-row");
            const boxIndex = this.getAttribute("data-box");

            const hoverContent = block.querySelector(`.acf-hover-content-row[data-row="${rowIndex}"][data-box="${boxIndex}"]`);
            if (hoverContent) {
                hoverContent.classList.add("active");
                hoverContent.style.opacity = "1";
                hoverContent.style.visibility = "visible";
            }
        });

        // **Hide content when moving mouse away**
        box.addEventListener("mouseleave", function () {
            const rowIndex = this.getAttribute("data-row");
            const boxIndex = this.getAttribute("data-box");

            const hoverContent = block.querySelector(`.acf-hover-content-row[data-row="${rowIndex}"][data-box="${boxIndex}"]`);
            if (hoverContent) {
                hoverContent.classList.remove("active");
                hoverContent.style.opacity = "0";
                hoverContent.style.visibility = "hidden";
            }
        });
    });
}


function enableClick(block) {
    block.addEventListener("click", function (event) {
        const box = event.target.closest(".acf-box");
        if (!box) return;

        reset(block); // Reset previous selections
        const rowIndex = box.getAttribute("data-row");
        const boxIndex = box.getAttribute("data-box");

        const activeGroup = block.querySelector(`.acf-boxes-group[data-row="${rowIndex}"]`);
        const activeContent = block.querySelector(`.acf-hover-content-row[data-row="${rowIndex}"][data-box="${boxIndex}"]`);

        if (activeGroup) activeGroup.classList.add("active");
        if (activeContent) {
            activeContent.classList.add("active");
            activeContent.style.opacity = "1";
            activeContent.style.visibility = "visible";
        }

        event.stopPropagation(); // Prevents bubbling up
    });

    // **Close content row when clicking outside**
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".acf-boxes-container")) {
            document.querySelectorAll(".acf-hover-content-row").forEach(content => {
                content.classList.remove("active");
                content.style.opacity = "0";
                content.style.visibility = "hidden";
            });
        }
    });
}


    function applyBehavior() {
        document.querySelectorAll(".acf-boxes-container").forEach(block => {
            reset(block); // Ensure it's reset before applying behavior

            if (isMobile()) {
                enableClick(block);
            } else {
                enableHover(block);
            }
        });
    }

    applyBehavior();

    // Detect window resize and reapply behavior **without reloading**
    window.addEventListener("resize", function () {
        applyBehavior();
    });
});


</script>

<?php
}, 9999);