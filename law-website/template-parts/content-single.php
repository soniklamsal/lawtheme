<?php
/**
 * Template part for displaying single posts
 *
 * @package LawFirm_Pro
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        
        <div class="entry-meta">
            <span class="posted-on"><?php echo get_the_date(); ?></span>
            <span class="byline"><?php esc_html_e( 'by', 'lawfirm-pro' ); ?> <?php the_author(); ?></span>
            <span class="categories"><?php the_category( ', ' ); ?></span>
        </div>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();
        
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lawfirm-pro' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>

    <footer class="entry-footer">
        <?php the_tags( '<span class="tags-links">', ', ', '</span>' ); ?>
    </footer>
</article>
