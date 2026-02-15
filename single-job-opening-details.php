<?php
/**
 * Job Opening details: full card + content + Apply Now
 * Included by single-job_opening.php.
 */
defined('ABSPATH') || exit;

$post_statuses = array('publish', 'future');
if (is_user_logged_in()) {
    $post_statuses[] = 'draft';
}

$job_query = null;
if (have_posts()) {
    $job_query = $GLOBALS['wp_query'];
} else {
    $post_id = get_queried_object_id();
    if ($post_id > 0) {
        $job_query = new WP_Query(array(
            'p' => $post_id,
            'post_type' => 'job_opening',
            'post_status' => $post_statuses,
            'posts_per_page' => 1,
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
        ));
    }
    $slug = get_query_var('name');
    if ((!$job_query || !$job_query->have_posts()) && $slug !== '') {
        $job_query = new WP_Query(array(
            'name' => $slug,
            'post_type' => 'job_opening',
            'post_status' => $post_statuses,
            'posts_per_page' => 1,
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
        ));
    }
    // 3) Fallback: use last URL segment as slug (e.g. /job-opening/my-new-job/ -> my-new-job)
    if ((!$job_query || !$job_query->have_posts()) && $slug === '') {
        $request_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $segments = array_filter(explode('/', $request_path));
        $slug_from_url = end($segments);
        if ($slug_from_url !== '' && $slug_from_url !== 'job-opening') {
            $job_query = new WP_Query(array(
                'name' => $slug_from_url,
                'post_type' => 'job_opening',
                'post_status' => $post_statuses,
                'posts_per_page' => 1,
                'no_found_rows' => true,
                'ignore_sticky_posts' => true,
            ));
        }
    }
}

$use_custom_query = $job_query && $job_query !== $GLOBALS['wp_query'];

if (!$job_query || !$job_query->have_posts()) {
    $maco_debug_no_post = isset($_GET['maco_debug']) && $_GET['maco_debug'] === '1';
    echo '<div class="maco-opening-detail"><div class="maco-opening-detail-inner"><p>' . esc_html__('Job opening not found.', 'mahbub-and-co') . '</p>';
    if ($maco_debug_no_post) {
        $req_uri = isset($_SERVER['REQUEST_URI']) ? esc_html(wp_unslash($_SERVER['REQUEST_URI'])) : '';
        echo '<div class="maco-opening-debug" style="background:#2a1a1a;color:#fcc;padding:12px;margin-top:12px;font-size:12px;">';
        echo '<strong>[Debug]</strong> have_posts=' . (have_posts() ? 'true' : 'false') . ' | queried_object_id=' . (int) get_queried_object_id() . ' | name=' . esc_html(get_query_var('name')) . ' | REQUEST_URI=' . $req_uri;
        echo '</div>';
    }
    echo '</div></div>';
    return;
}

while ($job_query->have_posts()) {
    $job_query->the_post();
    if (is_404()) {
        status_header(200);
    }
    $id = get_the_ID();
    $exp = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_experience') : '';
    $loc = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_location') : '';
    $typ = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_type') : '';
    $dead = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_deadline') : '';
    $apply_url = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_apply_url') : '';
    $apply_text = function_exists('carbon_get_post_meta') ? carbon_get_post_meta($id, 'maco_job_apply_text') : 'Apply Now';
    $apply_link = $apply_url !== '' ? $apply_url : get_permalink($id);
    $icon_briefcase = function_exists('maco_openings_icon_briefcase') ? maco_openings_icon_briefcase() : '';
    $icon_pin = function_exists('maco_openings_icon_pin') ? maco_openings_icon_pin() : '';
    $icon_calendar = function_exists('maco_openings_icon_calendar') ? maco_openings_icon_calendar() : '';
    $icon_arrow = function_exists('maco_openings_icon_arrow') ? maco_openings_icon_arrow() : '';

    $raw_content = get_post_field('post_content', $id);
    $has_raw = !empty(trim($raw_content));
    $share_url = get_permalink($id);
    $share_title = get_the_title($id);
    $share_fb = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($share_url);
    $share_li = 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode($share_url);
    $share_tw = 'https://twitter.com/intent/tweet?url=' . rawurlencode($share_url) . '&text=' . rawurlencode($share_title);
    $share_fb_custom = function_exists('carbon_get_post_meta') ? trim((string) carbon_get_post_meta($id, 'maco_job_share_facebook')) : '';
    $share_li_custom = function_exists('carbon_get_post_meta') ? trim((string) carbon_get_post_meta($id, 'maco_job_share_linkedin')) : '';
    $share_tw_custom = function_exists('carbon_get_post_meta') ? trim((string) carbon_get_post_meta($id, 'maco_job_share_twitter')) : '';
    if ($share_fb_custom !== '') {
        $share_fb = $share_fb_custom;
    }
    if ($share_li_custom !== '') {
        $share_li = $share_li_custom;
    }
    if ($share_tw_custom !== '') {
        $share_tw = $share_tw_custom;
    }

    $maco_show_debug = isset($_GET['maco_debug']) && $_GET['maco_debug'] === '1';
    if ($maco_show_debug) {
        $debug_source = $job_query === $GLOBALS['wp_query'] ? 'main query' : 'fallback query';
        $raw_preview = $raw_content === '' ? '(খালি)' : substr(strip_tags($raw_content), 0, 150) . (strlen($raw_content) > 150 ? '...' : '');
        echo '<div class="maco-opening-debug" style="background:#1e1e1e;color:#eee;padding:12px 16px;margin-bottom:16px;font-family:monospace;font-size:12px;border-radius:4px;">';
        echo '<strong style="color:#7dd">[Job Detail Debug]</strong><br>';
        echo 'Query source: ' . esc_html($debug_source) . '<br>';
        echo 'Post ID: ' . (int) $id . '<br>';
        echo 'Title: ' . esc_html(get_the_title($id)) . '<br>';
        echo 'post_content length: ' . strlen($raw_content) . ' chars | has_raw: ' . ($has_raw ? 'yes' : 'no') . '<br>';
        echo 'post_content preview: ' . esc_html($raw_preview) . '<br>';
        echo 'Meta – exp: ' . esc_html($exp) . ' | loc: ' . esc_html($loc) . ' | type: ' . esc_html($typ) . ' | deadline: ' . esc_html($dead) . '<br>';
        echo 'apply_url: ' . esc_html($apply_url) . '<br>';
        echo '</div>';
    }



    ?>
    <?php
    $archive_url = get_post_type_archive_link('job_opening');
    $back_text = __('Back to Job Openings', 'mahbub-and-co');
    ?>
    <article class="maco-opening-detail" id="maco-opening-detail-<?php echo esc_attr($id); ?>"
        data-maco-opening-id="<?php echo esc_attr($id); ?>">
        <div class="maco-opening-detail-inner">
            <?php if ($archive_url): ?>
                <p class="maco-opening-detail-back">
                    <a href="<?php echo esc_url($archive_url); ?>"
                        class="maco-opening-detail-back-link"><?php echo esc_html($back_text); ?></a>
                </p>
            <?php endif; ?>

            <div class="maco-opening-detail-layout">
                <div class="maco-opening-detail-main">
                    <div class="maco-opening-detail-desc-card">
                        <?php if ($has_raw): ?>
                            <?php
                            // Debug header
                           

                            // Try standard processing
                            $processed = do_blocks($raw_content);
                            $final = apply_filters('the_content', $processed);

                            if (trim(strip_tags($final)) !== '' && strpos($final, '<div class="maco-job-block') !== false) {
                                echo $final; // Success – blocks rendered!
                            } else {

                                if (preg_match('/<!-- wp:carbon-fields\/job-description\s+({.*?}) \/-->/s', $raw_content, $matches)) {
                                    $json = $matches[1];
                                    $data = json_decode($json, true);
                                    if (isset($data['data'])) {
                                        $fields = $data['data'];
                                        $heading = $fields['heading'] ?? 'Job Description';
                                        $content = $fields['content'] ?? '';

                                        echo '<div class="maco-job-block maco-job-block-description">';
                                        if ($heading)
                                            echo '<h2>' . esc_html($heading) . '</h2>';
                                        if ($content)
                                            echo '<div class="entry-content">' . wp_kses_post(apply_filters('the_content', $content)) . '</div>';
                                        echo '</div>';
                                    }
                                }

                                // Add similar preg_match blocks for key-requirements and key-skills if needed
                                // Example for requirements:
                                if (preg_match('/<!-- wp:carbon-fields\/key-requirements\s+({.*?}) \/-->/s', $raw_content, $matches_req)) {
                                   
                                }

                                // If nothing matched, show basic cleaned text
                                $clean = preg_replace('/<!--.*?-->/s', '', $raw_content);
                                echo wp_kses_post(wpautop($clean));
                            }
                            ?>
                        <?php else: ?>
                            <p>Add content using blocks...</p>
                        <?php endif; ?>
                    </div>
                </div>

                <aside class="maco-opening-detail-sidebar">
                    <div class="maco-openings-card maco-opening-detail-sidebar-card">
                        <h2 class="maco-openings-card-title maco-opening-detail-sidebar-title"><?php the_title(); ?></h2>
                        <div class="maco-openings-card-meta">
                            <?php if ($exp !== ''): ?>
                                <span class="maco-openings-card-meta-item">
                                    <span class="maco-openings-card-meta-icon"
                                        aria-hidden="true"><?php echo $icon_briefcase; ?></span>
                                    <span
                                        class="maco-openings-card-meta-text"><?php echo esc_html__('Experience:', 'mahbub-and-co'); ?>
                                        <?php echo esc_html($exp); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($loc !== ''): ?>
                                <span class="maco-openings-card-meta-item">
                                    <span class="maco-openings-card-meta-icon"
                                        aria-hidden="true"><?php echo $icon_pin; ?></span>
                                    <span
                                        class="maco-openings-card-meta-text"><?php echo esc_html__('Location:', 'mahbub-and-co'); ?>
                                        <?php echo esc_html($loc); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($typ !== ''): ?>
                                <span class="maco-openings-card-meta-item">
                                    <span class="maco-openings-card-meta-icon"
                                        aria-hidden="true"><?php echo $icon_briefcase; ?></span>
                                    <span
                                        class="maco-openings-card-meta-text"><?php echo esc_html__('Type:', 'mahbub-and-co'); ?>
                                        <?php echo esc_html($typ); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($dead !== ''): ?>
                                <span class="maco-openings-card-meta-item">
                                    <span class="maco-openings-card-meta-icon"
                                        aria-hidden="true"><?php echo $icon_calendar; ?></span>
                                    <span
                                        class="maco-openings-card-meta-text"><?php echo esc_html__('Deadline:', 'mahbub-and-co'); ?>
                                        <?php echo esc_html($dead); ?></span>
                                </span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo esc_url($apply_link); ?>" class="maco-opening-detail-apply-btn"
                            target="<?php echo $apply_url !== '' ? '_blank' : '_self'; ?>"
                            rel="<?php echo $apply_url !== '' ? 'noopener' : ''; ?>">
                            <?php echo esc_html($apply_text); ?>
                            <span class="maco-openings-apply-btn-arrow" aria-hidden="true"><?php echo $icon_arrow; ?></span>
                        </a>
                    </div>
                    <div class="maco-opening-detail-share-card">
                        <h3 class="maco-opening-detail-share-title">
                            <?php echo esc_html__('Share this Job', 'mahbub-and-co'); ?>
                        </h3>
                        <div class="maco-opening-detail-share-icons">
                            <a href="<?php echo esc_url($share_fb); ?>" class="maco-opening-detail-share-icon"
                                target="_blank" rel="noopener"
                                aria-label="<?php esc_attr_e('Share on Facebook', 'mahbub-and-co'); ?>">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="<?php echo esc_url($share_li); ?>" class="maco-opening-detail-share-icon"
                                target="_blank" rel="noopener"
                                aria-label="<?php esc_attr_e('Share on LinkedIn', 'mahbub-and-co'); ?>">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="<?php echo esc_url($share_tw); ?>" class="maco-opening-detail-share-icon"
                                target="_blank" rel="noopener"
                                aria-label="<?php esc_attr_e('Share on Twitter', 'mahbub-and-co'); ?>">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </article>
    <?php
}

if ($use_custom_query) {
    wp_reset_postdata();
}
