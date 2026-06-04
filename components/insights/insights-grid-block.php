<?php
/**
 * Gutenberg Block: Insights Grid Display
 * Uses the reusable insights-content-block.php component
 */

Block::make('Insights Grid Block', 'insights-grid-display')
    ->add_fields([
        Field::make('text', 'insights_grid_title', 'Section Title')
            ->set_default_value('Our Insights'),

        Field::make('number', 'insights_posts_per_page', 'Posts Per Page')
            ->set_default_value(6)
            ->set_min(1)
            ->set_max(20),

        Field::make('select', 'insights_category_filter', 'Filter by Category')
            ->add_options([
                '' => 'All Categories (show tabs)',
                'insights' => 'Insights Only',
                'news-and-events' => 'News & Events Only',
            ])
            ->set_default_value(''),

        Field::make('select', 'insights_grid_layout', 'Grid Layout')
            ->add_options([
                '3' => '3 Columns',
                '2' => '2 Columns',
                '4' => '4 Columns', 
            ])
            ->set_default_value('3'),

        Field::make('checkbox', 'show_load_more', 'Show Load More Button?')
            ->set_default_value(false),

        Field::make('text', 'load_more_text', 'Load More Button Text')
            ->set_default_value('Load More')
            ->set_conditional_logic([[
                'field' => 'show_load_more',
                'value' => true,
            ]]),

        Field::make('text', 'load_more_link', 'Load More Link URL')
            ->set_default_value('/insights/')
            ->set_conditional_logic([[
                'field' => 'show_load_more',
                'value' => true,
            ]]),
    ])
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {

        // Set query vars for the template
        set_query_var('insights_grid_title', $fields['insights_grid_title'] ?: 'Our Insights');
        set_query_var('insights_posts_per_page', $fields['insights_posts_per_page'] ?? 6);
        set_query_var('insights_category_filter', $fields['insights_category_filter'] ?? '');
        set_query_var('insights_grid_layout', $fields['insights_grid_layout'] ?? '3');
        set_query_var('show_load_more', $fields['show_load_more'] ?? false);
        set_query_var('load_more_text', $fields['load_more_text'] ?? 'Load More');
        set_query_var('load_more_link', $fields['load_more_link'] ?? '');

        // Include the main content template
        get_template_part('insights/insights-content-block');
    });