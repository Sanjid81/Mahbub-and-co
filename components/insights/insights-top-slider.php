<?php
/**
 * Template: Insights Top Slider (Dynamic from Insights posts)
 * Fixed version - variable names matched, better safety checks
 */

$query = get_query_var('slider_query');
$bg_id = get_query_var('slider_bg_id', 0);
$bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'full') : '';

// Safety: stop if no valid query or no posts
if (!$query || !$query->have_posts()) {
    
    return;
}
?>

<section class="insights-section" <?php if ($bg_url): ?>style="background-image: url('<?php echo esc_url($bg_url); ?>');" <?php endif; ?>>
    <div class="overlay"></div>
    <div class="container">
        <div class="header-row">
            <h2 class="heading-two">Insights</h2>
            <div class="insights-slider-buttons">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

        <div class="testimonials-slider" data-aos="fade-up">
            <div class="swiper">
                <div class="insights-swiper">
                    <div class="swiper-wrapper">

                        <?php while ($query->have_posts()):
                            $query->the_post(); ?>

                            <?php
                            $permalink = get_the_permalink();
                            $title = get_the_title();
                            $date = get_the_date('M j, Y');
                            $excerpt = has_excerpt() ? wp_trim_words(get_the_excerpt(), 18, '...') : '';
                            $author_name = get_the_author_meta('display_name');
                            ?>

                            <div class="swiper-slide">
                                <a href="<?php echo esc_url($permalink); ?>" class="testimonial-card-link">
                                    <div class="testimonial-card">

                                        <!-- Featured Image / Thumbnail -->
                                        <div class="card-thumbnail">
                                            <?php if (has_post_thumbnail()): ?>
                                                <?php the_post_thumbnail('medium_large', [
                                                    'class' => 'thumbnail-img',
                                                    'alt' => esc_attr($title)
                                                ]); ?>
                                            <?php else: ?>
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg'); ?>"
                                                    alt="No image" class="thumbnail-img">
                                            <?php endif; ?>
                                        </div>

                                        <!-- Quote icon -->
                                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M28.7916 25.8339C28.792 25.8146 28.7939 25.7954 28.7939 25.7767C28.8516 23.1057 28.0688 20.6818 26.1745 18.8199C24.5944 17.0406 22.3917 15.7459 19.8188 15.2823C13.9364 14.2224 8.34986 17.9073 7.34017 23.5121C6.33001 29.117 10.2792 34.5207 16.1602 35.5801C17.2369 35.7742 18.3038 35.8079 19.3345 35.701C20.2449 38.5431 16.515 44.7995 15.9867 45.7857C15.9169 45.9146 16.4508 45.8012 16.9674 45.4112C23.2627 40.6524 28.6177 32.4896 28.7916 25.8339Z"
                                                stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                                            <path
                                                d="M53.401 25.8339C53.4014 25.8146 53.4033 25.7954 53.4033 25.7767C53.461 23.1057 52.6782 20.6818 50.7839 18.8199C49.2038 17.0406 47.0007 15.7459 44.4277 15.2823C38.5453 14.2224 32.9597 17.9073 31.9496 23.5121C30.9394 29.117 34.8882 34.5207 40.7691 35.5801C41.8467 35.7742 42.9132 35.8079 43.9439 35.701C44.8547 38.5431 41.1239 44.7995 40.5957 45.7857C40.5263 45.9146 41.0597 45.8012 41.5763 45.4112C47.8721 40.6524 53.2271 32.4896 53.401 25.8339Z"
                                                stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                                        </svg>

                                        <!-- Title -->
                                        <h3 class="heading-four title"><?php echo esc_html($title); ?></h3>

                                        <!-- Date -->
                                        <p class="meta-date body-text-three"><?php echo esc_html($date); ?></p>

                                        <!-- Excerpt (optional) -->
                                        <?php if ($excerpt): ?>
                                            <p class="body-text-three excerpt"><?php echo esc_html($excerpt); ?></p>
                                        <?php endif; ?>

                                        <!-- Author (optional) -->
                                        <?php if ($author_name): ?>
                                            <p class="body-text-three author">By <?php echo esc_html($author_name); ?></p>
                                        <?php endif; ?>

                                    </div>
                                </a>
                            </div>

                        <?php endwhile; ?>

                    </div>
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>