<?php
/**
 * The archive template
 *
 * @package LawFirm_Pro
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <header class="page-header">
            <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header>

        <div class="content-area">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', get_post_type() );
                endwhile;
                
                the_posts_navigation();
            else :
                echo '<p>' . esc_html__( 'No content found', 'lawfirm-pro' ) . '</p>';
            endif;
            ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
