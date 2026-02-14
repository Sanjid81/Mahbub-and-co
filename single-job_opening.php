<?php
/**
 * Single job_opening – যে পোস্টে ক্লিক করবেন সেই পোস্টই এখানে দেখাবে।
 * ১. উপরে: এই পোস্টের কার্ড (টাইটেল + Experience, Location, Type, Deadline)
 * ২. নিচে: বাকি সব কন্টেন্ট = কাস্টম ব্লক (এডিটরে যে ব্লক দেবেন)
 */
defined('ABSPATH') || exit;
get_header();

// যে পোস্টের URL এ আছি (যে কার্ডে ক্লিক করা হয়েছিল) শুধু সেই পোস্ট লোড করি
// post_status এ future রাখা – ভবিষ্যত তারিখের পোস্টও ডিটেইলসে দেখাবে
$post_id = get_queried_object_id();
$job_query = new WP_Query(array(
    'p'              => $post_id,
    'post_type'      => 'job_opening',
    'post_status'    => array('publish', 'future'),
    'posts_per_page' => 1,
));

if (!$job_query->have_posts() && get_query_var('name')) {
    $job_query = new WP_Query(array(
        'name'           => get_query_var('name'),
        'post_type'      => 'job_opening',
        'post_status'    => array('publish', 'future'),
        'posts_per_page' => 1,
    ));
}

if ($job_query->have_posts()) {
    while ($job_query->have_posts()) {
        $job_query->the_post();
        $id = get_the_ID();
        $exp   = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_experience') : '';
        $loc   = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_location') : '';
        $typ   = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_type') : '';
        $dead  = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_deadline') : '';
        $apply_url  = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_apply_url') : '';
        $apply_text = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_apply_text') : 'Apply Now';
        $apply_link = $apply_url !== '' ? $apply_url : get_permalink($id);
        $icon_briefcase = function_exists('maco_openings_icon_briefcase') ? maco_openings_icon_briefcase() : '';
        $icon_pin       = function_exists('maco_openings_icon_pin') ? maco_openings_icon_pin() : '';
        $icon_calendar  = function_exists('maco_openings_icon_calendar') ? maco_openings_icon_calendar() : '';
        $icon_arrow     = function_exists('maco_openings_icon_arrow') ? maco_openings_icon_arrow() : '';
        ?>
        <article class="maco-opening-detail" id="maco-opening-detail-<?php echo esc_attr($id); ?>" data-maco-opening-id="<?php echo esc_attr($id); ?>">
            <div class="maco-opening-detail-inner">
                <!-- এই পোস্টের কার্ড (টাইটেল + মেটা) -->
                <div class="maco-opening-detail-card-wrap">
                    <div class="maco-openings-card maco-opening-detail-full-card">
                        <h1 class="maco-openings-card-title maco-opening-detail-card-title"><?php the_title(); ?></h1>
                        <div class="maco-openings-card-meta">
                            <?php if ($exp !== ''): ?>
                                <span class="maco-openings-card-meta-item">
                                    <span class="maco-openings-card-meta-icon" aria-hidden="true"><?php echo $icon_briefcase; ?></span>
                                    <span class="maco-openings-card-meta-text"><?php echo esc_html__('Experience:', 'mahbub-and-co'); ?> <?php echo esc_html($exp); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($loc !== ''): ?>
                                <span class="maco-openings-card-meta-item">
                                    <span class="maco-openings-card-meta-icon" aria-hidden="true"><?php echo $icon_pin; ?></span>
                                    <span class="maco-openings-card-meta-text"><?php echo esc_html__('Location:', 'mahbub-and-co'); ?> <?php echo esc_html($loc); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($typ !== ''): ?>
                                <span class="maco-openings-card-meta-item">
                                    <span class="maco-openings-card-meta-icon" aria-hidden="true"><?php echo $icon_briefcase; ?></span>
                                    <span class="maco-openings-card-meta-text"><?php echo esc_html__('Type:', 'mahbub-and-co'); ?> <?php echo esc_html($typ); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($dead !== ''): ?>
                                <span class="maco-openings-card-meta-item">
                                    <span class="maco-openings-card-meta-icon" aria-hidden="true"><?php echo $icon_calendar; ?></span>
                                    <span class="maco-openings-card-meta-text"><?php echo esc_html__('Deadline:', 'mahbub-and-co'); ?> <?php echo esc_html($dead); ?></span>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- বাকি সব কন্টেন্ট = কাস্টম ব্লক (এই পোস্টের এডিটরে যেগুলো দেবেন) -->
                <div class="maco-opening-detail-blocks entry-content">
                    <?php the_content(); ?>
                </div>
                <a href="<?php echo esc_url($apply_link); ?>" class="maco-opening-detail-apply-btn" target="<?php echo $apply_url !== '' ? '_blank' : '_self'; ?>" rel="<?php echo $apply_url !== '' ? 'noopener' : ''; ?>">
                    <?php echo esc_html($apply_text); ?>
                    <span class="maco-openings-apply-btn-arrow" aria-hidden="true"><?php echo $icon_arrow; ?></span>
                </a>
            </div>
        </article>
        <?php
    }
    wp_reset_postdata();
} else {
    echo '<div class="maco-opening-detail"><div class="maco-opening-detail-inner"><p>' . esc_html__('Job opening not found.', 'mahbub-and-co') . '</p></div></div>';
}

get_footer();
