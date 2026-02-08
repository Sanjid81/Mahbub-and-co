<?php
/**
 * insights-content-block.php
 */

$fields = get_query_var('insights_details_fields', array());

if (empty($fields)) {
    echo '<p>No custom content available.</p>';
    return;
}
?>

<div class="insights-details-content">

    <?php if (!empty($fields['insights_content'])): ?>
        <div class="insights-main-content">
            <?php echo apply_filters('the_content', $fields['insights_content']); ?>
        </div>
    <?php endif; ?>

   

</div>