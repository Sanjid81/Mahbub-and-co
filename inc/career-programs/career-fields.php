<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'register_custom_career_blocks');

function register_custom_career_blocks()
{

    // Block 1: Career Overview (list page)
    Block::make(__('Career Overview Section'))
        ->set_icon('businessman')
        ->set_category('layout')
        ->add_fields(array(
            Field::make('complex', 'team_tabs', 'Tabs')
                ->add_fields(array(
                    Field::make('text', 'tab_id', 'Tab ID')
                        ->set_help_text('Example: about, recognition'),
                    Field::make('text', 'tab_title', 'Tab Title'),
                ))
                ->set_layout('tabbed-horizontal')
                ->set_max(6),
            Field::make('text', 'career_heading', 'Main Heading')
                ->set_default_value('Our Career Programs'),
            Field::make('rich_text', 'career_intro', 'Intro Text Above List'),

            Field::make('complex', 'career_dev_sections', 'Development Sections')
                ->add_fields(array(
                    Field::make('text', 'dev_title', 'Section Title'),
                    Field::make('rich_text', 'dev_content', 'Content'),

                ))
                ->set_max(2)
                ->set_layout('tabbed-horizontal')
                ->set_header_template('<%- dev_title %>'),

            Field::make('complex', 'dev_section_images', __('Section Images', 'mahbub-and-co'))
                ->add_fields(array(
                    Field::make('image', 'dev_image1', 'Image 1'),
                    // Field::make('image', 'dev_image2', 'Image 2'),
                    // Field::make('image', 'dev_image3', 'Image 3'),
                ))
                // ->set_max(1)
                ->set_layout('tabbed-horizontal'),

            Field::make('image', 'background_image', 'Background Image')
                ->set_value_type('url'),

                
        ))
        ->set_render_callback('career_overview_render_callback');

    // Block 2: Single Program Details
    Block::make(__('Program Details Full Layout'))
        ->set_icon('businessman')
        ->set_category('layout')
        ->add_fields(array()) // no extra fields needed
        ->set_render_callback('program_details_render_callback');
}

