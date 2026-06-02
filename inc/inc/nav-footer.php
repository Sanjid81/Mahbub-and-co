<?php
// Register dynamic menus
// Menus
function mytheme_setup()
{
    add_theme_support('menus');
    register_nav_menus(array(
        'main_menu' => __('Main Menu', 'mytheme'),
        'mobile_menu' => __('Mobile Menu', 'mytheme'),
    ));
}
add_action('after_setup_theme', 'mytheme_setup');

// ....................................
// Footer menu register
function yourthemename_register_menus()
{
    register_nav_menus(array(
        'footer_expertise_col1' => __('Areas of Expertise Column 1', 'yourthemename'),
        'footer_expertise_col2' => __('Areas of Expertise Column 2', 'yourthemename'),
        'footer_quicklinks' => __('Quick Links', 'yourthemename'),
    ));

}
add_action('init', 'yourthemename_register_menus');
