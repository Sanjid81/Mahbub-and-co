<?php
/**
 * Helper functions to ensure insights categories exist
 */

// Ensure categories exist on theme activation
add_action('init', 'ensure_insights_categories_exist', 5);

function ensure_insights_categories_exist() {
    // Check and create Insights category
    if (!term_exists('Insights', 'insights_category')) {
        wp_insert_term('Insights', 'insights_category', array(
            'slug' => 'insights',
            'description' => 'Insights articles and thought leadership'
        ));
    }

    // Check and create News and Events category
    if (!term_exists('News and Events', 'insights_category')) {
        wp_insert_term('News and Events', 'insights_category', array(
            'slug' => 'news-and-events',
            'description' => 'News and events'
        ));
    }
}

// That's it! Posts will now work with categories normally.
// Just assign categories to posts from the editor, and they'll show in the correct tabs.
?>


