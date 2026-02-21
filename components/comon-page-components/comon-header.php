<?php
$title = get_query_var('careers_title', 'Careers');
$desc = get_query_var('careers_description', '');
$btn_text = get_query_var('careers_button_text', 'Apply');
$btn_link = get_query_var('careers_button_link', '#');

$bg_img = get_query_var('careers_hero_bg', '');
if (empty($bg_img) && function_exists('carbon_get_theme_option')) {
    $bg_id = carbon_get_theme_option('careers_hero_bg');
    $bg_img = $bg_id ? wp_get_attachment_url($bg_id) : '';
}
if (empty($bg_img)) {
    $bg_img = 'https://i.postimg.cc/hGk6QtbV/hero-background-img.webp';
}
?>
<section class="careers-hero">
    <div class="careers-hero-bg">
        <img src="<?php echo esc_url($bg_img); ?>" alt="" class="careers-hero-bg-img">
        <span class="careers-hero-bg-overlay"></span>
    </div>
    <div class="container">
        <div class="careers-content">
            <h1 class="heading-one">
                <?php echo esc_html($title); ?>
            </h1>

            <?php if ($desc): ?>
                <div class="body-text-two careers-description">
                    <?php echo wp_kses_post($desc); ?>
                </div>
            <?php endif; ?>

            <div class="comon-header-button-wraper">
                <?php if (!empty($btn_text) && !empty($btn_link)): ?>
                    <a href="<?php echo esc_url($btn_link); ?>" class="primary-button">
                        <div class="button-text">
                                <?php echo esc_html($btn_text); ?>
                        </div>
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="44" rx="22" fill="#BC001A" />
                            <g clip-path="url(#clip0_642_270)">
                                <path d="M16.166 17H26.9993V27.8333" stroke="white" stroke-width="2" />
                                <path d="M16 28L27 17" stroke="white" stroke-width="2" />
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
</section>