<?php
// NO WHITESPACE ABOVE THIS LINE

/**
 * Insights Post Type + Categories Taxonomy
 */
function register_insights_post_type_and_taxonomy()
{
    /* =========================
     * Insights Post Type
     * ========================= */
    register_post_type('insights', array(
        'labels' => array(
            'name' => 'All Insights',
            'singular_name' => 'Insight',
            'add_new_item' => 'Add New Insight',
            'edit_item' => 'Edit Insight',
            'featured_image' => 'Insight Cover Image',
            'set_featured_image' => 'Set cover image',
            'remove_featured_image' => 'Remove cover image',
            'use_featured_image' => 'Use as cover image',
        ),
        'public' => true,
        'menu_icon' => 'dashicons-lightbulb',
        'supports' => ['title', 'thumbnail', 'editor', 'excerpt', 'author'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'insights'],
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'menu_position' => 6,
    ));

    /* =========================
     * Insights Category Taxonomy
     * ========================= */
    register_taxonomy('insights_category', 'insights', array(
        'labels' => array(
            'name' => 'Insight Categories',
            'singular_name' => 'Category',
            'add_new_item' => 'Add New Category',
            'edit_item' => 'Edit Category',
            'menu_name' => 'Categories',
        ),
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'insights-category'),
    ));
}
add_action('init', 'register_insights_post_type_and_taxonomy');

/**
 * Flush rewrite rules for insights
 */
function flush_rewrite_rules_for_insights()
{
    register_insights_post_type_and_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'flush_rewrite_rules_for_insights');

/**
 * Create default insights categories
 */
function create_default_insights_categories()
{
    // Check if terms already exist
    if (!term_exists('Insights', 'insights_category')) {
        wp_insert_term('Insights', 'insights_category', array(
            'slug' => 'insights',
            'description' => 'Insights articles and thought leadership'
        ));
    }

    if (!term_exists('News and Events', 'insights_category')) {
        wp_insert_term('News and Events', 'insights_category', array(
            'slug' => 'news-and-events',
            'description' => 'News and events'
        ));
    }
}
add_action('after_switch_theme', 'create_default_insights_categories');

// NO WHITESPACE BELOW THIS LINE
