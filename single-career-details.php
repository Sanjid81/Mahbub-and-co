<?php
get_header();
while (have_posts()) {
    the_post();
    ?>
    <article class="single-program" id="post-<?php the_ID(); ?>">
        <header class="program-details-header">
            <h1 class="program-details-title"><?php the_title(); ?></h1>
        </header>
        <div class="program-details-content">
            <?php the_content(); ?>
        </div>
    </article>
    <?php
}
get_footer();