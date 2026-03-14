<?php
/**
 * The 404 error template
 *
 * @package LawFirm_Pro
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( '404 - Page Not Found', 'lawfirm-pro' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'lawfirm-pro' ); ?></p>
                
                <?php get_search_form(); ?>
                
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button">
                    <?php esc_html_e( 'Return to Homepage', 'lawfirm-pro' ); ?>
                </a>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
