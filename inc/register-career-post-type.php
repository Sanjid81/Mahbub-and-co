<?php
// NO WHITESPACE ABOVE THIS LINE

/**
 * Career Program Post Type
 */
function register_career_program_cpt()
{

    $labels = array(
        'name' => 'Career Programs',
        'singular_name' => 'Career Program',
        'menu_name' => 'Career Programs',
        'add_new' => 'Add New Program',
        'add_new_item' => 'Add New Program',
        'edit_item' => 'Edit Program',
        'new_item' => 'New Program',
        'view_item' => 'View Program',
        'all_items' => 'All Programs',
    );

    register_post_type('program', array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'career-program'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-businessman',
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_career_program_cpt');


/**
 * Career Job Type Taxonomy
 * (Internship, Full Time, Part Time etc.)
 */
function register_career_job_type_taxonomy()
{

    $labels = array(
        'name' => 'Career Job Types',
        'singular_name' => 'Career Job Type',
        'search_items' => 'Search Job Types',
        'all_items' => 'All Job Types',
        'edit_item' => 'Edit Job Type',
        'add_new_item' => 'Add New Job Type',
        'menu_name' => 'Career Job Types',
    );

    register_taxonomy('career_job_type', 'program', array(
        'labels' => $labels,
        'hierarchical' => true, // category-like
        'show_ui' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'career-job-type'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_career_job_type_taxonomy');
