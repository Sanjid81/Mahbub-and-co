<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

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