<?php
/**
 * Theme setup functions
 *
 * @package LawFirm_Pro
 */

if ( ! function_exists( 'lawfirm_pro_setup' ) ) :
    function lawfirm_pro_setup() {
        load_theme_textdomain( 'lawfirm-pro', get_template_directory() . '/languages' );
        
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'custom-logo' );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
        add_theme_support( 'customize-selective-refresh-widgets' );
        
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Menu', 'lawfirm-pro' ),
            'footer'  => esc_html__( 'Footer Menu', 'lawfirm-pro' ),
        ) );
        
        add_image_size( 'lawfirm-pro-featured', 1200, 600, true );
    }
endif;
add_action( 'after_setup_theme', 'lawfirm_pro_setup' );

function lawfirm_pro_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'lawfirm-pro' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'lawfirm-pro' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    
    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer %d', 'lawfirm-pro' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'Footer widget area %d', 'lawfirm-pro' ), $i ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }
}
add_action( 'widgets_init', 'lawfirm_pro_widgets_init' );
