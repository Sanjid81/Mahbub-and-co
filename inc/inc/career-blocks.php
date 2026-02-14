<?php
// inc/career-blocks.php
// কোনো স্পেস/লাইন <?php এর আগে রাখবে না!

use Carbon_Fields\Block;
use Carbon_Fields\Field;

// ===============================================
// 1. রেন্ডার ফাংশন (প্রথমে ডিফাইন করতে হবে)
// ===============================================

function career_overview_render_callback($fields, $attributes, $inner_blocks)
{
    $team_tabs = $fields['team_tabs'] ?? [];

    $bg_attachment = $fields['background_image'] ?? '';
    $bg_image = $bg_attachment ? (is_numeric($bg_attachment) ? wp_get_attachment_image_url($bg_attachment, 'full') : $bg_attachment) : '';

    ?>
    <div class="career-page-section">
        <div class="career-overview-block">

            <?php if (!empty($team_tabs)): ?>
                <div class="team-details-tabs">
                    <div class="team-details-tab">
                        <?php foreach ($team_tabs as $index => $tab): ?>
                            <a href="#<?php echo esc_attr($tab['tab_id'] ?? 'tab-' . $index); ?>"
                               class="tab-item nav-item <?php echo $index === 0 ? 'active' : ''; ?>"
                               data-tab-id="<?php echo esc_attr($tab['tab_id'] ?? 'tab-' . $index); ?>">
                                <?php echo esc_html($tab['tab_title'] ?? $tab['tab_id'] ?? ''); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="tab-contents">
                <?php foreach ($team_tabs as $index => $tab):
                    $tab_id = $tab['tab_id'] ?? 'tab-' . $index;
                ?>
                    <div id="<?php echo esc_attr($tab_id); ?>" class="tab-content <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="container">

                            <?php if (!empty($tab['tab_heading'])): ?>
                                <h1><?php echo esc_html($tab['tab_heading']); ?></h1>
                            <?php endif; ?>

                            <?php if (!empty($tab['tab_content'])): ?>
                                <div class="tab-main-content">
                                    <?php echo wp_kses_post($tab['tab_content']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($tab['tab_images'])): ?>
                                <div class="tab-images">
                                    <?php foreach ($tab['tab_images'] as $img): ?>
                                        <?php if (!empty($img['image'])): ?>
                                            <?php echo wp_get_attachment_image($img['image'], 'large', false, ['loading' => 'lazy']); ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (stripos($tab_id, 'overview') !== false || $index === 0): ?>
                                <div class="overview-first-section">
                                    <div class="overview-first-content">
                                        <h1><?php echo esc_html($tab['career_heading'] ?? 'Our Career Programs'); ?></h1>
                                        <?php if (!empty($tab['career_intro'])): ?>
                                            <div class="intro"><?php echo wp_kses_post($tab['career_intro']); ?></div>
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
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- তোমার আগের career-dev-sections -->
            <div class="career-dev-sections" <?php echo $bg_image ? ' style="--career-section-bg: url(\'' . esc_url($bg_image) . '\');"' : ''; ?>>
                <div class="overlay"></div>
                <div class="container">
                    <div class="dev-sections-content">
                        <?php 
                        $career_dev_sections = $fields['career_dev_sections'] ?? [];
                        if (!empty($career_dev_sections)): ?>
                            <div class="dev-sections-wrapper">
                                <?php foreach ($career_dev_sections as $sec): ?>
                                    <div class="dev-section">
                                        <div class="dev-card">
                                            <h2><?php echo esc_html($sec['dev_title'] ?? ''); ?></h2>
                                            <?php echo wp_kses_post($sec['dev_content'] ?? ''); ?>
                                        </div>
                                    </div>
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

function program_details_render_callback($fields, $attributes, $inner_blocks)
{
    ?>
    <div class="program-details-full-layout alignwide">
        <?php the_content(); ?>
    </div>
    <?php
}

// ===============================================
// 2. Block Register (ফাংশনের পরে)
// ===============================================

add_action('carbon_fields_register_fields', function() {
    Block::make(__('Career Overview Section'))
        ->set_icon('businessman')
        ->set_category('layout')
        ->add_fields(array(
            Field::make('complex', 'team_tabs', 'Tabs')
                ->add_fields(array(
                    Field::make('text', 'tab_id', 'Tab ID')
                        ->set_help_text('Example: overview, what-we-look-for'),
                    Field::make('text', 'tab_title', 'Tab Title'),

                    Field::make('text', 'career_heading', 'Main Heading')
                        ->set_default_value('Our Career Programs'),
                    Field::make('rich_text', 'career_intro', 'Intro Text Above List'),

                    Field::make('complex', 'career_dev_sections', 'Development Sections')
                        ->add_fields(array(
                            Field::make('text', 'dev_title', 'Section Title'),
                            Field::make('rich_text', 'dev_content', 'Content'),
                        ))
                        ->set_max(2)
                        ->set_layout('tabbed-horizontal')
                        ->set_header_template('<%- dev_title %>'),

                    Field::make('complex', 'dev_section_images', __('Section Images', 'mahbub-and-co'))
                        ->add_fields(array(
                            Field::make('image', 'dev_image1', 'Image 1'),
                        ))
                        ->set_layout('tabbed-horizontal'),

                    Field::make('image', 'background_image', 'Background Image')
                        ->set_value_type('url'),
                ))
                ->set_layout('tabbed-horizontal')
                ->set_max(6),
        ))
        ->set_render_callback('career_overview_render_callback');

    Block::make(__('Program Details Full Layout'))
        ->set_icon('businessman')
        ->set_category('layout')
        ->add_fields(array())
        ->set_render_callback('program_details_render_callback');
});