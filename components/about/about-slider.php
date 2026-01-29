<?php
$slides = get_query_var('slides');
?>

<?php if ($slides): ?>
    <div class="about-slider-section">
        <div class="swiper">
            <div class="swiper-wrapper">

                <?php foreach ($slides as $slide):
                    $title = $slide['title'] ?? '';
                    $content = $slide['custom_content'] ?? '';
                    $image_id = $slide['image'] ?? '';
                    $image_url = wp_get_attachment_image_url($image_id, 'full');
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $title;
                    ?>
                    <div class="swiper-slide">
                        <div class="content-wraper">

                            <div class="slide-content" data-aos="fade-up">
                                <?php if ($title): ?>
                                    <h1 class="slide-title text-red">
                                        <?php echo esc_html($title); ?>
                                    </h1>
                                <?php endif; ?>

                                <?php if ($content): ?>
                                    <div class="slide-description">
                                        <?php echo apply_filters('the_content', $content); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($image_url): ?>
                                <div class="slide-image" data-aos="fade-up">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>">
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