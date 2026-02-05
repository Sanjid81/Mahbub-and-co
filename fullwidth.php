<?php
/*
Template Name: Full width template
*/
get_header();  // header include
?>


        <?php
        // Loop to display page or post content
        if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                        <?php the_content(); ?>
                <?php endwhile;
        ?>
        <?php endif; ?>


<?php get_footer();  // footer include ?>
