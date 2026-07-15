<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use Carbon_Fields\Container;

add_action('carbon_fields_register_fields', 'register_custom_career_blocks');
add_action('carbon_fields_register_fields', 'register_program_post_meta');

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
                        ->set_help_text('Use: overview (first tab), what-we-look-for (second tab)'),
                    Field::make('text', 'tab_title', 'Tab Title')
                        ->set_help_text('e.g. Overview, What We Look For'),

                    Field::make('text', 'career_heading', 'Main Heading')
                        ->set_default_value('Our Career Programs'),
                    Field::make('rich_text', 'career_intro', 'Intro Text Above List'),

                    // Field::make('complex', 'career_dev_sections', 'Development Sections (2 boxes for this tab)')
                    //     ->add_fields(array(
                    //         Field::make('text', 'dev_title', 'Section Title'),
                    //         Field::make('rich_text', 'dev_content', 'Content'),
                    //     ))
                    //     ->set_max(5)
                    //     ->set_layout('tabbed-horizontal')
                    //     ->set_header_template('<%- dev_title || "Section" %>'),

                    // Field::make('complex', 'dev_section_images', __('Section Images (dark block)', 'mahbub-and-co'))
                    //     ->add_fields(array(
                    //         Field::make('image', 'dev_image1', 'Image 1'),
                    //     ))
                    //     ->set_layout('tabbed-horizontal'),

                    Field::make('image', 'background_image', 'Background Image (dark section)')
                        ->set_value_type('url'),
                    Field::make('text', 'button_title', 'Button Title')
                        ->set_help_text('Button text below the background section'),
                    Field::make('text', 'button_url', 'Button URL')
                        ->set_help_text('Link for the button (e.g. /apply or full URL)'),

                ))
                ->set_layout('tabbed-horizontal')
                ->set_max(6),
        ))
        ->set_render_callback('career_overview_render_callback');

    // Block 2: Single Program Details
    Block::make(__('Program Details Full Layout'))
        ->set_icon('businessman')
        ->set_category('layout')
        ->add_fields(array()) // no extra fields needed
        ->set_render_callback('program_details_render_callback');
}

/**
 * Program post type: only short title for list grid. Details page = title + custom blocks.
 */
function register_program_post_meta()
{
    Container::make('post_meta', __('Program Options', 'mahbub-and-co'))
        ->where('post_type', '=', 'program')
        ->add_fields(array(
            Field::make('text', 'program_short_title', __('Short Title (for list grid)', 'mahbub-and-co'))
                ->set_help_text('e.g. Minipupillage, Internship. Leave blank to use post title. Details page = title + blocks below.'),
        ));
}

