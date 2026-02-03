<div class="contact-us-section">
    <div class="contact-container">


        <div class="contact-content">

            <!-- Left Side -->
            <div>
                <div class="contact-header">
                    <h1 class="heading-one">
                        <?php echo esc_html($fields['contact_title']); ?>
                    </h1>
                    <p class="body-text">
                            <?php echo esc_html($fields['contact_description']); ?>
                    </p>
                </div>
                <div class="contact-left">

                    <div class="office-address-content">

                        <h3 class="heading-three">Address</h3>

                        <?php if (!empty($fields['office_addresses'])): ?>
                            <?php foreach ($fields['office_addresses'] as $office): ?>
                                <div class="office-section">
                                    <h3 class="heading-three">
                                        <?php echo esc_html($office['office_title']); ?>
                                    </h3>
                                    <?php
                                    $lines = explode("\n", $office['office_address']);
                                    foreach ($lines as $line) {
                                        echo '<p>' . esc_html($line) . '</p>';
                                    }
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="office-cotact-info">
                        <?php if (!empty($fields['contact_email'])): ?>
                            <div class="email-section">
                                <h3 class="heading-three">
                                    Email Us</h3>
                                <a href="mailto:<?php echo esc_attr($fields['contact_email']); ?>" class="body-text">
                                    <?php echo esc_html($fields['contact_email']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="office-section">
                            <h3 class="heading-three">
                                <?php echo esc_html($fields['office_hours_title']); ?>
                            </h3>
                            <p>
                                <?php echo esc_html($fields['office_time']); ?>
                            </p>
                            <p>
                                <?php echo esc_html($fields['office_days']); ?>
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Side -->
            <div class="contact-right">
                <?php
                if (!empty($fields['contact_form_shortcode'])) {
                    echo do_shortcode($fields['contact_form_shortcode']);
                }
                ?>
            </div>

        </div>
    </div>
</div>