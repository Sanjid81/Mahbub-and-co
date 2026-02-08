<?php
$fields = get_query_var('insights_slider_fields', []);
$heading = !empty($fields['heading'])
    ? $fields['heading']
    : 'Featured Insights';
$bg_id = $fields['background_image'] ?? 0;
$count = !empty($fields['slides_count']) ? (int) $fields['slides_count'] : 5;
$cat = $fields['insights_category'] ?? '';
$bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'full') : '';

// WP_Query args
$args = [
    'post_type' => 'insights',
    'posts_per_page' => $count,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'ignore_sticky_posts' => true,
];

if (!empty($cat)) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'insights_category',
            'field' => 'slug',
            'terms' => [$cat],
        ],
    ];
}

$query = new WP_Query($args);
?>

<section class="insights-slider-section" <?php if ($bg_url)
    echo "style='background-image:url({$bg_url});'"; ?>>
    <div class="overlay"></div>
    <div class="container">
        <div class="header-row">
            <h2 class="heading-one"><?php echo esc_html($heading); ?></h2>

            <div class="insights-slider-buttons">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

        <?php if ($query->have_posts()): ?>
            <div class="insights-slider">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php while ($query->have_posts()):
                            $query->the_post(); ?>
                            <div class="swiper-slide">
                                <a href="<?php the_permalink(); ?>" class="insight-card-link">
                                    <div class="insight-card">
                                        <div class="card-thumbnail">
                                            <?php if (has_post_thumbnail()): ?>
                                                <?php the_post_thumbnail('medium_large', ['class' => 'thumbnail-img', 'alt' => get_the_title()]); ?>
                                            <?php else: ?>
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg'); ?>"
                                                    alt="No image" class="thumbnail-img">
                                            <?php endif; ?>
                                        </div>
                                        <div class="insights-slider-card-content">
                                            <div class="insights-slider-card-meta">
                                                <?php
                                                // Category Badge
                                                $terms = get_the_terms(get_the_ID(), 'insights_category');
                                                if ($terms && !is_wp_error($terms) && !empty($terms)) {
                                                    $first_term = $terms[0];
                                                    echo '<span class="category-badge meta-category">' . esc_html($first_term->name) . '</span>';
                                                    echo ' • ';

                                                }
                                                ?>

                                                <!-- Date -->
                                                <span class="insights-slider-card-date">
                                                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                                                </span>
                                            </div>
                                            <h3 class="insight-title"><?php the_title(); ?>
                                            </h3>



                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align:center; color:red;">No insights found!</p>
        <?php endif; ?>
    </div>
</section>

<?php wp_reset_postdata(); ?>