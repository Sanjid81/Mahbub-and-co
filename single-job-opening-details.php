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
    $share_email_subject = sprintf(__('Share: %s', 'mahbub-and-co'), $share_title);
    $share_email_body = $share_title . "\n" . $share_url;
    $share_email_custom = function_exists('carbon_get_post_meta') ? trim((string) carbon_get_post_meta($id, 'maco_job_share_email')) : '';
    $share_email = 'mailto:' . ($share_email_custom !== '' ? $share_email_custom : '') . '?subject=' . rawurlencode($share_email_subject) . '&body=' . rawurlencode($share_email_body);
    $share_fb_custom = function_exists('carbon_get_post_meta') ? trim((string) carbon_get_post_meta($id, 'maco_job_share_facebook')) : '';
    $share_li_custom = function_exists('carbon_get_post_meta') ? trim((string) carbon_get_post_meta($id, 'maco_job_share_linkedin')) : '';
    if ($share_fb_custom !== '') {
        $share_fb = $share_fb_custom;
    }
    if ($share_li_custom !== '') {
        $share_li = $share_li_custom;
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
    <section class="maco-opening-detail" id="maco-opening-detail-<?php echo esc_attr($id); ?>"
        data-maco-opening-id="<?php echo esc_attr($id); ?>">
        <div class="container">
            <div class="maco-opening-detail-inner">
                <button class="back-btn" onclick="history.back()">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.4693 6.99962C12.4693 7.17366 12.4001 7.34058 12.2771 7.46365C12.154 7.58672 11.9871 7.65587 11.813 7.65587H3.77396L6.59145 10.4728C6.71474 10.5961 6.784 10.7633 6.784 10.9377C6.784 11.112 6.71474 11.2792 6.59145 11.4025C6.46817 11.5258 6.30096 11.5951 6.12661 11.5951C5.95226 11.5951 5.78505 11.5258 5.66177 11.4025L1.72427 7.46501C1.66309 7.40404 1.61454 7.33159 1.58142 7.25182C1.5483 7.17206 1.53125 7.08653 1.53125 7.00016C1.53125 6.91379 1.5483 6.82827 1.58142 6.7485C1.61454 6.66873 1.66309 6.59629 1.72427 6.53532L5.66177 2.59782C5.72281 2.53677 5.79528 2.48835 5.87504 2.45531C5.9548 2.42228 6.04028 2.40527 6.12661 2.40527C6.21294 2.40527 6.29843 2.42228 6.37818 2.45531C6.45794 2.48835 6.53041 2.53677 6.59145 2.59782C6.6525 2.65886 6.70092 2.73133 6.73396 2.81109C6.767 2.89085 6.784 2.97633 6.784 3.06266C6.784 3.14899 6.767 3.23448 6.73396 3.31423C6.70092 3.39399 6.6525 3.46646 6.59145 3.52751L3.77396 6.34337H11.813C11.9871 6.34337 12.154 6.41251 12.2771 6.53558C12.4001 6.65865 12.4693 6.82557 12.4693 6.99962Z"
                            fill="black" />
                    </svg>

                    Back </button>


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
                            <h2 class="maco-openings-card-title maco-opening-detail-sidebar-title">
                                <?php the_title(); ?>
                            </h2>
                            <div class="maco-openings-card-meta">
                                <?php if ($exp !== ''): ?>
                                    <span class="maco-openings-card-meta-item">
                                        <span class="maco-openings-card-meta-icon" aria-hidden="true">
                                            <!-- < ?php echo $icon_briefcase; ?> -->
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
                                            <!-- < ?php echo $icon_pin; ?> -->
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
                                            <!-- < ?php echo $icon_briefcase; ?> -->
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
                                            <!-- < ?php echo $icon_calendar; ?> -->
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

                            <a href="<?php echo esc_url($apply_link); ?>" class="red-bg-button" data-aos="fade-up">
                                <div class="button-text">
                                    <?php echo esc_html($apply_text); ?>
                                </div>
                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
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
                        </div>
                        <div class="maco-opening-detail-share-card">
                            <h3 class="maco-opening-detail-share-title">
                                <?php echo esc_html__('Share this Job', 'mahbub-and-co'); ?>
                            </h3>
                            <div class="maco-opening-detail-share-icons">
                                <a href="<?php echo esc_url($share_email); ?>" class="maco-opening-detail-share-icon"
                                    aria-label="<?php esc_attr_e('Share via Email', 'mahbub-and-co'); ?>">
                                    <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#960014" />
                                        <path
                                            d="M25 12.25H13C11.35 12.25 10 13.6 10 15.25V22.75C10 24.4 11.35 25.75 13 25.75H25C26.65 25.75 28 24.4 28 22.75V15.25C28 13.6 26.65 12.25 25 12.25ZM26.2 16.6L20.275 20.575C19.9 20.8 19.45 20.95 19 20.95C18.55 20.95 18.1 20.8 17.725 20.575L11.8 16.6C11.5 16.375 11.425 15.925 11.65 15.55C11.875 15.25 12.325 15.175 12.7 15.4L18.625 19.375C18.85 19.525 19.225 19.525 19.45 19.375L25.375 15.4C25.75 15.175 26.2 15.25 26.425 15.625C26.575 15.925 26.5 16.375 26.2 16.6Z"
                                            fill="#960014" />
                                    </svg>

                                </a>
                                <a href="<?php echo esc_url($share_fb); ?>" class="maco-opening-detail-share-icon"
                                    target="_blank" rel="noopener"
                                    aria-label="<?php esc_attr_e('Share on Facebook', 'mahbub-and-co'); ?>">
                                    <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#960014" />
                                        <path
                                            d="M23.1598 20.0485L23.6556 16.8155H20.5537V14.7175C20.5537 13.833 20.987 12.9709 22.3764 12.9709H23.7867V10.2185C23.7867 10.2185 22.5068 10 21.2831 10C18.7283 10 17.0586 11.5484 17.0586 14.3515V16.8155H14.2188V20.0485H17.0586V27.8641C17.628 27.9535 18.2116 28 18.8061 28C19.4007 28 19.9843 27.9535 20.5537 27.8641V20.0485H23.1598Z"
                                            fill="#960014" />
                                    </svg>

                                </a>
                                <a href="<?php echo esc_url($share_li); ?>" class="maco-opening-detail-share-icon"
                                    target="_blank" rel="noopener"
                                    aria-label="<?php esc_attr_e('Share on LinkedIn', 'mahbub-and-co'); ?>">
                                    <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#960014" />
                                        <g clip-path="url(#clip0_1420_20214)">
                                            <path
                                                d="M28 20.9445V27.5988H24.1414V21.3923C24.1414 19.8313 23.5847 18.7683 22.1869 18.7683C21.1197 18.7683 20.4878 19.484 20.2074 20.1787C20.107 20.4256 20.0777 20.773 20.0777 21.1203V27.603H16.219C16.219 27.603 16.2692 17.0859 16.219 15.9978H20.0777V17.6425C20.0693 17.6551 20.0609 17.6676 20.0525 17.6802H20.0777V17.6425C20.5924 16.8515 21.5048 15.7258 23.5555 15.7258C26.0958 15.7216 28 17.383 28 20.9445ZM12.1846 10.4023C10.8621 10.4023 10 11.2687 10 12.407C10 13.5202 10.837 14.4116 12.1344 14.4116H12.1595C13.5071 14.4116 14.3441 13.5202 14.3441 12.407C14.3148 11.2687 13.5029 10.4023 12.1846 10.4023ZM10.2302 27.603H14.0888V15.9936H10.2302V27.603Z"
                                                fill="#960014" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1420_20214">
                                                <rect width="18" height="18" fill="white" transform="translate(10 10)" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                </a>

                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <?php
}

if ($use_custom_query) {
    wp_reset_postdata();
}
