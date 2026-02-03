<?php
/**
 * Template part: Insight details. Included by single-insights.php
 */
?>
<div class="insights-single-wrapper">
    <?php if (have_posts()):
        while (have_posts()):
            the_post();
            $author_id = get_the_author_meta('ID');
            $author_name = get_the_author_meta('display_name', $author_id);
            ?>

            <article class="insights-single-article">

                <!-- Featured Image -->
                <div class="insights-featured-image">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('full', array('class' => 'insights-hero-img', 'alt' => get_the_title())); ?>
                    <?php else: ?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/img/placeholder.jpg"
                            alt="No image" class="insights-hero-img">
                    <?php endif; ?>
                </div>

                <div class="insights-single-content-wrapper">

                    <!-- Category & Meta Info -->
                    <div class="insights-meta-info">
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'insights_category');
                        if ($terms && !is_wp_error($terms)) {
                            echo '<div class="insights-categories">';
                            foreach ($terms as $term) {
                                echo '<a href="' . esc_url(get_term_link($term)) . '" class="insights-category-tag">' . esc_html($term->name) . '</a>';
                            }
                            echo '</div>';
                        }
                        ?>
                        <div class="insights-date">
                            <?php echo esc_html(get_the_date('F j, Y')); ?>
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="insights-single-title"><?php the_title(); ?></h1>

                    <!-- Excerpt -->
                    <?php if (has_excerpt()): ?>
                        <div class="insights-excerpt"><?php the_excerpt(); ?></div>
                    <?php endif; ?>

                    <!-- Author Box -->
                    <div class="insights-author-box">
                        <div class="insights-author-image">
                            <?php
                            $author_custom_img = function_exists('carbon_get_the_post_meta') 
                                ? carbon_get_the_post_meta('insights_author_image') 
                                : '';
                            
                            if ($author_custom_img):
                                ?>
                                <img src="<?php echo esc_url($author_custom_img); ?>" 
                                    alt="<?php echo esc_attr($author_name); ?>" 
                                    class="insights-author-avatar">
                            <?php else:
                                echo get_avatar($author_id, 120, '', $author_name, array('class' => 'insights-author-avatar'));
                            endif;
                            ?>
                        </div>
                        <div class="insights-author-details">
                            <h4 class="insights-author-name">
                                <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="insights-author-link">
                                    <?php
                                    $custom_author_name = function_exists('carbon_get_the_post_meta') 
                                        ? carbon_get_the_post_meta('insights_author_name') 
                                        : '';
                                    
                                    echo esc_html($custom_author_name ?: $author_name);
                                    ?>
                                </a>
                            </h4>
                            <p class="insights-author-bio">
                                <?php
                                $custom_author_bio = function_exists('carbon_get_the_post_meta') 
                                    ? carbon_get_the_post_meta('insights_author_bio') 
                                    : '';
                                
                                if ($custom_author_bio):
                                    echo wp_kses_post($custom_author_bio);
                                else:
                                    echo wp_kses_post(get_the_author_meta('description', $author_id));
                                endif;
                                ?>
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Main Content -->
                <div class="insights-main-content">
                    <?php the_content(); ?>
                </div>

                <!-- Related Posts by Author -->
                <div class="insights-related-author-posts">
                    <h3 class="insights-related-title">More from <?php echo esc_html($author_name); ?></h3>
                    <?php
                    $author_posts = new WP_Query(array(
                        'post_type' => 'insights',
                        'author' => $author_id,
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));

                    if ($author_posts->have_posts()): ?>
                        <div class="author-posts-grid">
                            <?php
                            while ($author_posts->have_posts()):
                                $author_posts->the_post();
                                ?>
                                <div class="author-post-card">
                                    <div class="author-post-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('medium', array('alt' => get_the_title()));
                                            } else {
                                                echo '<img src="' . esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg') . '" alt="No image">';
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <div class="author-post-info">
                                        <h4 class="author-post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <div class="author-post-date">
                                            <?php echo esc_html(get_the_date('F j, Y')); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif;
                    wp_reset_postdata(); ?>
                </div>

            </article>

        <?php endwhile;
    else: ?>
        <div class="insights-not-found">
            <h2>Insight not found</h2>
            <p>Sorry, the requested insight could not be found.</p>
        </div>
    <?php endif; ?>
</div>
