<?php
/**
 * The blog home template
 *
 * @package LawFirm_Pro
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e( 'Latest News & Updates', 'lawfirm-pro' ); ?></h1>
        </header>

        <div class="content-area">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', get_post_format() );
                endwhile;
                
                the_posts_navigation();
            else :
                echo '<p>' . esc_html__( 'No posts found', 'lawfirm-pro' ) . '</p>';
            endif;
            ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
