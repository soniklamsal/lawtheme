<?php
/**
 * Template part for displaying posts
 *
 * @package LawFirm_Pro
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
        endif;
        ?>
        
        <div class="entry-meta">
            <span class="posted-on"><?php echo get_the_date(); ?></span>
            <span class="byline"><?php esc_html_e( 'by', 'lawfirm-pro' ); ?> <?php the_author(); ?></span>
        </div>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_excerpt();
        ?>
    </div>

    <footer class="entry-footer">
        <a href="<?php the_permalink(); ?>" class="read-more">
            <?php esc_html_e( 'Read More', 'lawfirm-pro' ); ?>
        </a>
    </footer>
</article>
