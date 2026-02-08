<?php
/**
 * Insights Grid Component
 * Displays insights posts in a grid layout with images
 */

// Get arguments
$args = array_merge(array(
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_type' => 'insights',
    'paged' => get_query_var('paged') ?: 1,
), $args ?? array());

$insights_query = new WP_Query($args);
?>

<div class="insights-grid-container">

    <?php if ($insights_query->have_posts()): ?>

        <div class="insights-posts-grid">
            <?php
            while ($insights_query->have_posts()):
                $insights_query->the_post();
                $author_id = get_the_author_meta('ID');
                $author_name = get_the_author_meta('display_name', $author_id);
                ?>

                <div class="insights-card">
                    <!-- Card Image -->
                    <div class="insights-card-image">
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium', array(
                                    'class' => 'insights-card-img',
                                    'alt' => get_the_title()
                                ));
                            } else {
                                echo '<img src="' . esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg') . '" alt="No image" class="insights-card-img">';
                            }
                            ?>
                        </a>

                        <!-- Category Badge -->
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'insights_category');
                        if ($terms && !is_wp_error($terms)) {
                            echo '<div class="insights-card-category">';
                            echo '<span class="category-badge">' . esc_html($terms[0]->name) . '</span>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <!-- Card Content -->
                    <div class="insights-card-content">
                        <h3 class="insights-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <div class="insights-card-meta">
                            <span class="insights-card-date">
                                <?php echo esc_html(get_the_date('M j, Y')); ?>
                            </span>
                        </div>

                        <!-- Author Box in Card -->
                        <div class="insights-card-author">
                            <div class="insights-card-author-image">
                                <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                    <?php
                                    $author_img = function_exists('carbon_get_the_post_meta') 
                                        ? carbon_get_the_post_meta('insights_author_image') 
                                        : '';
                                    
                                    if ($author_img):
                                        echo '<img src="' . esc_url($author_img) . '" alt="' . esc_attr($author_name) . '" class="insights-card-author-avatar">';
                                    else:
                                        echo get_avatar($author_id, 40, '', $author_name, array('class' => 'insights-card-author-avatar'));
                                    endif;
                                    ?>
                                </a>
                            </div>
                            <div class="insights-card-author-info">
                                <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="insights-card-author-name">
                                    <?php
                                    $custom_name = function_exists('carbon_get_the_post_meta') 
                                        ? carbon_get_the_post_meta('insights_author_name') 
                                        : '';
                                    
                                    echo esc_html($custom_name ?: $author_name);
                                    ?>
                                </a>
                            </div>
                        </div>

                        <a href="<?php the_permalink(); ?>" class="insights-card-link">Read More</a>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php
        $pagination = paginate_links(array(
            'total' => $insights_query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'format' => get_pagenum_link(1) . '%#%',
            'echo' => false,
        ));

        if ($pagination) {
            echo '<div class="insights-pagination">' . wp_kses_post($pagination) . '</div>';
        }
        ?>

    <?php else: ?>

        <div class="insights-no-posts">
            <h3>No insights found</h3>
            <p>Sorry, there are no insights to display at this time.</p>
        </div>

    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

</div>
