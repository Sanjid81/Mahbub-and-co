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

/**
 * Team Member Designation (Post Meta)
 */

/* Add Meta Box */
function team_member_designation_meta_box()
{
    add_meta_box(
        'team_member_designation',
        'Member Designation',
        'team_member_designation_callback',
        'team',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'team_member_designation_meta_box');

/* Meta Box Field */
function team_member_designation_callback($post)
{
    $designation = get_post_meta($post->ID, '_team_member_designation', true);
    wp_nonce_field('team_designation_nonce_action', 'team_designation_nonce');
    echo '<input type="text" name="team_member_designation" value="' . esc_attr($designation) . '" class="widefat" placeholder="e.g., Senior Attorney, Partner, etc." />';
}

/* Save Meta */
function save_team_member_designation($post_id)
{
    if (!isset($_POST['team_designation_nonce']) || !wp_verify_nonce($_POST['team_designation_nonce'], 'team_designation_nonce_action')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['team_member_designation'])) {
        update_post_meta(
            $post_id,
            '_team_member_designation',
            sanitize_text_field($_POST['team_member_designation'])
        );
    }
}
add_action('save_post_team', 'save_team_member_designation');

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


