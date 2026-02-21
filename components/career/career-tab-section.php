<?php
/**
 * Render callback for Career Overview Block
 * Carbon Fields may pass (inner_blocks, attributes, fields) - we detect $fields from args.
 */
function career_overview_render_callback()
{
    try {
        $args  = func_get_args();
        $fields = [];
        foreach ($args as $arg) {
            if (is_array($arg) && array_key_exists('team_tabs', $arg)) {
                $fields = $arg;
                break;
            }
        }
        $team_tabs = isset($fields['team_tabs']) && is_array($fields['team_tabs']) ? $fields['team_tabs'] : [];
    } catch (Throwable $e) {
        echo '<div class="career-page-section career-overview-block"><div class="container"><p class="career-block-error">Career block: ' . esc_html($e->getMessage()) . '</p></div></div>';
        return;
    }
    ?>
    <div class="career-page-section">
        <div class="career-overview-block">

            <?php if (!empty($team_tabs)): ?>
                <div class="team-details-tabs">
                    <div class="team-details-tab">
                        <?php foreach ($team_tabs as $index => $tab): $tab_nav = is_array($tab) ? $tab : []; ?>
                            <a href="#<?php echo esc_attr($tab_nav['tab_id'] ?? 'tab-' . $index); ?>"
                               class="tab-item nav-item <?php echo $index === 0 ? 'active' : ''; ?>"
                               data-tab-id="<?php echo esc_attr($tab_nav['tab_id'] ?? 'tab-' . $index); ?>">
                                <?php echo esc_html($tab_nav['tab_title'] ?? $tab_nav['tab_id'] ?? ''); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tab contents – same page: Overview then What We Look For (scroll + tab click) -->
            <div class="tab-contents career-tab-contents">
                <?php foreach ($team_tabs as $index => $tab):
                    $tab = is_array($tab) ? $tab : [];
                    $tab_id = $tab['tab_id'] ?? 'tab-' . $index;
                    // This tab's data only (no mixing with other tabs)
                    $career_heading = !empty($tab['career_heading']) ? (string) $tab['career_heading'] : 'Our Career Programs';
                    $career_intro   = isset($tab['career_intro']) ? (string) $tab['career_intro'] : '';
                    $bg_attachment  = $tab['background_image'] ?? '';
                    $bg_image       = $bg_attachment ? (is_numeric($bg_attachment) ? wp_get_attachment_image_url((int) $bg_attachment, 'full') : (string) $bg_attachment) : '';
                ?>
                    <div id="<?php echo esc_attr($tab_id); ?>" class="tab-content <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="career-container">

                           
                            <?php
                            $is_overview_tab = (stripos($tab_id, 'overview') !== false || $index === 0);
                            $is_look_for_tab = (stripos($tab_id, 'what-we-look-for') !== false || stripos($tab_id, 'what_we_look') !== false || $index === 1);
                            $career_dev_sections = isset($tab['career_dev_sections']) && is_array($tab['career_dev_sections']) ? $tab['career_dev_sections'] : [];
                            $dev_section_images  = isset($tab['dev_section_images']) && is_array($tab['dev_section_images']) ? $tab['dev_section_images'] : [];
                            ?>

                            <?php if ($is_overview_tab): ?>
                                <!-- Tab 1: Why Mahbub & Co (left content + right program list) -->
                               <div class="container">
                                 <div class="overview-first-section">
                                    <div class="overview-first-content">
                                        <h1><?php echo esc_html($career_heading); ?></h1>
                                        <?php if ($career_intro !== ''): ?>
                                            <div class="intro">
                                                <?php echo wp_kses_post($career_intro); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="program-list-grid">
                                        <?php
                                        $programs = new WP_Query([
                                            'post_type'      => 'program',
                                            'posts_per_page' => -1,
                                            'orderby'        => 'menu_order title',
                                            'order'          => 'ASC',
                                        ]);
                                        if ($programs->have_posts()) {
                                            foreach ($programs->posts as $program_post) {
                                                $p_id   = $program_post->ID;
                                                $short  = function_exists('carbon_get_post_meta') ? (carbon_get_post_meta($p_id, 'program_short_title') ?: $program_post->post_title) : $program_post->post_title;
                                                $p_link = get_permalink($p_id);
                                                ?>
                                                <a href="<?php echo esc_url($p_link); ?>" class="program-card">
                                                    <?php echo esc_html($short); ?>
                                                    <span class="arrow">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_1911_3226)">
                                                                <path d="M13.1727 11.9997L8.22266 7.04974L9.63666 5.63574L16.0007 11.9997L9.63666 18.3637L8.22266 16.9497L13.1727 11.9997Z" fill="#BC001A" />
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
                                <?php if (!empty($career_dev_sections) || !empty($dev_section_images)): ?>
                                <div class="career-dev-sections" <?php echo $bg_image ? ' style="--career-section-bg: url(\'' . esc_url($bg_image) . '\');"' : ''; ?>>
                                    <div class="overlay"></div>
                                    <div class="container">
                                        <div class="dev-sections-content">
                                            <?php if (!empty($career_dev_sections)): ?>
                                                <div class="dev-sections-wrapper">
                                                    <?php foreach ($career_dev_sections as $sec): ?>
                                                        <?php $sec = is_array($sec) ? $sec : []; ?>
                                                        <div class="dev-section">
                                                            <div class="dev-card">
                                                                <h2><?php echo esc_html(isset($sec['dev_title']) ? (string) $sec['dev_title'] : ''); ?></h2>
                                                                <?php echo wp_kses_post(isset($sec['dev_content']) && is_string($sec['dev_content']) ? $sec['dev_content'] : ''); ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($dev_section_images)): ?>
                                                <div class="dev-sections-images">
                                                    <?php foreach ($dev_section_images as $img_item): ?>
                                                        <?php $img_item = is_array($img_item) ? $img_item : []; if (!empty($img_item['dev_image1'])): ?>
                                                            <?php echo wp_get_attachment_image((int) $img_item['dev_image1'], 'medium', false, ['loading' => 'lazy']); ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                           
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($is_look_for_tab): ?>
                                <!-- Tab 2: What We Look for – light blue section with two dotted boxes -->
                                <div class="what-we-look-for">
                                    <div class="what-we-look-for-inner">
                                        <h1 class="what-we-look-for-heading"><?php echo esc_html($career_heading); ?></h1>
                                        <?php if ($career_intro !== ''): ?>
                                            <div class="what-we-look-for-intro">
                                                <?php echo wp_kses_post($career_intro); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($career_dev_sections)): ?>
                                            <div class="look-for-boxes">
                                                <?php foreach ($career_dev_sections as $sec): ?>
                                                    <?php $sec = is_array($sec) ? $sec : []; ?>
                                                    <div class="look-for-box">
                                                        <?php if (!empty($sec['dev_title'])): ?>
                                                            <h2 class="look-for-box-title"><?php echo esc_html((string) $sec['dev_title']); ?></h2>
                                                        <?php endif; ?>
                                                        <div class="look-for-box-content">
                                                            <?php echo wp_kses_post(isset($sec['dev_content']) && is_string($sec['dev_content']) ? $sec['dev_content'] : ''); ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php
            $first_tab = !empty($team_tabs[0]) && is_array($team_tabs[0]) ? $team_tabs[0] : [];
            $btn_title = isset($first_tab['button_title']) ? trim((string) $first_tab['button_title']) : '';
            $btn_url   = isset($first_tab['button_url']) ? trim((string) $first_tab['button_url']) : '';
            if ($btn_title !== '' && $btn_url !== ''):
                $btn_url = preg_match('#^https?://#', $btn_url) ? $btn_url : home_url('/' . ltrim($btn_url, '/'));
            ?>
                <div class="career-apply-button-wrap">
                <a href="<?php echo esc_url($btn_url); ?>" class="red-bg-button" data-aos="fade-up">
                            <div class="button-text"><?php echo esc_html($btn_title); ?></div>
                           <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="44" height="44" rx="22" fill="white"/>
<g clip-path="url(#clip0_1948_2508)">
<path d="M16.166 17H26.9993V27.8333" stroke="#BC001A" stroke-width="2" stroke-miterlimit="10"/>
<path d="M16 28L27 17" stroke="#BC001A" stroke-width="2" stroke-miterlimit="10"/>
</g>
<defs>
<clipPath id="clip0_1948_2508">
<rect width="20" height="20" fill="white" transform="translate(12 12)"/>
</clipPath>
</defs>
</svg>

                        </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php
}

/**
 * Render callback for Program Details Full Layout block (single program page).
 */
function program_details_render_callback($fields, $attributes, $inner_blocks)
{
    ?>
    <div class="program-details-full-layout alignwide">
        <?php the_content(); ?>
    </div>
    <?php
}