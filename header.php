<?php
// Exit if accessed directly
defined('ABSPATH') || exit;
?>

<!DOCTYPE html>
<html lang="en" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo THEMEROOT; ?>/dist/app.css">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


    <!-- Navbar -->
    <nav class="navbar">
        <!-- <div class="container"> -->
            <div class="nav-container">
                <div class="nav-wraper">
                    <div class="nav-first-half">
                        <!-- Logo -->
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                            <?php
                            $nav_logo_id = carbon_get_theme_option('site_logo');

                            if ($nav_logo_id):
                                $nav_logo_alt = get_bloginfo('name');

                                if (empty($nav_logo_alt)) {
                                    $nav_logo_alt = get_post_meta($nav_logo_id, '_wp_attachment_image_alt', true);
                                }

                                echo wp_get_attachment_image($nav_logo_id, 'full', false, [
                                    'class' => 'h-10',
                                    'alt' => esc_attr($nav_logo_alt),
                                    'loading' => 'lazy',
                                ]);
                            else:
                                ?>
                                <img src="<?php echo esc_url(IMG . '/logo.svg'); ?>" alt="<?php bloginfo('name'); ?>"
                                    class="h-10">
                            <?php endif; ?>
                        </a>

                        <!-- Desktop Menu -->
                        <div class="nav-menu" id="navMenu">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'main_menu',
                                'container' => false,
                                'menu_class' => 'main-menu-list',
                            ));

                            ?>
                        </div>
                    </div>

                    <div class="nav-sec-half">
                        <!-- Social Media Icons -->
                        <div class="social-media">
                            <?php if ($fb = carbon_get_theme_option('facebook_link')): ?>
                                <a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener noreferrer">

                                    <svg width=" 38" height="38" viewBox="0 0 38 38" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                            stroke-opacity="0.3" />
                                        <path
                                            d="M23.1598 20.0485L23.6556 16.8155H20.5537V14.7175C20.5537 13.833 20.987 12.9709 22.3764 12.9709H23.7867V10.2185C23.7867 10.2185 22.5068 10 21.2831 10C18.7283 10 17.0586 11.5484 17.0586 14.3515V16.8155H14.2188V20.0485H17.0586V27.8641C17.628 27.9535 18.2116 28 18.8061 28C19.4007 28 19.9843 27.9535 20.5537 27.8641V20.0485H23.1598Z"
                                            fill="white" />
                                    </svg>

                                </a>
                            <?php endif; ?>
                            <?php if ($insta = carbon_get_theme_option('linkedin_link')): ?>
                                <a href="<?php echo esc_url($insta); ?>" target="_blank" rel="noopener noreferrer">
                                    <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                            stroke-opacity="0.3" />
                                        <g clip-path="url(#clip0_905_257)">
                                            <path
                                                d="M28 20.9445V27.5988H24.1414V21.3923C24.1414 19.8313 23.5847 18.7683 22.1869 18.7683C21.1197 18.7683 20.4878 19.484 20.2074 20.1787C20.107 20.4256 20.0777 20.773 20.0777 21.1203V27.603H16.219C16.219 27.603 16.2692 17.0859 16.219 15.9978H20.0777V17.6425C20.0693 17.6551 20.0609 17.6676 20.0525 17.6802H20.0777V17.6425C20.5924 16.8515 21.5048 15.7258 23.5555 15.7258C26.0958 15.7216 28 17.383 28 20.9445ZM12.1846 10.4023C10.8621 10.4023 10 11.2687 10 12.407C10 13.5202 10.837 14.4116 12.1344 14.4116H12.1595C13.5071 14.4116 14.3441 13.5202 14.3441 12.407C14.3148 11.2687 13.5029 10.4023 12.1846 10.4023ZM10.2302 27.603H14.0888V15.9936H10.2302V27.603Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_905_257">
                                                <rect width="18" height="18" fill="white" transform="translate(10 10)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($email = carbon_get_theme_option('email_link')): ?>
                                <a href="mailto:<?php echo esc_attr($email); ?>" target="_blank" rel="noopener noreferrer">
                                    <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                            stroke-opacity="0.3" />
                                        <path
                                            d="M25 12.25H13C11.35 12.25 10 13.6 10 15.25V22.75C10 24.4 11.35 25.75 13 25.75H25C26.65 25.75 28 24.4 28 22.75V15.25C28 13.6 26.65 12.25 25 12.25ZM26.2 16.6L20.275 20.575C19.9 20.8 19.45 20.95 19 20.95C18.55 20.95 18.1 20.8 17.725 20.575L11.8 16.6C11.5 16.375 11.425 15.925 11.65 15.55C11.875 15.25 12.325 15.175 12.7 15.4L18.625 19.375C18.85 19.525 19.225 19.525 19.45 19.375L25.375 15.4C25.75 15.175 26.2 15.25 26.425 15.625C26.575 15.925 26.5 16.375 26.2 16.6Z"
                                            fill="white" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Primary Button -->
                        <?php 
                        // Use the Header-specific options for the button, as set in inc/theme-option.php under "Header Options"
                        // To change this button's text & link, go to WP Admin > Theme Options > Header Options.

                        $btn_text = carbon_get_theme_option('header_button_text');
                        $btn_link = carbon_get_theme_option('header_button_link');

                        if ($btn_text && $btn_link): ?>
                            <a href="<?php echo esc_url($btn_link); ?>" class="primary-button">
                                <div class="button-text">
                                    <?php echo esc_html($btn_text); ?>
                                </div>
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="44" height="44" rx="22" fill="#BC001A" />
                                    <g clip-path="url(#clip0_642_270)">
                                        <path d="M16.166 17H26.9993V27.8333" stroke="white" stroke-width="2"
                                            stroke-miterlimit="10" />
                                        <path d="M16 28L27 17" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_642_270">
                                            <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Hamburger -->
                <button class="hamburger" id="hamburger">
                    <div class="hamburger-icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M19.5 21.6667C18.3034 21.6667 17.3333 20.6966 17.3333 19.5C17.3333 18.3034 18.3034 17.3333 19.5 17.3333C20.6966 17.3333 21.6667 18.3034 21.6667 19.5C21.6667 20.6966 20.6966 21.6667 19.5 21.6667ZM19.5 13C18.3034 13 17.3333 12.0299 17.3333 10.8333C17.3333 9.63671 18.3034 8.66667 19.5 8.66667C20.6966 8.66667 21.6667 9.63671 21.6667 10.8333C21.6667 12.0299 20.6966 13 19.5 13ZM19.5 4.33333C18.3034 4.33333 17.3333 3.36328 17.3333 2.16667C17.3333 0.97005 18.3034 0 19.5 0C20.6966 0 21.6667 0.97005 21.6667 2.16667C21.6667 3.36328 20.6966 4.33333 19.5 4.33333ZM10.8333 21.6667C9.63671 21.6667 8.66667 20.6966 8.66667 19.5C8.66667 18.3034 9.63671 17.3333 10.8333 17.3333C12.0299 17.3333 13 18.3034 13 19.5C13 20.6966 12.0299 21.6667 10.8333 21.6667ZM10.8333 13C9.63671 13 8.66667 12.0299 8.66667 10.8333C8.66667 9.63671 9.63671 8.66667 10.8333 8.66667C12.0299 8.66667 13 9.63671 13 10.8333C13 12.0299 12.0299 13 10.8333 13ZM10.8333 4.33333C9.63671 4.33333 8.66667 3.36328 8.66667 2.16667C8.66667 0.97005 9.63671 0 10.8333 0C12.0299 0 13 0.97005 13 2.16667C13 3.36328 12.0299 4.33333 10.8333 4.33333ZM2.16667 21.6667C0.97005 21.6667 0 20.6966 0 19.5C0 18.3034 0.97005 17.3333 2.16667 17.3333C3.36328 17.3333 4.33333 18.3034 4.33333 19.5C4.33333 20.6966 3.36328 21.6667 2.16667 21.6667ZM2.16667 13C0.97005 13 0 12.0299 0 10.8333C0 9.63671 0.97005 8.66667 2.16667 8.66667C3.36328 8.66667 4.33333 9.63671 4.33333 10.8333C4.33333 12.0299 3.36328 13 2.16667 13ZM2.16667 4.33333C0.97005 4.33333 0 3.36328 0 2.16667C0 0.97005 0.97005 0 2.16667 0C3.36328 0 4.33333 0.97005 4.33333 2.16667C4.33333 3.36328 3.36328 4.33333 2.16667 4.33333Z"
                                fill="white" />
                        </svg>

                    </div>
                    <div class="cross">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 3L3 23" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M23 23L3 3" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </button>
                <!-- Mobile Menu -->

                <div class="small-nav-wraper">
                    <div class="small-nav-container">
                        <div class="small-nav-first-half">
                            <!-- < ?php mytheme_nav_menu(); ?> -->
                            <div class="nav-menu" id="navMenu">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'main_menu',
                                    'container' => false,
                                    'menu_class' => 'main-menu-list',
                                ));

                                ?>
                            </div>
                        </div>

                        <div class="nav-sec-half">
                            <!-- Social Media Icons -->
                            <div class="social-media">
                                <?php if ($fb = carbon_get_theme_option('facebook_link')): ?>
                                    <a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener noreferrer">

                                        <svg width=" 38" height="38" viewBox="0 0 38 38" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                                stroke-opacity="0.3" />
                                            <path
                                                d="M23.1598 20.0485L23.6556 16.8155H20.5537V14.7175C20.5537 13.833 20.987 12.9709 22.3764 12.9709H23.7867V10.2185C23.7867 10.2185 22.5068 10 21.2831 10C18.7283 10 17.0586 11.5484 17.0586 14.3515V16.8155H14.2188V20.0485H17.0586V27.8641C17.628 27.9535 18.2116 28 18.8061 28C19.4007 28 19.9843 27.9535 20.5537 27.8641V20.0485H23.1598Z"
                                                fill="white" />
                                        </svg>

                                    </a>
                                <?php endif; ?>
                                <?php if ($li = carbon_get_theme_option('linkedin_link')): ?>
                                    <a href="<?php echo esc_url($li); ?>" target="_blank" rel="noopener noreferrer">
                                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                                stroke-opacity="0.3" />
                                            <g clip-path="url(#clip0_905_257)">
                                                <path
                                                    d="M28 20.9445V27.5988H24.1414V21.3923C24.1414 19.8313 23.5847 18.7683 22.1869 18.7683C21.1197 18.7683 20.4878 19.484 20.2074 20.1787C20.107 20.4256 20.0777 20.773 20.0777 21.1203V27.603H16.219C16.219 27.603 16.2692 17.0859 16.219 15.9978H20.0777V17.6425C20.0693 17.6551 20.0609 17.6676 20.0525 17.6802H20.0777V17.6425C20.5924 16.8515 21.5048 15.7258 23.5555 15.7258C26.0958 15.7216 28 17.383 28 20.9445ZM12.1846 10.4023C10.8621 10.4023 10 11.2687 10 12.407C10 13.5202 10.837 14.4116 12.1344 14.4116H12.1595C13.5071 14.4116 14.3441 13.5202 14.3441 12.407C14.3148 11.2687 13.5029 10.4023 12.1846 10.4023ZM10.2302 27.603H14.0888V15.9936H10.2302V27.603Z"
                                                    fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_905_257">
                                                    <rect width="18" height="18" fill="white"
                                                        transform="translate(10 10)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                                <?php if ($email = carbon_get_theme_option('email_link')): ?>
                                    <a href="mailto:<?php echo esc_attr($email); ?>" target="_blank" rel="noopener noreferrer">
                                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                                stroke-opacity="0.3" />
                                            <path
                                                d="M25 12.25H13C11.35 12.25 10 13.6 10 15.25V22.75C10 24.4 11.35 25.75 13 25.75H25C26.65 25.75 28 24.4 28 22.75V15.25C28 13.6 26.65 12.25 25 12.25ZM26.2 16.6L20.275 20.575C19.9 20.8 19.45 20.95 19 20.95C18.55 20.95 18.1 20.8 17.725 20.575L11.8 16.6C11.5 16.375 11.425 15.925 11.65 15.55C11.875 15.25 12.325 15.175 12.7 15.4L18.625 19.375C18.85 19.525 19.225 19.525 19.45 19.375L25.375 15.4C25.75 15.175 26.2 15.25 26.425 15.625C26.575 15.925 26.5 16.375 26.2 16.6Z"
                                                fill="white" />
                                        </svg>
                                    </a>
                                  
                                <?php endif; ?>
                            </div>

                            <!-- Primary Button -->
                            <?php 
                            $mobile_btn_text = carbon_get_theme_option('header_button_text');
                            $mobile_btn_link = carbon_get_theme_option('header_button_link');
                            if ($mobile_btn_text && $mobile_btn_link): ?>
                                <a href="<?php echo esc_url($mobile_btn_link); ?>" class="primary-button">
                                    <div class="button-text">
                                        <?php echo esc_html($mobile_btn_text); ?>
                                    </div>
                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="44" height="44" rx="22" fill="#BC001A" />
                                        <g clip-path="url(#clip0_642_270)">
                                            <path d="M16.166 17H26.9993V27.8333" stroke="white" stroke-width="2"
                                                stroke-miterlimit="10" />
                                            <path d="M16 28L27 17" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_642_270">
                                                <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        <!-- </div> -->
    </nav>