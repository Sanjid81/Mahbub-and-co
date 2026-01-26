<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;





// add_action('carbon_fields_register_fields', function () {
//     Container::make('theme_options', 'Header Options')
//         ->set_icon('dashicons-admin-generic') // optional
//         ->add_fields(array(
//             Field::make('image', 'site_logo', 'Site Logo'),
//             Field::make('text', 'facebook_link', 'Facebook URL'),
//             Field::make('text', 'email_link', 'Email'),
//             Field::make('text', 'linkedin_link', 'LinkedIn URL'),
//             Field::make('text', 'button_text', 'Button Text'),
//             Field::make('text', 'button_link', 'Button Link'),
//         ));
// });

// // footer


// add_action('carbon_fields_register_fields', 'footer_theme_options');
// function footer_theme_options()
// {
//     Container::make('theme_options', __('Footer Settings'))
//         ->set_icon('dashicons-editor-quote')
//         ->add_fields(array(
//             Field::make('image', 'footer_logo', 'Footer Logo'),
//             Field::make('image', 'footer_mobile_logo', 'Footer Mobile Logo'),
//             Field::make('text', 'footer_tagline', 'Footer Tagline'),
//             Field::make('text', 'footer_address', 'Address'),
//             Field::make('text', 'footer_email', 'Email'),
//             Field::make('text', 'footer_copyright', 'Copyright Text'),
//             Field::make('text', 'footer_site_name', 'Site Name'),
//             Field::make('text', 'footer_site_url', 'Site URL'),
//             Field::make('text', 'footer_privacy_policy', 'Privacy Policy Page URL'),
//             Field::make('text', 'footer_terms_conditions', 'Terms & Conditions Page URL'),
//         ));
// }

// .................................................

add_action('carbon_fields_register_fields', function () {
    // ............// Home page..................
    // Hero slider
    // .............
    Block::make('Hero section')
        ->add_fields(array(
            Field::make('image', 'hero_bg_image', 'Hero Background Image'),

            Field::make('complex', 'hero_slides', 'Hero Slides')
                ->add_fields(array(
                    Field::make('text', 'title', 'Slide Title'),
                    Field::make('text', 'highlight_text', 'Highlighted Text (inside <span>)'),
                    Field::make('textarea', 'description', 'Slide Description'),
                    Field::make('text', 'button_text', 'Button Text')->set_default_value('Get Started'),
                    Field::make('text', 'button_link', 'Button Link')->set_default_value('#contact'),
                    Field::make('image', 'image', 'Slide Image')
                ))
                ->set_layout('tabbed-horizontal')
        ))
        ->set_render_callback(function ($fields) {

            set_query_var('slides', $fields['hero_slides'] ?? []);
            set_query_var('hero_bg_image', $fields['hero_bg_image'] ?? '');

            get_template_part('components/home/hero');
        });




    // .................News and insights.....................
    Block::make('News & Insights Section')
        ->add_fields(array(
            // Section Titles
            Field::make('text', 'news_title', 'News Section Title')
                ->set_default_value('News & Events'),
            Field::make('text', 'insights_title', 'Insights Section Title')
                ->set_default_value('Insights'),

            // News Cards
            Field::make('complex', 'news_cards', 'News Cards')
                ->set_layout('tabbed-horizontal')

                ->add_fields(array(
                    Field::make('image', 'image', 'Card Image'),
                    Field::make('text', 'meta', 'Meta Text')->set_default_value('NEWS • APRIL 28, 2025'),
                    Field::make('text', 'heading', 'Card Heading'),
                    Field::make('textarea', 'excerpt', 'Excerpt'),
                    Field::make('text', 'read_more_text', 'Read More Text')->set_default_value('Read More'),
                    Field::make('text', 'read_more_link', 'Read More URL')->set_default_value('#'),
                )),

            // Insights Cards
            Field::make('complex', 'insights_cards', 'Insights Cards')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('image', 'image', 'Card Image'),
                    Field::make('text', 'meta', 'Meta Text')->set_default_value('NEWS • APRIL 28, 2025'),
                    Field::make('text', 'heading', 'Card Heading'),
                    Field::make('textarea', 'excerpt', 'Excerpt'),
                    Field::make('text', 'read_more_text', 'Read More Text')->set_default_value('Read More'),
                    Field::make('text', 'read_more_link', 'Read More URL')->set_default_value('#'),
                )),

            // Buttons
            Field::make('text', 'news_button_text', 'News Button Text')->set_default_value('View more'),
            Field::make('text', 'news_button_link', 'News Button Link')->set_default_value('#'),
            Field::make('text', 'insights_button_text', 'Insights Button Text')->set_default_value('Get Started'),
            Field::make('text', 'insights_button_link', 'Insights Button Link')->set_default_value('#'),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            // Pass all fields to template
            set_query_var('news_insights_fields', $fields);
            get_template_part('components/home/news-and-insights');
        });


    // .....................Testimonials Section...................
    Block::make('Testimonials Section')
        ->add_fields(array(
            Field::make('complex', 'testimonials', 'Testimonials')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('textarea', 'text', 'Testimonial Text'),
                    Field::make('text', 'author', 'Author / Position'),
                )),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {

            set_query_var('testimonials', $fields['testimonials'] ?? []);

            get_template_part('components/home/home-testimonials');
        });


    // ......................Accolades.................

    Block::make('Accolades Section')
        ->add_fields(array(
            Field::make('text', 'accolades_title', 'Accolades Section Title')
                ->set_default_value('News & Events'),
            Field::make('complex', 'companies', 'Companies')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('image', 'logo', 'Company Logo'),
                    Field::make('text', 'alt', 'Alt Text'),
                )),
            // Buttons
            Field::make('text', 'acolades_button_text', 'Acolades Button Text')->set_default_value('View more'),
            Field::make('text', 'acolades_button_link', 'Acolades Button Link')->set_default_value('#'),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            $companies = $fields['companies'] ?? [];
            include get_template_directory() . '/components/home/accolades.php';
        });


    // legal solutions
    Block::make('Legal Solutions Section')
        ->add_fields(array(
            Field::make('text', 'lead_text', 'Lead Text')
                ->set_help_text('Use <br> for line breaks if needed'),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            set_query_var('lead_text', $fields['lead_text'] ?? '');
            get_template_part('components/home/legal-solution');
        });



    // ===================Our expertise page========================
    // ===========================================

    Block::make('FAQ Section')
        ->set_description('Add FAQ section with dynamic team area categories')
        ->set_category('common')
        ->add_fields(array(
            Field::make('text', 'faq_section_title', 'Section Title'),
            Field::make('textarea', 'faq_section_description', 'Section Description'),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            set_query_var('fields', $fields);
            get_template_part('components/our-expertise/tailored-solution');
        });






    //// ...........................Our people page..................................
    //// .............................................................
    //// .............................................................
    Block::make('Teams Section')
        ->set_description('Our people page team section')
        ->set_category('common')
        ->add_fields(array(
            Field::make('text', 'block_title', 'Block Title')
                ->set_default_value('Our Team'),
            Field::make('textarea', 'block_description', 'Block Description')
                ->set_default_value('Meet our amazing team members.'),
            Field::make('text', 'button_text', 'Button Text')
                ->set_default_value('Learn More'),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            // Pass $fields to template
            set_query_var('fields', $fields);
            get_template_part('components/our-people/our-people');
        });





});



