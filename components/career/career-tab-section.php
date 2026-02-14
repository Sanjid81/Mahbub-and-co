<?php
/**
 * Render callback for Career Overview Block
 * 
 * @param array $fields      Saved field values
 * @param array $attributes  Block attributes
 * @param array $inner_blocks Inner blocks content (not used here)
 */

function career_overview_render_callback($fields, $attributes, $inner_blocks)
{
    $team_tabs = isset($fields['team_tabs']) ? $fields['team_tabs'] : [];
    // Backward compat: old block had career_heading/intro/dev_sections inside first tab
    $career_heading = $fields['career_heading'] ?? ($team_tabs[0]['career_heading'] ?? '') ?: 'Our Career Programs';
    $career_intro = $fields['career_intro'] ?? ($team_tabs[0]['career_intro'] ?? '');
    $career_dev_sections = $fields['career_dev_sections'] ?? ($team_tabs[0]['career_dev_sections'] ?? []);
    $bg_attachment = $fields['background_image'] ?? '';
    $bg_image = '';
    if (!empty($bg_attachment)) {
        $bg_image = is_numeric($bg_attachment) ? wp_get_attachment_image_url($bg_attachment, 'full') : $bg_attachment;
    }
    ?>
    <div class="career-page-section">
        <div class="career-overview-block">
            <?php if (!empty($team_tabs)): ?>
                <div class="team-details-tabs">
                    <div class="team-details-tab">
                        <?php foreach ($team_tabs as $index => $tab): ?>
                            <a href="#<?php echo esc_attr($tab['tab_id'] ?? ''); ?>"
                                class="tab-item nav-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <?php echo esc_html($tab['tab_title'] ?? $tab['tab_id'] ?? ''); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="container">

                <div class="overview-first-section">
                    <div class="overview-first-content">
                        <h1>
                            <?php echo esc_html($career_heading); ?>
                        </h1>

                        <?php if (!empty($career_intro)): ?>
                            <div class="intro">
                                <?php echo wp_kses_post($career_intro); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="program-list-grid">
                        <?php
                        $programs = new WP_Query([
                            'post_type' => 'program',
                            'posts_per_page' => -1,
                            'orderby' => 'menu_order title',
                            'order' => 'ASC',
                        ]);

                        if ($programs->have_posts()) {
                            while ($programs->have_posts()) {
                                $programs->the_post();
                                $short = carbon_get_the_post_meta('program_short_title') ?: get_the_title();
                                ?>
                                <a href="<?php the_permalink(); ?>" class="program-card">
                                    <?php echo esc_html($short); ?>
                                    <span class="arrow"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_1911_3226)">
                                                <path
                                                    d="M13.1727 11.9997L8.22266 7.04974L9.63666 5.63574L16.0007 11.9997L9.63666 18.3637L8.22266 16.9497L13.1727 11.9997Z"
                                                    fill="#BC001A" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_1911_3226">
                                                    <rect width="24" height="24" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                </a>
                                <?php
                            }
                            wp_reset_postdata();
                        } else {
                            echo '<p>No career programs found.</p>';
                        }
                        ?>
                    </div>
                </div>

            </div>
            <div class="career-dev-sections" <?php echo $bg_image ? ' style="--career-section-bg: url(\'' . esc_url($bg_image) . '\');"' : ''; ?>>
                <div class="overlay"></div>
                <div class="container">
                    <div class="dev-sections-content">
                        <?php if (!empty($career_dev_sections)): ?>
                            <div class="dev-sections-wrapper">
                                <?php foreach ($career_dev_sections as $sec): ?>
                                    <div class="dev-section">
                                        <div class="dev-card">
                                            <h2>
                                                <?php echo esc_html($sec['dev_title'] ?? ''); ?>
                                            </h2>
                                            <?php echo wp_kses_post($sec['dev_content'] ?? ''); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>


                        <?php if (!empty($career_dev_sections)): ?>
                            <div class="dev-sections-images">
                                <?php foreach ($career_dev_sections as $sec): ?>
                                    <?php
                                    $sec_images = isset($sec['dev_section_images']) && is_array($sec['dev_section_images']) ? $sec['dev_section_images'] : [];
                                    $imgs = isset($sec_images[0]) && is_array($sec_images[0]) ? $sec_images[0] : $sec;
                                    $has_any = !empty($imgs['dev_image1']) || !empty($imgs['dev_image2']) || !empty($imgs['dev_image3']);
                                    if ($has_any):
                                        ?>
                                        <div class="dev-section-images-wrapper">
                                            <?php
                                            foreach (['dev_image1', 'dev_image2', 'dev_image3'] as $key) {
                                                if (!empty($imgs[$key])) {
                                                    echo wp_get_attachment_image($imgs[$key], 'medium', false, ['loading' => 'lazy']);
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            
        </div>
    </div>
    <?php
}

/**
 * Render callback for Program Details Full Layout block (single program page).
 *
 * @param array $fields      Saved field values (empty for this block)
 * @param array $attributes  Block attributes
 * @param array $inner_blocks Inner blocks content (not used here)
 */
function program_details_render_callback($fields, $attributes, $inner_blocks)
{
    ?>
    <div class="program-details-full-layout alignwide">
        <?php the_content(); ?>
    </div>
    <?php
}