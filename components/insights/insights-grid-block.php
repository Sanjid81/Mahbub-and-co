<?php
/**
 * Archive template for insights post type with dynamic category tabs
 */
get_header();
?>

<div class="insights-archive-section">

    <?php
    // ────────────────────────────────────────────────
    // Load categories dynamically from taxonomy
    // ────────────────────────────────────────────────
    $terms = get_terms([
        'taxonomy' => 'insights_category',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ]);

    $categories = [];

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $categories[$term->slug] = $term->name;
        }
    }

    // Fallback if no categories exist at all
    if (empty($categories)) {
        $categories = [
            'insights' => 'Insights',
            'news-and-events' => 'News & Events',
        ];
    }
    ?>

    <?php if (!empty($categories)): ?>
        <div class="container">

            <div class="insights-page-section">
                <!-- Category Tabs -->
                <div class="insights-tabs-container">
                    <div class="insights-tabs">
                        <?php
                        $first = true;
                        foreach ($categories as $slug => $name):
                            $active = $first ? 'active' : '';
                            ?>
                            <button class="insights-tab <?php echo esc_attr($active); ?>"
                                data-category="<?php echo esc_attr($slug); ?>">
                                <?php echo esc_html($name); ?>
                            </button>
                            <?php
                            $first = false;
                        endforeach;
                        ?>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div class="insights-tab-contents">
                    <?php
                    $first = true;
                    foreach ($categories as $slug => $name):
                        $active = $first ? 'active' : '';

                        $posts_query = new WP_Query([
                            'post_type' => 'insights',
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'tax_query' => [
                                [
                                    'taxonomy' => 'insights_category',
                                    'field' => 'slug',
                                    'terms' => $slug,
                                ],
                            ],
                        ]);
                        ?>

                        <div class="insights-tab-content <?php echo esc_attr($active); ?>"
                            data-category="<?php echo esc_attr($slug); ?>">
                            <?php if ($posts_query->have_posts()): ?>

                                <div class="insights-posts-grid">
                                    <?php
                                    while ($posts_query->have_posts()):
                                        $posts_query->the_post();
                                        $author_id = get_the_author_meta('ID');
                                        $author_name = get_the_author_meta('display_name', $author_id);
                                        ?>

                                        <div class="insights-card">
                                            <!-- Card Image -->
                                            <div class="insights-card-image">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php
                                                    if (has_post_thumbnail()) {
                                                        the_post_thumbnail('medium', [
                                                            'class' => 'insights-card-img',
                                                            'alt' => get_the_title()
                                                        ]);
                                                    } else {
                                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg') . '" alt="No image" class="insights-card-img">';
                                                    }
                                                    ?>
                                                </a>

                                                <!-- Category Badge -->

                                            </div>

                                            <!-- Card Content -->
                                            <div class="insights-card-content">

                                                <div class="insights-card-meta">
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
                                                    <span class="insights-card-date">
                                                        <?php echo esc_html(get_the_date('M j, Y')); ?>
                                                    </span>
                                                </div>
                                                <h3 class="insights-card-title">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>

                                                <!-- Excerpt / Short Description -->
                                                <?php if (has_excerpt()): ?>
                                                    <div class="insights-card-excerpt">
                                                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Author Box in Card -->

                                                <a href="<?php the_permalink(); ?>" class="insights-card-link">Read More</a>
                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                </div>

                            <?php else: ?>

                                <div class="insights-no-posts">
                                    <h3>No
                                        <?php echo esc_html($name); ?> found
                                    </h3>
                                    <p>Sorry, there are no posts to display in this category.</p>
                                </div>

                            <?php endif; ?>

                            <?php wp_reset_postdata(); ?>
                        </div>

                        <?php $first = false; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="insights-no-categories">
            <h2>No insight categories found</h2>
            <p>Please create some categories in Insights → Categories.</p>
        </div>

    <?php endif; ?>

</div>



<?php
get_footer();