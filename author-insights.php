<?php
/**
 * Template: Custom Author Insights Page
 * URL pattern: /author/custom-author-slug/
 */

get_header();

$author_slug = get_query_var('insights_author_slug');

if (empty($author_slug)) {
    echo '<div class="container"><h2>Author not found</h2><p>No author slug provided in URL.</p></div>';
    get_footer();
    exit;
}

// Slug থেকে নাম বের করা
$author_name = trim(str_replace('-', ' ', urldecode($author_slug)));
$author_name_lower = strtolower($author_name); // case insensitive match এর জন্য

// Debug Info
echo '<div style="background: #fff3cd; padding: 20px; border: 1px solid #ffeeba; margin: 20px 0;">';
echo '<strong>Debug: Author Page</strong><br>';
echo 'URL Slug: ' . esc_html($author_slug) . '<br>';
echo 'Converted Name: ' . esc_html($author_name) . ' (lowercase: ' . esc_html($author_name_lower) . ')<br><br>';

// Test query with LIKE + wildcard
$test_args = [
    'post_type' => 'insights',
    'posts_per_page' => 3, // ৩টা পোস্ট দেখাবে ডিবাগে
    'meta_query' => [
        [
            'key' => '_insights_author_name',
            'value' => '%' . $author_name . '%', // wildcard যোগ করা হলো
            'compare' => 'LIKE',
        ]
    ]
];
$test_query = new WP_Query($test_args);

echo 'Found Posts (LIKE wildcard): ' . $test_query->found_posts . '<br>';

if ($test_query->have_posts()) {
    echo 'Matching posts found:<br>';
    while ($test_query->have_posts()) {
        $test_query->the_post();
        echo '- Post Title: ' . esc_html(get_the_title()) . '<br>';
        echo '  Author Name in meta: ' . esc_html(carbon_get_the_post_meta('insights_author_name')) . '<br>';
    }
    wp_reset_postdata();
} else {
    echo 'No posts match this author name.<br>';
    echo 'Possible reasons:<br>';
    echo '1. No post has exactly this name in "insights_author_name" field<br>';
    echo '2. Name has extra space, capital letters difference, or typo<br>';
    echo '3. Field name is wrong (must be _insights_author_name)';
}
echo '</div>';
?>

<div class="author-details-page container">

    <!-- Author Header -->
    <div class="author-header">
        <?php
        $args = [
            'post_type' => 'insights',
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => '_insights_author_name',
                    'value' => '%' . $author_name . '%',
                    'compare' => 'LIKE',
                ]
            ]
        ];

        $query = new WP_Query($args);

        $author_image = '';
        $author_bio = '';

        if ($query->have_posts()) {
            $query->the_post();
            $author_image = carbon_get_the_post_meta('insights_author_image');
            $author_bio = carbon_get_the_post_meta('insights_author_bio');
            wp_reset_postdata();
        }
        ?>

        <?php if ($author_image): ?>
            <img src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr($author_name); ?>"
                class="author-avatar-large">
        <?php endif; ?>

        <h1 class="author-page-title"><?php echo esc_html($author_name); ?></h1>

        <?php if ($author_bio): ?>
            <div class="author-bio"><?php echo wp_kses_post($author_bio); ?></div>
        <?php endif; ?>
    </div>

    <!-- Author's All Insights -->
    <h2 class="section-title">All Insights by <?php echo esc_html($author_name); ?></h2>

    <?php
    $posts_args = [
        'post_type' => 'insights',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => '_insights_author_name',
                'value' => '%' . $author_name . '%',
                'compare' => 'LIKE',
            ]
        ],
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    $posts_query = new WP_Query($posts_args);

    if ($posts_query->have_posts()): ?>
        <div class="insights-grid">
            <?php while ($posts_query->have_posts()):
                $posts_query->the_post(); ?>
                <div class="insights-card">
                    <?php if (has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                        </a>
                    <?php endif; ?>

                    <div class="insights-card-content">
                        <h3 class="insights-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <?php if (has_excerpt()): ?>
                            <p class="insights-card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </p>
                        <?php endif; ?>

                        <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php wp_reset_postdata(); ?>

    <?php else: ?>
        <p>No insights found from this author. (Check if posts have exact author name set in meta)</p>
    <?php endif; ?>

</div>

<?php get_footer(); ?>