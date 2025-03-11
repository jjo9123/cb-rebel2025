<?php
$columns = get_field('boxes');
$heading = get_field('heading');
$desc = get_field('desc');

if ($columns):
?>

<section class="no-hover-boxes" style="position: relative;">
    <div class="container-xl py-2">
        <div class="row">
            <div class="col-12 mx-auto pb-4">
                <h2><?php echo $heading; ?></h2>
                <?php if ($desc): ?>
                    <p><?php echo $desc; ?></p>
                <?php endif; ?>
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
                    </div>
                        <div class="box-content">
                            <?php echo wp_kses_post($box['content']); ?>
                        </div>
                        
                        
                    </div>
                <?php endforeach; ?>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
</section>

<?php endif; ?>