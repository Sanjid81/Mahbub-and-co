<?php
$block_class = !empty($attributes['className']) ? esc_attr($attributes['className']) : '';
$fields = get_query_var('career_programs_details_fields', []);
?>
<div class="alumni-testimonials-block <?php echo $block_class; ?>">

    <div class="container">

        <div class="testimonials-grid">
            <?php foreach ($fields['testimonials'] ?? [] as $item):
                $name = $item['name'] ?? '';
                $former_pos = $item['former_position'] ?? '';
                $years = $item['years'] ?? '';
                $current_role = $item['current_role'] ?? '';
                $quote = $item['quote'] ?? '';
                $info_desc = $item['info-desc'] ?? '';
                $photo_id = $item['photo'] ?? 0;

                if (empty($quote) && empty($name))
                    continue;
                ?>
                <div class="testimonial-item" data-aos="fade-up">


                    <div class="testimonial-content">


                        <div class="testimonial-meta">
                            <div class="testimonial-meta-position-info">
                                 <?php if ($name): ?>
                                    <h4 class="name">
                                        <?php echo esc_html($name); ?>
                                    </h4>
                                <?php endif; ?>


                                <?php if ($former_pos): ?>
                                    <span class="former-position">Former Position:
                                        <?php echo esc_html($former_pos); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ($years): ?>
                                    <span class="years">Years at Firm:
                                        <?php echo esc_html($years); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ($current_role): ?>
                                    <p class="current-role">Current Role:
                                        <?php echo esc_html($current_role); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="testimonial-meta-desc">
                                <?php if ($info_desc): ?>
                                    <div class="info-desc">
                                        <?php echo wp_kses_post($info_desc); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="testimonial-meta-quote">
                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M28.7907 25.8339C28.7912 25.8146 28.7931 25.7954 28.7931 25.7767C28.8507 23.1057 28.0679 20.6818 26.1737 18.8199C24.5935 17.0406 22.3909 15.7459 19.8179 15.2823C13.9356 14.2224 8.349 17.9073 7.33931 23.5121C6.32916 29.117 10.2784 34.5207 16.1593 35.5801C17.236 35.7742 18.3029 35.8079 19.3337 35.701C20.244 38.5431 16.5142 44.7995 15.9859 45.7857C15.916 45.9146 16.4499 45.8012 16.9665 45.4112C23.2618 40.6524 28.6168 32.4896 28.7907 25.8339Z"
                                        stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                                    <path
                                        d="M53.4001 25.8339C53.4006 25.8146 53.4025 25.7954 53.4025 25.7767C53.4601 23.1057 52.6773 20.6818 50.7831 18.8199C49.2029 17.0406 46.9998 15.7459 44.4268 15.2823C38.5445 14.2224 32.9589 17.9073 31.9487 23.5121C30.9385 29.117 34.8873 34.5207 40.7682 35.5801C41.8459 35.7742 42.9123 35.8079 43.9431 35.701C44.8539 38.5431 41.1231 44.7995 40.5948 45.7857C40.5254 45.9146 41.0589 45.8012 41.5754 45.4112C47.8712 40.6524 53.2262 32.4896 53.4001 25.8339Z"
                                        stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                                </svg>
                                <?php if ($quote): ?>
                                    <div class="quote-mark">
                                        <?php echo wp_kses_post($quote); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
</div>
</div>