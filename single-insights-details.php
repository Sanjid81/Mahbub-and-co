<?php
/**
 * Template part: Insight Single Details
 * Included by single-insights.php
 */
?>

<div class="insights-single-page">
    <div class="insights-single-wrapper">
        <button class="back-btn" onclick="history.back()">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.4693 6.99962C12.4693 7.17366 12.4001 7.34058 12.2771 7.46365C12.154 7.58672 11.9871 7.65587 11.813 7.65587H3.77396L6.59145 10.4728C6.71474 10.5961 6.784 10.7633 6.784 10.9377C6.784 11.112 6.71474 11.2792 6.59145 11.4025C6.46817 11.5258 6.30096 11.5951 6.12661 11.5951C5.95226 11.5951 5.78505 11.5258 5.66177 11.4025L1.72427 7.46501C1.66309 7.40404 1.61454 7.33159 1.58142 7.25182C1.5483 7.17206 1.53125 7.08653 1.53125 7.00016C1.53125 6.91379 1.5483 6.82827 1.58142 6.7485C1.61454 6.66873 1.66309 6.59629 1.72427 6.53532L5.66177 2.59782C5.72281 2.53677 5.79528 2.48835 5.87504 2.45531C5.9548 2.42228 6.04028 2.40527 6.12661 2.40527C6.21294 2.40527 6.29843 2.42228 6.37818 2.45531C6.45794 2.48835 6.53041 2.53677 6.59145 2.59782C6.6525 2.65886 6.70092 2.73133 6.73396 2.81109C6.767 2.89085 6.784 2.97633 6.784 3.06266C6.784 3.14899 6.767 3.23448 6.73396 3.31423C6.70092 3.39399 6.6525 3.46646 6.59145 3.52751L3.77396 6.34337H11.813C11.9871 6.34337 12.154 6.41251 12.2771 6.53558C12.4001 6.65865 12.4693 6.82557 12.4693 6.99962Z"
                    fill="black" />
            </svg>

            Back </button>
        <div class="insights-single-container">
            <?php if (have_posts()): ?>
                <?php while (have_posts()):
                    the_post(); ?>

                    <?php
                    // Author Info
                    $author_id = get_the_author_meta('ID');
                    $author_name = get_the_author_meta('display_name', $author_id);
                    $author_link = get_author_posts_url($author_id);

                    // Custom Author Fields (Carbon)
                    $custom_author_name = carbon_get_the_post_meta('insights_author_name') ?: '';
                    $custom_author_bio = carbon_get_the_post_meta('insights_author_bio') ?: '';
                    $custom_author_image = carbon_get_the_post_meta('insights_author_image') ?: '';

                    // Custom author link (using slug)
                    $custom_author_slug = sanitize_title($custom_author_name ?: $author_name);
                    $custom_author_link = home_url('/author/' . $custom_author_slug);
                    ?>

                    <article class="insights-single-article">




                        <div class="insights-hero-content">
                            <!-- Meta: Category + Date + Social Links -->
                            <div class="insights-details-card-meta">
                                <!-- Category -->
                                <div class="category-badge-and-date">
                                    <?php
                                    $terms = get_the_terms(get_the_ID(), 'insights_category');
                                    if ($terms && !is_wp_error($terms) && !empty($terms)) {
                                        echo '<span class="category-badge meta-category">' . esc_html($terms[0]->name) . '</span>';
                                    }
                                    ?>

                                    <div class="circle"></div>

                                    <!-- Date (Custom or Default) -->
                                    <?php
                                    $custom_date = carbon_get_the_post_meta('insights_custom_publish_date');
                                    $display_date = $custom_date ? date('M j, Y', strtotime($custom_date)) : get_the_date('M j, Y');
                                    ?>
                                    <span class="insights-card-date">
                                        <?php echo esc_html($display_date); ?>
                                    </span>
                                </div>

                                <!-- Social Media Links (SVG always shown; link from backend URL if set) -->
                                <?php
                                $fb_link = carbon_get_the_post_meta('insights_facebook_link');
                                $li_link = carbon_get_the_post_meta('insights_linkedin_link');
                                $fb_url = is_string($fb_link) && $fb_link !== '' ? esc_url($fb_link) : '';
                                $li_url = is_string($li_link) && $li_link !== '' ? esc_url($li_link) : '';
                                ?>
                                <div class="social-media-links-container">
                                    <span>SHARE</span>
                                    <div class="social-media-links">
                                        <?php if ($fb_url): ?>
                                            <a href="<?php echo $fb_url; ?>" target="_blank" rel="noopener noreferrer"
                                                class="social-icon social-facebook" title="Facebook">
                                            <?php else: ?>
                                                <span class="social-icon social-facebook" title="Facebook" aria-hidden="true">
                                                <?php endif; ?>
                                                <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="black"
                                                        stroke-opacity="0.1" />
                                                    <path
                                                        d="M23.1598 20.0485L23.6556 16.8155H20.5537V14.7175C20.5537 13.833 20.987 12.9709 22.3764 12.9709H23.7867V10.2185C23.7867 10.2185 22.5068 10 21.2831 10C18.7283 10 17.0586 11.5484 17.0586 14.3515V16.8155H14.2188V20.0485H17.0586V27.8641C17.628 27.9535 18.2116 28 18.8061 28C19.4007 28 19.9843 27.9535 20.5537 27.8641V20.0485H23.1598Z"
                                                        fill="black" fill-opacity="0.6" />
                                                </svg>
                                                <?php if ($fb_url): ?></a><?php else: ?></span><?php endif; ?>

                                        <?php if ($li_url): ?>
                                            <a href="<?php echo $li_url; ?>" target="_blank" rel="noopener noreferrer"
                                                class="social-icon social-linkedin" title="LinkedIn">
                                            <?php else: ?>
                                                <span class="social-icon social-linkedin" title="LinkedIn" aria-hidden="true">
                                                <?php endif; ?>
                                                <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="black"
                                                        stroke-opacity="0.1" />
                                                    <g clip-path="url(#clip0_927_13025)">
                                                        <path
                                                            d="M28 20.9445V27.5988H24.1414V21.3923C24.1414 19.8313 23.5847 18.7683 22.1869 18.7683C21.1197 18.7683 20.4878 19.484 20.2074 20.1787C20.107 20.4256 20.0777 20.773 20.0777 21.1203V27.603H16.219C16.219 27.603 16.2692 17.0859 16.219 15.9978H20.0777V17.6425C20.0693 17.6551 20.0609 17.6676 20.0525 17.6802H20.0777V17.6425C20.5924 16.8515 21.5048 15.7258 23.5555 15.7258C26.0958 15.7216 28 17.383 28 20.9445ZM12.1846 10.4023C10.8621 10.4023 10 11.2687 10 12.407C10 13.5202 10.837 14.4116 12.1344 14.4116H12.1595C13.5071 14.4116 14.3441 13.5202 14.3441 12.407C14.3148 11.2687 13.5029 10.4023 12.1846 10.4023ZM10.2302 27.603H14.0888V15.9936H10.2302V27.603Z"
                                                            fill="black" fill-opacity="0.6" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_927_13025">
                                                            <rect width="18" height="18" fill="white"
                                                                transform="translate(10 10)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                <?php if ($li_url): ?></a><?php else: ?></span><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <h1 class="insights-single-title">
                                <?php the_title(); ?>
                            </h1>


                        </div>

                        <div class="insights-single-content-wrapper-container">
                            <div class="insights-authors-section">
                                <?php
                                $authors = carbon_get_the_post_meta('insights_authors') ?: [];
                                if (!empty($authors)): ?>
                                    <span>Author<?php echo (count($authors) > 1) ? 's' : ''; ?> :</span>
                                    <div class="authors-grid">
                                        <?php foreach ($authors as $author):
                                            $name = trim($author['author_name'] ?? 'Unknown Author');
                                            $image = $author['author_image'] ?? '';
                                            $bio = $author['author_bio'] ?? '';

                                            $author_slug = sanitize_title($name);
                                            $author_url = home_url('/insights-author/' . $author_slug . '/'); // 
                                            ?>
                                            <div class="author-card">
                                                <?php if ($image): ?>
                                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>"
                                                        class="author-avatar">
                                                <?php endif; ?>

                                                <h4 class="author-name">
                                                    <a href="<?php echo esc_url($author_url); ?>" class="author-link">
                                                        <?php echo esc_html($name); ?>
                                                    </a>
                                                </h4>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Main Content -->
                            <div class="insights-main-content">
                                <?php the_content(); ?>
                            </div>
                        </div>

                    </article>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="insights-not-found">
                    <h2>Insight not found</h2>
                    <p>Sorry, the requested insight could not be found.</p>
                </div>
            <?php endif; ?>

        </div>




        <?php wp_reset_postdata(); ?>
    </div>
</div>





<div class="insights-bottom-slider-section">
    <?php
    // Get fields from query var (set by block or archive)
    $fields = get_query_var('insights_slider_fields', []);

    $heading = !empty($fields['heading']) ? $fields['heading'] : 'Featured Insights';
    $slides_count = !empty($fields['slides_count']) ? (int) $fields['slides_count'] : 5;
    $cat_slug = !empty($fields['insights_category']) ? $fields['insights_category'] : '';
    $bg_id = !empty($fields['background_image']) ? (int) $fields['background_image'] : 0;

    // Get background URL safely
    $bg_url = '';
    if ($bg_id > 0) {
        $bg_url = wp_get_attachment_image_url($bg_id, 'full');
        // Fallback: try large size if full fails
        if (!$bg_url) {
            $bg_url = wp_get_attachment_image_url($bg_id, 'large');
        }
    }

    // Debug output (remove later)
    if (!$bg_url && $bg_id > 0) {
        // Uncomment to debug
        echo "<!-- Debug: No bg url for ID {$bg_id} -->";
    }

    // WP_Query setup
    $args = [
        'post_type' => 'insights',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
    ];

    $query = new WP_Query($args);
    ?>

    <section class="insights-bottom-slider" <?php if ($bg_url): ?> style="background-image: url('
        <?php echo esc_url($bg_url); ?>');" <?php endif; ?>>
        <!-- <div class="overlay"></div> -->
        <div class="container">
            <div class="header-row">
                <h2 class="heading-two">Related Topics
                    <!-- < ?php echo esc_html($heading); ?> -->
                </h2>

                <!-- <div class="insights-slider-buttons">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div> -->
            </div>

            <?php if ($query->have_posts()): ?>
                <div class="insights-details-bottom-slider">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php while ($query->have_posts()):
                                $query->the_post(); ?>
                                <div class="swiper-slide">
                                    <div class="insights-card">
                                        <div class="insights-card-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if (has_post_thumbnail()): ?>
                                                    <?php the_post_thumbnail('medium', [
                                                        'class' => 'insights-card-img',
                                                        'alt' => get_the_title()
                                                    ]); ?>
                                                <?php else: ?>
                                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg'); ?>"
                                                        alt="No image" class="insights-card-img">
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                        <div class="insights-card-content">
                                            <div class="insights-card-meta">
                                                <?php
                                                $terms = get_the_terms(get_the_ID(), 'insights_category');
                                                if ($terms && !is_wp_error($terms)) {
                                                    echo '<span class="category-badge meta-category">' . esc_html($terms[0]->name) . '</span>';
                                                }
                                                ?>
                                                <div class="circle"></div>

                                                <?php
                                                $custom_date = carbon_get_the_post_meta('insights_custom_publish_date');
                                                $display_date = $custom_date
                                                    ? date('M j, Y', strtotime($custom_date))
                                                    : get_the_date('M j, Y');
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
                                                <a href="<?php the_permalink(); ?>" class="insights-card-link">
                                                    Read More
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12.1727 11.9998L9.34375 9.17184L10.7577 7.75684L15.0007 11.9998L10.7577 16.2428L9.34375 14.8278L12.1727 11.9998Z"
                                                            fill="#BC001A" />
                                                    </svg>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            <?php else: ?>
                <p style="text-align:center; color:#fff; background:rgba(0,0,0,0.5); padding:1rem;">
                    No insights found!
                </p>
            <?php endif; ?>
        </div>
    </section>
</div>