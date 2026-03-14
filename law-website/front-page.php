<?php
/**
 * The front page template - Home Service Platform
 *
 * @package LawFirm_Pro
 */

get_header(); ?>

<main id="primary" class="site-main front-page home-service-page">
    
    <!-- Hero Section -->
    <?php get_template_part( 'template-parts/home', 'hero' ); ?>
    
    <!-- Category Section -->
    <?php get_template_part( 'template-parts/home', 'category' ); ?>
    
    <!-- Featured Services Section -->
    <?php get_template_part( 'template-parts/home', 'featured-services' ); ?>
    
    <!-- Popular Services Section -->
    <?php get_template_part( 'template-parts/home', 'popular-services' ); ?>
    
    <!-- AMC Packages Section -->
    <?php get_template_part( 'template-parts/home', 'amc-packages' ); ?>
    
    <!-- Testimonials Section -->
    <?php get_template_part( 'template-parts/home', 'testimonials' ); ?>
    
    <!-- FAQ Section -->
    <?php get_template_part( 'template-parts/home', 'faq' ); ?>
    
    <!-- WhatsApp Button -->
    <?php get_template_part( 'template-parts/home', 'whatsapp-button' ); ?>
    
</main>

<?php get_footer(); ?>
