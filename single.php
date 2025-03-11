<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
$img = get_the_post_thumbnail_url(get_the_ID(), 'full') ?? null;
// <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" />
?>
<main id="main" class="blog">
    <?php
    $content = get_the_content();
$blocks = parse_blocks($content);
$sidebar = array();
$after;
?>
    <div class="container-xl py-3">
    <?php
    $the_date = get_the_date('jS F, Y');
    $countries = get_the_tags();
    $cats = get_the_category();
    ?>
        <div class="row g-4 pb-4">
            <div class="col-lg-10 mx-auto blog__content">
                <h1 class="blog__title text-green-400 mb-3">
                    <?=get_the_title()?></h1>
                    <div class="news__meta d-flex align-items-center fs-300 mb-2">
                <!--<div>Posted on <?//=$the_date?></div>-->
            </div>
            <?php
                if ($img) {
                    ?>
                <img src="<?=$img?>" alt="" class="blog__image">
                    <?php
                }
    $count = estimate_reading_time_in_minutes(get_the_content(), 200, true, true);
echo $count;

foreach ($blocks as $block) {
    if ($block['blockName'] == 'core/heading') {
        if (!array_key_exists('level', $block['attrs'])) {
            $heading = strip_tags($block['innerHTML']);
            $id = acf_slugify($heading);
            echo '<a id="' . $id . '" class="anchor"></a>';
            $sidebar[$heading] = $id;
        }
    }
    echo render_block($block);
}
?>
            </div>
            
        </div>
    </div>
    <section class="form pt-3 pb-5 gradient-3" style="padding-top:50px!important;">
        <div class="container-xl">
            <div class="pb-2">
            <h3>INTERESTED IN FINDING OUT MORE?</h3>
            <p>Fill in your details below and we’ll be in touch</p>
        
            </div>

            <?php gravity_form(2, false, false, false, '', true); ?>

    </div>
    </section>
</main>
<?php
get_footer();
