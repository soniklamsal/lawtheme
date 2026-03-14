<?php
/**
 * LawFirm Pro functions and definitions
 *
 * @package LawFirm_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme Constants
 */
define( 'LAWFIRM_PRO_VERSION', '1.0.0' );
define( 'LAWFIRM_PRO_DIR', get_template_directory() );
define( 'LAWFIRM_PRO_URI', get_template_directory_uri() );

/**
 * Core Files
 */
require_once LAWFIRM_PRO_DIR . '/inc/theme-setup.php';
require_once LAWFIRM_PRO_DIR . '/inc/enqueue.php';

/**
 * Features
 */
require_once LAWFIRM_PRO_DIR . '/inc/custom-post-types.php';
require_once LAWFIRM_PRO_DIR . '/inc/custom-taxonomies.php';
require_once LAWFIRM_PRO_DIR . '/inc/customizer.php';
