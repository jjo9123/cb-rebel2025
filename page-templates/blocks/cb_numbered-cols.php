<?php
// Get ACF background image
$background_image = get_field('background');
$columns = get_field('columns'); // Repeater field
?>

<section class="numbered-cols" style="position: relative; background: url('<?php echo esc_url($background_image['url']); ?>') center/cover no-repeat;">
    <div class="container py-5">
        <div class="row g-4">
            <?php if ($columns): ?>
                <?php $index = 0; ?>
                <?php foreach ($columns as $column): ?>
                    <div class="card-wrapper col-lg-3 mx-4">
                        <div class="card p-4 position-relative">
                        <div class="card-number position-absolute" data-number="<?php echo ++$index; ?>"></div>

                            <div class="card-text"><?php echo $column['content']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php $index = 0; ?>
            <?php endif; ?>
        </div>
    </div>
</section>