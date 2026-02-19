<?php
/**
 * Component: Single Team Member Profile
 * File: single-team-details.php
 * Included by: single-team.php
 */
?>

<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>

        <section class="team-details-banner-section">
            <div class="button-wraper">
                <button class="back-btn" onclick="history.back()">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.4693 6.99962C12.4693 7.17366 12.4001 7.34058 12.2771 7.46365C12.154 7.58672 11.9871 7.65587 11.813 7.65587H3.77396L6.59145 10.4728C6.71474 10.5961 6.784 10.7633 6.784 10.9377C6.784 11.112 6.71474 11.2792 6.59145 11.4025C6.46817 11.5258 6.30096 11.5951 6.12661 11.5951C5.95226 11.5951 5.78505 11.5258 5.66177 11.4025L1.72427 7.46501C1.66309 7.40404 1.61454 7.33159 1.58142 7.25182C1.5483 7.17206 1.53125 7.08653 1.53125 7.00016C1.53125 6.91379 1.5483 6.82827 1.58142 6.7485C1.61454 6.66873 1.66309 6.59629 1.72427 6.53532L5.66177 2.59782C5.72281 2.53677 5.79528 2.48835 5.87504 2.45531C5.9548 2.42228 6.04028 2.40527 6.12661 2.40527C6.21294 2.40527 6.29843 2.42228 6.37818 2.45531C6.45794 2.48835 6.53041 2.53677 6.59145 2.59782C6.6525 2.65886 6.70092 2.73133 6.73396 2.81109C6.767 2.89085 6.784 2.97633 6.784 3.06266C6.784 3.14899 6.767 3.23448 6.73396 3.31423C6.70092 3.39399 6.6525 3.46646 6.59145 3.52751L3.77396 6.34337H11.813C11.9871 6.34337 12.154 6.41251 12.2771 6.53558C12.4001 6.65865 12.4693 6.82557 12.4693 6.99962Z"
                            fill="black" />
                    </svg>

                    Back </button>
            </div>
            <div class="team-profile-wrapper">

                <div class="team-profile-grid">

                    <!-- Photo + Downloads Column -->
                    <div class="team-profile-photo-area">
                        <div class="team-profile-photo-frame">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('team-large', [
                                    'class' => 'team-profile-photo-img',
                                    'alt' => get_the_title()
                                ]); ?>
                            <?php else: ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/img/placeholder-team.jpg"
                                    alt="No photo" class="team-profile-photo-img">
                            <?php endif; ?>
                        </div>


                    </div>

                    <div class="team-profile-info-container">
                        <div class="team-profile-info-content">

                            <div class="team-profile-info-area">

                                <h1 class="team-profile-name">
                                    <?php the_title(); ?>
                                </h1>

                                <?php
                                $designation = carbon_get_post_meta(get_the_ID(), 'team_designation')
                                    ?: get_post_meta(get_the_ID(), '_team_member_designation', true)
                                    ?: '—';
                                ?>
                                <p class="team-profile-designation">
                                    <?php echo esc_html($designation); ?>
                                </p>

                                <div class="team-profile-contact-group">



                                    <?php
                                    $email = carbon_get_post_meta(get_the_ID(), 'team_email') ?: get_post_meta(get_the_ID(), 'team_email', true);
                                    $email = trim($email);
                                    ?>
                                    <?php if ($email): ?>
                                        <div class="profile-contact-item email-item">
                                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-icon-wrapper">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M21.6244 8.06221L12.6244 2.06222C12.4395 1.93887 12.2222 1.87305 12 1.87305C11.7778 1.87305 11.5605 1.93887 11.3756 2.06222L2.37563 8.06221C2.22138 8.16512 2.09497 8.30456 2.00763 8.46812C1.92029 8.63168 1.87473 8.81429 1.875 8.99971V18.7497C1.875 19.247 2.07255 19.7239 2.42418 20.0755C2.77581 20.4272 3.25272 20.6247 3.75 20.6247H20.25C20.7473 20.6247 21.2242 20.4272 21.5758 20.0755C21.9275 19.7239 22.125 19.247 22.125 18.7497V8.99971C22.1253 8.81429 22.0797 8.63168 21.9924 8.46812C21.905 8.30456 21.7786 8.16512 21.6244 8.06221ZM8.41969 14.2497L4.125 17.2788V11.185L8.41969 14.2497ZM10.7213 15.3747H13.2788L17.5313 18.3747H6.47344L10.7213 15.3747ZM15.5803 14.2497L19.875 11.1832V17.2769L15.5803 14.2497ZM12 4.35159L19.0181 9.03065L13.2759 13.1247H10.7241L4.98188 9.03065L12 4.35159Z"
                                                        fill="white" />
                                                </svg>

                                            </a>

                                        </div>
                                    <?php endif; ?>


                                    <!-- Social Links -->
                                    <?php
                                    $socials = carbon_get_post_meta(get_the_ID(), 'team_socials') ?: [];
                                    if (is_array($socials) && !empty($socials)): ?>
                                        <div class="team-profile-social-section">
                                            <div class="social-icons-list">
                                                <?php foreach ($socials as $s): ?>
                                                    <?php if (empty($s['social_url']))
                                                        continue; ?>
                                                    <a href="<?php echo esc_url($s['social_url']); ?>" target="_blank"
                                                        rel="noopener noreferrer" class="social-icon-link"
                                                        title="<?php echo esc_attr($s['social_name'] ?: 'Profile'); ?>">

                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M20.25 1.875H3.75C3.25272 1.875 2.77581 2.07254 2.42417 2.42417C2.07254 2.77581 1.875 3.25272 1.875 3.75V20.25C1.875 20.7473 2.07254 21.2242 2.42417 21.5758C2.77581 21.9275 3.25272 22.125 3.75 22.125H20.25C20.7473 22.125 21.2242 21.9275 21.5758 21.5758C21.9275 21.2242 22.125 20.7473 22.125 20.25V3.75C22.125 3.25272 21.9275 2.77581 21.5758 2.42417C21.2242 2.07254 20.7473 1.875 20.25 1.875ZM19.875 19.875H4.125V4.125H19.875V19.875ZM10.5 16.5V11.25C10.5002 11.0162 10.5733 10.7883 10.709 10.5979C10.8447 10.4076 11.0364 10.2642 11.2574 10.1878C11.4783 10.1114 11.7176 10.1058 11.9419 10.1716C12.1662 10.2375 12.3645 10.3716 12.5091 10.5553C13.0805 10.2558 13.7195 10.1088 14.3643 10.1284C15.0092 10.1481 15.6381 10.3338 16.1901 10.6676C16.7422 11.0014 17.1989 11.472 17.5159 12.0338C17.833 12.5957 17.9997 13.2299 18 13.875V16.5C18 16.7984 17.8815 17.0845 17.6705 17.2955C17.4595 17.5065 17.1734 17.625 16.875 17.625C16.5766 17.625 16.2905 17.5065 16.0795 17.2955C15.8685 17.0845 15.75 16.7984 15.75 16.5V13.875C15.75 13.4772 15.592 13.0956 15.3107 12.8143C15.0294 12.533 14.6478 12.375 14.25 12.375C13.8522 12.375 13.4706 12.533 13.1893 12.8143C12.908 13.0956 12.75 13.4772 12.75 13.875V16.5C12.75 16.7984 12.6315 17.0845 12.4205 17.2955C12.2095 17.5065 11.9234 17.625 11.625 17.625C11.3266 17.625 11.0405 17.5065 10.8295 17.2955C10.6185 17.0845 10.5 16.7984 10.5 16.5ZM9 11.25V16.5C9 16.7984 8.88147 17.0845 8.6705 17.2955C8.45952 17.5065 8.17337 17.625 7.875 17.625C7.57663 17.625 7.29048 17.5065 7.0795 17.2955C6.86853 17.0845 6.75 16.7984 6.75 16.5V11.25C6.75 10.9516 6.86853 10.6655 7.0795 10.4545C7.29048 10.2435 7.57663 10.125 7.875 10.125C8.17337 10.125 8.45952 10.2435 8.6705 10.4545C8.88147 10.6655 9 10.9516 9 11.25ZM6.375 7.5C6.375 7.20333 6.46297 6.91332 6.6278 6.66665C6.79262 6.41997 7.02689 6.22771 7.30097 6.11418C7.57506 6.00065 7.87666 5.97094 8.16764 6.02882C8.45861 6.0867 8.72588 6.22956 8.93566 6.43934C9.14544 6.64912 9.2883 6.91639 9.34618 7.20736C9.40406 7.49834 9.37435 7.79994 9.26082 8.07403C9.14729 8.34811 8.95503 8.58238 8.70835 8.7472C8.46168 8.91203 8.17167 9 7.875 9C7.47718 9 7.09564 8.84196 6.81434 8.56066C6.53304 8.27936 6.375 7.89782 6.375 7.5Z"
                                                                fill="white" />
                                                        </svg>

                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <!-- Info Column -->
                            <div class="team-profile-downloads">
                                <?php
                                $cv_url = carbon_get_post_meta(get_the_ID(), 'team_cv_file') ?? '';
                                $cv_text = carbon_get_post_meta(get_the_ID(), 'team_cv_button_text') ?: 'Download CV';
                                $port_url = carbon_get_post_meta(get_the_ID(), 'team_portfolio_file') ?? '';
                                $port_text = carbon_get_post_meta(get_the_ID(), 'team_portfolio_button_text') ?: 'View Portfolio';
                                ?>
                                <?php if ($cv_url): ?>
                                    <a href="<?php echo esc_url($cv_url); ?>" class="profile-download-btn cv-btn" download>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.5 17.5H2.5M15 9.16667L10 14.1667M10 14.1667L5 9.16667M10 14.1667V2.5"
                                                stroke="#BC001A" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>

                                        <?php echo esc_html($cv_text); ?>
                                    </a>
                                <?php endif; ?>
                                <?php if ($port_url): ?>
                                    <a href="<?php echo esc_url($port_url); ?>" class="profile-download-btn portfolio-btn" download>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.083 8.5H15.833" stroke="#BC001A" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12.083 11.5H15.833" stroke="#BC001A" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M6.46777 11.5C7.71041 11.5 8.71777 10.4926 8.71777 9.25C8.71777 8.00736 7.71041 7 6.46777 7C5.22513 7 4.21777 8.00736 4.21777 9.25C4.21777 10.4926 5.22513 11.5 6.46777 11.5Z"
                                                stroke="#BC001A" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M3.56348 13.75C3.7287 13.1047 4.104 12.5327 4.63021 12.1243C5.15642 11.7158 5.8036 11.4941 6.46973 11.4941C7.13585 11.4941 7.78304 11.7158 8.30924 12.1243C8.83545 12.5327 9.21075 13.1047 9.37598 13.75"
                                                stroke="#BC001A" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M18.083 2.5H1.58301C1.16879 2.5 0.833008 2.83579 0.833008 3.25V16.75C0.833008 17.1642 1.16879 17.5 1.58301 17.5H18.083C18.4972 17.5 18.833 17.1642 18.833 16.75V3.25C18.833 2.83579 18.4972 2.5 18.083 2.5Z"
                                                stroke="#BC001A" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>

                                        <?php echo esc_html($port_text); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <!-- Main Content Area (blocks / components after the profile) -->
        <div class="team-profile-content-area">
            <?php the_content(); ?>
        </div>



    <?php endwhile; else: ?>
    <div class="team-profile-not-found">
        <h2>Team member not found</h2>
        <p>Sorry, the requested team member could not be found.</p>
    </div>
<?php endif; ?>