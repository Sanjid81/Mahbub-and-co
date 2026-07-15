<?php
// NO WHITESPACE ABOVE THIS LINE

/**
 * Insights Post Type + Categories Taxonomy (Disabled/Removed)
 */
/*
function register_insights_post_type_and_taxonomy()
{
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

    register_taxonomy('insights_category', 'insights', array(
        'labels' => array(
            'name' => 'Insight Categories',
            'singular_name' => 'Category',
            'add_new_item' => 'Add New Category',
            'edit_item' => 'Edit Category',
            'menu_name' => 'Categories',
        ),
        'hierarchical'       => true,
        'public'             => true,
        'show_admin_column'  => true,
        'show_in_rest'       => true,
        'show_in_nav_menus'   => true,
        'rewrite'            => array('slug' => 'insights-category'),
    ));
}
add_action('init', 'register_insights_post_type_and_taxonomy');

function flush_rewrite_rules_for_insights()
{
    register_insights_post_type_and_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'flush_rewrite_rules_for_insights');

function create_default_insights_categories()
{
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
*/

// Register custom post type 'insights_author'
function register_insights_author_post_type()
{
    register_post_type('insights_author', array(
        'labels' => array(
            'name' => 'Insights Authors',
            'singular_name' => 'Insights Author',
            'add_new_item' => 'Add New Author',
            'edit_item' => 'Edit Author',
            'all_items' => 'All Authors',
        ),
        'public' => true,
        'menu_icon' => 'dashicons-admin-users',
        'supports' => array('title', 'editor', 'excerpt'), // title = Name, editor = Content, excerpt = Bio/Description
        'has_archive' => false,
        'rewrite' => array('slug' => 'insights-author'),
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'menu_position' => 7,
    ));
}
add_action('init', 'register_insights_author_post_type');

// *************************post date and social media*********************************
add_action('carbon_fields_register_fields', 'crb_attach_insights_custom_date_and_social', 100);

function crb_attach_insights_custom_date_and_social()
{
    if (!class_exists('Carbon_Fields\\Container')) {
        return; 
    }

    // Attach fields to CPT insights_author
    \Carbon_Fields\Container::make('post_meta', 'Author Details')
        ->where('post_type', '=', 'insights_author')
        ->add_fields(array(
            \Carbon_Fields\Field::make('image', 'user_image', 'Profile Image'),
            \Carbon_Fields\Field::make('text', 'user_facebook_link', 'Facebook Link')
                ->set_attribute('placeholder', 'https://facebook.com/yourprofile'),
            \Carbon_Fields\Field::make('text', 'user_linkedin_link', 'LinkedIn Link')
                ->set_attribute('placeholder', 'https://linkedin.com/in/yourprofile'),
        ));

    \Carbon_Fields\Container::make('post_meta', 'Publish Settings & Authors')
        ->set_context('normal')
        ->set_priority('high')
        ->add_fields(array(

            \Carbon_Fields\Field::make('date', 'insights_custom_publish_date', 'Custom Publish Date')
                ->set_storage_format('Y-m-d')
                ->set_input_format('Y-m-d', 'Y-m-d'),

            \Carbon_Fields\Field::make('select', 'insights_hide_author', 'Author Display')
                ->add_options(array(
                    'none' => 'None (Hide Author)',
                    'show' => 'Show Author',
                ))
                ->set_default_value('none'),

            \Carbon_Fields\Field::make('association', 'insights_authors', 'Select Author(s)')
                ->set_types(array(
                    array(
                        'type' => 'post',
                        'post_type' => 'insights_author',
                    )
                ))
                ->set_max(10)
                ->set_help_text('Select one or more custom Insights Authors. Leave empty to use default post author.'),
        ));
}