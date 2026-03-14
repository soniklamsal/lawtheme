<?php
/**
 * The single post template
 *
 * @package LawFirm_Pro
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <?php
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content', 'single' );
                
                the_post_navigation();
                
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
            endwhile;
            ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
