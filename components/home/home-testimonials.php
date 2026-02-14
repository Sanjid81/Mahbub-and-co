<?php
$testimonials = get_query_var('testimonials', []);
$testimonials_bg = get_query_var('testimonials_bg', ''); // NEW
$extra_class = get_query_var('testimonials_extra_class', ''); 


$bg_url = $testimonials_bg ? wp_get_attachment_image_url($testimonials_bg, 'full') : '';
?>

<?php if (!empty($testimonials)): ?>

    <section class="testimonials-section <?php echo esc_attr($extra_class); ?>" <?php if($bg_url) echo 'style="background-image: url('.esc_url($bg_url).');"'; ?>>
        <div class="overlay"></div>
        <div class="container">
            <div class="header-row">
                <h2 class="heading-two">Testimonials</h2>
                <div class="testimonials-slider-buttons">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>

            <div class="testimonials-slider" data-aos="fade-up">
                <div class="swiper">
                    <div class="testimonials-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($testimonials as $testimonial):
                                $text = $testimonial['text'] ?? '';
                                $author = $testimonial['author'] ?? '';
                                ?>
                                <div class="swiper-slide">
                                    <div class="testimonial-card">
                                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M28.7916 25.8339C28.792 25.8146 28.7939 25.7954 28.7939 25.7767C28.8516 23.1057 28.0688 20.6818 26.1745 18.8199C24.5944 17.0406 22.3917 15.7459 19.8188 15.2823C13.9364 14.2224 8.34986 17.9073 7.34017 23.5121C6.33001 29.117 10.2792 34.5207 16.1602 35.5801C17.2369 35.7742 18.3038 35.8079 19.3345 35.701C20.2449 38.5431 16.515 44.7995 15.9867 45.7857C15.9169 45.9146 16.4508 45.8012 16.9674 45.4112C23.2627 40.6524 28.6177 32.4896 28.7916 25.8339Z"
                                                    stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                                                <path
                                                    d="M53.401 25.8339C53.4014 25.8146 53.4033 25.7954 53.4033 25.7767C53.461 23.1057 52.6782 20.6818 50.7839 18.8199C49.2038 17.0406 47.0007 15.7459 44.4277 15.2823C38.5453 14.2224 32.9597 17.9073 31.9496 23.5121C30.9394 29.117 34.8882 34.5207 40.7691 35.5801C41.8467 35.7742 42.9132 35.8079 43.9439 35.701C44.8547 38.5431 41.1239 44.7995 40.5957 45.7857C40.5263 45.9146 41.0597 45.8012 41.5763 45.4112C47.8721 40.6524 53.2271 32.4896 53.401 25.8339Z"
                                                    stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                                            </svg>

                                        <p class="heading-four text"><?php echo esc_html($text); ?></p>
                                        <p class="body-text-three author"><?php echo esc_html($author); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
