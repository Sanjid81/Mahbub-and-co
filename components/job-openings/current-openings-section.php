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
        ))
        ->set_render_callback('maco_current_openings_render_callback');
}

function maco_current_openings_render_callback()
{
    $args = func_get_args();
    $heading = 'Current Openings';
    foreach ($args as $arg) {
        if (is_array($arg) && array_key_exists('maco_openings_heading', $arg)) {
            if ($arg['maco_openings_heading'] !== '') {
                $heading = $arg['maco_openings_heading'];
            }
            break;
        }
        if (is_object($arg) && method_exists($arg, 'get_id') && function_exists('carbon_get_block_meta')) {
            $h = carbon_get_block_meta($arg->get_id(), 'maco_openings_heading');
            if ($h !== '') {
                $heading = $h;
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
                    <nav class="maco-openings-tabs" role="tablist">
                        <button type="button" class="maco-openings-tab maco-openings-tab--active"
                            data-maco-openings-filter="all" aria-selected="true">All</button>
                        <?php foreach ($terms as $term): ?>
                            <button type="button" class="maco-openings-tab"
                                data-maco-openings-filter="<?php echo esc_attr($term->slug); ?>" aria-selected="false">
                                <?php echo esc_html($term->name); ?>
                            </button>
                        <?php endforeach; ?>
                    </nav>
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
                            $view_details_text = __('View Details', 'mahbub-and-co');
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
                                                <?php echo maco_openings_icon_briefcase(); ?>
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
                                                <?php echo maco_openings_icon_pin(); ?>
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
                                                <?php echo maco_openings_icon_briefcase(); ?>
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
                                                <?php echo maco_openings_icon_calendar(); ?>
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
                                    <?php echo esc_html($view_details_text); ?>
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
