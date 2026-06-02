<?php
// NO WHITESPACE ABOVE THIS LINE

/**
 * Team Post Type + Team Area Taxonomy
 */
function register_team_post_type_and_taxonomy()
{
    /* =========================
     * Team Post Type
     * ========================= */
    // Updated register_post_type function
    register_post_type('team', array(
        'labels' => array(
            'name' => 'All Teams',
            'singular_name' => 'Team Member',
            'add_new_item' => 'Add New Member',
            'edit_item' => 'Edit Team Member',
            'featured_image' => 'Member Photo',
            'set_featured_image' => 'Set member photo',
            'remove_featured_image' => 'Remove member photo',
            'use_featured_image' => 'Use as member photo',
        ),
        'public' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'thumbnail', 'editor', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'team'],
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'menu_position' => 5,
    ));

    /* =========================
     * Team Area Taxonomy (Category)
     * ========================= */
    register_taxonomy('team_area', 'team', array(
        'labels' => array(
            'name' => 'Team Areas',
            'singular_name' => 'Team Area',
            'add_new_item' => 'Add New Practice Area',
            'edit_item' => 'Edit Team Area',
            'menu_name' => 'Area of practice',
        ),
        'hierarchical'       => true,
        'public'             => true,
        'show_admin_column'  => true,
        'show_in_rest'       => true,
        'show_in_nav_menus'   => true,
        'rewrite'            => array('slug' => 'team-area'),
    ));
}
add_action('init', 'register_team_post_type_and_taxonomy');

/* Designation is in Carbon Fields only: inc/team-details/team-details.php → "Team Member Extra Info" → Designation / Position (team_designation). No separate meta box. */

/**
 * Enqueue Media Uploader Scripts
 */
function enqueue_team_admin_scripts($hook)
{
    global $post_type;

    if ($post_type === 'team' && ($hook === 'post.php' || $hook === 'post-new.php')) {
        // Simply enqueue WordPress media library
        // WordPress handles featured image natively
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'enqueue_team_admin_scripts');

/**
 * Flush rewrite rules
 */
function flush_rewrite_rules_for_team()
{
    register_team_post_type_and_taxonomy();
    flush_rewrite_rules();
}
// If this is in a theme
add_action('after_switch_theme', 'flush_rewrite_rules_for_team');
// If this is in a plugin
// register_activation_hook(__FILE__, 'flush_rewrite_rules_for_team');

/**
 * Ensure taxonomy menu links (from Appearance > Menus) have correct href for details/archive
 */
function mahbub_nav_menu_taxonomy_link_attributes($atts, $item, $args)
{
    if (!isset($item->type) || $item->type !== 'taxonomy' || empty($item->object) || empty($item->object_id)) {
        return $atts;
    }
    $url = isset($item->url) ? $item->url : '';
    if (empty($url)) {
        $term = get_term((int) $item->object_id, $item->object);
        if ($term && !is_wp_error($term)) {
            $url = get_term_link($term);
            $url = is_wp_error($url) ? '' : esc_url($url);
        }
    }
    if ($url) {
        $atts['href'] = $url;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'mahbub_nav_menu_taxonomy_link_attributes', 10, 3);

// NO WHITESPACE BELOW THIS LINE


