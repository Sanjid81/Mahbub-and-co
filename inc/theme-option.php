<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Theme Options with nested sub-options
 */
add_action('carbon_fields_register_fields', function () {

    // Main Theme Options
    $theme_options_container = Container::make('theme_options', __('Theme Options'))
        ->add_fields(array(
            Field::make('header_scripts', 'crb_header_script', __('Header Scripts')),
            Field::make('footer_scripts', 'crb_footer_script', __('Footer Scripts')),
        ));

    // Sub-options: Header Options
    Container::make('theme_options', __('Header Options'))
        ->set_page_parent($theme_options_container) // nested under main Theme Options
        ->add_fields(array(
            Field::make('image', 'site_logo', 'Site Logo'),
            Field::make('text', 'facebook_link', 'Facebook URL'),
            Field::make('text', 'email_link', 'Email'),
            Field::make('text', 'linkedin_link', 'LinkedIn URL'),
            Field::make('text', 'header_button_text', 'Button Text'),
            Field::make('text', 'header_button_link', 'Button Link'),
        ));

    // Sub-options: Footer Options
    Container::make('theme_options', __('Footer Options'))
        ->set_page_parent($theme_options_container)
        ->add_fields(array(
            Field::make('image', 'footer_logo', 'Footer Logo'),
            Field::make('image', 'footer_mobile_logo', 'Footer Mobile Logo'),
            Field::make('text', 'footer_tagline', 'Footer Tagline'),
            Field::make('text', 'footer_address', 'Address'),
            Field::make('text', 'footer_email', 'Email'),
            Field::make('text', 'footer_facebook_link', 'Facebook URL'),
            Field::make('text', 'footer_linkedin_link', 'LinkedIn URL'),
            Field::make('text', 'footer_copyright', 'Copyright Text'),
            Field::make('text', 'footer_site_name', 'Site Name'),
            Field::make('text', 'footer_site_url', 'Site URL'),
            Field::make('text', 'footer_privacy_policy', 'Privacy Policy Page URL'),
            Field::make('text', 'footer_terms_conditions', 'Terms & Conditions Page URL'),
        ));

    // ----------------------------
    // Page Meta Checkbox
    // ----------------------------


});
add_action('carbon_fields_register_fields', function () {

    // ----------------------------
    // Global Theme Options
    // ----------------------------
    Container::make('theme_options', 'Common Footer Top Section')
        ->add_fields([
            Field::make('text', 'lead_text', 'Lead Text')
                ->set_help_text('Use <br> for line breaks'),

            Field::make('textarea', 'legal_text', 'Legal Text')
                ->set_help_text('Use <br> for line breaks'),

            Field::make('text', 'button_text', 'Button Text')
                ->set_default_value('Learn More'),

            Field::make('text', 'button_link', 'Button Link')
                ->set_default_value('#'),
        ]);

    // ----------------------------
    // Page Meta (Checkbox)
    // ----------------------------
    Container::make('post_meta', 'Common Footer Top Display')
        ->show_on_post_type('page')
        ->add_fields([
            Field::make('checkbox', 'enable_common_footer_top_page', 'Enable Common Footer Top Section')
                ->set_option_value('yes'),
        ]);

});




















