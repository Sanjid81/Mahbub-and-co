<?php
/**
 * Carbon Fields: Job Opening meta (experience, location, type, deadline, Apply button)
 */
defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'maco_register_job_opening_meta');

function maco_register_job_opening_meta()
{
    Container::make('post_meta', __('Job Details', 'mahbub-and-co'))
        ->where('post_type', '=', 'job_opening')
        ->add_fields(array(
            Field::make('text', 'maco_job_experience', __('Experience', 'mahbub-and-co'))
                ->set_help_text('e.g. 4 Years To 5 Years')
                ->set_attribute('placeholder', 'Experience: 4 Years To 5 Years'),
            Field::make('text', 'maco_job_location', __('Location', 'mahbub-and-co'))
                ->set_help_text('e.g. Main Office')
                ->set_attribute('placeholder', 'Main Office'),
            Field::make('text', 'maco_job_type', __('Type', 'mahbub-and-co'))
                ->set_help_text('e.g. Full-time, Part-time')
                ->set_attribute('placeholder', 'Full-time'),
            Field::make('text', 'maco_job_deadline', __('Deadline', 'mahbub-and-co'))
                ->set_help_text('e.g. March 15, 2025')
                ->set_attribute('placeholder', 'March 15, 2025'),
            Field::make('text', 'maco_job_apply_url', __('Apply URL', 'mahbub-and-co'))
                ->set_help_text('Link for Apply Now. Leave blank to use job details page.')
                ->set_attribute('type', 'url'),
            Field::make('text', 'maco_job_apply_text', __('Apply Button Text', 'mahbub-and-co'))
                ->set_default_value('Apply Now'),
        ));
}
