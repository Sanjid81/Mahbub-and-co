 <div class="insights-bottom-slider-section">
          <?php
          // Get fields from query var (set by block or archive)
          $fields = get_query_var('insights_slider_fields', []);

          $heading = !empty($fields['heading']) ? $fields['heading'] : 'Featured Insights';
          $slides_count = !empty($fields['slides_count']) ? (int) $fields['slides_count'] : 5;
          $cat_slug = !empty($fields['insights_category']) ? $fields['insights_category'] : '';
          $bg_id = !empty($fields['background_image']) ? (int) $fields['background_image'] : 0;

          // Get background URL safely
          $bg_url = '';
          if ($bg_id > 0) {
              $bg_url = wp_get_attachment_image_url($bg_id, 'full');
              // Fallback: try large size if full fails
              if (!$bg_url) {
                  $bg_url = wp_get_attachment_image_url($bg_id, 'large');
              }
          }

          // Debug output (remove later)
          if (!$bg_url && $bg_id > 0) {
              // Uncomment to debug
              echo "<!-- Debug: No bg url for ID {$bg_id} -->";
          }

          // WP_Query setup
          $args = [
              'post_type' => 'insights',
              'posts_per_page' => $slides_count,
              'post_status' => 'publish',
              'orderby' => 'date',
              'order' => 'DESC',
              'ignore_sticky_posts' => true,
          ];

          if (!empty($cat_slug)) {
              $args['tax_query'] = [
                  [
                      'taxonomy' => 'insights_category',
                      'field' => 'slug',
                      'terms' => $cat_slug,
                  ]
              ];
          }

          $query = new WP_Query($args);
          ?>

    <section class="insights-bottom-slider" <?php if ($bg_url): ?> style="background-image: url('
        <?php echo esc_url($bg_url); ?>');"
        <?php endif; ?>>
        <!-- <div class="overlay"></div> -->
        <div class="container">
            <div class="header-row">
                <h2 class="heading-one">
                    <?php echo esc_html($heading); ?>
                </h2>

                <div class="insights-slider-buttons">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>

            <?php if ($query->have_posts()): ?>
                    <div class="insights-details-bottom-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <?php while ($query->have_posts()):
                                    $query->the_post(); ?>
                                        <div class="swiper-slide">
                                            <!-- <a href="< ?php the_permalink(); ?>" class="insight-card-link"> -->
                                            <div class="insights-card">
                                                <div class="insights-card-image">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php if (has_post_thumbnail()): ?>
                                                                <?php the_post_thumbnail('medium', [
                                                                    'class' => 'insights-card-img',
                                                                    'alt' => get_the_title()
                                                                ]); ?>
                                                        <?php else: ?>
                                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/img/placeholder.jpg'); ?>"
                                                                    alt="No image" class="insights-card-img">
                                                        <?php endif; ?>
                                                    </a>
                                                </div>

                                                <div class="insights-card-content">
                                                    <div class="insights-card-meta">
                                                        <?php
                                                        $terms = get_the_terms(get_the_ID(), 'insights_category');
                                                        if ($terms && !is_wp_error($terms)) {
                                                            echo '<span class="category-badge meta-category">' . esc_html($terms[0]->name) . '</span>';
                                                        }
                                                        ?>
                                                        <div class="circle"></div>

                                                        <?php
                                                        $custom_date = carbon_get_the_post_meta('insights_custom_publish_date');
                                                        $display_date = $custom_date
                                                            ? date('M j, Y', strtotime($custom_date))
                                                            : get_the_date('M j, Y');
                                                        ?>
                                                        <span class="insights-card-date">
                                                            <?php echo esc_html($display_date); ?>
                                                        </span>
                                                    </div>

                                                    <h3 class="insights-card-title">
                                                        <a href="<?php the_permalink(); ?>">
                                                            <?php the_title(); ?>
                                                        </a>
                                                    </h3>

                                                    <?php if (has_excerpt()): ?>
                                                            <div class="insights-card-excerpt">
                                                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                                            </div>
                                                    <?php endif; ?>

                                                    <div class="insights-card-details-button">
                                                        <a href="<?php the_permalink(); ?>" class="insights-card-link">
                                                            Read More →
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- </a> -->
                                        </div>
                                <?php endwhile; ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
            <?php else: ?>
                    <p style="text-align:center; color:#fff; background:rgba(0,0,0,0.5); padding:1rem;">
                        No insights found!
                    </p>
            <?php endif; ?>
        </div>
    </section>
</div>