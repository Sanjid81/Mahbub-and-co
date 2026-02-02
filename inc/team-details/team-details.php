<?php
/**
 * Carbon Fields: Team Member Meta + Gutenberg Block
 * File: inc/team-details/team-details.php
 */

// Import all required classes at the top
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;

// Register everything inside the proper hook
add_action('carbon_fields_register_fields', function () {

    // Post Meta for Team CPT
    Container::make('post_meta', 'Team Member Extra Info')
        ->where('post_type', '=', 'team')
        ->add_fields(array(
            Field::make('text', 'team_designation', 'Designation / Position')
                ->set_width(50),

            Field::make('text', 'team_email', 'Email Address')
                ->set_width(50),

            Field::make('complex', 'team_socials', 'Social Media Links')
                ->add_fields(array(
                    Field::make('text', 'social_name', 'Platform Name')
                        ->set_width(33),
                    Field::make('text', 'social_url', 'Profile URL')
                        ->set_width(67),
                    Field::make('text', 'social_icon', 'Icon Class (optional)')
                        ->set_width(33),
                ))
                ->set_layout('tabbed-horizontal')
                ->set_max(8),

            Field::make('file', 'team_cv_file', 'CV / Resume (PDF)')
                ->set_value_type('url')
                ->set_width(50),

            Field::make('file', 'team_portfolio_file', 'Portfolio / Other Document')
                ->set_value_type('url')
                ->set_width(50),
        ));
        
// ======================================================
    // Gutenberg Block: Team Details Tabs
    Block::make(__('Team Details Tabs', 'mahbub-and-co'))
        ->set_description(__('Custom tabs for team member details', 'mahbub-and-co'))
        ->set_category('common', __('Team Components', 'mahbub-and-co'), 'groups')
        ->set_icon('table-row-before')
        ->add_fields(array(
            Field::make('complex', 'team_tabs', 'Tabs')
                ->add_fields(array(
                    Field::make('text', 'tab_id', 'Tab ID')
                        ->set_help_text('Example: about, recognition, work-highlight'),

                    Field::make('text', 'tab_title', 'Tab Title'),

                    Field::make('rich_text', 'tab_content', 'Tab Content'),

                    Field::make('text', 'button_text', 'Button Text')
                        ->set_default_value('Learn More'),

                    Field::make('text', 'button_link', 'Button Link')
                        ->set_default_value('#'),
                ))
                ->set_layout('tabbed-horizontal')
                ->set_max(6),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            set_query_var('team_tabs', $fields['team_tabs'] );
            get_template_part('components/team-details/team-details-tab-inf');
        });
});