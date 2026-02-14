<?php
/**
 * Job Opening details page: full card (same as listing) + content + Apply Now
 * All classes prefixed maco-opening-detail-* or reuse maco-openings-* for card.
 */
defined('ABSPATH') || exit;

if (!have_posts()) {
    return;
}

while (have_posts()) {
    the_post();
    $id = get_the_ID();
    $exp   = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_experience') : '';
    $loc   = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_location') : '';
    $typ   = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_type') : '';
    $dead  = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_deadline') : '';
    $apply_url  = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_apply_url') : '';
    $apply_text = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_apply_text') : 'Apply Now';
    $apply_link = $apply_url !== '' ? $apply_url : get_permalink($id);
    ?>
    <article class="maco-opening-detail" id="maco-opening-detail-<?php echo esc_attr($id); ?>">
        <div class="maco-opening-detail-inner">
            <!-- Full card: same info as listing (title + Experience, Location, Type, Deadline with icons) -->
            <div class="maco-opening-detail-card-wrap">
                <div class="maco-openings-card maco-opening-detail-full-card">
                    <h1 class="maco-openings-card-title maco-opening-detail-card-title"><?php the_title(); ?></h1>
                    <div class="maco-openings-card-meta">
                        <?php if ($exp !== ''): ?>
                            <span class="maco-openings-card-meta-item">
                                <span class="maco-openings-card-meta-icon" aria-hidden="true"><?php echo function_exists('maco_openings_icon_briefcase') ? maco_openings_icon_briefcase() : ''; ?></span>
                                <span class="maco-openings-card-meta-text"><?php echo esc_html__('Experience:', 'mahbub-and-co'); ?> <?php echo esc_html($exp); ?></span>
                            </span>
                        <?php endif; ?>
                        <?php if ($loc !== ''): ?>
                            <span class="maco-openings-card-meta-item">
                                <span class="maco-openings-card-meta-icon" aria-hidden="true"><?php echo function_exists('maco_openings_icon_pin') ? maco_openings_icon_pin() : ''; ?></span>
                                <span class="maco-openings-card-meta-text"><?php echo esc_html__('Location:', 'mahbub-and-co'); ?> <?php echo esc_html($loc); ?></span>
                            </span>
                        <?php endif; ?>
                        <?php if ($typ !== ''): ?>
                            <span class="maco-openings-card-meta-item">
                                <span class="maco-openings-card-meta-icon" aria-hidden="true"><?php echo function_exists('maco_openings_icon_briefcase') ? maco_openings_icon_briefcase() : ''; ?></span>
                                <span class="maco-openings-card-meta-text"><?php echo esc_html__('Type:', 'mahbub-and-co'); ?> <?php echo esc_html($typ); ?></span>
                            </span>
                        <?php endif; ?>
                        <?php if ($dead !== ''): ?>
                            <span class="maco-openings-card-meta-item">
                                <span class="maco-openings-card-meta-icon" aria-hidden="true"><?php echo function_exists('maco_openings_icon_calendar') ? maco_openings_icon_calendar() : ''; ?></span>
                                <span class="maco-openings-card-meta-text"><?php echo esc_html__('Deadline:', 'mahbub-and-co'); ?> <?php echo esc_html($dead); ?></span>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="maco-opening-detail-content">
                <?php
                $content = get_the_content(null, false, $id);
                if ($content !== '') {
                    echo apply_filters('the_content', $content);
                } else {
                    echo '<p class="maco-opening-detail-no-desc">' . esc_html__('No additional description for this opening.', 'mahbub-and-co') . '</p>';
                }
                ?>
            </div>

            <a href="<?php echo esc_url($apply_link); ?>" class="maco-opening-detail-apply-btn" target="<?php echo $apply_url !== '' ? '_blank' : '_self'; ?>" rel="<?php echo $apply_url !== '' ? 'noopener' : ''; ?>">
                <?php echo esc_html($apply_text); ?>
                <span class="maco-openings-apply-btn-arrow" aria-hidden="true"><?php echo function_exists('maco_openings_icon_arrow') ? maco_openings_icon_arrow() : ''; ?></span>
            </a>
        </div>
    </article>
    <?php
}
