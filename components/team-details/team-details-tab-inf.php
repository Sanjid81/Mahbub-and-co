<?php
$team_tabs = get_query_var('team_tabs');
if (empty($team_tabs))
    return;
?>
<div class="team-details-tab-section">
    <!-- Tabs Navigation -->
    <div class="team-details-tabs">
        <div class="team-details-tab">
            <?php foreach ($team_tabs as $index => $tab): ?>
                <a href="#<?php echo esc_attr($tab['tab_id']); ?>"
                    class="tab-item nav-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <?php echo esc_html($tab['tab_title']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Tab Content -->
    <div class="container">
        <?php foreach ($team_tabs as $index => $tab): ?>
            <section id="<?php echo esc_attr($tab['tab_id']); ?>" class="tab-content">
                <h2><?php echo esc_html($tab['tab_title']); ?></h2>
                <div class="subcategory-description-container">
                    <?php echo apply_filters('the_content', $tab['tab_content']); ?>
                </div>
                <?php if (!empty($tab['button_text'])): ?>
                    <a href="<?php echo esc_url($tab['button_link']); ?>" class="download-btn">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5 17.5H2.5M15 9.16667L10 14.1667M10 14.1667L5 9.16667M10 14.1667V2.5" stroke="#BC001A"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <?php echo esc_html($tab['button_text']); ?>
                    </a>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
</div>