<?php
if (!empty($companies)):

    $accolades_title = $fields['accolades_title'] ?? 'Our Trusted Companies';
    $acolades_button_text = $fields['acolades_button_text'] ?? 'Load more';
    $acolades_button_link = $fields['acolades_button_link'] ?? '#';

    ?>

    <section class="company-section">
        <div class="banner-overlay"></div>
        <div class="company-container">
            <h2 class="heading-two" data-aos="fade-up">
                <?php echo esc_html($fields['accolades_title'] ?? 'Our Trusted Companies');
                ?>
            </h2>

            <div class="company-grid" style="--total-items: <?php echo count($companies); ?>;" data-aos="fade-up">
                <?php foreach ($companies as $company):
                    $logo_id = $company['logo'] ?? '';
                    ?>
                    <div class="company-content">
                        <?php if ($logo_id): ?>
                            <?php
                            echo wp_get_attachment_image(
                                $logo_id,
                                'medium',
                                false,
                                array(
                                    'alt' => get_post_meta($logo_id, '_wp_attachment_image_alt', true)
                                )
                            );
                            ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="button-wraper" data-aos="fade-up">
                <a href="<?php echo esc_url($acolades_button_link); ?>" class="primary-button">
                    <div class="button-text">
                        <?php echo esc_html($acolades_button_text); ?>
                    </div>

                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="44" height="44" rx="22" fill="#BC001A" />
                        <g clip-path="url(#clip0_642_270)">
                            <path d="M16.166 17H26.9993V27.8333" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                            <path d="M16 28L27 17" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                        </g>
                        <defs>
                            <clipPath id="clip0_642_270">
                                <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                            </clipPath>
                        </defs>
                    </svg>
                </a>
            </div>

        </div>
    </section>
<?php endif; ?>