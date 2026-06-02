<?php
$fields = get_query_var('news_insights_fields', []);

// News section data
$news_title = $fields['news_title'] ?? 'News & Events';
$news_cards = $fields['news_cards'] ?? [];

// Insights section data
$insights_title = $fields['insights_title'] ?? 'Insights';
$insights_cards = $fields['insights_cards'] ?? [];

// Buttons
$news_button_text = $fields['news_button_text'] ?? 'View more';
$news_button_link = $fields['news_button_link'] ?? '#';
$insights_button_text = $fields['insights_button_text'] ?? 'Get Started';
$insights_button_link = $fields['insights_button_link'] ?? '#';
?>
<section class="news-insights">
  <div class="container">
    <div class="section-columns">

      <!-- News & Events -->
      <div class="column">
        <h2 class="heading-two" data-aos="fade-up">
          <?php echo esc_html($news_title); ?>
        </h2>
        <div class="card-grid">
          <?php if (!empty($news_cards)): ?>
            <?php $first_card = array_shift($news_cards); ?>
            <!-- Card 1 -->
            <div class="card"data-aos="fade-up">
              <?php if ($first_card['image'] ?? false): ?>
                <div class="card-image">
                  <?php echo wp_get_attachment_image($first_card['image'], 'full'); ?>
                </div>
              <?php endif; ?>
              <div class="card-content" >
                <p class="meta" ><?php echo esc_html($first_card['meta']); ?></p>
                <h3 class="heading-three" ><?php echo esc_html($first_card['heading']); ?></h3>
                <p class="excerpt" ><?php echo esc_html($first_card['excerpt']); ?></p>
                <a href="<?php echo esc_url($first_card['read_more_link']); ?>" class="read-more" >
                  <?php echo esc_html($first_card['read_more_text']); ?>
                  <span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_730_55)">
                        <path
                          d="M12.1727 11.9998L9.34375 9.17184L10.7577 7.75684L15.0007 11.9998L10.7577 16.2428L9.34375 14.8278L12.1727 11.9998Z"
                          fill="#BC001A" />
                      </g>
                      <defs>
                        <clipPath id="clip0_730_55">
                          <rect width="24" height="24" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                  </span>
                </a>
              </div>
            </div>

            <!-- Remaining Cards -->
            <?php if (!empty($news_cards)): ?>
              <div class="card-grid-inner"data-aos="fade-down">
                <?php foreach ($news_cards as $card): ?>
                  <div class="card">
                    <?php if ($card['image'] ?? false): ?>
                      <div class="card-image">
                        <?php echo wp_get_attachment_image($card['image'], 'full'); ?>
                      </div>
                    <?php endif; ?>
                    <div class="card-content">
                      <p class="meta" ><?php echo esc_html($card['meta']); ?></p>
                      <h3 class="heading-three" ><?php echo esc_html($card['heading']); ?></h3>
                      <p class="excerpt" ><?php echo esc_html($card['excerpt']); ?></p>
                      <a href="<?php echo esc_url($card['read_more_link']); ?>" class="read-more" >
                        <?php echo esc_html($card['read_more_text']); ?>
                        <span>
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_730_55)">
                              <path
                                d="M12.1727 11.9998L9.34375 9.17184L10.7577 7.75684L15.0007 11.9998L10.7577 16.2428L9.34375 14.8278L12.1727 11.9998Z"
                                fill="#BC001A" />
                            </g>
                            <defs>
                              <clipPath id="clip0_730_55">
                                <rect width="24" height="24" fill="white" />
                              </clipPath>
                            </defs>
                          </svg>
                        </span>
                      </a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <div class="button-wrap" >
          <a href="<?php echo esc_url($news_button_link); ?>" class="primary-button"data-aos="fade-up">
            <div class="button-text"><?php echo esc_html($news_button_text); ?>
            </div>
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="44" height="44" rx="22" fill="#BC001A" />
              <g clip-path="url(#clip0_642_270)">
                <path d="M16.166 17H26.9993V27.8333" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                <path d="M16 28L27 17" stroke="white" stroke-width="2" stroke-miterlimit="10" />
              </g>
              <defs>
                <clipPath id="clip0_642_270">
                  <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                </clipPath>
              </defs>
            </svg>
          </a>
        </div>
      </div>

      <!-- Insights -->
      <div class="column">
        <h2 class="heading-two"data-aos="fade-up" >
          <?php echo esc_html($insights_title); ?></h2>
        <div class="card-grid">
          <?php if (!empty($insights_cards)): ?>
            <?php $first_card = array_shift($insights_cards); ?>
            <!-- Card 1 -->
            <div class="card"data-aos="fade-up">
              <?php if ($first_card['image'] ?? false): ?>
                <div class="card-image">
                  <?php echo wp_get_attachment_image($first_card['image'], 'full'); ?>
                </div>
              <?php endif; ?>
              <div class="card-content">
                <p class="meta" ><?php echo esc_html($first_card['meta']); ?></p>
                <h3 class="heading-three" ><?php echo esc_html($first_card['heading']); ?></h3>
                <p class="excerpt" ><?php echo esc_html($first_card['excerpt']); ?></p>
                <a href="<?php echo esc_url($first_card['read_more_link']); ?>" class="read-more" >
                  <?php echo esc_html($first_card['read_more_text']); ?>
                  <span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_730_55)">
                        <path
                          d="M12.1727 11.9998L9.34375 9.17184L10.7577 7.75684L15.0007 11.9998L10.7577 16.2428L9.34375 14.8278L12.1727 11.9998Z"
                          fill="#BC001A" />
                      </g>
                      <defs>
                        <clipPath id="clip0_730_55">
                          <rect width="24" height="24" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                  </span>
                </a>
              </div>
            </div>

            <!-- Remaining Cards -->
            <?php if (!empty($insights_cards)): ?>
              <div class="card-grid-inner"data-aos="fade-down">
                <?php foreach ($insights_cards as $card): ?>
                  <div class="card">
                    <?php if ($card['image'] ?? false): ?>
                      <div class="card-image">
                        <?php echo wp_get_attachment_image($card['image'], 'full'); ?>
                      </div>
                    <?php endif; ?>
                    <div class="card-content">
                      <p class="meta"><?php echo esc_html($card['meta']); ?></p>
                      <h3 class="heading-three"><?php echo esc_html($card['heading']); ?></h3>
                      <p class="excerpt"><?php echo esc_html($card['excerpt']); ?></p>
                      <a href="<?php echo esc_url($card['read_more_link']); ?>" class="read-more" data-aos="fade-up">
                        <?php echo esc_html($card['read_more_text']); ?>
                        <span>
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_730_55)">
                              <path
                                d="M12.1727 11.9998L9.34375 9.17184L10.7577 7.75684L15.0007 11.9998L10.7577 16.2428L9.34375 14.8278L12.1727 11.9998Z"
                                fill="#BC001A" />
                            </g>
                            <defs>
                              <clipPath id="clip0_730_55">
                                <rect width="24" height="24" fill="white" />
                              </clipPath>
                            </defs>
                          </svg>
                        </span>
                      </a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <div class="button-wrap">
          <a href="<?php echo esc_url($insights_button_link); ?>" class="primary-button" data-aos="fade-up">
            <div class="button-text"><?php echo esc_html($insights_button_text); ?>
            </div>
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="44" height="44" rx="22" fill="#BC001A" />
              <g clip-path="url(#clip0_642_270)">
                <path d="M16.166 17H26.9993V27.8333" stroke="white" stroke-width="2" stroke-miterlimit="10" />
                <path d="M16 28L27 17" stroke="white" stroke-width="2" stroke-miterlimit="10" />
              </g>
              <defs>
                <clipPath id="clip0_642_270">
                  <rect width="20" height="20" fill="white" transform="translate(12 12)" />
                </clipPath>
              </defs>
            </svg>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>