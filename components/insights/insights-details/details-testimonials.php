<?php
$fields = get_query_var('insights_details_fields', []);
?>

<section class="insights-details-testimonials">
    <div class="details-testimonial-container">
        <div class="testimonial-card">
            <div class="quote-mark">
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M28.7917 25.8339C28.7922 25.8146 28.794 25.7954 28.794 25.7767C28.8517 23.1057 28.0689 20.6818 26.1747 18.8199C24.5945 17.0406 22.3919 15.7459 19.8189 15.2823C13.9365 14.2224 8.34998 17.9073 7.34029 23.5121C6.33013 29.117 10.2794 34.5207 16.1603 35.5801C17.237 35.7742 18.3039 35.8079 19.3347 35.701C20.245 38.5431 16.5151 44.7995 15.9869 45.7857C15.917 45.9146 16.4509 45.8012 16.9675 45.4112C23.2628 40.6524 28.6178 32.4896 28.7917 25.8339Z"
                        stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                    <path
                        d="M53.4011 25.8339C53.4016 25.8146 53.4034 25.7954 53.4034 25.7767C53.4611 23.1057 52.6783 20.6818 50.7841 18.8199C49.2039 17.0406 47.0008 15.7459 44.4278 15.2823C38.5455 14.2224 32.9598 17.9073 31.9497 23.5121C30.9395 29.117 34.8883 34.5207 40.7692 35.5801C41.8469 35.7742 42.9133 35.8079 43.9441 35.701C44.8548 38.5431 41.1241 44.7995 40.5958 45.7857C40.5264 45.9146 41.0598 45.8012 41.5764 45.4112C47.8722 40.6524 53.2272 32.4896 53.4011 25.8339Z"
                        stroke="#BC001A" stroke-width="2" stroke-miterlimit="10" />
                </svg>
            </div>

            <div class="testimonial-content">
                <?php if (!empty($fields['testimonial_text'])): ?>
                    <div class="heading-four">
                        <?php echo esc_html($fields['testimonial_text']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($fields['testimonial_attribution'])): ?>
                    <p class="body-text-three">
                        <?php echo esc_html($fields['testimonial_attribution']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>