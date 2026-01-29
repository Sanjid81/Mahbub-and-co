<?php
$content = get_query_var('custom_content', '');
?>
<section class="about-details-text">
    <div class="container">
        <div class="about-details-content">
            <?php echo wp_kses_post($content); ?>
        </div>
    </div>
</section>