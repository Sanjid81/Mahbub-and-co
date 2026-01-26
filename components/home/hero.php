<?php
$slides = get_query_var('slides');
$bg_image_id = get_query_var('hero_bg_image');
$bg_image_url = $bg_image_id
    ? wp_get_attachment_image_url($bg_image_id, 'full')
    : '';
?>

<?php if ($slides): ?>
    <div class="hero-section"
        style="<?php if ($bg_image_url): ?>
            background-image: url('<?php echo esc_url($bg_image_url); ?>');
        <?php endif; ?>">

        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ($slides as $slide):

                    // ------------------------------
                    // Variables declared at top
                    // ------------------------------
                    $title = $slide['title'] ?? '';
                    $highlight_text = $slide['highlight_text'] ?? '';
                    $description = $slide['description'] ?? '';
                    $button_text = $slide['button_text'] ?? 'Get Started';
                    $button_link = $slide['button_link'] ?? '#contact';
                    $image_id = $slide['image'] ?? '';
                    $image_url = wp_get_attachment_image_url($image_id, 'full');
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $title;
                ?>
                    <div class="swiper-slide">
                        <div class="content-wraper">
                            <div class="slide-content">
                                <h1 class="slide-title" data-aos="fade-up">
                                    <?php echo esc_html($title); ?>
                                    <?php if ($highlight_text): ?>
                                        <span><?php echo esc_html($highlight_text); ?></span>
                                    <?php endif; ?>
                                </h1>

                                <p class="slide-description" data-aos="fade-up">
                                    <?php echo esc_html($description); ?>
                                </p>

                                <a href="<?php echo esc_url($button_link); ?>" class="primary-button" data-aos="fade-up">
                                    <div class="button-text">
                                        <?php echo esc_html($button_text); ?>
                                    </div>

                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
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
                            </div>

                            <?php if ($image_url): ?>
                                <div class="slide-image" data-aos="fade-up">
                                    <img src="<?php echo esc_url($image_url); ?>"
                                        alt="<?php echo esc_attr($alt_text); ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="swiper-pagination"></div>
        </div>
    </div>
<?php endif; ?>
