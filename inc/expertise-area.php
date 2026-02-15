<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {

    /**
     * ==============================
     * TEAM AREA (TERM META)
     * ==============================
     */
    Container::make('term_meta', __('Team Area Properties'))
        ->where('term_taxonomy', '=', 'team_area')
        ->add_fields(array(

            Field::make('text', 'crb_title', __('Title')),

            Field::make('image', 'crb_banner', __('Banner Image')),

            Field::make('rich_text', 'crb_description', __('Description')),

            Field::make('text', 'button_text', 'Back Button Text')
                ->set_default_value('Back'),


            Field::make('text', 'pdf_button_text', 'PDF Button Text')
                ->set_default_value('Download PDF'),

            Field::make('file', 'pdf_file', 'PDF File')
                ->set_type('application/pdf'),

            Field::make('rich_text', 'expertise_details_content', __('Content below (details page)', 'mahbub-and-co'))
                ->help_text(__('Add content that will show below the team list. You can use formatting, links, lists, etc.', 'mahbub-and-co')),

            Field::make('association', 'expertise_blocks_page', __('Custom blocks below', 'mahbub-and-co'))
                ->set_types(array(array('type' => 'post', 'post_type' => 'page')))
                ->set_max(1)
                ->help_text(__('Select a page. All blocks (Hero, Apply Form, etc.) from that page will show below on this details page. Create a page, add your blocks there, then select it here.', 'mahbub-and-co'))
        ));

    /**
     * ==============================
     * TEAM MEMBER DETAILS
     * ==============================
     */
    Container::make('post_meta', 'Team Member Details')
        ->where('post_type', '=', 'team')
        ->add_fields(array(

            Field::make('text', 'team_email', 'Email'),

            Field::make('text', 'team_number', 'Phone Number'),
        ));

});
