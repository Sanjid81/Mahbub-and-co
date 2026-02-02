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
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'team-area'),
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

// NO WHITESPACE BELOW THIS LINE


