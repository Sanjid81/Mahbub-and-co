<?php
get_header();

// Current subcategory
$term = get_queried_object();

// Carbon Fields meta for category
$title = carbon_get_term_meta($term->term_id, 'crb_title');
$banner = carbon_get_term_meta($term->term_id, 'crb_banner');
$description = carbon_get_term_meta($term->term_id, 'crb_description');
$button_text = carbon_get_term_meta($term->term_id, 'button_text');

$pdf_btn_text = carbon_get_term_meta($term->term_id, 'pdf_button_text');
$pdf_id = carbon_get_term_meta($term->term_id, 'pdf_file');
$pdf_url = $pdf_id ? wp_get_attachment_url($pdf_id) : '';

$description_bg_id = carbon_get_term_meta($term->term_id, 'crb_description_background');
$description_bg_url = $description_bg_id ? wp_get_attachment_url($description_bg_id) : 'https://i.postimg.cc/hGk6QtbV/hero-background-img.webp';


// $back_url = wp_get_referer();


// Team members in this subcategory
$team_query = new WP_Query(array(
    'post_type' => 'team',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'team_area',
            'field' => 'term_id',
            'terms' => $term->term_id,
        ),
    ),
));
?>

<section class="subcategory-details-section">
    <img class="bg-img" src="<?php echo esc_url($description_bg_url); ?>" alt="">
    <div class="subcategory-details-wrapper">
        <div class="subcategory-details-header">
            <button class="back-btn" onclick="history.back()">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.4693 6.99962C12.4693 7.17366 12.4001 7.34058 12.2771 7.46365C12.154 7.58672 11.9871 7.65587 11.813 7.65587H3.77396L6.59145 10.4728C6.71474 10.5961 6.784 10.7633 6.784 10.9377C6.784 11.112 6.71474 11.2792 6.59145 11.4025C6.46817 11.5258 6.30096 11.5951 6.12661 11.5951C5.95226 11.5951 5.78505 11.5258 5.66177 11.4025L1.72427 7.46501C1.66309 7.40404 1.61454 7.33159 1.58142 7.25182C1.5483 7.17206 1.53125 7.08653 1.53125 7.00016C1.53125 6.91379 1.5483 6.82827 1.58142 6.7485C1.61454 6.66873 1.66309 6.59629 1.72427 6.53532L5.66177 2.59782C5.72281 2.53677 5.79528 2.48835 5.87504 2.45531C5.9548 2.42228 6.04028 2.40527 6.12661 2.40527C6.21294 2.40527 6.29843 2.42228 6.37818 2.45531C6.45794 2.48835 6.53041 2.53677 6.59145 2.59782C6.6525 2.65886 6.70092 2.73133 6.73396 2.81109C6.767 2.89085 6.784 2.97633 6.784 3.06266C6.784 3.14899 6.767 3.23448 6.73396 3.31423C6.70092 3.39399 6.6525 3.46646 6.59145 3.52751L3.77396 6.34337H11.813C11.9871 6.34337 12.154 6.41251 12.2771 6.53558C12.4001 6.65865 12.4693 6.82557 12.4693 6.99962Z"
                        fill="white" />
                </svg>
                <?php echo esc_html($button_text ?: 'Back'); ?>
            </button>


            <?php if ($title): ?>
                <h1 class="subcategory-title">
                    <?php echo esc_html($title); ?>
                </h1>
            <?php endif; ?>
        </div>
        <?php if ($banner): ?>
            <div class="subcategory-banner">
                <img src="<?php echo wp_get_attachment_url($banner); ?>" alt="<?php echo esc_attr($title); ?>"
                    class="w-full object-contain object-top">
            </div>
        <?php endif; ?>


        <div class="subcategory-description-container">
            <div class="subcategory-description-content-wrapper">
                <?php if ($description): ?>
                    <div class="subcategory-description-content">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>
                <?php if ($pdf_url): ?>
                    <a href="<?php echo esc_url($pdf_url); ?>" class="pdf-download-btn" download>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5 17.5H2.5M15 9.16667L10 14.1667M10 14.1667L5 9.16667M10 14.1667V2.5"
                                stroke="#BC001A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <?php echo esc_html($pdf_btn_text ?: 'Read More'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="team-members-container">
                <h2>Key Contact</h2>
                <?php if ($team_query->have_posts()): ?>
                    <div class="team-members">
                        <?php while ($team_query->have_posts()):
                            $team_query->the_post();

                            // Dynamic fields
                            $email = carbon_get_post_meta(get_the_ID(), 'team_email');
                            $phone = carbon_get_post_meta(get_the_ID(), 'team_number');

                            // designation from team post meta
                            $designation = get_post_meta(get_the_ID(), '_team_member_designation', true);
                            ?>
                            <div class="team-member ">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="team-thumb">
                                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover rounded']); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="team-member-contact-info">
                                    <h3 class="team-name">
                                        <?php the_title(); ?>
                                    </h3>

                                    <?php if ($designation): ?>

                                        <p class="team-designation">
                                            <?php echo esc_html($designation); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ($email): ?>
                                        <p class="team-email">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_927_13250)">
                                                    <path
                                                        d="M14.6606 4.66504L8.66876 8.48168C8.46543 8.59978 8.23447 8.66199 7.99933 8.66199C7.76419 8.66199 7.53323 8.59978 7.3299 8.48168L1.33203 4.66504"
                                                        stroke="#BC001A" stroke-width="1.33286" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M13.3278 2.66602H2.66489C1.92877 2.66602 1.33203 3.26276 1.33203 3.99888V11.996C1.33203 12.7322 1.92877 13.3289 2.66489 13.3289H13.3278C14.0639 13.3289 14.6606 12.7322 14.6606 11.996V3.99888C14.6606 3.26276 14.0639 2.66602 13.3278 2.66602Z"
                                                        stroke="#BC001A" stroke-width="1.33286" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_927_13250">
                                                        <rect width="15.9943" height="15.9943" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                            <a href="mailto:<?php echo esc_attr($email); ?>">


                                                <?php echo esc_html($email); ?>
                                            </a>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($phone): ?>
                                        <p class="team-number">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_927_13272)">
                                                    <path
                                                        d="M9.21723 11.0416C9.35487 11.1048 9.50993 11.1192 9.65687 11.0825C9.80381 11.0458 9.93386 10.9601 10.0256 10.8396L10.2622 10.5297C10.3863 10.3642 10.5473 10.2298 10.7324 10.1373C10.9175 10.0448 11.1216 9.9966 11.3285 9.9966H13.3278C13.6813 9.9966 14.0203 10.137 14.2702 10.387C14.5202 10.6369 14.6606 10.976 14.6606 11.3295V13.3287C14.6606 13.6822 14.5202 14.0213 14.2702 14.2712C14.0203 14.5212 13.6813 14.6616 13.3278 14.6616C10.1463 14.6616 7.09514 13.3978 4.8455 11.1481C2.59586 8.8985 1.33203 5.84733 1.33203 2.66587C1.33203 2.31237 1.47246 1.97335 1.72242 1.72339C1.97238 1.47343 2.31139 1.33301 2.66489 1.33301H4.66418C5.01768 1.33301 5.35669 1.47343 5.60665 1.72339C5.85661 1.97335 5.99704 2.31237 5.99704 2.66587V4.66516C5.99704 4.87208 5.94886 5.07616 5.85633 5.26123C5.76379 5.44631 5.62943 5.60729 5.4639 5.73145L5.15201 5.96536C5.02966 6.05878 4.94343 6.19167 4.90795 6.34146C4.87248 6.49125 4.88996 6.6487 4.95741 6.78707C5.86821 8.63699 7.36617 10.1331 9.21723 11.0416Z"
                                                        stroke="#BC001A" stroke-width="1.33286" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_927_13272">
                                                        <rect width="15.9943" height="15.9943" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <a href="tel:<?php echo esc_attr($phone); ?>">
                                                <?php echo esc_html($phone); ?>
                                            </a>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                <?php else: ?>F
                </div>
                <p class="text-gray-500">No team members found in this category.</p>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php
$details_content = function_exists('carbon_get_term_meta') ? carbon_get_term_meta($term->term_id, 'expertise_details_content') : '';
$blocks_page_arr = function_exists('carbon_get_term_meta') ? carbon_get_term_meta($term->term_id, 'expertise_blocks_page') : array();
$blocks_page_id = 0;
if (is_array($blocks_page_arr) && !empty($blocks_page_arr)) {
    $first = $blocks_page_arr[0];
    $blocks_page_id = is_array($first) && isset($first['id']) ? (int) $first['id'] : (int) $first;
}

if ($details_content !== '' && trim($details_content) !== '') {
    echo '<div class="expertise-details-custom-blocks">';
    echo '<div class="container">';
    echo wp_kses_post(apply_filters('the_content', $details_content));
    echo '</div>';
    echo '</div>';
}

if ($blocks_page_id > 0) {
    $blocks_page = get_post($blocks_page_id);
    if ($blocks_page && $blocks_page->post_status === 'publish') {
        echo '<div class="expertise-details-custom-blocks expertise-details-blocks-from-page">';
        $page_content = get_post_field('post_content', $blocks_page_id);
        echo apply_filters('the_content', $page_content);
        echo '</div>';
    }
}
?>

<?php get_footer(); ?>