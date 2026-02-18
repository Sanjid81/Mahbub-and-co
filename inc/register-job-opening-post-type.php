<?php
/**
 * Job Opening Post Type + Category Taxonomy (Current Openings page)
 * CPT: job_opening | Taxonomy: job_opening_category (All, Internship, Professionals, Mini Pupillage)
 */
defined('ABSPATH') || exit;

function maco_register_job_opening_cpt()
{
    $labels = array(
        'name'               => __('Job Openings', 'mahbub-and-co'),
        'singular_name'      => __('Job Opening', 'mahbub-and-co'),
        'menu_name'          => __('Job Openings', 'mahbub-and-co'),
        'add_new'            => __('Add New', 'mahbub-and-co'),
        'add_new_item'       => __('Add New Job Opening', 'mahbub-and-co'),
        'edit_item'           => __('Edit Job Opening', 'mahbub-and-co'),
        'new_item'            => __('New Job Opening', 'mahbub-and-co'),
        'view_item'           => __('View Job Opening', 'mahbub-and-co'),
        'all_items'           => __('All Job Openings', 'mahbub-and-co'),
    );

    register_post_type('job_opening', array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'job-opening'),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon'          => 'dashicons-clipboard',
        'show_in_rest'       => true,
    ));
}
add_action('init', 'maco_register_job_opening_cpt');

/**
 * Flush rewrite rules once so single job_opening URLs work (e.g. /job-opening/post-slug/).
 */
function maco_job_opening_maybe_flush_rewrite_rules()
{
    if (get_option('maco_job_opening_rewrite_flushed')) {
        return;
    }
    flush_rewrite_rules(false);
    update_option('maco_job_opening_rewrite_flushed', true);
}
add_action('init', 'maco_job_opening_maybe_flush_rewrite_rules', 999);

function maco_register_job_opening_category_taxonomy()
{
    $labels = array(
        'name'              => __('Opening Categories', 'mahbub-and-co'),
        'singular_name'     => __('Opening Category', 'mahbub-and-co'),
        'search_items'      => __('Search Categories', 'mahbub-and-co'),
        'all_items'         => __('All Categories', 'mahbub-and-co'),
        'edit_item'         => __('Edit Category', 'mahbub-and-co'),
        'add_new_item'      => __('Add New Category', 'mahbub-and-co'),
        'menu_name'         => __('Opening Categories', 'mahbub-and-co'),
    );

    register_taxonomy('job_opening_category', 'job_opening', array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_admin_column'  => true,
        'show_in_nav_menus'   => true,
        'rewrite'            => array('slug' => 'opening-category'),
        'show_in_rest'       => true,
    ));
}
add_action('init', 'maco_register_job_opening_category_taxonomy');

/**
 * Single job_opening: allow future and (when logged in) draft in main query.
 */
function maco_job_opening_single_include_future($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
    if ($query->is_singular('job_opening')) {
        $statuses = array('publish', 'future');
        if (is_user_logged_in()) {
            $statuses[] = 'draft';
        }
        $query->set('post_status', $statuses);
    }
}
add_action('pre_get_posts', 'maco_job_opening_single_include_future');

/**
 * Force single-job_opening.php template for singular job_opening.
 * When URL is /job-opening/slug/ but WordPress returns 404 (e.g. rewrite not flushed),
 * still load single template so single-job-opening-details.php can find post by slug.
 */
function maco_single_job_opening_template($template)
{
    if (is_singular('job_opening')) {
        $single = get_query_template('single', array('single-job_opening.php'));
        if ($single !== '') {
            return $single;
        }
    }
    if (is_404() && !empty($_SERVER['REQUEST_URI'])) {
        $path = trim(parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH), '/');
        $segments = array_filter(explode('/', $path));
        $slug = count($segments) >= 1 ? end($segments) : '';
        $prev = count($segments) >= 2 ? $segments[count($segments) - 2] : '';
        if ($slug !== '' && $slug !== 'job-opening' && $prev === 'job-opening') {
                $check = new WP_Query(array(
                    'name'           => $slug,
                    'post_type'      => 'job_opening',
                    'post_status'    => array('publish', 'future'),
                    'posts_per_page' => 1,
                    'no_found_rows'  => true,
                ));
                if ($check->have_posts()) {
                    $single = get_query_template('single', array('single-job_opening.php'));
                    if ($single !== '') {
                        return $single;
                    }
                }
        }
    }
    return $template;
}
add_filter('template_include', 'maco_single_job_opening_template', 99);
