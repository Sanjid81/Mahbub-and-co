<?php
/**
 * Current Openings Section: block render (tabs + job cards grid)
 * All class names prefixed maco-openings-* to avoid overwriting existing styles.
 */
defined('ABSPATH') || exit;

use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'maco_register_current_openings_block', 20);
add_shortcode('current_openings', 'maco_current_openings_shortcode');

function maco_current_openings_shortcode($atts)
{
    $atts = shortcode_atts(array('heading' => 'Current Openings'), $atts, 'current_openings');
    ob_start();
    maco_current_openings_render_callback(array('maco_openings_heading' => $atts['heading']));
    return ob_get_clean();
}

function maco_register_current_openings_block()
{
    Block::make(__('Current Openings Section', 'mahbub-and-co'))
        ->set_icon('clipboard')
        ->set_category('layout')
        ->add_fields(array(
            Field::make('text', 'maco_openings_heading', __('Section Heading', 'mahbub-and-co'))
                ->set_default_value('Current Openings'),
            Field::make('text', 'maco_openings_button_text', __('Button Text', 'mahbub-and-co'))
                ->set_default_value('Apply Now')
             
        ))
        ->set_render_callback('maco_current_openings_render_callback');
}

function maco_current_openings_render_callback()
{
    $args = func_get_args();
    $heading = 'Current Openings';
    $button_text = 'Apply Now';
    foreach ($args as $arg) {
        if (is_array($arg) && array_key_exists('maco_openings_heading', $arg)) {
            if ($arg['maco_openings_heading'] !== '') {
                $heading = $arg['maco_openings_heading'];
            }
            if (!empty($arg['maco_openings_button_text'])) {
                $button_text = $arg['maco_openings_button_text'];
            }
            break;
        }
        if (is_object($arg) && method_exists($arg, 'get_id') && function_exists('carbon_get_block_meta')) {
            $block_id = $arg->get_id();
            $h = carbon_get_block_meta($block_id, 'maco_openings_heading');
            if ($h !== '') {
                $heading = $h;
            }
            $bt = carbon_get_block_meta($block_id, 'maco_openings_button_text');
            if ($bt !== '') {
                $button_text = $bt;
            }
            break;
        }
    }

    $terms = get_terms(array(
        'taxonomy' => 'job_opening_category',
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC',
    ));
    if (is_wp_error($terms)) {
        $terms = array();
    }

    $jobs = new WP_Query(array(
        'post_type' => 'job_opening',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => array('publish', 'future'),
    ));

    ?>
    <section class="maco-openings">
        <div class="container">
            <div class="maco-openings-inner">
                <h2 class="maco-openings-title">
                    <?php echo esc_html($heading); ?>
                </h2>

                <div class="maco-openings-tabs-wrap">
                    <div class="maco-openings-tabs" role="tablist">
                        <button type="button" class="maco-openings-tab maco-openings-tab--active"
                            data-maco-openings-filter="all" aria-selected="true">All</button>
                        <?php foreach ($terms as $term): ?>
                            <button type="button" class="maco-openings-tab"
                                data-maco-openings-filter="<?php echo esc_attr($term->slug); ?>" aria-selected="false">
                                <?php echo esc_html($term->name); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="maco-openings-grid">
                    <?php
                    if ($jobs->have_posts()) {
                        while ($jobs->have_posts()) {
                            $jobs->the_post();
                            $id = get_the_ID();
                            $job_terms = get_the_terms($id, 'job_opening_category');
                            $term_slugs = array();
                            if ($job_terms && !is_wp_error($job_terms)) {
                                foreach ($job_terms as $t) {
                                    $term_slugs[] = $t->slug;
                                }
                            }
                            $data_cat = implode(' ', $term_slugs);

                            $exp = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_experience') : '';
                            $loc = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_location') : '';
                            $typ = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_type') : '';
                            $dead = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_deadline') : '';
                            $details_url = get_permalink($id);
                            ?>
                            <article class="maco-openings-card" data-maco-openings-category="<?php echo esc_attr($data_cat); ?>">
                                <h3 class="maco-openings-card-title"><a href="<?php echo esc_url($details_url); ?>"
                                        class="maco-openings-card-title-link">
                                        <?php the_title(); ?>
                                    </a></h3>
                                <div class="maco-openings-card-meta">
                                    <?php if ($exp !== ''): ?>
                                        <span class="maco-openings-card-meta-item">
                                            <span class="maco-openings-card-meta-icon" aria-hidden="true">
                                                <!-- < ?php echo maco_openings_icon_briefcase(); ?> -->
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.33398 1.33301V3.99967" stroke="#BC001A" stroke-width="1.33333"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M10.666 1.33301V3.99967" stroke="#BC001A" stroke-width="1.33333"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M12.6667 2.66699H3.33333C2.59695 2.66699 2 3.26395 2 4.00033V13.3337C2 14.07 2.59695 14.667 3.33333 14.667H12.6667C13.403 14.667 14 14.07 14 13.3337V4.00033C14 3.26395 13.403 2.66699 12.6667 2.66699Z"
                                                        stroke="#BC001A" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M2 6.66699H14" stroke="#BC001A" stroke-width="1.33333"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>

                                            </span>
                                            <span class="maco-openings-card-meta-text">Experience:
                                                <!-- < ?php echo esc_html__('', 'mahbub-and-co'); ?> -->
                                                <p>
                                                    <?php echo esc_html($exp); ?>

                                                </p>
                                            </span>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($loc !== ''): ?>
                                        <span class="maco-openings-card-meta-item">
                                            <span class="maco-openings-card-meta-icon" aria-hidden="true">
                                                <!-- < ?php echo maco_openings_icon_pin(); ?> -->
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3327 6.66634C13.3327 9.99501 9.64002 13.4617 8.40002 14.5323C8.2845 14.6192 8.14388 14.6662 7.99935 14.6662C7.85482 14.6662 7.7142 14.6192 7.59868 14.5323C6.35868 13.4617 2.66602 9.99501 2.66602 6.66634C2.66602 5.25185 3.22792 3.8953 4.22811 2.89511C5.22831 1.89491 6.58486 1.33301 7.99935 1.33301C9.41384 1.33301 10.7704 1.89491 11.7706 2.89511C12.7708 3.8953 13.3327 5.25185 13.3327 6.66634Z"
                                                        stroke="#BC001A" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M8 8.66699C9.10457 8.66699 10 7.77156 10 6.66699C10 5.56242 9.10457 4.66699 8 4.66699C6.89543 4.66699 6 5.56242 6 6.66699C6 7.77156 6.89543 8.66699 8 8.66699Z"
                                                        stroke="#BC001A" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>

                                            </span>
                                            <span class="maco-openings-card-meta-text">Location:
                                                <!-- < ?php echo esc_html__('', 'mahbub-and-co'); ?> -->
                                                <p>
                                                    <?php echo esc_html($loc); ?>
                                                </p>
                                            </span>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($typ !== ''): ?>
                                        <span class="maco-openings-card-meta-item">
                                            <span class="maco-openings-card-meta-icon" aria-hidden="true">
                                                <!-- < ?php echo maco_openings_icon_briefcase(); ?> -->
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M10.6673 13.333V2.66634C10.6673 2.31272 10.5268 1.97358 10.2768 1.72353C10.0267 1.47348 9.68761 1.33301 9.33398 1.33301H6.66732C6.3137 1.33301 5.97456 1.47348 5.72451 1.72353C5.47446 1.97358 5.33398 2.31272 5.33398 2.66634V13.333"
                                                        stroke="#BC001A" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M13.334 4H2.66732C1.93094 4 1.33398 4.59695 1.33398 5.33333V12C1.33398 12.7364 1.93094 13.3333 2.66732 13.3333H13.334C14.0704 13.3333 14.6673 12.7364 14.6673 12V5.33333C14.6673 4.59695 14.0704 4 13.334 4Z"
                                                        stroke="#BC001A" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>

                                            </span>
                                            <span class="maco-openings-card-meta-text">Type:
                                                <!-- < ?php echo esc_html__('', 'mahbub-and-co'); ?> -->
                                                <p>
                                                    <?php echo esc_html($typ); ?>
                                                </p>
                                            </span>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($dead !== ''): ?>
                                        <span class="maco-openings-card-meta-item">
                                            <span class="maco-openings-card-meta-icon" aria-hidden="true">
                                                <!-- < ?php echo maco_openings_icon_calendar(); ?> -->
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.33398 1.33301V3.99967" stroke="#BC001A" stroke-width="1.33333"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M10.666 1.33301V3.99967" stroke="#BC001A" stroke-width="1.33333"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M12.6667 2.66699H3.33333C2.59695 2.66699 2 3.26395 2 4.00033V13.3337C2 14.07 2.59695 14.667 3.33333 14.667H12.6667C13.403 14.667 14 14.07 14 13.3337V4.00033C14 3.26395 13.403 2.66699 12.6667 2.66699Z"
                                                        stroke="#BC001A" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M2 6.66699H14" stroke="#BC001A" stroke-width="1.33333"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>

                                            </span>
                                            <span class="maco-openings-card-meta-text">Deadline:
                                                <!-- < ?php echo esc_html__('', 'mahbub-and-co'); ?> -->
                                                <p>
                                                    <?php echo esc_html($dead); ?>
                                                </p>
                                            </span>
                                        </span>
                                    <?php endif; ?>
                                </div>


                                <a href="<?php echo esc_url($details_url); ?>" class="red-bg-button" data-aos="fade-up">
                                    <div class="button-text">
                                        <?php echo esc_html($button_text); ?>
                                    </div>
                                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="44" height="44" rx="22" fill="white" />
                                        <g clip-path="url(#clip0_1948_2508)">
                                            <path d="M16.166 17H26.9993V27.8333" stroke="#BC001A" stroke-width="2"
                                                stroke-miterlimit="10" />
                                            <path d="M16 28L27 17" stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1948_2508">
                                                <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                </a>
                            </article>
                            <?php
                        }
                        wp_reset_postdata();
                    } else {
                        echo '<p class="maco-openings-empty">' . esc_html__('No job openings at the moment.', 'mahbub-and-co') . '</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}

function maco_openings_icon_briefcase()
{
    return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zm-8 12V4m0 0V2m0 2h6a2 2 0 012 2v2H6V6a2 2 0 012-2h6z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}

function maco_openings_icon_pin()
{
    return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21c-4.418 0-8-3.582-8-8 0-4.418 3.582-8 8-8s8 3.582 8 8c0 4.418-3.582 8-8 8zm0-14a6 6 0 100 12 6 6 0 000-12z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}

function maco_openings_icon_calendar()
{
    return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M3 10h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>';
}

function maco_openings_icon_arrow()
{
    return '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}
