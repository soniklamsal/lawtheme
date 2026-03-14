<?php
/**
 * The search results template
 *
 * @package LawFirm_Pro
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">
                <?php printf( esc_html__( 'Search Results for: %s', 'lawfirm-pro' ), '<span>' . get_search_query() . '</span>' ); ?>
            </h1>
        </header>

        <div class="content-area">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', 'search' );
                endwhile;
                
                the_posts_navigation();
            else :
                ?>
                <p><?php esc_html_e( 'Sorry, no results found. Please try a different search.', 'lawfirm-pro' ); ?></p>
                <?php get_search_form(); ?>
                <?php
            endif;
            ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
