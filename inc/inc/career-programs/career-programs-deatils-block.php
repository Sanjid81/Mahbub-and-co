<?php
/**
 * Testimonial / Alumni Spotlight Block
 * Carbon Fields Gutenberg Block
 */
defined('ABSPATH') || exit;

use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function() {
    Block::make('Career Program Details Info Block')
        ->set_icon('format-quote')
        ->set_category('layout')
        ->set_description('Career Program Details')
        ->add_fields([
            Field::make('text', 'section_title', 'Section Heading (optional)')
                ->set_help_text('Leave empty if no heading needed'),

            Field::make('complex', 'testimonials', 'Testimonials / Quotes')
                ->set_layout('tabbed-horizontal') 
                ->set_collapsed(true)
                ->set_header_template('<%- name %> - <%- position %>') 
                ->add_fields([
                    Field::make('text', 'name', 'Full Name')
                        ->set_default_value('H.M. Sanjid Siddiqi'),

                    Field::make('text', 'former_position', 'Former Position')
                        ->set_default_value('Associate'),

                    Field::make('text', 'years', 'Years at Firm')
                        ->set_default_value('2010-2015'),

                    Field::make('text', 'current_role', 'Current Role')
                        ->set_default_value('Chief Legal Officer at XYZ Group'),

                    Field::make('rich_text', 'info-desc', 'Info Description / Testimonial')
                        ->set_help_text('The info description text'),
                    Field::make('rich_text', 'quote', 'Quote / Testimonial')
                        ->set_help_text('The main quote text'),

                    // Field::make('image', 'photo', 'Profile Photo (optional)'),
                ]),
        ])
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
          set_query_var('career_programs_details_fields', $fields);
          set_query_var('career_programs_details_attributes', $attributes);
          include get_template_directory() . '/components/career/career-program-details.php';
        });
});