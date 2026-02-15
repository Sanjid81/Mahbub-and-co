<?php
// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Theme Constants
 */
define('THEMEROOT', get_template_directory_uri());
define('IMG', THEMEROOT . '/dist/img');
define('ICON', THEMEROOT . '/dist/icons');
define('JS', THEMEROOT . '/dist/js');
define('CSS', THEMEROOT . '/dist/css');

/**
 * Theme Supports
 */
function theme_setup_supports()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'theme_setup_supports');

/**
 * Load Carbon Fields
 */
/**
 * Load Carbon Fields + all custom blocks & fields
 */
add_action('after_setup_theme', 'crb_load_carbonfields');
function crb_load_carbonfields()
{
    // 1. Composer autoload (vendor/autoload.php)
    $autoload = get_template_directory() . '/vendor/autoload.php';
    if (file_exists($autoload)) {
        require_once $autoload;
    }
    if (class_exists('\Carbon_Fields\Carbon_Fields')) {
        \Carbon_Fields\Carbon_Fields::boot();

        if (is_admin()) {
            add_action('admin_notices', function () {
                echo '<div class="notice notice-success is-dismissible"><p><strong>Carbon Fields LOADED successfully!</strong></p></div>';
            });
        }
    }

    $files = [
        '/inc/gutenberg.php',               
        '/inc/theme-option.php',
        '/inc/team-post-type.php',
        '/inc/expertise-area.php',
        '/inc/team-details/team-details.php',
        '/inc/insights-post-type.php',
        '/inc/distribute-insights-categories.php',
        '/inc/register-career-post-type.php',
        '/components/career/career-tab-section.php',
        '/inc/career-programs/career-fields.php',
        '/inc/register-job-opening-post-type.php',
        '/inc/job-openings/job-opening-fields.php',
        '/inc/job-openings/job-opening-blocks.php',
        '/components/job-openings/current-openings-section.php',
        '/inc/inc/apply-form.php',
        '/inc/career-programs/career-programs-deatils-block.php',
    ];

    foreach ($files as $file) {
        $path = get_template_directory() . $file;
        if (file_exists($path)) {
            require_once $path;
        } else {
            if (is_admin()) {
                add_action('admin_notices', function () use ($file) {
                    echo '<div class="notice notice-error is-dismissible"><p><strong>Missing file:</strong> ' . esc_html($file) . '</p></div>';
                });
            }
        }
    }
}



/**
 * Enqueue Theme Assets
 */
function theme_enqueue_assets()
{
    // Default style.css
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // Webpack compiled CSS & JS
    wp_enqueue_style('app-style', get_template_directory_uri() . '/dist/app.css', [], '1.0');
    wp_enqueue_script('app-js', get_template_directory_uri() . '/dist/app.js', [], '1.0', true);


    // Swiper & AOS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', [], null, true);





    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@next/dist/aos.css');
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@next/dist/aos.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');







// Register dynamic menus
// Menus
function mytheme_setup()
{
    add_theme_support('menus');
    register_nav_menus(array(
        'main_menu' => __('Main Menu', 'mytheme'),
        'mobile_menu' => __('Mobile Menu', 'mytheme'),
    ));
}
add_action('after_setup_theme', 'mytheme_setup');

// ....................................
// Footer menu register
function yourthemename_register_menus()
{
    register_nav_menus(array(
        'footer_expertise_col1' => __('Areas of Expertise Column 1', 'yourthemename'),
        'footer_expertise_col2' => __('Areas of Expertise Column 2', 'yourthemename'),
        'footer_quicklinks' => __('Quick Links', 'yourthemename'),
    ));

}
add_action('init', 'yourthemename_register_menus');
// .........................................



/**
 * Allow SVG Upload
 */
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

/**
 * Disable Auto Updates (Optional)
 */
add_filter('auto_update_plugin', '__return_false');
add_filter('auto_update_theme', '__return_false');

/**
 * Remove Contact Form 7 auto <p> and <br>
 */
add_filter('wpcf7_autop_or_not', '__return_false');




// AOS script
function aos_init_script()
{
    echo '<script>
        AOS.init({
            duration: 1000, // animation duration in ms
            offset: 100,    // scroll offset before animation triggers
            once: false,    // true: animate only once, false: animate every scroll
        });
    </script>';
}
add_action('wp_footer', 'aos_init_script', 100);

// ==================================== ajax register=================================================

// =====================================================================================
// =====================================================================================
// =====================================================================================


function mahbub_team_search_scripts()
{
    wp_enqueue_script('mahbub-team-search', get_stylesheet_directory_uri() . '/src/scripts/components/people/team-search.js', array('jquery'), '1.0', true);
    wp_localize_script('mahbub-team-search', 'mahbub_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'mahbub_team_search_scripts');

// ====================================// AJAX handler=================================================

// =====================================================================================
// =====================================================================================
// =====================================================================================

// AJAX handler
function mahbub_team_search_ajax()
{

    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $area = isset($_POST['area']) ? sanitize_text_field($_POST['area']) : '';

    $args = array(
        'post_type' => 'team',
        'posts_per_page' => -1,
    );

    if (!empty($search)) {
        $args['s'] = $search;
    }

    if (!empty($area)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'team_area',
                'field' => 'slug',
                'terms' => $area,
            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post(); ?>
            <div class="mahbub__team-member">
                <?php if (has_post_thumbnail()): ?>
                    <div class="mahbub__team-thumb"><?php the_post_thumbnail('thumbnail'); ?></div>
                <?php endif; ?>
                <div class="team-member-info">
                    <h3 class="mahbub__team-name">
                        <?php the_title(); ?>
                    </h3>
                    <p class="mahbub__team-designation">
                        <?php echo esc_html(get_post_meta(get_the_ID(), '_team_member_designation', true)); ?>
                    </p>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else:
        echo '<p>No Team Members found.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_mahbub_team_search', 'mahbub_team_search_ajax');
add_action('wp_ajax_nopriv_mahbub_team_search', 'mahbub_team_search_ajax');




function enable_jquery_properly()
{
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enable_jquery_properly');




/**
 * Ensure featured image support is enabled
 */
add_theme_support('post-thumbnails');

// Add specific thumbnail sizes for team
add_image_size('team-thumb', 300, 300, true); // Square thumb
add_image_size('team-large', 600, 400, false); // Large size





// **************************************************************8
// Insights Load More
wp_enqueue_script(
    'insights-load-more',
    get_template_directory_uri() . '/src/scripts/components/insights/insights-load-more.js',
    array('jquery'),
    '1.0.1',
    true
);

wp_localize_script(
    'insights-load-more',
    'insightsAjax',
    array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('insights_load_more_nonce'),
    )
);
















// ==================================== Insights Load More AJAX ====================================

add_action('wp_ajax_load_more_insights', 'load_more_insights_handler');
add_action('wp_ajax_nopriv_load_more_insights', 'load_more_insights_handler');

function load_more_insights_handler()
{

    check_ajax_referer('insights_load_more_nonce', 'nonce');

    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $ppp = isset($_POST['ppp']) ? intval($_POST['ppp']) : 6;
    $category_slug = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    $args = [
        'post_type' => 'insights',
        'posts_per_page' => $ppp,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
    ];

    if (!empty($category_slug) && $category_slug !== 'all') {
        $args['tax_query'] = [
            [
                'taxonomy' => 'insights_category',
                'field' => 'slug',
                'terms' => $category_slug,
            ]
        ];
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>

                        <div class="insights-card">
                            <div class="insights-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('medium', ['class' => 'insights-card-img', 'alt' => get_the_title()]);
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
                                    <span class="insights-card-date"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                </div>

                                <h3 class="insights-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <?php if (has_excerpt()): ?>
                                        <div class="insights-card-excerpt">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                        </div>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>" class="insights-card-link">Read More</a>
                            </div>
                        </div>

                        <?php
        }
    }

    $html = ob_get_clean();
    wp_reset_postdata();

    wp_send_json_success(['html' => $html]);
    wp_die();
}
















//***************** */ post author**********************
// Custom Author for Insights
// Custom Author Slug for Insights (using custom name from Carbon Fields)
// Custom author slug support
add_filter('query_vars', function ($vars) {
    $vars[] = 'insights_author_slug';
    return $vars;
});

add_action('init', function () {
    add_rewrite_rule(
        '^insights-author/([^/]+)/?$',          
        'index.php?insights_author_slug=$matches[1]',
        'top'
    );
});

add_action('after_switch_theme', function () {
    flush_rewrite_rules();
});

add_action('template_redirect', function () {
    if ($author_slug = get_query_var('insights_author_slug')) {
        $template = locate_template('author-insights.php');
        if ($template) {
            load_template($template);
            exit;
        } else {
            // Fallback to 404 if template missing
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            nocache_headers();
        }
    }
});

// Optional: flush rewrite rules when theme is activated/switched
add_action('after_switch_theme', function () {
    flush_rewrite_rules();
});





/**
 * Display Insights Top Slider
 *
 * @param array $args Optional override values
 */
function display_insights_top_slider($args = [])
{
    $defaults = [
        'background_image' => 0,
        'heading' => 'Featured Insights',
        'slides_count' => 5,
        'insights_category' => '',
    ];

    $fields = wp_parse_args($args, $defaults);

    set_query_var('insights_slider_fields', $fields);
    get_template_part('components/insights/insights-top-slider');
}