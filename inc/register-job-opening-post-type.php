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
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'opening-category'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'maco_register_job_opening_category_taxonomy');
