<?php
/**
 * The page template
 *
 * @package LawFirm_Pro
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 pt-24 pb-16">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-8">
                    <?php the_title( '<h1 class="text-4xl font-bold text-gray-900">', '</h1>' ); ?>
                </header>
                
                <div class="entry-content prose max-w-none">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
