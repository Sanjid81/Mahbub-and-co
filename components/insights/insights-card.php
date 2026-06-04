<?php
/**
 * Single insight card for grid listings and AJAX load more.
 */
defined('ABSPATH') || exit;
?>
<div class="insights-card">
    <div class="insights-card-image">
        <a href="<?php the_permalink(); ?>">
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('medium', [
                    'class' => 'insights-card-img',
                    'alt' => get_the_title(),
                ]);
            } else {
                echo '<img src="' . esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg') . '" alt="No image" class="insights-card-img">';
            }
            ?>
        </a>
    </div>

    <div class="insights-card-content">
        <div class="insights-card-meta">
            <?php
            $terms = get_the_terms(get_the_ID(), 'category');
            if ($terms && !is_wp_error($terms) && !empty($terms)) {
                echo '<span class="category-badge meta-category">' . esc_html($terms[0]->name) . '</span>';
            }
            ?>

            <div class="circle"></div>

            <?php
            $custom_date = function_exists('carbon_get_the_post_meta')
                ? carbon_get_the_post_meta('insights_custom_publish_date')
                : '';

            if ($custom_date) {
                $display_date = date('M j, Y', strtotime($custom_date));
            } else {
                $display_date = get_the_date('M j, Y');
            }
            ?>
            <span class="insights-card-date">
                <?php echo esc_html($display_date); ?>
            </span>
        </div>

        <h3 class="insights-card-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <?php if (has_excerpt()): ?>
            <div class="insights-card-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
            </div>
        <?php endif; ?>

        <div class="insights-card-details-button">
            <a href="<?php the_permalink(); ?>" class="insights-card-link">Read More <svg
                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1787_525)">
                        <path
                            d="M12.1727 11.9998L9.34375 9.17184L10.7577 7.75684L15.0007 11.9998L10.7577 16.2428L9.34375 14.8278L12.1727 11.9998Z"
                            fill="#BC001A" />
                    </g>
                    <defs>
                        <clipPath id="clip0_1787_525">
                            <rect width="24" height="24" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </a>
        </div>
    </div>
</div>
