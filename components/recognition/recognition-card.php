<?php
$cards = get_query_var('recognition_cards', []);
$load_more_text = get_query_var('load_more_text', '');
$load_more_link = get_query_var('load_more_link', '#');
?>

<?php if (!empty($cards)): ?>
    <section class="recognition-section">
        <div class="container">

            <div class="recognition-cards">

                <?php foreach ($cards as $card):
                    $image_id = $card['icon'] ?? '';
                    $image_url = wp_get_attachment_image_url($image_id, 'full');
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

                    $title = $card['title'] ?? '';
                    $description = $card['description'] ?? '';
                    ?>
                    <div class="recognition-wraper" data-aos="fade-up">

                        <?php if ($image_url): ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text ?: $title); ?>">
                        <?php endif; ?>

                        <div class="recongnition-content">
                            <?php if ($title): ?>
                                <h5 class="heading-five">
                                    <?php echo esc_html($title); ?>
                                </h5>
                            <?php endif; ?>

                            <?php if ($description): ?>
                                <p class="body-text">
                                    <?php echo esc_html($description); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if ($load_more_text): ?>
                    <a href="<?php echo esc_url($load_more_link); ?>" class="primary-button" data-aos="fade-up">
                        <div class="button-text">
                            <?php echo esc_html($load_more_text); ?>
                        </div>

                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="44" rx="22" fill="#BC001A" />
                            <g clip-path="url(#clip0_1637_2017)">
                                <path d="M16.166 17H26.9993V27.8333" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                                <path d="M16 28L27 17" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1637_2017">
                                    <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </section>
<?php endif; ?>