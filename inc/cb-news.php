<?php 
function numeric_posts_nav($query = null)
{
    if (is_singular()) {
        return;
    }

    global $wp_query;

    // Use custom query if provided, otherwise default to main query
    $query = $query ? $query : $wp_query;

    /** Stop execution if there's only 1 page */
    if ($query->max_num_pages <= 1) {
        return;
    }

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max   = intval($query->max_num_pages);

    $links = [];

    /** Add current page to the array */
    if ($paged >= 1) {
        $links[] = $paged;
    }

    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 1;
        $links[] = $paged + 2;
    }

    echo '<div class="pagination"><ul class="pagination-list">' . "\n";

    /** Previous Post Link */
    if (get_previous_posts_link('', $query->max_num_pages)) {
        printf('<li class="prev">%s</li>' . "\n", get_previous_posts_link('« Prev', $query->max_num_pages));
    }

    /** Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
        $class = ($paged == 1) ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

        if (!in_array(2, $links)) {
            echo '<li>…</li>';
        }
    }

    /** Link to current page, plus 2 pages in either direction */
    sort($links);
    foreach ((array) $links as $link) {
        $class = ($paged == $link) ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }

    /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links)) {
            echo '<li>…</li>' . "\n";
        }

        $class = ($paged == $max) ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }

    /** Next Post Link */
    if (get_next_posts_link('', $query->max_num_pages)) {
        printf('<li class="next">%s</li>' . "\n", get_next_posts_link('Next »', $query->max_num_pages));
    }

    echo '</ul></div>' . "\n";
} ?>