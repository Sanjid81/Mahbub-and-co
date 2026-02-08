<?php
get_header();

set_query_var('insights_grid_title', 'Our Insights');
set_query_var('insights_posts_per_page', -1);     // all posts
set_query_var('insights_category_filter', '');    // all categories → tabs
set_query_var('insights_grid_layout', '3');
set_query_var('show_load_more', true);

get_template_part('components/insights/insights-content-block');

get_footer();