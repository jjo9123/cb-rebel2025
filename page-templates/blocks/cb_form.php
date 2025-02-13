<section class="form pt-5 pb-5">
    <div class="container-xl">
    <div class="pb-4">
    <?php
        $wysiwyg_content = get_field('intro');

        if (!empty($wysiwyg_content)) : ?>
            
            <?php echo apply_filters('the_content', $wysiwyg_content); ?>
            
        <?php endif; ?>
 
    </div>

    <?php 
        $form_object = get_field('form');
        echo do_shortcode('[gravityform id="' . $form_object['id'] . '" title="false" description="false" ajax="true"]');
    ?>
</div>
</section>