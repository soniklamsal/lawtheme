<?php
/**
 * Register custom taxonomies
 *
 * @package LawFirm_Pro
 */

function lawfirm_pro_register_taxonomies() {
    register_taxonomy( 'practice_area_category', 'practice_area', array(
        'labels' => array(
            'name'          => esc_html__( 'Practice Area Categories', 'lawfirm-pro' ),
            'singular_name' => esc_html__( 'Practice Area Category', 'lawfirm-pro' ),
        ),
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => array( 'slug' => 'practice-category' ),
    ) );
}
add_action( 'init', 'lawfirm_pro_register_taxonomies' );
