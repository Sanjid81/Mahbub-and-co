<?php
/**
 * Reusable Insights Grid + Tabs Display with AJAX Load More
 * Used in archive & Gutenberg block
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Default values passed via set_query_var
$title = get_query_var('insights_grid_title', 'Our Insights');
$layout_columns = get_query_var('insights_grid_layout', '3');
$category_filter = get_query_var('insights_category_filter', ''); // empty = show tabs
$show_load_more = get_query_var('show_load_more', true);         // enable by default

// Load More settings
$initial_posts = 9;
$load_more_increment = 6;

// Decide whether to show tabs or single category
$use_tabs = empty($category_filter);

// Load categories
$categories = [];

if ($use_tabs) {
    // Show tabs – load all categories
    $terms = get_terms([
        'taxonomy' => 'insights_category',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ]);

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $categories[$term->slug] = $term->name;
        }
    }

    // Fallback categories
    if (empty($categories)) {
        $categories = [
            'insights' => 'Insights',
            'news-and-events' => 'News & Events',
        ];
    }
} else {
    // Block mode – single category or all
    if (!empty($category_filter)) {
        $term = get_term_by('slug', $category_filter, 'insights_category');
        if ($term && !is_wp_error($term)) {
            $categories[$category_filter] = $term->name;
        }
    } else {
        $categories['all'] = $title;
    }
}
?>

<div class="insights-archive-section">
    <div class="container">

        <?php if (!empty($title)): ?>
            <!-- <h2 class="insights-section-title">< ?php echo esc_html($title); ?></h2> -->
        <?php endif; ?>

        <div class="insights-page-section">

            <?php if ($use_tabs && count($categories) > 1): ?>
                <!-- Category Tabs -->
                <div class="insights-tabs-container">
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
                        'post_type' => 'insights',
                        'posts_per_page' => $initial_posts,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'post_status' => 'publish',
                    ];

                    if ($slug !== 'all' && !empty($slug)) {
                        $query_args['tax_query'] = [
                            [
                                'taxonomy' => 'insights_category',
                                'field' => 'slug',
                                'terms' => $slug,
                            ]
                        ];
                    }

                    $posts_query = new WP_Query($query_args);

                    // Calculate total posts for this category (for load more logic)
                    $total_args = $query_args;
                    $total_args['posts_per_page'] = -1;
                    $total_args['fields'] = 'ids';
                    $total_query = new WP_Query($total_args);
                    $total_posts = $total_query->found_posts;
                    ?>

                    <div class="insights-tab-content <?php echo esc_attr($active); ?>"
                        data-category="<?php echo esc_attr($slug); ?>">

                        <?php if ($posts_query->have_posts()): ?>

                            <div class="insights-posts-grid columns-<?php echo esc_attr($layout_columns); ?>">
                                <?php while ($posts_query->have_posts()):
                                    $posts_query->the_post(); ?>
                                    <div class="insights-card">
                                        <div class="insights-card-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('medium', [
                                                        'class' => 'insights-card-img',
                                                        'alt' => get_the_title()
                                                    ]);
                                                } else {
                                                    echo '<img src="' . esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg') . '" alt="No image" class="insights-card-img">';
                                                }
                                                ?>
                                            </a>
                                        </div>

                                        <div class="insights-card-content">
                                            <div class="insights-card-meta">
                                                <?php
                                                $terms = get_the_terms(get_the_ID(), 'insights_category');
                                                if ($terms && !is_wp_error($terms) && !empty($terms)) {
                                                    echo '<span class="category-badge meta-category">' . esc_html($terms[0]->name) . '</span>';
                                                }
                                                ?>
                                                <div class="circle"></div>
                                                <span class="insights-card-date">
                                                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                                                </span>
                                            </div>

                                            <h3 class="insights-card-title">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>

                                            <?php if (has_excerpt()): ?>
                                                <div class="insights-card-excerpt">
                                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="insights-card-details-button">
                                                <a href="<?php the_permalink(); ?>" class="insights-card-link">Read More <svg
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_1787_525)">
                                                            <path
                                                                d="M12.1727 11.9998L9.34375 9.17184L10.7577 7.75684L15.0007 11.9998L10.7577 16.2428L9.34375 14.8278L12.1727 11.9998Z"
                                                                fill="#BC001A" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_1787_525">
                                                                <rect width="24" height="24" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>

                            <?php if ($total_posts > $initial_posts && $show_load_more): ?>
                                <div class="load-more-wrap">
                                    <button class="insights-load-more-btn load-more-btn" data-offset="<?php echo $initial_posts; ?>"
                                        data-ppp="<?php echo $load_more_increment; ?>" data-total="<?php echo $total_posts; ?>"
                                        data-category="<?php echo esc_attr($slug); ?>">
                                        Load More
                                    </button>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <div class="insights-no-posts">
                                <h3>No <?php echo esc_html($name); ?> found</h3>
                                <p>Sorry, there are no posts to display.</p>
                            </div>
                        <?php endif; ?>

                        <?php wp_reset_postdata(); ?>

                    </div>

                    <?php $first = false; endforeach; ?>
            </div>

        </div>
    </div>
</div>