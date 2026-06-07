<?php
/**
 * Template: Custom Author Insights Page
 * URL: /insights-author/author-slug/
 */

get_header();

$author_slug = get_query_var('insights_author_slug');

if (empty($author_slug)) {
    echo '<div style="padding:3rem;text-align:center;color:red;">No author slug found in URL.</div>';
    get_footer();
    exit;
}

$author_image = '';
$author_bio = '';
$fb_link = '';
$li_link = '';
$found = false;
$author_name = '';

$author = get_user_by('slug', $author_slug);

if ($author) {
    $found = true;
    $author_name = $author->display_name;
    $author_bio = get_the_author_meta('description', $author->ID);
    
    $author_image_id = carbon_get_user_meta($author->ID, 'user_image');
    if ($author_image_id) {
        $author_image = wp_get_attachment_image_url($author_image_id, 'medium');
        if (!$author_image) {
            $author_image = wp_get_attachment_url($author_image_id);
        }
    }
    
    $fb_link = carbon_get_user_meta($author->ID, 'user_facebook_link');
    $li_link = carbon_get_user_meta($author->ID, 'user_linkedin_link');
}

// Get posts by this author
$author_posts = [];
if ($found) {
    $author_posts_query = new WP_Query([
        'post_type' => 'post',
        'author' => $author->ID,
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    ]);

    if ($author_posts_query->have_posts()) {
        while ($author_posts_query->have_posts()) {
            $author_posts_query->the_post();
            $author_posts[] = get_post();
        }
        wp_reset_postdata();
    }
}
?>

<div class="author-details-page">
    <div class="container">
        <div class="button-wraper">
            <button class="back-btn" onclick="history.back()">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.4693 6.99962C12.4693 7.17366 12.4001 7.34058 12.2771 7.46365C12.154 7.58672 11.9871 7.65587 11.813 7.65587H3.77396L6.59145 10.4728C6.71474 10.5961 6.784 10.7633 6.784 10.9377C6.784 11.112 6.71474 11.2792 6.59145 11.4025C6.46817 11.5258 6.30096 11.5951 6.12661 11.5951C5.95226 11.5951 5.78505 11.5258 5.66177 11.4025L1.72427 7.46501C1.66309 7.40404 1.61454 7.33159 1.58142 7.25182C1.5483 7.17206 1.53125 7.08653 1.53125 7.00016C1.53125 6.91379 1.5483 6.82827 1.58142 6.7485C1.61454 6.66873 1.66309 6.59629 1.72427 6.53532L5.66177 2.59782C5.72281 2.53677 5.79528 2.48835 5.87504 2.45531C5.9548 2.42228 6.04028 2.40527 6.12661 2.40527C6.21294 2.40527 6.29843 2.42228 6.37818 2.45531C6.45794 2.48835 6.53041 2.53677 6.59145 2.59782C6.6525 2.65886 6.70092 2.73133 6.73396 2.81109C6.767 2.89085 6.784 2.97633 6.784 3.06266C6.784 3.14899 6.767 3.23448 6.73396 3.31423C6.70092 3.39399 6.6525 3.46646 6.59145 3.52751L3.77396 6.34337H11.813C11.9871 6.34337 12.154 6.41251 12.2771 6.53558C12.4001 6.65865 12.4693 6.82557 12.4693 6.99962Z"
                        fill="black" />
                </svg>

                Back </button>
        </div>

        <div class="author-details-page-wraper">

            <?php if ($found): ?>

                <!-- ================= AUTHOR HEADER ================= -->
                <div class="author-header">
                    <div class="author-info-wrapper">
                            <?php if ($author_image): ?>
                            <div class="author-avatar-container">
                                <img src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr($author_name); ?>"
                                    class="author-avatar">
                            </div>
                            <?php endif; ?>

                        <div class="author-details">
                            <h1 class="author-page-title">
                                    <?php echo esc_html($author_name); ?>
                            </h1>

                                <?php if ($author_bio): ?>
                                <div class="author-bio">
                                            <?php echo wp_kses_post($author_bio); ?>
                                </div>
                            <?php else: ?>
                                <p style="color:#999;">No bio available</p>
                            <?php endif; ?>

                            <?php if ($fb_link || $li_link): ?>
                                <div class="author-social-links">
                                    <?php if ($fb_link): ?>
                                        <a href="<?php echo esc_url($fb_link); ?>" target="_blank" rel="noopener noreferrer"
                                            class="social-facebook">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M20.25 1.875H3.75C3.25272 1.875 2.77581 2.07254 2.42417 2.42417C2.07254 2.77581 1.875 3.25272 1.875 3.75V20.25C1.875 20.7473 2.07254 21.2242 2.42417 21.5758C2.77581 21.9275 3.25272 22.125 3.75 22.125H20.25C20.7473 22.125 21.2242 21.9275 21.5758 21.5758C21.9275 21.2242 22.125 20.7473 22.125 20.25V3.75C22.125 3.25272 21.9275 2.77581 21.5758 2.42417C21.2242 2.07254 20.7473 1.875 20.25 1.875ZM19.875 19.875H4.125V4.125H19.875V19.875ZM10.5 16.5V11.25C10.5002 11.0162 10.5733 10.7883 10.709 10.5979C10.8447 10.4076 11.0364 10.2642 11.2574 10.1878C11.4783 10.1114 11.7176 10.1058 11.9419 10.1716C12.1662 10.2375 12.3645 10.3716 12.5091 10.5553C13.0805 10.2558 13.7195 10.1088 14.3643 10.1284C15.0092 10.1481 15.6381 10.3338 16.1901 10.6676C16.7422 11.0014 17.1989 11.472 17.5159 12.0338C17.833 12.5957 17.9997 13.2299 18 13.875V16.5C18 16.7984 17.8815 17.0845 17.6705 17.2955C17.4595 17.5065 17.1734 17.625 16.875 17.625C16.5766 17.625 16.2905 17.5065 16.0795 17.2955C15.8685 17.0845 15.75 16.7984 15.75 16.5V13.875C15.75 13.4772 15.592 13.0956 15.3107 12.8143C15.0294 12.533 14.6478 12.375 14.25 12.375C13.8522 12.375 13.4706 12.533 13.1893 12.8143C12.908 13.0956 12.75 13.4772 12.75 13.875V16.5C12.75 16.7984 12.6315 17.0845 12.4205 17.2955C12.2095 17.5065 11.9234 17.625 11.625 17.625C11.3266 17.625 11.0405 17.5065 10.8295 17.2955C10.6185 17.0845 10.5 16.7984 10.5 16.5ZM9 11.25V16.5C9 16.7984 8.88147 17.0845 8.6705 17.2955C8.45952 17.5065 8.17337 17.625 7.875 17.625C7.57663 17.625 7.29048 17.5065 7.0795 17.2955C6.86853 17.0845 6.75 16.7984 6.75 16.5V11.25C6.75 10.9516 6.86853 10.6655 7.0795 10.4545C7.29048 10.2435 7.57663 10.125 7.875 10.125C8.17337 10.125 8.45952 10.2435 8.6705 10.4545C8.88147 10.6655 9 10.9516 9 11.25ZM6.375 7.5C6.375 7.20333 6.46297 6.91332 6.6278 6.66665C6.79262 6.41997 7.02689 6.22771 7.30097 6.11418C7.57506 6.00065 7.87666 5.97094 8.16764 6.02882C8.45861 6.0867 8.72588 6.22956 8.93566 6.43934C9.14544 6.64912 9.2883 6.91639 9.34618 7.20736C9.40406 7.49834 9.37435 7.79994 9.26082 8.07403C9.14729 8.34811 8.95503 8.58238 8.70835 8.7472C8.46168 8.91203 8.17167 9 7.875 9C7.47718 9 7.09564 8.84196 6.81434 8.56066C6.53304 8.27936 6.375 7.89782 6.375 7.5Z"
                                                    fill="#BC001A" />
                                            </svg>

                                        </a>
                                    <?php endif; ?>
                                    <?php if ($li_link): ?>
                                        <a href="<?php echo esc_url($li_link); ?>" target="_blank" rel="noopener noreferrer"
                                            class="social-linkedin">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21.6244 8.06221L12.6244 2.06222C12.4395 1.93887 12.2222 1.87305 12 1.87305C11.7778 1.87305 11.5605 1.93887 11.3756 2.06222L2.37563 8.06221C2.22138 8.16512 2.09497 8.30456 2.00763 8.46812C1.92029 8.63168 1.87473 8.81429 1.875 8.99971V18.7497C1.875 19.247 2.07255 19.7239 2.42418 20.0755C2.77581 20.4272 3.25272 20.6247 3.75 20.6247H20.25C20.7473 20.6247 21.2242 20.4272 21.5758 20.0755C21.9275 19.7239 22.125 19.247 22.125 18.7497V8.99971C22.1253 8.81429 22.0797 8.63168 21.9924 8.46812C21.905 8.30456 21.7786 8.16512 21.6244 8.06221ZM8.41969 14.2497L4.125 17.2788V11.185L8.41969 14.2497ZM10.7213 15.3747H13.2788L17.5313 18.3747H6.47344L10.7213 15.3747ZM15.5803 14.2497L19.875 11.1832V17.2769L15.5803 14.2497ZM12 4.35159L19.0181 9.03065L13.2759 13.1247H10.7241L4.98188 9.03065L12 4.35159Z"
                                                    fill="#BC001A" />
                                            </svg>

                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <h2 class="section-title">Published Insights</h2>

                <?php if (!empty($author_posts)): ?>
                    <div class="insights-posts-grid">
                        <?php foreach ($author_posts as $post): ?>
                            <?php setup_postdata($post); ?>
                            <div class="insights-card">
                                <div class="insights-card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        if (has_post_thumbnail()) {
                                            the_post_thumbnail('medium', ['class' => 'insights-card-img', 'alt' => get_the_title()]);
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
                                        <span class="insights-card-date">
                                            <?php
                                            $custom_date = carbon_get_the_post_meta('insights_custom_publish_date');
                                            echo esc_html($custom_date ? date('M j, Y', strtotime($custom_date)) : get_the_date('M j, Y'));
                                            ?>
                                        </span>
                                    </div>

                                    <h3 class="insights-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No insights found from this author.</p>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

            <?php else: ?>
                <div style="padding:4rem 2rem; text-align:center; color:#c0392b;">
                    <h2>Author Not Found</h2>
                    <p>No information found for "<?php echo esc_html($author_name); ?>".</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>