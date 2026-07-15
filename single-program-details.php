<?php
/**
 * Program details page: only title + rest = custom blocks (Gutenberg)
 */
defined('ABSPATH') || exit;

if (!have_posts()) {
    return;
}

while (have_posts()) {
    the_post();
    ?>
    <section class="program-details-page" id="program-<?php the_ID(); ?>">
        <div class="program-details-inner">

            <!-- <div class="container">
                <header class="program-details-header">
                    <h1 class="program-details-title">
                        <?php the_title(); ?>
                    </h1>
                </header>
            </div> -->
            <div class="program-details-blocks">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
    <?php
}
