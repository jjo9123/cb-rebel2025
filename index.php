<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

$page_for_posts = get_option('page_for_posts');
$bg = get_the_post_thumbnail_url($page_for_posts, 'full') ?? null;

get_header();

// Sanitize input values
$category_slug = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING ) ?? null;

// Get category object if a category is selected
$category_obj = get_category_by_slug($category_slug);

// Fetch category description dynamically
$category_description = $category_obj ? category_description($category_obj->term_id) : '<h2><strong>BLOG</strong> | THE REBEL LENS</h2>
Sharp insights for bold leaders. Our blog cuts through the noise to share battle-tested perspectives on transformation, technology, and what really drives business performance';

// Ensure WordPress keeps `<h2>`, `<p>`, `<br>`, etc.
$category_description = wpautop($category_description);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" />
<main id="main">
<section class="hero pt-4 pb-5" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/img/blog-hero_compress.jpg'); background-size: cover; background-repeat: no-repeat;">
        <div class="hero-content">    
            <div class="container-xl h-100">
            <div class="row h-100">
            <div class="col-lg-10 d-flex flex-column pt-4 pt-lg-0align-items-md-start justify-content-start justify-content-md-center">
                <h1 data-aos="fade-right" class="text-md-start">PERSPECTIVE IS <?= do_shortcode('[Replace_R color="white"]EVERYTHING[/Replace_R]') ?></h1>
                <div class="fs-300 fw-600" data-aos="fade-right">
                Dive into our world of transformation through:<br>
                - Thought leadership blogs<br>
                - The breakthrough moment podcast<br>
                - Eexecutive roundtables and events<br>
                - Practical insights and case studies
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

    <div id="blog-intro" class="wp-block-group wp-text-block"><div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">
        <div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>


        <div class="container-xl">
            <?= $category_description; ?>
        </div>


        <div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
        </div>
    </div>


    <div class="blog-listing container-xl py-5">
        <?php

        if (get_the_content(null, false, $page_for_posts)) {
            echo '<div class="mb-5">' . get_the_content(null, false, $page_for_posts) . '</div>';
        }

//  filters here
?>
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="<?= home_url('/rebel-perspective/') ?>" class="btn <?= !$category_slug ? 'btn btn-primary pink-btn' : 'btn btn-primary pink-btn' ?>">All</a>
    <?php
    $cats = get_categories();
    foreach ($cats as $c) {
        $active_class = ($category_slug === $c->slug) ? 'btn btn-primary pink-btn' : 'btn btn-primary pink-btn';
        echo "<a href=\"" . add_query_arg('category', $c->slug, home_url('/rebel-perspective/#blog-intro')) . "\" class=\"btn {$active_class}\">{$c->name}</a>";
    }
    ?>
</div>
<?php

echo '<div class=" mb-5">';

    
// Setup the query arguments
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'category_name'  => $category_slug,
    'posts_per_page' => 9, 
    'paged'          => $paged,
);
    
// Create a new WP_Query instance
$query = new WP_Query($args);

// Check if the query returns any posts
if ($query->have_posts()) {
    
    $post_count = 0; // Track number of posts for row grouping

    echo '<div class="container blog-index"><div class="row gy-4 mb-4">'; // Start Bootstrap row container

    while ($query->have_posts()) {
        $query->the_post();
        $the_date = get_the_date('jS F, Y');
        $cats = get_the_category();
        $post_count++;

        $button_text = 'Read More'; // Default text for blogs

        // Loop through categories to check if it belongs to Podcasts or Events
        foreach ($cats as $category) {
            if ($category->slug === 'podcasts') {
                $button_text = 'Listen Now';
                break;
            } elseif ($category->slug === 'events') {
                $button_text = 'Find Out More';
                break;
            }
        }

        // Get the post thumbnail or fallback image
        $thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium', ['class' => 'card-img-top']);
        if (!$thumbnail) {
            $thumbnail = '<img src="' . get_stylesheet_directory_uri() . '/img/pr-placeholder.jpg" class="card-img-top" style="max-width: 250px; display: block; margin: auto;">';
        }

        // Truncate the post title if too long
        $post_title = get_the_title();

        ?>

        <!-- Post Card -->
        <div class="col-md-4">
            <div class="card h-100">
                <a href="<?= get_the_permalink() ?>" class="stretched-link">
                    <?= $thumbnail ?>
                </a>
                <div class="card-footer small">
                    <span><!--Posted on <?//= $the_date ?>--></span>
                    <?php if ($cats): ?>
                        <span> 
                        <?php
                        $catlinks = array();
                        foreach ($cats as $c) {
                            $link = get_term_link($c->term_id);
                            
                            // Remove the trailing "s" if it exists
                            $cat_name = rtrim($c->cat_name, 's');
                        
                            $catlinks[] = "<a href=\"{$link}\">{$cat_name}</a>";
                        }
                        echo implode(', ', $catlinks);                                                
                        ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><?= $post_title ?></h5>
                    <p class="card-text text-muted"></p>
                    <a class="btn btn-primary pink-btn mt-4 align-self-center align-self-md-start" href="<?= get_the_permalink() ?>"><?= esc_html($button_text); ?>
                    <span class="arrow-circle"></span>
                    </a>
                </div>
                
            </div>
        </div>

        <?php
        // Close and open new row every 3 posts
        if ($post_count % 3 === 0) {
            echo '</div><div class="row gy-4 mb-4">'; 
        }
    }
    echo '</div></div>'; // Close last row and container
} else {
    echo '<p class="text-center">No posts found.</p>';
}

// Reset post data
wp_reset_postdata();
?>
        </div>
        <?php
        numeric_posts_nav($query);
?>
    </div>
    </div>
</main>
<?php

get_footer();
?>