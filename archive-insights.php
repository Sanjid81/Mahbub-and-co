<?php
get_header();

// === Insights Top Slider (Featured section) ===
$slider_fields = [
    'background_image' => 0,                    // change to an attachment ID if you want a background image
    'heading' => 'Featured Insights',  // customize as needed
    'slides_count' => 5,                    // how many posts to show in slider
    'insights_category' => '',                   // '' = all categories, or use 'insights' / 'news-and-events'
];

set_query_var('insights_slider_fields', $slider_fields);
get_template_part('components/insights/insights-top-slider');

// === Insights Grid / Archive Content ===
set_query_var('insights_grid_title', 'Our Insights');
set_query_var('insights_posts_per_page', -1);     // -1 = show all (or set to 9, 12, etc.)
set_query_var('insights_category_filter', '');    // '' = show tabs for all categories
set_query_var('insights_grid_layout', '3');       // 2, 3 or 4 columns
set_query_var('show_load_more', true);            // enable "Load More" button

get_template_part('components/insights/insights-content-block');

get_footer();