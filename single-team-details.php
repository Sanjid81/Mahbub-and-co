<?php
get_header();
?>
<?php
get_header();
echo '<h1 style="color:red;">Single Team Page Loaded Successfully!</h1>';
echo '<p>Post ID: ' . get_the_ID() . '</p>';
echo '<p>Title: ' . get_the_title() . '</p>';
?>
<div class="team-member-single">

    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>

            <article class="team-member-article">

                <div class="team-member-layout">

                    <!-- Photo Column -->
                    <div class="team-member-photo-column">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="team-member-photo">
                                <?php the_post_thumbnail('team-large', array('class' => 'team-member-photo-img', 'alt' => get_the_title())); ?>
                            </div>
                        <?php else: ?>
                            <div class="team-member-photo no-photo">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/img/placeholder-team.jpg"
                                    alt="No photo" class="team-member-photo-img">
                            </div>
                        <?php endif; ?>

                        <!-- Downloads -->
                        <div class="team-member-downloads">
                            <?php if (function_exists('carbon_get_the_post_meta')): ?>
                                <?php $cv = carbon_get_the_post_meta('team_cv_file');
                                if ($cv): ?>
                                    <a href="<?php echo esc_url($cv); ?>" class="download-btn download-cv" download>Download CV</a>
                                <?php endif; ?>

                                <?php $port = carbon_get_the_post_meta('team_portfolio_file');
                                if ($port): ?>
                                    <a href="<?php echo esc_url($port); ?>" class="download-btn download-portfolio" download>Download
                                        Portfolio</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Info Column -->
                    <div class="team-member-info-column">

                        <h1 class="team-member-name"><?php the_title(); ?></h1>
                        <div style="background: #fff3cd; padding: 20px; border: 2px solid #ffeeba; margin: 20px 0;">
                            <strong>Debug Info (এটা পরে delete করো):</strong><br>
                            Post ID: <?php echo get_the_ID(); ?><br>

                            Designation from Carbon:
                            <?php
                            $des_carbon = carbon_get_the_post_meta('team_designation');
                            var_dump($des_carbon);
                            ?><br>

                            Designation from normal get_post_meta:
                            <?php var_dump(get_post_meta(get_the_ID(), 'team_designation', true)); ?><br>

                            Old fallback meta:
                            <?php var_dump(get_post_meta(get_the_ID(), '_team_member_designation', true)); ?>
                        </div>
                        <p class="team-member-designation">
                            <?php
                            $des = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('team_designation') : '';
                            $des = $des ?: get_post_meta(get_the_ID(), '_team_member_designation', true);
                            echo esc_html($des ?: '—');
                            ?>
                        </p>

                        <?php if (function_exists('carbon_get_the_post_meta')):
                            $email = carbon_get_the_post_meta('team_email');
                            if ($email): ?>
                                <p class="team-member-email">Email: <a
                                        href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                            <?php endif; endif; ?>

                        <?php if (function_exists('carbon_get_the_post_meta')):
                            $socials = carbon_get_the_post_meta('team_socials');
                            if ($socials && is_array($socials)): ?>
                                <div class="team-member-social-links">
                                    <h4>Social Profiles</h4>
                                    <ul class="social-links-list">
                                        <?php foreach ($socials as $s):
                                            $url = esc_url($s['social_url'] ?: '#');
                                            $name = esc_html($s['social_name'] ?: 'Link');
                                            $icon = esc_attr($s['social_icon'] ?: '');
                                            ?>
                                            <li class="social-link-item">
                                                <a href="<?php echo $url; ?>" target="_blank" rel="noopener" title="<?php echo $name; ?>">
                                                    <?php echo $icon ? '<i class="' . $icon . '"></i>' : $name; ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; endif; ?>

                        <div class="team-member-main-content"><?php the_content(); ?></div>

                        <?php if (has_excerpt()): ?>
                            <div class="team-member-excerpt"><?php the_excerpt(); ?></div>
                        <?php endif; ?>

                    </div>

                </div>

            </article>

        <?php endwhile; else: ?>
        <div class="team-member-not-found">
            <h2>Team member not found</h2>
            <p>Sorry, the requested team member could not be found.</p>
        </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>