<?php
/**
 * Template part for home hero section
 *
 * @package LawFirm_Pro
 */

// Get hero section settings from customizer
$hero_title = get_theme_mod( 'hero_title', 'Find Your <span class="text-[#26cf71]">Legal Expert</span> Today' );
$hero_subtitle = get_theme_mod( 'hero_subtitle', 'Connect with experienced attorneys across all practice areas • Free Consultation' );
$hero_button_text = get_theme_mod( 'hero_button_text', 'Free Consultation' );
$hero_button_url = get_theme_mod( 'hero_button_url', '#contact' );
$hero_background_image = get_theme_mod( 'hero_background_image', '' );

// Default video path
$default_video_url = get_template_directory_uri() . '/assets/herovideo/6699964-hd_1920_1080_24fps.mp4';

// Determine what to display: image or video
$use_video = empty( $hero_background_image );
?>

<section class="relative w-full h-[500px] flex items-center justify-center text-white px-5 overflow-hidden">
    <?php if ( $use_video ) : ?>
        <!-- Default Video Background -->
        <video 
            autoplay 
            loop 
            muted 
            playsinline
            class="absolute inset-0 w-full h-full object-cover"
        >
            <source src="<?php echo esc_url( $default_video_url ); ?>" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/40"></div>
        
    <?php else : ?>
        <!-- Uploaded Image Background -->
        <div class="absolute inset-0 bg-cover bg-center" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo esc_url( $hero_background_image ); ?>'); background-size: cover; background-position: center;"></div>
    <?php endif; ?>
    
    <div class="relative z-10 w-full max-w-6xl mx-auto text-center">
        <h1 class="text-5xl font-extrabold mb-2 tracking-tight">
            <?php echo wp_kses_post( $hero_title ); ?>
        </h1>
        <p class="text-lg font-medium opacity-90 mb-6">
            <?php echo esc_html( $hero_subtitle ); ?>
        </p>
        
        <?php if ( $hero_button_text && $hero_button_url ) : ?>
            <a href="<?php echo esc_url( $hero_button_url ); ?>" class="inline-block bg-[#26cf71] hover:bg-[#1eb863] text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                <?php echo esc_html( $hero_button_text ); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
