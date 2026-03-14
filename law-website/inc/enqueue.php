<?php
/**
 * Enqueue scripts and styles
 *
 * @package LawFirm_Pro
 */

function lawfirm_pro_scripts() {
    // Enqueue main JavaScript
    wp_enqueue_script( 'lawfirm-pro-main', get_template_directory_uri() . '/assets/js/main.js', array(), LAWFIRM_PRO_VERSION, true );
    
    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'lawfirm_pro_scripts' );
