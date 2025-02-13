<?php
$columns = get_field('boxes');
$heading = get_field('heading');

if ($columns):
?>

<section class="boxes" style="position: relative;">
    <div class="container py-2">
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
    let lastActiveContent = null; // Store the last active element

    block.querySelectorAll(".acf-box").forEach(box => {
        box.addEventListener("mouseenter", function () {
            if (isMobile()) return; // Disable hover on mobile

            const rowIndex = this.getAttribute("data-row");
            const boxIndex = this.getAttribute("data-box");

            const newContent = block.querySelector(`.acf-hover-content-row[data-row="${rowIndex}"][data-box="${boxIndex}"]`);

            if (newContent) {
                // Deactivate all content rows first
                block.querySelectorAll(".acf-hover-content-row").forEach(content => {
                    content.classList.remove("active");
                    content.style.opacity = "0";
                    content.style.visibility = "hidden";
                });

                // Add a small delay before activating the new content
                setTimeout(() => {
                    newContent.classList.add("active");
                    newContent.style.opacity = "1";
                    newContent.style.visibility = "visible";
                    lastActiveContent = newContent;
                }, 50); // Delay to ensure a smooth transition
            }
        });

        box.addEventListener("mouseleave", function () {
            if (lastActiveContent) {
                lastActiveContent.style.opacity = "0";
                lastActiveContent.style.visibility = "hidden";

                setTimeout(() => {
                    if (lastActiveContent.style.opacity === "0") {
                        lastActiveContent.classList.remove("active");
                    }
                }, 300); // Matches the CSS transition duration
            }
        });
    });
}



    // Click behavior is no longer needed since content is always visible on mobile
    /*
    function enableClick(block) {
        block.addEventListener("click", function (event) {
            const box = event.target.closest(".acf-box");
            if (!box) return;

            // Reset all other active boxes before opening a new one
            document.querySelectorAll(".acf-hover-content-mobile").forEach(content => {
                if (content !== box.querySelector(".acf-hover-content-mobile")) {
                    content.style.display = "none";
                }
            });

            const activeContent = box.querySelector(".acf-hover-content-mobile");

            if (activeContent) {
                activeContent.style.display = (activeContent.style.display === "block") ? "none" : "block";
                
                // Scroll into view smoothly
                if (activeContent.style.display === "block") {
                    activeContent.scrollIntoView({ behavior: "smooth", block: "start" });
                }
            }

            event.stopPropagation(); // Prevents bubbling up
        });

        // Close content row when clicking outside
        document.addEventListener("click", function (e) {
            if (!e.target.closest(".acf-box")) {
                document.querySelectorAll(".acf-hover-content-mobile").forEach(content => {
                    content.style.display = "none";
                });
            }
        });
    }
    */

    function applyBehavior() {
        document.querySelectorAll(".acf-boxes-container").forEach(block => {
            reset(block); // Ensure it's reset before applying behavior

            if (!isMobile()) { // Only enable hover behavior for desktop
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