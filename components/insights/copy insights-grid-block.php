<?php
/**
 * Insights Grid Block Component with Category Tabs
 * Displays insights posts with category tabs
 */

$grid_title = get_query_var('insights_grid_title', 'Our Insights');
$grid_layout = get_query_var('insights_grid_layout', '3');

// Define categories
$categories = array(
    'insights' => 'Insights',
    'news-and-events' => 'News & Events',
);

// Get posts for each category
$category_posts = array();
foreach ($categories as $slug => $name) {
    $args = array(
        'posts_per_page' => 6,
        'post_type' => 'insights',
        'tax_query' => array(
            array(
                'taxonomy' => 'insights_category',
                'field' => 'slug',
                'terms' => $slug,
            )
        ),
    );
    $category_posts[$slug] = new WP_Query($args);
}
?>

<div class="insights-grid-block-wrapper with-tabs">

    <?php if (!empty($grid_title)): ?>
        <h2 class="insights-grid-block-title"><?php echo esc_html($grid_title); ?></h2>
    <?php endif; ?>

    <!-- Category Tabs -->
    <div class="insights-tabs-container">
        <div class="insights-tabs">
            <?php
            $first = true;
            foreach ($categories as $slug => $name):
                $active = $first ? 'active' : '';
                ?>
                <button class="insights-tab <?php echo esc_attr($active); ?>" data-category="<?php echo esc_attr($slug); ?>">
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
            $posts_query = $category_posts[$slug];
            ?>

            <div class="insights-tab-content <?php echo esc_attr($active); ?>" data-category="<?php echo esc_attr($slug); ?>">
                <?php if ($posts_query->have_posts()): ?>

                    <div class="insights-grid-block insights-grid-cols-<?php echo esc_attr($grid_layout); ?>">
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

                <?php else: ?>

                    <div class="insights-no-posts">
                        <h3>No <?php echo esc_html($name); ?> found</h3>
                        <p>Sorry, there are no posts to display in this category.</p>
                    </div>

                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>

            <?php
            $first = false;
        endforeach;
        ?>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.insights-tab');
    const contents = document.querySelectorAll('.insights-tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // Remove active class from all tabs and contents
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.querySelector('.insights-tab-content[data-category="' + category + '"]').classList.add('active');
        });
    });
});
</script>

