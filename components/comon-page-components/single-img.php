<?php
$image_id = $fields['single_image'] ?? '';

if (!$image_id)
    return;

$image_url = wp_get_attachment_image_url($image_id, 'full'); // get image URL
$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
?>

<div class="single-img-container">
       <div class="img-wraper">
         <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>"
            class="object-cover max-w-full h-auto">
       </div>
</div>