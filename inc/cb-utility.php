<?php

function parse_phone($phone)
{
    $phone = preg_replace('/\s+/', '', $phone);
    $phone = preg_replace('/\(0\)/', '', $phone);
    $phone = preg_replace('/[\(\)\.]/', '', $phone);
    $phone = preg_replace('/-/', '', $phone);
    $phone = preg_replace('/^0/', '+44', $phone);
    return $phone;
}

function split_lines($content)
{
    $content = preg_replace('/<br \/>/', '<br>&nbsp;<br>', $content);
    return $content;
}
function split_lines_to_array($content)
{   
    $arr = array();
    $content = explode('<br />', $content);
    foreach ($content as $c) {
        $arr[$c] = $c;
    }
    return $arr;
}

add_shortcode('contact_address', 'contact_address');

function contact_address() {
    $output = get_field('contact_address', 'options');
    return $output;
}

add_shortcode('contact_phone', 'contact_phone');
function contact_phone() {
    if (get_field('contact_phone', 'options')) {
        return '<a href="tel:' . parse_phone(get_field('contact_phone', 'options')) . '">' . get_field('contact_phone', 'options') . '</a>';
    }
    return;
}

add_shortcode('contact_phone_icon', 'contact_phone_icon');
function contact_phone_icon() {
    if (get_field('contact_phone', 'options')) {
        return '<a href="tel:' . parse_phone(get_field('contact_phone', 'options')) . '"><i class="fas fa-phone"></i> ' . get_field('contact_phone', 'options') . '</a>';
    }
    return;
}

add_shortcode('contact_email', 'contact_email');
function contact_email() {
    if (get_field('contact_email', 'options')) {
        return '<a href="mailto:' . get_field('contact_email', 'options') . '">' . get_field('contact_email', 'options') . '</a>';
    }
    return;
}

add_shortcode('contact_email_icon', 'contact_email_icon');
function contact_email_icon() {
    if (get_field('contact_email', 'options')) {
        return '<a href="mailto:' . get_field('contact_email', 'options') . '"><i class="fas fa-envelope"></i></a>';
    }
    return;
}


add_shortcode('social_in_icon', function () {
     $socials = get_field('socials', 'options'); // Get the 'socials' group
     $linkedin_url = isset($socials['linkedin_url']) ? $socials['linkedin_url'] : null; // Retrieve the 'linkedin_url' subfield
 
     // Check if the URL exists
     if ($linkedin_url) {
         return '<a href="' . esc_url($linkedin_url) . '" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-linkedin"></i></a>';
     }
 
     // Return nothing if no URL is set
     return '';
});

add_shortcode('social_icons', 'social_icons');

function social_icons($size = null) {
    
    $s = get_field('socials', 'options') ?? null;

    $size = $size ?? null;

    $output = '<div class="social_icons">';
    if ($s['linkedin_url'] ?? null) {
        $output .= '<a href="' . $s['linkedin_url'] . '" target="_blank"><i class="fa-brands fa-linkedin-in ' . $size . '"></i></a>';
    }
    if ($s['instagram_url'] ?? null) {
        $output .= '<a href="' . $s['instagram_url'] . '" target="_blank"><i class="fa-brands fa-instagram ' . $size . '"></i></a>';
    }
    if ($s['facebook_url'] ?? null) {
        $output .= '<a href="' . $s['facebook_url'] . '" target="_blank"><i class="fa-brands fa-facebook-f ' . $size . '"></i></a>';
    }
    if ($s['twitter_url'] ?? null) {
        $output .= '<a href="' . $s['twitter_url'] . '" target="_blank"><i class="fa-brands fa-x-twitter ' . $size . '"></i></a>';
    }
    $output .= '</div>';

    return $output;

}

/**
 * Grab the specified data like Thumbnail URL of a publicly embeddable video hosted on Vimeo.
 *
 * @param  str $video_id The ID of a Vimeo video.
 * @param  str $data 	  Video data to be fetched
 * @return str            The specified data
 */
function get_vimeo_data_from_id($video_id, $data)
{
    // width can be 100, 200, 295, 640, 960 or 1280
    $request = wp_remote_get('https://vimeo.com/api/oembed.json?url=https://vimeo.com/' . $video_id . '&width=960');
    
    $response = wp_remote_retrieve_body($request);
    
    $video_array = json_decode($response, true);
    
    return $video_array[$data];
}


function cb_gutenberg_admin_styles()
{
    echo '
        <style>
            /* Main column width */
            .wp-block {
                max-width: 1040px;
            }
 
            /* Width of "wide" blocks */
            .wp-block[data-align="wide"] {
                max-width: 1080px;
            }
 
            /* Width of "full-wide" blocks */
            .wp-block[data-align="full"] {
                max-width: none;
            }	
        </style>
    ';
}
add_action('admin_head', 'cb_gutenberg_admin_styles');


// disable full-screen editor view by default
if (is_admin()) {
    function cb_disable_editor_fullscreen_by_default()
    {
        $script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
        wp_add_inline_script('wp-blocks', $script);
    }
    add_action('enqueue_block_editor_assets', 'cb_disable_editor_fullscreen_by_default');
}



// God I hate Gravity Forms
// Change textarea rows to 4 instead of 10
add_filter('gform_field_content', function ($field_content, $field) {
    if ($field->type == 'textarea') {
        return str_replace("rows='10'", "rows='4'", $field_content);
    }
    return $field_content;
}, 10, 2);


function get_the_top_ancestor_id()
{
    global $post;
    if ($post->post_parent) {
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    } else {
        return $post->ID;
    }
}

function cb_json_encode($string)
{
    // $value = json_encode($string);
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $string);
    $result = json_encode($result);
    return $result;
}

function cb_time_to_8601($string)
{
    $time = explode(':', $string);
    $output = 'PT' . $time[0] . 'H' . $time[1] . 'M' . $time[2] . 'S';
    return $output;
}


function cbdump($var)
{
    // ob_start();
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    return; // ob_get_clean();
}

function cbslugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function cb_social_share($id)
{
    ob_start();
    $url = get_the_permalink($id);

    ?>
<div class="text-larger text--yellow mb-5">
    <div class="h4 text-dark">Share</div>
    <a target='_blank' href='https://twitter.com/share?url=<?=$url?>'
        class="mr-2"><i class='fab fa-twitter'></i></a>
    <a target='_blank'
        href='http://www.linkedin.com/shareArticle?url=<?=$url?>'
        class="mr-2"><i class='fab fa-linkedin-in'></i></a>
    <a target='_blank'
        href='http://www.facebook.com/sharer.php?u=<?=$url?>'><i
            class='fab fa-facebook-f'></i></a>
</div>
<?php
    
    $out = ob_get_clean();
    return $out;
}


function enable_strict_transport_security_hsts_header()
{
    header('Strict-Transport-Security: max-age=31536000');
}
add_action('send_headers', 'enable_strict_transport_security_hsts_header');


function cb_list($field)
{
    ob_start();
    $field = strip_tags($field, '<br />');
    $bullets = preg_split("/\r\n|\n|\r/", $field);
    foreach ($bullets as $b) {
        if ($b == '') {
            continue;
        }
        ?>
<li><?=$b?></li>
<?php
    }
    return ob_get_clean();
}

/**
 * formatBytes
 *
 * Returns img tag with srcset.
 *
 * @param	string $size
 * @param	int    $precision
 * @return	string
 */
function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}


/**
 * cb_featured_image
 *
 * Returns img tag with srcset.
 *
 * @param	string $id The post ID.
 * @return	string
 */
function cb_featured_image($id)
{
    $tag = get_the_post_thumbnail(
        $id,
        'full',
        array(
            'srcset' => wp_get_attachment_image_url(get_post_thumbnail_id(), 'medium') . ' 480w, ' .
                wp_get_attachment_image_url(get_post_thumbnail_id(), 'large') . ' 640w, ' .
                wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') . ' 960w'
        )
    );
    return $tag;
}

// REMOVE TAG AND COMMENT SUPPORT

// Disable Tags Dashboard WP
// add_action('admin_menu', 'my_remove_sub_menus');

function my_remove_sub_menus()
{
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}
// Remove tags support from posts
function myprefix_unregister_tags()
{
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
// add_action('init', 'myprefix_unregister_tags');

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

function remove_comments()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'remove_comments');


function estimate_reading_time_in_minutes($content = '', $words_per_minute = 300, $with_gutenberg = false, $formatted = false)
{
    // In case if content is build with gutenberg parse blocks
    if ($with_gutenberg) {
        $blocks = parse_blocks($content);
        $contentHtml = '';

        foreach ($blocks as $block) {
            $contentHtml .= render_block($block);
        }

        $content = $contentHtml;
    }
            
    // Remove HTML tags from string
    $content = wp_strip_all_tags($content);
            
    // When content is empty return 0
    if (!$content) {
        return 0;
    }
            
    // Count words containing string
    $words_count = str_word_count($content);
            
    // Calculate time for read all words and round
    $minutes = ceil($words_count / $words_per_minute);
    
    if ($formatted) {
        $minutes = '<p class="reading">Estimated reading time ' . $minutes . ' ' . pluralise($minutes, 'minute') . '</p>';
    }

    return $minutes;
}

function pluralise($quantity, $singular, $plural=null)
{
    if($quantity==1 || !strlen($singular)) {
        return $singular;
    }
    if($plural!==null) {
        return $plural;
    }

    $last_letter = strtolower($singular[strlen($singular)-1]);
    switch($last_letter) {
        case 'y':
            return substr($singular, 0, -1).'ies';
        case 's':
            return $singular.'es';
        default:
            return $singular.'s';
    }
}

/*function replace_r_tag($option, $content) {
    global $post;
    $html = '';
    $html .= '<span class="replace-text">'.$content.'</span>';
    
	return $html;
}
add_shortcode('Replace_R', 'replace_r_tag');*/

function replace_r_tag($atts, $content = '') {
    // Set default value to 'white' if no 'color' attribute is provided
    $atts = shortcode_atts(
        array(
            'color' => 'purple',
        ), 
        $atts, 
        'Replace_R'
    );

    // Ensure the color class is either 'white' or 'purple'
    $valid_colors = array('white', 'purple');
    $color = in_array($atts['color'], $valid_colors) ? $atts['color'] : 'white';

    $class = 'replace-text ' . esc_attr($color);

    $html = '<span class="' . esc_attr($class) . '">' . $content . '</span>';
    
    return $html;
}
add_shortcode('Replace_R', 'replace_r_tag');

add_filter('gform_submit_button', function ($button, $form) {
    return '<div class="gform-submit-wrapper">' . $button . '<span class="arrow-circle"></span></div>';
}, 10, 2);

function custom_gutenberg_button_render($block_content, $block) {
    if ($block['blockName'] === 'core/button') {
        // Extract URL from innerHTML since attrs is empty
        preg_match('/href=["\'](.*?)["\']/', $block['innerHTML'], $matches);
        $cta_url = !empty($matches[1]) ? esc_url($matches[1]) : '#';

        // Set target attribute if needed
        $cta_target = (strpos($block['innerHTML'], 'target="_blank"') !== false) ? ' target="_blank"' : '';

        // Extract button text
        preg_match('/<a.*?>(.*?)<\/a>/', $block['innerHTML'], $text_matches);
        $cta_title = !empty($text_matches[1]) ? strip_tags($text_matches[1]) : 'Find out more';

        // Check for additional classes from Gutenberg
        $extra_classes = isset($block['attrs']['className']) ? esc_attr($block['attrs']['className']) : '';

        // Always include btn-primary, and append pink-btn if it's in the extra classes
        $button_classes = 'btn btn-primary mt-4 align-self-center align-self-md-start';
        if (strpos($extra_classes, 'pink-btn') !== false) {
            $button_classes .= ' pink-btn';
        }

        // Return modified button markup
        return '<a class="' . $button_classes . '" href="' . $cta_url . '"' . $cta_target . '>'
                . $cta_title .
                '<span class="arrow-circle"></span></a>';
    }

    return $block_content;
}

add_filter('render_block', 'custom_gutenberg_button_render', 10, 2);

?>