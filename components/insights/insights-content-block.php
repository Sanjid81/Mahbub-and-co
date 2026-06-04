<?php
/**
 * Reusable Insights Grid Display with AJAX Load More
 * Used in Gutenberg block
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Get variables from block
$title = get_query_var('insights_grid_title', 'Our Insights');
$posts_per_page = (int) get_query_var('insights_posts_per_page', 6);
$category_filter = get_query_var('insights_category_filter', '');
$layout_columns = get_query_var('insights_grid_layout', '3');
$show_load_more = get_query_var('show_load_more', false);
$load_more_text = get_query_var('load_more_text', 'Load More');
$load_more_link = get_query_var('load_more_link', '');

// Load More AJAX settings (-1 = show all, no AJAX paging)
$show_all_posts = $posts_per_page < 1;
$initial_posts = $show_all_posts ? -1 : $posts_per_page;
$load_more_increment = $show_all_posts ? 6 : $posts_per_page;

// Decide whether to show tabs or single category
$use_tabs = empty($category_filter);

// Load categories for tabs
$categories = [];

if ($use_tabs) {
    $terms = get_terms([
        'taxonomy' => 'category',
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC',
    ]);

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $categories[$term->slug] = $term->name;
        }
    }
} else {
    // Single category mode
    if (!empty($category_filter)) {
        $term = get_term_by('slug', $category_filter, 'category');
        if ($term && !is_wp_error($term)) {
            $categories[$category_filter] = $term->name;
        } else {
            $categories[$category_filter] = $category_filter;
        }
    } else {
        $categories['all'] = $title;
    }
}
?>

<div class="insights-archive-section">
    <div class="container">
        
        <!-- <?php if (!empty($title) && $use_tabs): ?>
            <h2 class="insights-section-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?> -->

        <div class="insights-page-section">

            <?php if ($use_tabs && count($categories) > 1): ?>
                <!-- Category Tabs -->
                <div class="insights-tabs-container">
    <button class="insights-tabs-arrow arrow-prev" aria-label="Previous">&#8592;</button>
    <div class="insights-tabs">
        <?php
        $first = true;
        foreach ($categories as $slug => $name):
            $active = $first ? 'active' : '';
        ?>
            <button class="insights-tab <?php echo esc_attr($active); ?>"
                data-category="<?php echo esc_attr($slug); ?>">
                <?php echo esc_html($name); ?>
            </button>
        <?php
            $first = false;
        endforeach; ?>
    </div>
    <button class="insights-tabs-arrow arrow-next" aria-label="Next">&#8594;</button>
</div>
            <?php endif; ?>

            <!-- Tab Contents -->
            <div class="insights-tab-contents<?php echo $use_tabs ? '' : ' no-tabs'; ?>">
                <?php
                $first = true;
                foreach ($categories as $slug => $name):
                    $active = $first ? 'active' : '';

                    // Query for initial posts
                    $query_args = [
                        'post_type' => 'post',
                        'posts_per_page' => $initial_posts,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'post_status' => 'publish',
                    ];

                    if ($slug !== 'all' && !empty($slug)) {
                        $query_args['tax_query'] = [
                            [
                                'taxonomy' => 'category',
                                'field' => 'slug',
                                'terms' => $slug,
                            ],
                        ];
                    }

                    $posts_query = new WP_Query($query_args);

                    // Calculate total posts for this category
                    $total_args = $query_args;
                    $total_args['posts_per_page'] = -1;
                    $total_args['fields'] = 'ids';
                    $total_query = new WP_Query($total_args);
                    $total_posts = $total_query->found_posts;
                    ?>

                    <div class="insights-tab-content <?php echo esc_attr($active); ?>"
                        data-category="<?php echo esc_attr($slug); ?>"
                        data-loaded="<?php echo $initial_posts; ?>"
                        data-total="<?php echo $total_posts; ?>">

                        <?php if ($posts_query->have_posts()): ?>
                            <div class="insights-posts-grid columns-<?php echo esc_attr($layout_columns); ?>">
                                <?php while ($posts_query->have_posts()):
                                    $posts_query->the_post(); ?>
                                    <?php get_template_part('components/insights/insights-card'); ?>
                                <?php endwhile; ?>
                            </div>

                            <?php if (!$show_all_posts && $total_posts > $initial_posts && $show_load_more): ?>
                                <div class="load-more-wrap">
                                    <button class="insights-load-more-btn load-more-btn" 
                                        data-category="<?php echo esc_attr($slug); ?>"
                                        data-offset="<?php echo $initial_posts; ?>"
                                        data-ppp="<?php echo $load_more_increment; ?>"
                                        data-total="<?php echo $total_posts; ?>">
                                        <?php echo esc_html($load_more_text); ?>
                                    </button>
                                </div>
                            <?php elseif (!empty($load_more_link) && $show_load_more): ?>
                                <div class="load-more-wrap">
                                    <a href="<?php echo esc_url($load_more_link); ?>" class="load-more-link">
                                        <?php echo esc_html($load_more_text); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <div class="insights-no-posts">
                                <p>No <?php echo esc_html($name); ?> found.</p>
                            </div>
                        <?php endif; ?>

                        <?php wp_reset_postdata(); ?>
                    </div>

                    <?php $first = false; endforeach; ?>
            </div>

        </div>
    </div>
</div>