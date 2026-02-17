<?php
$footer_logo = carbon_get_theme_option('footer_logo');
$footer_mobile_logo = carbon_get_theme_option('footer_mobile_logo');
$footer_tagline = carbon_get_theme_option('footer_tagline');
$footer_address = carbon_get_theme_option('footer_address');
$footer_email = carbon_get_theme_option('footer_email');
$footer_copyright = carbon_get_theme_option('footer_copyright');
$footer_site_name = carbon_get_theme_option('footer_site_name');
$footer_site_url = carbon_get_theme_option('footer_site_url');
$privacy_policy = carbon_get_theme_option('footer_privacy_policy');
$terms_conditions = carbon_get_theme_option('footer_terms_conditions');
?>


<footer class="footer">
    <div class="container">
        <div class="footer-container">
            <!-- About / Logo Section -->
            <div class="footer-column footer-about" data-aos="fade-up">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                    <?php if ($footer_logo): ?>
                        <?php echo wp_get_attachment_image($footer_logo, 'full', false, ['alt' => get_bloginfo('name')]); ?>
                    <?php endif; ?>
                </a>

                <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-logo">
                    <?php if ($footer_mobile_logo): ?>
                        <?php echo wp_get_attachment_image($footer_mobile_logo, 'full', false, ['alt' => get_bloginfo('name')]); ?>
                    <?php endif; ?>
                </a>

                <p class="footer-text"><?php echo esc_html($footer_tagline); ?></p>
            </div>
<div class="footer-columns">
    
            <!-- Areas of Expertise Section -->
            <div class="footer-column double-menu-column" data-aos="fade-up">
                <h3 class="footer-title">Areas of Expertise</h3>
                <div class="area-of-expertise">

                    <?php
                    // First column
                    wp_nav_menu(array(
                        'theme_location' => 'footer_expertise_col1',
                        'container' => false,
                        'menu_class' => 'footer-links',
                    ));

                    // Second column
                    wp_nav_menu(array(
                        'theme_location' => 'footer_expertise_col2',
                        'container' => false,
                        'menu_class' => 'footer-links',
                    ));
                    ?>

                </div>
            </div>

            <!-- Quick Links Section -->
            <div class="footer-column footer-quick-links" data-aos="fade-up">
                <h3 class="footer-title">Quick Links</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_quicklinks',
                    'container' => false,
                    'menu_class' => 'footer-links',
                ));
                ?>
            </div>

            <!-- Contact Section -->
            <div class="footer-column footer-address" data-aos="fade-up">
                <h3 class="footer-title">Contact</h3>
                <p><?php echo nl2br(esc_html($footer_address)); ?></p>
                <div class="footer-social-links">
                    <div class="footer-media">
                        <!-- <span>< ?php echo esc_html($footer_email); ?></span> -->

                        <?php if ($footer_email = carbon_get_theme_option('footer_email')): ?>
                            <a href="mailto:<?php echo esc_attr($footer_email); ?>" class="footer-email-link" target="_blank" rel="noopener noreferrer">
                                <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                        stroke-opacity="0.3" />
                                    <path
                                        d="M25 12.25H13C11.35 12.25 10 13.6 10 15.25V22.75C10 24.4 11.35 25.75 13 25.75H25C26.65 25.75 28 24.4 28 22.75V15.25C28 13.6 26.65 12.25 25 12.25ZM26.2 16.6L20.275 20.575C19.9 20.8 19.45 20.95 19 20.95C18.55 20.95 18.1 20.8 17.725 20.575L11.8 16.6C11.5 16.375 11.425 15.925 11.65 15.55C11.875 15.25 12.325 15.175 12.7 15.4L18.625 19.375C18.85 19.525 19.225 19.525 19.45 19.375L25.375 15.4C25.75 15.175 26.2 15.25 26.425 15.625C26.575 15.925 26.5 16.375 26.2 16.6Z"
                                        fill="rgba(255, 255, 255, 0.5)" />
                                </svg>
                            </a>
                        <?php endif; ?>

                    </div>
                    <div class="footer-media">
                        <!-- <span>< ?php echo esc_html($footer_email); ?></span> -->

                        <?php if ($footer_facebook_link = carbon_get_theme_option('footer_facebook_link')): ?>
                            <a href="<?php echo esc_url($footer_facebook_link); ?>" class="footer-email-link" target="_blank" rel="noopener noreferrer">
                                <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                        stroke-opacity="0.3" />
                                    <path
                                        d="M23.1598 20.0485L23.6556 16.8155H20.5537V14.7175C20.5537 13.833 20.987 12.9709 22.3764 12.9709H23.7867V10.2185C23.7867 10.2185 22.5068 10 21.2831 10C18.7283 10 17.0586 11.5484 17.0586 14.3515V16.8155H14.2188V20.0485H17.0586V27.8641C17.628 27.9535 18.2116 28 18.8061 28C19.4007 28 19.9843 27.9535 20.5537 27.8641V20.0485H23.1598Z"
                                        fill="rgba(255, 255, 255, 0.5)
" />
                                </svg>

                            </a>
                        <?php endif; ?>

                    </div>
                    <div class="footer-media">
                        <!-- <span>< ?php echo esc_html($footer_email); ?></span> -->

                        <?php if ($footer_linkedin_link = carbon_get_theme_option('footer_linkedin_link')): ?>
                            <a href="<?php echo esc_url($footer_linkedin_link); ?>" class="footer-email-link" target="_blank" rel="noopener noreferrer">
                                <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="white"
                                        stroke-opacity="0.3" />
                                    <g clip-path="url(#clip0_1575_650)">
                                        <path
                                            d="M28 20.9445V27.5988H24.1414V21.3923C24.1414 19.8313 23.5847 18.7683 22.1869 18.7683C21.1197 18.7683 20.4878 19.484 20.2074 20.1787C20.107 20.4256 20.0777 20.773 20.0777 21.1203V27.603H16.219C16.219 27.603 16.2692 17.0859 16.219 15.9978H20.0777V17.6425C20.0693 17.6551 20.0609 17.6676 20.0525 17.6802H20.0777V17.6425C20.5924 16.8515 21.5048 15.7258 23.5555 15.7258C26.0958 15.7216 28 17.383 28 20.9445ZM12.1846 10.4023C10.8621 10.4023 10 11.2687 10 12.407C10 13.5202 10.837 14.4116 12.1344 14.4116H12.1595C13.5071 14.4116 14.3441 13.5202 14.3441 12.407C14.3148 11.2687 13.5029 10.4023 12.1846 10.4023ZM10.2302 27.603H14.0888V15.9936H10.2302V27.603Z"
                                            fill="rgba(255, 255, 255, 0.5)" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1575_650">
                                            <rect width="18" height="18" fill="white" transform="translate(10 10)" />
                                        </clipPath>
                                    </defs>
                                </svg>

                            </a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
</div>

        <!-- Footer Bottom -->



        <div class="footer-bottom">
            <div class="copy-right-text">
                <span><?php echo esc_html($footer_copyright); ?></span> | <span> Site by:</span>
                <?php if ($footer_site_name && $footer_site_url): ?>
                    <a href="<?php echo esc_url($footer_site_url); ?>" target="_blank" rel="noopener noreferrer">
                        <?php echo esc_html($footer_site_name); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="footer-policy-terms">
                <?php if ($privacy_policy): ?>
                    <div class="privacy-policy">
                        <a href="<?php echo esc_url($privacy_policy); ?>">Privacy Policy</a>
                    </div>
                <?php endif; ?>

                <?php if ($terms_conditions): ?>
                    <div class="terms-conditions">
                        <a href="<?php echo esc_url($terms_conditions); ?>">Terms & Conditions</a>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</footer>

<?php wp_footer(); ?>


</body>

</html>