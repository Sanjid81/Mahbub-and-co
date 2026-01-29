<?php
$title = get_query_var('recognition_title');
$images = get_query_var('recognition_images');
?>

<?php if ($title || $images): ?>
    <section class="about-recognition-section">
        <div class="container">
            <div class="about-recognition-wraper">

                <?php if ($title): ?>
                    <h2 class="heading-two" data-aos="fade-up">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>
                <?php if (!empty($images)): ?>
                    <div class="about-recognition-img">
                        <?php foreach ($images as $item):
                            $image_id = $item['logo'] ?? '';
                            $image_url = wp_get_attachment_image_url($image_id, 'full');
                            $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                            ?>
                            <?php if ($image_url): ?>
                                <img src="<?php echo esc_url($image_url); ?>"
                                    alt="<?php echo esc_attr($alt_text ?: 'Recognition Logo'); ?>" data-aos="fade-up">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
<?php endif; ?>