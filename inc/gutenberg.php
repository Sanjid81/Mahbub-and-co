<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;




add_action('carbon_fields_register_fields', function () {

    // =========================================================
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
            Field::make('image', 'background_image', 'Background Image'), // NEW

            Field::make('complex', 'testimonials', 'Testimonials')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('textarea', 'text', 'Testimonial Text'),
                    Field::make('text', 'author', 'Author / Position'),
                )),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {

            set_query_var('testimonials', $fields['testimonials'] ?? []);
            set_query_var('testimonials_bg', $fields['background_image'] ?? ''); // NEW
    
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
            Field::make('textarea', 'legal_description', __('Description', 'your-textdomain'))
                ->set_rows(4),

            Field::make('text', 'legal_button_text', __('Button Text', 'your-textdomain'))
                ->set_default_value('Apply'),

            Field::make('text', 'legal_button_link', __('Button Link (URL)', 'your-textdomain'))
                ->set_default_value('#'),
            Field::make('image', 'background_image', 'Background Image')
                ->set_value_type('url'),
        ))
        ->set_render_callback(function ($fields) {
            set_query_var('lead_text', $fields['lead_text'] ?? '');
            set_query_var('legal_description', $fields['legal_description'] ?? '');
            set_query_var('button_text', $fields['legal_button_text'] ?? '');
            set_query_var('button_link', $fields['legal_button_link'] ?? '#');
            set_query_var('bg_image', $fields['background_image'] ?? '');

            get_template_part('components/home/legal-solution');
        });

    // ========================end home page=================================




    // ===================================================
    // =======================About us page============================
    // ===================================================

    // ========================about us header===========================
    Block::make('comon header Section')
        ->add_fields(array(
            Field::make('text', 'careers_title', __('Main Title', 'your-textdomain'))
                ->set_default_value('Careers')
                ->set_width(50),

            Field::make('textarea', 'careers_description', __('Description', 'your-textdomain'))
                ->set_rows(4),

            Field::make('text', 'careers_button_text', __('Button Text', 'your-textdomain')),

            Field::make('text', 'careers_button_link', __('Button Link (URL)', 'your-textdomain'))
        ))
        ->set_render_callback(function ($fields) {

            set_query_var('careers_title', $fields['careers_title'] ?? 'Careers');
            set_query_var('careers_description', $fields['careers_description'] ?? '');
            set_query_var('careers_button_text', $fields['careers_button_text'] ?? 'Apply');
            set_query_var('careers_button_link', $fields['careers_button_link'] ?? '#');

            get_template_part('components/comon-page-components/comon-header');
        });



    // =========================================================
    // single img Section
    // =========================================================
    Block::make('Single Image Block', 'single img section')
        ->add_fields(array(
            Field::make('image', 'single_image', 'Image')
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            include get_template_directory() . '/components/comon-page-components/single-img.php';
        });

    // ========about text field=============
    Block::make('About Details Text', 'about-details-text')
        ->set_description('Add custom content with rich text editor')
        ->set_category('common')
        ->add_fields(array(
            Field::make('rich_text', 'custom_content', 'Content')
                ->set_help_text('Add heading, paragraph, image etc'),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            set_query_var('custom_content', $fields['custom_content'] ?? '');
            get_template_part('components/about/about-text-details');
        });

    // ==================about page slider========================
    Block::make('About page slider')
        ->add_fields(array(

            Field::make('complex', 'about_slides', 'About Slides')
                ->add_fields(array(

                    Field::make('text', 'title', 'Slide Title'),

                    Field::make('rich_text', 'custom_content', 'Content')
                        ->set_help_text('Add heading, paragraph, image etc'),

                    Field::make('image', 'image', 'Slide Image')

                ))
                ->set_layout('tabbed-horizontal')

        ))
        ->set_render_callback(function ($fields) {

            set_query_var('slides', $fields['about_slides'] ?? []);

            get_template_part('components/about/about-slider');
        });


    // =====================about recognition====================
    Block::make('About Recognition Section')
        ->add_fields(array(

            Field::make('text', 'section_title', 'Section Title')
                ->set_default_value('Recognition'),

            Field::make('complex', 'recognition_images', 'Recognition Images')
                ->add_fields(array(
                    Field::make('image', 'logo', 'Recognition Logo')
                ))
                ->set_layout('tabbed-horizontal')

        ))
        ->set_render_callback(function ($fields) {

            set_query_var('recognition_title', $fields['section_title'] ?? '');
            set_query_var('recognition_images', $fields['recognition_images'] ?? []);

            get_template_part('components/about/about-recognition');
        });
    // ===========================end about page==============================


    // ===================Our expertise page========================
    // =========================================================

    // =================FAQ Section==========================
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

    // ==========================end expertise page===============================




    // =========================================================
    //// ...........................Our people page..................................
    // =========================================================

    //// ........................Teams Section.....................................
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
            set_query_var('fields', $fields);
            get_template_part('components/our-people/our-people');
        });

    // =========================end our peopl page================================

    // =========================recognition page================================

    Block::make('Recognition Cards Section')
        ->add_fields(array(

            Field::make('complex', 'recognition_cards', 'Recognition Cards')
                ->add_fields(array(
                    Field::make('image', 'icon', 'Logo / Icon'),
                    Field::make('text', 'title', 'Title'),
                    Field::make('textarea', 'description', 'Description')
                        ->set_rows(3),
                ))
                ->set_layout('tabbed-horizontal'),

            Field::make('text', 'load_more_text', 'Load More Text')
                ->set_default_value('Load More'),

            Field::make('text', 'load_more_link', 'Load More Link')
                ->set_default_value('#'),
        ))
        ->set_render_callback(function ($fields) {

            set_query_var('recognition_cards', $fields['recognition_cards'] ?? []);
            set_query_var('load_more_text', $fields['load_more_text'] ?? '');
            set_query_var('load_more_link', $fields['load_more_link'] ?? '#');

            get_template_part('components/recognition/recognition-card');
        });
    // =========================end recognition page================================
























    
});



