<?php
$fields = get_query_var('fields');
$block_title = isset($fields['block_title']) ? $fields['block_title'] : 'Our Team';
$block_description = isset($fields['block_description']) ? $fields['block_description'] : 'Meet our amazing team members.';
$button_text = isset($fields['button_text']) ? $fields['button_text'] : 'Search for Expert';

// Get all team_area terms
$terms = get_terms(array(
    'taxonomy' => 'team_area',
    'hide_empty' => false,
));
?>

<div class="our-people-section mahbub__team-section-wrapper" style="display:flex; gap:10px; flex-wrap:wrap;">
    <!-- DEBUG TERMS:
    <?php
    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $t) {
            echo "ID: " . $t->term_id . " | Slug: '" . $t->slug . "' | Name: '" . $t->name . "'\n";
        }
    } else {
        echo "No terms or WP_Error: " . (is_wp_error($terms) ? $terms->get_error_message() : 'empty');
    }
    ?>
    -->
    <img class="bg-img" src="https://i.postimg.cc/hGk6QtbV/hero-background-img.webp" alt="Hero Background">

    <!-- <div class="container"> -->
    <div class="our-people-container">
        <!-- ===== Left Section ===== -->
        <div class="team-section-left">
            <div class="team-left-inner">
                <div class="team-left-content">
                    <div class="text-content">
                        <h2 class="heading-one">
                            <?php echo esc_html($block_title); ?>
                        </h2>
                        <p class="body-text ">
                            <?php echo esc_html($block_description); ?>
                        </p>
                    </div>

                    <div class="form-wrapper">
                        <form class="mahbub__team-search-form" id="mahbub__team-search-form" method="GET">
                            <div class="mahbub__input-wrapper">
                                <input type="text" name="mahbub__team_search" placeholder="Search by name"
                                    class="mahbub__team-search-input">

                                <svg class="mahbub__input-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_927_12810)">
                                        <path
                                            d="M10.875 18.75C15.2242 18.75 18.75 15.2242 18.75 10.875C18.75 6.52576 15.2242 3 10.875 3C6.52576 3 3 6.52576 3 10.875C3 15.2242 6.52576 18.75 10.875 18.75Z"
                                            stroke="white" stroke-opacity="0.8" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M16.4453 16.4434L21.0016 20.9996" stroke="white" stroke-opacity="0.8"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_927_12810">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>

                            <select name="mahbub__team_area" class="mahbub__team-select">
                                <option value="">Select Area</option>
                                <?php
                                if (!empty($terms) && !is_wp_error($terms)) {
                                    foreach ($terms as $term) {
                                        echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                                    }
                                }
                                ?>
                            </select>

                            <button type="submit" class="primary-button">
                                <div class="button-text">
                                    <?php echo esc_html($button_text); ?>
                                </div>

                                <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="44" height="44" rx="22" fill="#BC001A" />
                                    <g clip-path="url(#clip0_642_270)">
                                        <path d="M16.166 17H26.9993V27.8333" stroke="white" stroke-width="2"
                                            stroke-miterlimit="10" />
                                        <path d="M16 28L27 17" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_642_270">
                                            <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- ===== Right Section ===== -->
        <div class="team-section-right">

            <div class="team-right-inner">
                <div class="team-right-content">
                    <!-- Selected Category Display -->
                    <div class="mahbub__selected-category" style="display:none;">
                        <span class="mahbub__selected-category-name"></span>
                        <button type="button" class="mahbub__clear-category" style="margin-left:10px;"><svg width="14"
                                height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.402 10.4735C11.5253 10.5968 11.5946 10.764 11.5946 10.9383C11.5946 11.1127 11.5253 11.2799 11.402 11.4032C11.2787 11.5265 11.1115 11.5957 10.9372 11.5957C10.7628 11.5957 10.5956 11.5265 10.4723 11.4032L7.00022 7.92997L3.52702 11.4021C3.40373 11.5254 3.23652 11.5946 3.06217 11.5946C2.88782 11.5946 2.72061 11.5254 2.59733 11.4021C2.47405 11.2788 2.40479 11.1116 2.40479 10.9372C2.40479 10.7629 2.47405 10.5957 2.59733 10.4724L6.07053 7.00028L2.59842 3.52708C2.47514 3.40379 2.40588 3.23658 2.40588 3.06223C2.40588 2.88788 2.47514 2.72067 2.59842 2.59739C2.72171 2.4741 2.88892 2.40484 3.06327 2.40484C3.23762 2.40484 3.40483 2.4741 3.52811 2.59739L7.00022 6.07059L10.4734 2.59684C10.5967 2.47356 10.7639 2.4043 10.9383 2.4043C11.1126 2.4043 11.2798 2.47356 11.4031 2.59684C11.5264 2.72013 11.5957 2.88733 11.5957 3.06169C11.5957 3.23604 11.5264 3.40324 11.4031 3.52653L7.92991 7.00028L11.402 10.4735Z"
                                    fill="#BC001A" />
                            </svg>
                        </button>
                    </div>

                    <div class="mahbub__team-results">
                        <?php
                        // Placeholder cards: same .mahbub__team-member design, no content. Replaced by real results on search.
                        for ($i = 0; $i < 6; $i++) :
                        ?>
                        <div class="mahbub__team-member mahbub__team-member--placeholder" aria-hidden="true">
                            <div class="mahbub__team-thumb"></div>
                            <div class="team-member-info">
                                <h3 class="mahbub__team-name">&nbsp;</h3>
                                <p class="mahbub__team-designation">&nbsp;</p>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->

</div>