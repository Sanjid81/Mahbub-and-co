<?php
/**
 * Insights Content Block Component
 * Renders custom content blocks on insights details pages
 */

$fields = get_query_var('insights_details_fields', []);
?>

<div class="insights-content-block">

    <?php if (!empty($fields['insights_content'])): ?>
        <div class="insights-main-text">
            <?php echo wp_kses_post($fields['insights_content']); ?>
        </div>
    <?php endif; ?>

    <?php
    if (!empty($fields['insights_sections']) && is_array($fields['insights_sections'])):
        foreach ($fields['insights_sections'] as $section):
            ?>
            <div class="insights-section">
                <?php if (!empty($section['section_title'])): ?>
                    <h3 class="insights-section-title">
                        <?php echo esc_html($section['section_title']); ?>
                    </h3>
                <?php endif; ?>

                <?php if (!empty($section['section_image'])): ?>
                    <div class="insights-section-image">
                        <img src="<?php echo esc_url($section['section_image']); ?>"
                            alt="<?php echo esc_attr($section['section_title'] ?? 'Section image'); ?>"
                            class="insights-section-img">
                    </div>
                <?php endif; ?>

                <?php if (!empty($section['section_content'])): ?>
                    <div class="insights-section-text">
                        <?php echo wp_kses_post($section['section_content']); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        endforeach;
    endif;
    ?>

</div>
