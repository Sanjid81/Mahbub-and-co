<?php
/**
 * Dynamic Google Map Block Template
 */

$fields = get_query_var('map_fields', []);
$attributes = get_query_var('map_attributes', []);

$iframe_raw = trim($fields['map_iframe'] ?? '');

if (empty($iframe_raw)) {
    echo '<div class="map-notice">No Google Maps iframe code added in block settings.</div>';
    return;
}

$allowed_tags = [
    'iframe' => [
        'src' => true,
        'width' => true,
        'height' => true,
        'style' => true,
        'allowfullscreen' => true,
        'loading' => true,
        'referrerpolicy' => true,
        'title' => true,
    ],
];

$safe_iframe = wp_kses($iframe_raw, $allowed_tags);

$block_class = !empty($attributes['className']) ? esc_attr($attributes['className']) : '';
?>

<div class="dynamic-google-map-block <?php echo $block_class; ?>">
    <div class="container">
        <div class="map-container">
            <?php echo $safe_iframe; ?>
        </div>
    </div>
</div>