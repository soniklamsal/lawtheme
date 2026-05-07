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
 * Create database table for submissions
 */
function lawfirm_pro_create_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'lawfirm_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        type varchar(20) NOT NULL,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(50) DEFAULT '',
        subject varchar(200) DEFAULT '',
        message text DEFAULT '',
        service_title varchar(200) DEFAULT '',
        package_type varchar(50) DEFAULT '',
        booking_date varchar(50) DEFAULT '',
        booking_time varchar(50) DEFAULT '',
        status varchar(20) DEFAULT 'new',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
add_action( 'after_switch_theme', 'lawfirm_pro_create_submissions_table' );

// Also create table on admin_init to ensure it exists
add_action( 'admin_init', 'lawfirm_pro_create_submissions_table' );

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
require_once LAWFIRM_PRO_DIR . '/inc/amc-package-meta-boxes.php';
require_once LAWFIRM_PRO_DIR . '/inc/smtp-settings.php';
require_once LAWFIRM_PRO_DIR . '/inc/contact-form-handler.php';
require_once LAWFIRM_PRO_DIR . '/inc/submissions-dashboard.php';
require_once LAWFIRM_PRO_DIR . '/inc/contact-info-settings.php';

/**
 * Admin notice to flush permalinks for AMC Packages
 */
function lawfirm_pro_amc_permalink_notice() {
    if ( get_option( 'lawfirm_pro_flush_done' ) != 'yes' ) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>AMC Packages Setup:</strong> Please go to <a href="<?php echo admin_url( 'options-permalink.php' ); ?>">Settings → Permalinks</a> and click "Save Changes" to activate AMC Packages permalinks.</p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'lawfirm_pro_amc_permalink_notice' );

/**
 * Handle booking form submission via AJAX
 */
function lawfirm_pro_handle_booking_submission() {
    // Verify nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'booking_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Security check failed.', 'lawfirm-pro' ) ) );
    }
    
    // Sanitize and validate form data
    $name = isset( $_POST['booking_name'] ) ? sanitize_text_field( $_POST['booking_name'] ) : '';
    $email = isset( $_POST['booking_email'] ) ? sanitize_email( $_POST['booking_email'] ) : '';
    $phone = isset( $_POST['booking_phone'] ) ? sanitize_text_field( $_POST['booking_phone'] ) : '';
    $date = isset( $_POST['booking_date'] ) ? sanitize_text_field( $_POST['booking_date'] ) : '';
    $time = isset( $_POST['booking_time'] ) ? sanitize_text_field( $_POST['booking_time'] ) : '';
    $message = isset( $_POST['booking_message'] ) ? sanitize_textarea_field( $_POST['booking_message'] ) : '';
    $service_title = isset( $_POST['service_title'] ) ? sanitize_text_field( $_POST['service_title'] ) : '';
    $service_url = isset( $_POST['service_url'] ) ? esc_url_raw( $_POST['service_url'] ) : '';
    $package_type = isset( $_POST['package_type'] ) ? sanitize_text_field( $_POST['package_type'] ) : '';
    
    // Validate required fields
    if ( empty( $name ) || empty( $email ) || empty( $phone ) || empty( $date ) || empty( $time ) ) {
        wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'lawfirm-pro' ) ) );
    }
    
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'lawfirm-pro' ) ) );
    }
    
    // Format date for better display
    $formatted_date = date( 'F j, Y', strtotime( $date ) );
    
    // Prepare email content - MINIMAL BUT BEAUTIFUL HTML
    $to = get_option( 'admin_email' );
    $subject = 'New Booking: ' . $service_title . ( ! empty( $package_type ) ? ' - ' . $package_type : '' );
    
    // Beautiful minimal HTML email
    $email_body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; background-color: #f5f5f5;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 40px 20px;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        
                        <!-- Header -->
                        <tr>
                            <td style="background-color: #ffffff; padding: 30px 40px; text-align: center; border-bottom: 1px solid #e5e7eb;">
                                <h1 style="margin: 0; color: #1a2b3c; font-size: 24px; font-weight: 600; letter-spacing: -0.5px;">
                                    New Booking Request
                                </h1>
                            </td>
                        </tr>
                        
                        <!-- Content -->
                        <tr>
                            <td style="padding: 40px;">
                                
                                <!-- Service Info -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                                    <tr>
                                        <td style="padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
                                            <div style="color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Service</div>
                                            <div style="color: #1a2b3c; font-size: 18px; font-weight: 600; margin-bottom: 12px;">' . esc_html( $service_title ) . '</div>
                                            ' . ( ! empty( $package_type ) ? '
                                            <div style="display: inline-block; padding: 6px 16px; background-color: #26cf71; color: white; border-radius: 20px; font-size: 13px; font-weight: 600;">
                                                ' . esc_html( $package_type ) . ' Package
                                            </div>
                                            ' : '' ) . '
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Client Details -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                                    <tr>
                                        <td>
                                            <div style="color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">Client Information</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 15px 0;">
                                            <table width="100%" cellpadding="8" cellspacing="0">
                                                <tr>
                                                    <td width="120" style="color: #999; font-size: 14px;">Name</td>
                                                    <td style="color: #1a2b3c; font-size: 15px; font-weight: 500;">' . esc_html( $name ) . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #999; font-size: 14px;">Email</td>
                                                    <td><a href="mailto:' . esc_attr( $email ) . '" style="color: #26cf71; text-decoration: none; font-size: 15px;">' . esc_html( $email ) . '</a></td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #999; font-size: 14px;">Phone</td>
                                                    <td><a href="tel:' . esc_attr( $phone ) . '" style="color: #26cf71; text-decoration: none; font-size: 15px;">' . esc_html( $phone ) . '</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Appointment Details -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                                    <tr>
                                        <td>
                                            <div style="color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">Appointment</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="50%" style="padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                                                        <div style="color: #999; font-size: 12px; margin-bottom: 5px;">Date</div>
                                                        <div style="color: #1a2b3c; font-size: 16px; font-weight: 600;">' . esc_html( $formatted_date ) . '</div>
                                                    </td>
                                                    <td width="20"></td>
                                                    <td width="50%" style="padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                                                        <div style="color: #999; font-size: 12px; margin-bottom: 5px;">Time</div>
                                                        <div style="color: #1a2b3c; font-size: 16px; font-weight: 600;">' . esc_html( $time ) . '</div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                                ' . ( ! empty( $message ) ? '
                                <!-- Message -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                                    <tr>
                                        <td>
                                            <div style="color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">Message</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px; background-color: #f8f9fa; border-radius: 8px; border-left: 4px solid #26cf71;">
                                            <div style="color: #333; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">' . esc_html( $message ) . '</div>
                                        </td>
                                    </tr>
                                </table>
                                ' : '' ) . '
                                
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="padding: 25px 40px; background-color: #f8f9fa; text-align: center; border-top: 1px solid #e5e7eb;">
                                <p style="margin: 0 0 5px 0; color: #999; font-size: 13px;">
                                    Submitted on ' . esc_html( current_time( 'F j, Y \a\t g:i A' ) ) . '
                                </p>
                                <p style="margin: 0; color: #ccc; font-size: 12px;">
                                    ' . esc_html( get_bloginfo( 'name' ) ) . ' • ' . esc_html( home_url() ) . '
                                </p>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    ';
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Send email
    wp_mail( $to, $subject, $email_body, $headers );
    
    // Save to database (optional - won't break if table doesn't exist)
    if ( function_exists( 'lawfirm_pro_save_booking_to_db' ) ) {
        try {
            lawfirm_pro_save_booking_to_db( array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'message' => $message,
                'service_title' => $service_title,
                'package_type' => $package_type,
                'booking_date' => $date,
                'booking_time' => $time
            ) );
        } catch ( Exception $e ) {
            // Silently fail - email was sent successfully
        }
    }
    
    wp_send_json_success( array( 
        'message' => __( 'Thank you! Your booking request has been submitted successfully. We will contact you soon.', 'lawfirm-pro' ) 
    ) );
}
add_action( 'wp_ajax_submit_booking', 'lawfirm_pro_handle_booking_submission' );
add_action( 'wp_ajax_nopriv_submit_booking', 'lawfirm_pro_handle_booking_submission' );

/**
 * Add Homepage Sections admin menu with submenus
 */
function lawfirm_pro_add_homepage_sections_menu() {
    // Parent menu
    add_menu_page(
        __( 'Homepage Sections', 'lawfirm-pro' ),           // Page title
        __( 'Homepage Sections', 'lawfirm-pro' ),           // Menu title
        'manage_options',                                    // Capability
        'homepage-sections',                                 // Menu slug
        'lawfirm_pro_hero_section_page',                    // Callback function (default to Hero Section)
        'dashicons-layout',                                  // Icon
        26                                                   // Position (after Comments which is 25)
    );
    
    // Hero Section submenu
    add_submenu_page(
        'homepage-sections',                                 // Parent slug
        __( 'Hero Section', 'lawfirm-pro' ),                // Page title
        __( 'Hero Section', 'lawfirm-pro' ),                // Menu title
        'manage_options',                                    // Capability
        'homepage-sections',                                 // Menu slug (same as parent for first item)
        'lawfirm_pro_hero_section_page'                     // Callback function
    );
    
    // FAQ Section submenu
    add_submenu_page(
        'homepage-sections',                                 // Parent slug
        __( 'FAQ Section', 'lawfirm-pro' ),                 // Page title
        __( 'FAQ Section', 'lawfirm-pro' ),                 // Menu title
        'manage_options',                                    // Capability
        'faq-section',                                       // Menu slug
        'lawfirm_pro_faq_section_page'                      // Callback function
    );
    
    // Testimonials Section submenu
    add_submenu_page(
        'homepage-sections',                                 // Parent slug
        __( 'Testimonials Section', 'lawfirm-pro' ),        // Page title
        __( 'Testimonials Section', 'lawfirm-pro' ),        // Menu title
        'manage_options',                                    // Capability
        'testimonials-section',                              // Menu slug
        'lawfirm_pro_testimonials_section_page'             // Callback function
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_homepage_sections_menu' );

/**
 * Add About Page parent menu with submenus
 */
function lawfirm_pro_add_aboutpage_menu() {
    // Add parent menu
    add_menu_page(
        __( 'About Page', 'lawfirm-pro' ),
        __( 'About Page', 'lawfirm-pro' ),
        'manage_options',
        'aboutpage-sections',
        'lawfirm_pro_abouthero_section_page',
        'dashicons-admin-page',
        26
    );
    
    // Add submenu items
    add_submenu_page(
        'aboutpage-sections',
        __( 'About Hero', 'lawfirm-pro' ),
        __( 'About Hero', 'lawfirm-pro' ),
        'manage_options',
        'aboutpage-sections',
        'lawfirm_pro_abouthero_section_page'
    );
    
    add_submenu_page(
        'aboutpage-sections',
        __( 'About Status', 'lawfirm-pro' ),
        __( 'About Status', 'lawfirm-pro' ),
        'manage_options',
        'aboutstatus-section',
        'lawfirm_pro_aboutstatus_section_page'
    );
    
    add_submenu_page(
        'aboutpage-sections',
        __( 'About Values', 'lawfirm-pro' ),
        __( 'About Values', 'lawfirm-pro' ),
        'manage_options',
        'aboutvalues-section',
        'lawfirm_pro_aboutvalues_section_page'
    );
    
    add_submenu_page(
        'aboutpage-sections',
        __( 'About Choose Us', 'lawfirm-pro' ),
        __( 'About Choose Us', 'lawfirm-pro' ),
        'manage_options',
        'aboutchooseus-section',
        'lawfirm_pro_aboutchooseus_section_page'
    );
    
    add_submenu_page(
        'aboutpage-sections',
        __( 'About CTA', 'lawfirm-pro' ),
        __( 'About CTA', 'lawfirm-pro' ),
        'manage_options',
        'aboutcta-section',
        'lawfirm_pro_aboutcta_section_page'
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_aboutpage_menu' );

/**
 * Add Team Section as independent menu after Comments
 */
function lawfirm_pro_add_team_section_menu() {
    add_menu_page(
        __( 'Team Section', 'lawfirm-pro' ),                 // Page title
        __( 'Team Section', 'lawfirm-pro' ),                 // Menu title
        'manage_options',                                     // Capability
        'team-section',                                       // Menu slug
        'lawfirm_pro_team_section_page',                     // Callback function
        'dashicons-groups',                                   // Icon
        30                                                    // Position (after About Choose Us which is 29)
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_team_section_menu' );

/**
 * Add Footer Section as independent menu after Comments
 */
function lawfirm_pro_add_footer_section_menu() {
    add_menu_page(
        __( 'Footer Section', 'lawfirm-pro' ),               // Page title
        __( 'Footer Section', 'lawfirm-pro' ),               // Menu title
        'manage_options',                                     // Capability
        'footer-section',                                     // Menu slug
        'lawfirm_pro_footer_section_page',                   // Callback function
        'dashicons-admin-settings',                           // Icon
        31                                                    // Position (after Team Section which is 30)
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_footer_section_menu' );

/**
 * Add WhatsApp Section menu
 */
function lawfirm_pro_add_whatsapp_section_menu() {
    add_menu_page(
        __( 'WhatsApp Section', 'lawfirm-pro' ),             // Page title
        __( 'WhatsApp Section', 'lawfirm-pro' ),             // Menu title
        'manage_options',                                     // Capability
        'whatsapp-section',                                   // Menu slug
        'lawfirm_pro_whatsapp_section_page',                 // Callback function
        'dashicons-whatsapp',                                 // Icon
        32                                                    // Position (after Footer Section which is 31)
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_whatsapp_section_menu' );

/**
 * Add Location/Map Section menu
 */
function lawfirm_pro_add_location_section_menu() {
    add_menu_page(
        __( 'Location/Map Section', 'lawfirm-pro' ),       // Page title
        __( 'Location/Map', 'lawfirm-pro' ),               // Menu title
        'manage_options',                                   // Capability
        'location-section',                                 // Menu slug
        'lawfirm_pro_location_section_page',               // Callback function
        'dashicons-location',                               // Icon
        33                                                  // Position (after WhatsApp Section which is 32)
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_location_section_menu' );

/**
 * About Hero Section admin page content
 */
function lawfirm_pro_abouthero_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Handle form submission
    if ( isset( $_POST['lawfirm_abouthero_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_abouthero_section_nonce'], 'lawfirm_abouthero_section_save' ) ) {
        lawfirm_pro_save_abouthero_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'About Hero Section saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $abouthero_title = get_theme_mod( 'abouthero_title', 'About <span class="text-[#26cf71]">Genius Law</span>' );
    $abouthero_subtitle = get_theme_mod( 'abouthero_subtitle', 'Your trusted legal partner with over 25 years of excellence' );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'About Hero Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Customize the hero section displayed at the top of the About page.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_abouthero_section_save', 'lawfirm_abouthero_section_nonce' ); ?>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="abouthero_title"><?php esc_html_e( 'Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="abouthero_title" name="abouthero_title" value="<?php echo esc_attr( $abouthero_title ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" />
                            <p class="description"><?php esc_html_e( 'You can use HTML like: About &lt;span class="text-[#26cf71]"&gt;Genius Law&lt;/span&gt;', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="abouthero_subtitle"><?php esc_html_e( 'Subtitle', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="abouthero_subtitle" name="abouthero_subtitle" value="<?php echo esc_attr( $abouthero_subtitle ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" />
                            <p class="description"><?php esc_html_e( 'Brief description below the title', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button( __( 'Save About Hero Section', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    <?php
}

/**
 * Save About Hero Section settings
 */
function lawfirm_pro_save_abouthero_section() {
    if ( isset( $_POST['abouthero_title'] ) ) {
        set_theme_mod( 'abouthero_title', wp_kses_post( $_POST['abouthero_title'] ) );
    }
    if ( isset( $_POST['abouthero_subtitle'] ) ) {
        set_theme_mod( 'abouthero_subtitle', sanitize_text_field( $_POST['abouthero_subtitle'] ) );
    }
}

/**
 * About Status Section admin page content
 */
function lawfirm_pro_aboutstatus_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Enqueue WordPress media uploader
    wp_enqueue_media();

    // Handle form submission
    if ( isset( $_POST['lawfirm_aboutstatus_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_aboutstatus_section_nonce'], 'lawfirm_aboutstatus_section_save' ) ) {
        lawfirm_pro_save_aboutstatus_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'About Status Section saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $aboutstatus_title = get_theme_mod( 'aboutstatus_title', 'Our <span class="text-[#26cf71]">Status</span>' );
    $aboutstatus_content_1 = get_theme_mod( 'aboutstatus_content_1', "Genius Law and Associates was founded with common mission of faire justice for the victim's People / Clients; to provide exceptional Legal services with integrity, dedication and expertise, for ours 25 years. It's has been serving Individuals, Families, Industrials Businesses, Banking and Corporate an across of Nepal." );
    $aboutstatus_content_2 = get_theme_mod( 'aboutstatus_content_2', "It's firm has grown from a Legal practice to be one the most respected services providers in the region. It's pride ourselves on our commitment to our clients and our track record of successful outcomes its mission." );
    $aboutstatus_years = get_theme_mod( 'aboutstatus_years', '25' );
    $aboutstatus_image = get_theme_mod( 'aboutstatus_image', 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800' );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'About Status Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Customize the "Our Status" section displayed on the About page.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_aboutstatus_section_save', 'lawfirm_aboutstatus_section_nonce' ); ?>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Section Content', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="aboutstatus_title"><?php esc_html_e( 'Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="aboutstatus_title" name="aboutstatus_title" value="<?php echo esc_attr( $aboutstatus_title ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" />
                            <p class="description"><?php esc_html_e( 'You can use HTML like: Our &lt;span class="text-[#26cf71]"&gt;Status&lt;/span&gt;', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="aboutstatus_content_1"><?php esc_html_e( 'First Paragraph', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="aboutstatus_content_1" name="aboutstatus_content_1" rows="4" class="large-text" style="width: 100%; max-width: 600px;"><?php echo esc_textarea( $aboutstatus_content_1 ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'First paragraph of content', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="aboutstatus_content_2"><?php esc_html_e( 'Second Paragraph', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="aboutstatus_content_2" name="aboutstatus_content_2" rows="4" class="large-text" style="width: 100%; max-width: 600px;"><?php echo esc_textarea( $aboutstatus_content_2 ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Second paragraph of content', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="aboutstatus_years"><?php esc_html_e( 'Years of Excellence', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="number" id="aboutstatus_years" name="aboutstatus_years" value="<?php echo esc_attr( $aboutstatus_years ); ?>" class="small-text" min="0" />
                            <p class="description"><?php esc_html_e( 'Number of years (displays as badge on image)', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
                
                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ddd;">
                
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Section Image', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="aboutstatus_image"><?php esc_html_e( 'Upload Image', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="hidden" id="aboutstatus_image" name="aboutstatus_image" value="<?php echo esc_attr( $aboutstatus_image ); ?>" />
                            <div id="aboutstatus_image_preview" style="margin-bottom: 10px;">
                                <?php if ( $aboutstatus_image ) : ?>
                                    <img src="<?php echo esc_url( $aboutstatus_image ); ?>" style="max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 4px;" />
                                <?php endif; ?>
                            </div>
                            <button type="button" class="button" id="upload_aboutstatus_image_button"><?php esc_html_e( 'Upload/Select Image', 'lawfirm-pro' ); ?></button>
                            <button type="button" class="button" id="remove_aboutstatus_image_button" <?php echo empty( $aboutstatus_image ) ? 'style="display:none;"' : ''; ?>><?php esc_html_e( 'Remove Image', 'lawfirm-pro' ); ?></button>
                            <p class="description">
                                <?php esc_html_e( 'Upload an image for the section. Recommended size: 800x600px or larger.', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button( __( 'Save About Status Section', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#upload_aboutstatus_image_button').on('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: '<?php esc_html_e( 'Choose About Status Image', 'lawfirm-pro' ); ?>',
                button: {
                    text: '<?php esc_html_e( 'Use this image', 'lawfirm-pro' ); ?>'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#aboutstatus_image').val(attachment.url);
                $('#aboutstatus_image_preview').html('<img src="' + attachment.url + '" style="max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 4px;" />');
                $('#remove_aboutstatus_image_button').show();
            });
            
            mediaUploader.open();
        });
        
        $('#remove_aboutstatus_image_button').on('click', function(e) {
            e.preventDefault();
            $('#aboutstatus_image').val('');
            $('#aboutstatus_image_preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * Save About Status Section settings
 */
function lawfirm_pro_save_aboutstatus_section() {
    if ( isset( $_POST['aboutstatus_title'] ) ) {
        set_theme_mod( 'aboutstatus_title', wp_kses_post( wp_unslash( $_POST['aboutstatus_title'] ) ) );
    }
    if ( isset( $_POST['aboutstatus_content_1'] ) ) {
        set_theme_mod( 'aboutstatus_content_1', sanitize_textarea_field( wp_unslash( $_POST['aboutstatus_content_1'] ) ) );
    }
    if ( isset( $_POST['aboutstatus_content_2'] ) ) {
        set_theme_mod( 'aboutstatus_content_2', sanitize_textarea_field( wp_unslash( $_POST['aboutstatus_content_2'] ) ) );
    }
    if ( isset( $_POST['aboutstatus_years'] ) ) {
        set_theme_mod( 'aboutstatus_years', absint( $_POST['aboutstatus_years'] ) );
    }
    if ( isset( $_POST['aboutstatus_image'] ) ) {
        set_theme_mod( 'aboutstatus_image', esc_url_raw( $_POST['aboutstatus_image'] ) );
    }
}

/**
 * About Values Section admin page content
 */
function lawfirm_pro_aboutvalues_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Handle form submission
    if ( isset( $_POST['lawfirm_aboutvalues_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_aboutvalues_section_nonce'], 'lawfirm_aboutvalues_section_save' ) ) {
        lawfirm_pro_save_aboutvalues_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'About Values Section saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $aboutvalues_title = get_theme_mod( 'aboutvalues_title', 'Our Core <span class="text-[#26cf71]">Values</span>' );
    $aboutvalues_subtitle = get_theme_mod( 'aboutvalues_subtitle', 'These principles guide everything we do and define who we are as a firm' );
    
    // Value 1
    $aboutvalues_1_title = get_theme_mod( 'aboutvalues_1_title', 'Integrity' );
    $aboutvalues_1_desc = get_theme_mod( 'aboutvalues_1_desc', 'We uphold the highest ethical standards in all our dealings, ensuring honesty and transparency with every client.' );
    
    // Value 2
    $aboutvalues_2_title = get_theme_mod( 'aboutvalues_2_title', 'Excellence' );
    $aboutvalues_2_desc = get_theme_mod( 'aboutvalues_2_desc', 'We strive for excellence in every case, combining legal expertise with innovative strategies to achieve the best outcomes.' );
    
    // Value 3
    $aboutvalues_3_title = get_theme_mod( 'aboutvalues_3_title', 'Client-Focused' );
    $aboutvalues_3_desc = get_theme_mod( 'aboutvalues_3_desc', 'Your needs are our priority. We provide personalized attention and tailored legal solutions for each unique situation.' );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'About Values Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Customize the "Our Core Values" section displayed on the About page.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_aboutvalues_section_save', 'lawfirm_aboutvalues_section_nonce' ); ?>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Section Header', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="aboutvalues_title"><?php esc_html_e( 'Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="aboutvalues_title" name="aboutvalues_title" value="<?php echo esc_attr( $aboutvalues_title ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" />
                            <p class="description"><?php esc_html_e( 'You can use HTML like: Our Core &lt;span class="text-[#26cf71]"&gt;Values&lt;/span&gt;', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="aboutvalues_subtitle"><?php esc_html_e( 'Subtitle', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="aboutvalues_subtitle" name="aboutvalues_subtitle" value="<?php echo esc_attr( $aboutvalues_subtitle ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" />
                            <p class="description"><?php esc_html_e( 'Brief description below the title', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
                
                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ddd;">
                
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Value 1', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="aboutvalues_1_title"><?php esc_html_e( 'Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="aboutvalues_1_title" name="aboutvalues_1_title" value="<?php echo esc_attr( $aboutvalues_1_title ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="aboutvalues_1_desc"><?php esc_html_e( 'Description', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="aboutvalues_1_desc" name="aboutvalues_1_desc" rows="3" class="large-text" style="width: 100%; max-width: 600px;"><?php echo esc_textarea( $aboutvalues_1_desc ); ?></textarea>
                        </td>
                    </tr>
                </table>
                
                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ddd;">
                
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Value 2', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="aboutvalues_2_title"><?php esc_html_e( 'Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="aboutvalues_2_title" name="aboutvalues_2_title" value="<?php echo esc_attr( $aboutvalues_2_title ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="aboutvalues_2_desc"><?php esc_html_e( 'Description', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="aboutvalues_2_desc" name="aboutvalues_2_desc" rows="3" class="large-text" style="width: 100%; max-width: 600px;"><?php echo esc_textarea( $aboutvalues_2_desc ); ?></textarea>
                        </td>
                    </tr>
                </table>
                
                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ddd;">
                
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Value 3', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="aboutvalues_3_title"><?php esc_html_e( 'Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="aboutvalues_3_title" name="aboutvalues_3_title" value="<?php echo esc_attr( $aboutvalues_3_title ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="aboutvalues_3_desc"><?php esc_html_e( 'Description', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="aboutvalues_3_desc" name="aboutvalues_3_desc" rows="3" class="large-text" style="width: 100%; max-width: 600px;"><?php echo esc_textarea( $aboutvalues_3_desc ); ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button( __( 'Save About Values Section', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    <?php
}

/**
 * Save About Values Section settings
 */
function lawfirm_pro_save_aboutvalues_section() {
    if ( isset( $_POST['aboutvalues_title'] ) ) {
        set_theme_mod( 'aboutvalues_title', wp_kses_post( wp_unslash( $_POST['aboutvalues_title'] ) ) );
    }
    if ( isset( $_POST['aboutvalues_subtitle'] ) ) {
        set_theme_mod( 'aboutvalues_subtitle', sanitize_text_field( wp_unslash( $_POST['aboutvalues_subtitle'] ) ) );
    }
    
    // Value 1
    if ( isset( $_POST['aboutvalues_1_title'] ) ) {
        set_theme_mod( 'aboutvalues_1_title', sanitize_text_field( wp_unslash( $_POST['aboutvalues_1_title'] ) ) );
    }
    if ( isset( $_POST['aboutvalues_1_desc'] ) ) {
        set_theme_mod( 'aboutvalues_1_desc', sanitize_textarea_field( wp_unslash( $_POST['aboutvalues_1_desc'] ) ) );
    }
    
    // Value 2
    if ( isset( $_POST['aboutvalues_2_title'] ) ) {
        set_theme_mod( 'aboutvalues_2_title', sanitize_text_field( wp_unslash( $_POST['aboutvalues_2_title'] ) ) );
    }
    if ( isset( $_POST['aboutvalues_2_desc'] ) ) {
        set_theme_mod( 'aboutvalues_2_desc', sanitize_textarea_field( wp_unslash( $_POST['aboutvalues_2_desc'] ) ) );
    }
    
    // Value 3
    if ( isset( $_POST['aboutvalues_3_title'] ) ) {
        set_theme_mod( 'aboutvalues_3_title', sanitize_text_field( wp_unslash( $_POST['aboutvalues_3_title'] ) ) );
    }
    if ( isset( $_POST['aboutvalues_3_desc'] ) ) {
        set_theme_mod( 'aboutvalues_3_desc', sanitize_textarea_field( wp_unslash( $_POST['aboutvalues_3_desc'] ) ) );
    }
}

/**
 * About Choose Us Section admin page
 */
function lawfirm_pro_aboutchooseus_section_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( isset( $_POST['lawfirm_aboutchooseus_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_aboutchooseus_nonce'], 'save_aboutchooseus' ) ) {
        lawfirm_pro_save_aboutchooseus_section();
        echo '<div class="notice notice-success is-dismissible"><p>About Choose Us Section saved!</p></div>';
    }
    $title = get_theme_mod( 'aboutchooseus_title', 'Why Choose <span class="text-[#26cf71]">Genius Law</span>' );
    $subtitle = get_theme_mod( 'aboutchooseus_subtitle', 'We stand out from other law firms through our commitment to excellence and client satisfaction' );
    $defaults = array('Proven Track Record|Over 500 successful cases with a high success rate across all practice areas.', '24/7 Availability|We\'re here when you need us most, with round-the-clock support for urgent matters.', 'Transparent Pricing|Clear, upfront pricing with no hidden fees. We offer flexible payment plans.', 'Expert Team|50+ experienced attorneys specializing in 25+ different areas of law.', 'Nationwide Coverage|Serving clients across Nepal with representation in all major courts.', 'Confidentiality Guaranteed|Your privacy is paramount. All communications are strictly confidential.');
    ?>
    <div class="wrap"><h1>About Choose Us Section</h1><p>Customize the "Why Choose Us" section with 6 reasons.</p>
    <form method="post"><?php wp_nonce_field( 'save_aboutchooseus', 'lawfirm_aboutchooseus_nonce' ); ?>
    <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4"><h2 style="margin-top:0;padding-bottom:10px;border-bottom:1px solid #ddd">Section Header</h2>
    <table class="form-table"><tr><th><label for="aboutchooseus_title">Title</label></th><td><input type="text" id="aboutchooseus_title" name="aboutchooseus_title" value="<?php echo esc_attr($title); ?>" class="regular-text" style="width:100%;max-width:600px"/><p class="description">You can use HTML</p></td></tr>
    <tr><th><label for="aboutchooseus_subtitle">Subtitle</label></th><td><input type="text" id="aboutchooseus_subtitle" name="aboutchooseus_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="regular-text" style="width:100%;max-width:600px"/></td></tr></table>
    <?php for($i=1;$i<=6;$i++): list($dt,$dd)=explode('|',$defaults[$i-1]); $t=get_theme_mod("aboutchooseus_{$i}_title",$dt); $d=get_theme_mod("aboutchooseus_{$i}_desc",$dd); ?>
    <hr style="margin:30px 0;border:0;border-top:1px solid #ddd"><h2 style="margin-top:0;padding-bottom:10px;border-bottom:1px solid #ddd">Reason <?php echo $i; ?></h2>
    <table class="form-table"><tr><th><label for="aboutchooseus_<?php echo $i;?>_title">Title</label></th><td><input type="text" id="aboutchooseus_<?php echo $i;?>_title" name="aboutchooseus_<?php echo $i;?>_title" value="<?php echo esc_attr($t);?>" class="regular-text"/></td></tr>
    <tr><th><label for="aboutchooseus_<?php echo $i;?>_desc">Description</label></th><td><textarea id="aboutchooseus_<?php echo $i;?>_desc" name="aboutchooseus_<?php echo $i;?>_desc" rows="2" class="large-text" style="width:100%;max-width:600px"><?php echo esc_textarea($d);?></textarea></td></tr></table>
    <?php endfor; ?></div><?php submit_button('Save About Choose Us Section'); ?></form></div><?php
}

/**
 * Save About Choose Us Section
 */
function lawfirm_pro_save_aboutchooseus_section() {
    if(isset($_POST['aboutchooseus_title'])) set_theme_mod('aboutchooseus_title',wp_kses_post(wp_unslash($_POST['aboutchooseus_title'])));
    if(isset($_POST['aboutchooseus_subtitle'])) set_theme_mod('aboutchooseus_subtitle',sanitize_text_field(wp_unslash($_POST['aboutchooseus_subtitle'])));
    for($i=1;$i<=6;$i++){
        if(isset($_POST["aboutchooseus_{$i}_title"])) set_theme_mod("aboutchooseus_{$i}_title",sanitize_text_field(wp_unslash($_POST["aboutchooseus_{$i}_title"])));
        if(isset($_POST["aboutchooseus_{$i}_desc"])) set_theme_mod("aboutchooseus_{$i}_desc",sanitize_textarea_field(wp_unslash($_POST["aboutchooseus_{$i}_desc"])));
    }
}

/**
 * Hero Section admin page content
 */
function lawfirm_pro_hero_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Enqueue WordPress media uploader
    wp_enqueue_media();

    // Handle form submission
    if ( isset( $_POST['lawfirm_hero_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_hero_section_nonce'], 'lawfirm_hero_section_save' ) ) {
        lawfirm_pro_save_hero_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Hero Section settings saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $hero_title = get_theme_mod( 'hero_title', 'Find Your <span class="text-[#26cf71]">Legal Expert</span> Today' );
    $hero_subtitle = get_theme_mod( 'hero_subtitle', 'Connect with experienced attorneys across all practice areas • Free Consultation' );
    $hero_button_text = get_theme_mod( 'hero_button_text', 'Free Consultation' );
    $hero_button_url = get_theme_mod( 'hero_button_url', '#contact' );
    $hero_background_image = get_theme_mod( 'hero_background_image', '' );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'Hero Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Customize the hero section content displayed at the top of the homepage.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_hero_section_save', 'lawfirm_hero_section_nonce' ); ?>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="hero_title"><?php esc_html_e( 'Hero Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="hero_title" name="hero_title" value="<?php echo esc_attr( $hero_title ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" />
                            <p class="description"><?php esc_html_e( 'You can use HTML like: Find Your &lt;span class="text-[#26cf71]"&gt;Legal Expert&lt;/span&gt; Today', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="hero_subtitle"><?php esc_html_e( 'Hero Subtitle', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="hero_subtitle" name="hero_subtitle" rows="3" class="large-text" style="width: 100%; max-width: 600px;"><?php echo esc_textarea( $hero_subtitle ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Brief description below the title', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="hero_button_text"><?php esc_html_e( 'Button Text', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="hero_button_text" name="hero_button_text" value="<?php echo esc_attr( $hero_button_text ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="hero_button_url"><?php esc_html_e( 'Button URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="hero_button_url" name="hero_button_url" value="<?php echo esc_attr( $hero_button_url ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Where the button should link to (e.g., #contact or /contact)', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
                
                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ddd;">
                
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Background Image', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="hero_background_image"><?php esc_html_e( 'Upload Background Image', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="hidden" id="hero_background_image" name="hero_background_image" value="<?php echo esc_attr( $hero_background_image ); ?>" />
                            <div id="hero_image_preview" style="margin-bottom: 10px;">
                                <?php if ( $hero_background_image ) : ?>
                                    <img src="<?php echo esc_url( $hero_background_image ); ?>" style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 4px;" />
                                <?php endif; ?>
                            </div>
                            <button type="button" class="button" id="upload_hero_image_button"><?php esc_html_e( 'Upload/Select Image', 'lawfirm-pro' ); ?></button>
                            <button type="button" class="button" id="remove_hero_image_button" <?php echo empty( $hero_background_image ) ? 'style="display:none;"' : ''; ?>><?php esc_html_e( 'Remove Image', 'lawfirm-pro' ); ?></button>
                            <p class="description">
                                <?php esc_html_e( 'Upload a background image for the hero section.', 'lawfirm-pro' ); ?><br>
                                <?php esc_html_e( 'If no image is uploaded, a default video background will be displayed.', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button( __( 'Save Hero Section', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#upload_hero_image_button').on('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: '<?php esc_html_e( 'Choose Hero Background Image', 'lawfirm-pro' ); ?>',
                button: {
                    text: '<?php esc_html_e( 'Use this image', 'lawfirm-pro' ); ?>'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#hero_background_image').val(attachment.url);
                $('#hero_image_preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 4px;" />');
                $('#remove_hero_image_button').show();
            });
            
            mediaUploader.open();
        });
        
        $('#remove_hero_image_button').on('click', function(e) {
            e.preventDefault();
            $('#hero_background_image').val('');
            $('#hero_image_preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * FAQ Section admin page content
 */
function lawfirm_pro_faq_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Handle form submission
    if ( isset( $_POST['lawfirm_faq_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_faq_section_nonce'], 'lawfirm_faq_section_save' ) ) {
        lawfirm_pro_save_faq_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'FAQ Section settings saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $faq_items = get_theme_mod( 'lawfirm_faq_items', '' );
    if ( ! empty( $faq_items ) && is_string( $faq_items ) ) {
        $faq_items = json_decode( $faq_items, true );
    }
    if ( ! is_array( $faq_items ) ) {
        $faq_items = array();
    }
    
    $cases_won_number = get_theme_mod( 'lawfirm_cases_won_number', '500' );
    $cases_won_label = get_theme_mod( 'lawfirm_cases_won_label', 'Cases Won' );
    $attorneys_number = get_theme_mod( 'lawfirm_attorneys_number', '50' );
    $attorneys_label = get_theme_mod( 'lawfirm_attorneys_label', 'Expert Attorneys' );
    $practice_areas_number = get_theme_mod( 'lawfirm_practice_areas_number', '25' );
    $practice_areas_label = get_theme_mod( 'lawfirm_practice_areas_label', 'Practice Areas' );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'FAQ Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Manage FAQ items and statistics displayed on the homepage.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_faq_section_save', 'lawfirm_faq_section_nonce' ); ?>
            
            <!-- FAQ Items -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'FAQ Items', 'lawfirm-pro' ); ?>
                </h2>
                
                <div id="faq-items-container">
                    <?php
                    if ( ! empty( $faq_items ) ) {
                        foreach ( $faq_items as $index => $item ) {
                            ?>
                            <div class="faq-item-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <strong><?php echo esc_html( sprintf( __( 'FAQ #%d', 'lawfirm-pro' ), $index + 1 ) ); ?></strong>
                                    <button type="button" class="button remove-faq-btn" style="background: #dc3545; color: white; border-color: #dc3545;"><?php esc_html_e( 'Remove', 'lawfirm-pro' ); ?></button>
                                </div>
                                <p>
                                    <label><strong><?php esc_html_e( 'Question:', 'lawfirm-pro' ); ?></strong></label><br>
                                    <input type="text" name="faq_question[]" value="<?php echo esc_attr( $item['question'] ); ?>" class="large-text" style="width: 100%;" />
                                </p>
                                <p>
                                    <label><strong><?php esc_html_e( 'Answer:', 'lawfirm-pro' ); ?></strong></label><br>
                                    <textarea name="faq_answer[]" rows="3" class="large-text" style="width: 100%;"><?php echo esc_textarea( $item['answer'] ); ?></textarea>
                                </p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" id="add-faq-btn" class="button button-secondary"><?php esc_html_e( 'Add FAQ', 'lawfirm-pro' ); ?></button>
            </div>
            
            <!-- Statistics -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Statistics', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="cases_won_number"><?php esc_html_e( 'Cases Won - Number', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="number" id="cases_won_number" name="cases_won_number" value="<?php echo esc_attr( $cases_won_number ); ?>" class="small-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="cases_won_label"><?php esc_html_e( 'Cases Won - Label', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="cases_won_label" name="cases_won_label" value="<?php echo esc_attr( $cases_won_label ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="attorneys_number"><?php esc_html_e( 'Attorneys - Number', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="number" id="attorneys_number" name="attorneys_number" value="<?php echo esc_attr( $attorneys_number ); ?>" class="small-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="attorneys_label"><?php esc_html_e( 'Attorneys - Label', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="attorneys_label" name="attorneys_label" value="<?php echo esc_attr( $attorneys_label ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="practice_areas_number"><?php esc_html_e( 'Practice Areas - Number', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="number" id="practice_areas_number" name="practice_areas_number" value="<?php echo esc_attr( $practice_areas_number ); ?>" class="small-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="practice_areas_label"><?php esc_html_e( 'Practice Areas - Label', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="practice_areas_label" name="practice_areas_label" value="<?php echo esc_attr( $practice_areas_label ); ?>" class="regular-text" />
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button( __( 'Save FAQ Section', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var faqIndex = <?php echo count( $faq_items ); ?>;
        
        // Add FAQ
        $('#add-faq-btn').on('click', function() {
            faqIndex++;
            var html = '<div class="faq-item-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">' +
                '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">' +
                '<strong><?php esc_html_e( 'FAQ #', 'lawfirm-pro' ); ?>' + faqIndex + '</strong>' +
                '<button type="button" class="button remove-faq-btn" style="background: #dc3545; color: white; border-color: #dc3545;"><?php esc_html_e( 'Remove', 'lawfirm-pro' ); ?></button>' +
                '</div>' +
                '<p>' +
                '<label><strong><?php esc_html_e( 'Question:', 'lawfirm-pro' ); ?></strong></label><br>' +
                '<input type="text" name="faq_question[]" value="" class="large-text" style="width: 100%;" />' +
                '</p>' +
                '<p>' +
                '<label><strong><?php esc_html_e( 'Answer:', 'lawfirm-pro' ); ?></strong></label><br>' +
                '<textarea name="faq_answer[]" rows="3" class="large-text" style="width: 100%;"></textarea>' +
                '</p>' +
                '</div>';
            $('#faq-items-container').append(html);
        });
        
        // Remove FAQ
        $(document).on('click', '.remove-faq-btn', function() {
            $(this).closest('.faq-item-row').remove();
            // Renumber FAQs
            $('#faq-items-container .faq-item-row').each(function(index) {
                $(this).find('strong').first().text('<?php esc_html_e( 'FAQ #', 'lawfirm-pro' ); ?>' + (index + 1));
            });
            faqIndex = $('#faq-items-container .faq-item-row').length;
        });
    });
    </script>
    <?php
}

/**
 * Save Hero Section settings
 */
function lawfirm_pro_save_hero_section() {
    if ( isset( $_POST['hero_title'] ) ) {
        set_theme_mod( 'hero_title', wp_kses_post( $_POST['hero_title'] ) );
    }
    if ( isset( $_POST['hero_subtitle'] ) ) {
        set_theme_mod( 'hero_subtitle', sanitize_textarea_field( $_POST['hero_subtitle'] ) );
    }
    if ( isset( $_POST['hero_button_text'] ) ) {
        set_theme_mod( 'hero_button_text', sanitize_text_field( $_POST['hero_button_text'] ) );
    }
    if ( isset( $_POST['hero_button_url'] ) ) {
        set_theme_mod( 'hero_button_url', esc_url_raw( $_POST['hero_button_url'] ) );
    }
    if ( isset( $_POST['hero_background_image'] ) ) {
        set_theme_mod( 'hero_background_image', esc_url_raw( $_POST['hero_background_image'] ) );
    }
}

/**
 * Save FAQ Section settings
 */
function lawfirm_pro_save_faq_section() {
    // FAQ Items
    if ( isset( $_POST['faq_question'] ) && isset( $_POST['faq_answer'] ) ) {
        $questions = array_map( 'sanitize_text_field', $_POST['faq_question'] );
        $answers = array_map( 'sanitize_textarea_field', $_POST['faq_answer'] );
        
        $faq_items = array();
        foreach ( $questions as $index => $question ) {
            if ( ! empty( $question ) || ! empty( $answers[$index] ) ) {
                $faq_items[] = array(
                    'question' => $question,
                    'answer'   => isset( $answers[$index] ) ? $answers[$index] : '',
                );
            }
        }
        
        set_theme_mod( 'lawfirm_faq_items', json_encode( $faq_items ) );
    }
    
    // Statistics
    if ( isset( $_POST['cases_won_number'] ) ) {
        set_theme_mod( 'lawfirm_cases_won_number', sanitize_text_field( $_POST['cases_won_number'] ) );
    }
    if ( isset( $_POST['cases_won_label'] ) ) {
        set_theme_mod( 'lawfirm_cases_won_label', sanitize_text_field( $_POST['cases_won_label'] ) );
    }
    if ( isset( $_POST['attorneys_number'] ) ) {
        set_theme_mod( 'lawfirm_attorneys_number', sanitize_text_field( $_POST['attorneys_number'] ) );
    }
    if ( isset( $_POST['attorneys_label'] ) ) {
        set_theme_mod( 'lawfirm_attorneys_label', sanitize_text_field( $_POST['attorneys_label'] ) );
    }
    if ( isset( $_POST['practice_areas_number'] ) ) {
        set_theme_mod( 'lawfirm_practice_areas_number', sanitize_text_field( $_POST['practice_areas_number'] ) );
    }
    if ( isset( $_POST['practice_areas_label'] ) ) {
        set_theme_mod( 'lawfirm_practice_areas_label', sanitize_text_field( $_POST['practice_areas_label'] ) );
    }
}

/**
 * Testimonials Section admin page content
 */
function lawfirm_pro_testimonials_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Enqueue WordPress media uploader
    wp_enqueue_media();

    // Handle form submission
    if ( isset( $_POST['lawfirm_testimonials_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_testimonials_section_nonce'], 'lawfirm_testimonials_section_save' ) ) {
        lawfirm_pro_save_testimonials_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Testimonials Section settings saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $testimonials_items = get_theme_mod( 'lawfirm_testimonials_items', '' );
    if ( ! empty( $testimonials_items ) && is_string( $testimonials_items ) ) {
        $testimonials_items = json_decode( $testimonials_items, true );
    }
    if ( ! is_array( $testimonials_items ) ) {
        $testimonials_items = array();
    }
    
    $testimonials_title = get_theme_mod( 'lawfirm_testimonials_title', 'See what our clients say about us' );
    $testimonials_description = get_theme_mod( 'lawfirm_testimonials_description', 'Genius Law and Associates is your trusted legal partner with over 25 years of professional experience. We offer comprehensive legal solutions for individuals and businesses, allowing you to focus on what matters most while we handle your legal matters.' );
    $testimonials_description_2 = get_theme_mod( 'lawfirm_testimonials_description_2', 'We provide a wide range of legal services including family law, corporate law, criminal defense, property disputes, immigration law, contract drafting, employment law, and many more practice areas to serve all your legal needs.' );
    $testimonials_video_url = get_theme_mod( 'lawfirm_testimonials_video_url', 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=800' );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'Testimonials Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Manage testimonials and content displayed on the homepage.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_testimonials_section_save', 'lawfirm_testimonials_section_nonce' ); ?>
            
            <!-- Section Content -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Section Content', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="testimonials_title"><?php esc_html_e( 'Section Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="testimonials_title" name="testimonials_title" value="<?php echo esc_attr( $testimonials_title ); ?>" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="testimonials_description"><?php esc_html_e( 'Description Paragraph 1', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="testimonials_description" name="testimonials_description" rows="3" class="large-text"><?php echo esc_textarea( $testimonials_description ); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="testimonials_description_2"><?php esc_html_e( 'Description Paragraph 2', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="testimonials_description_2" name="testimonials_description_2" rows="3" class="large-text"><?php echo esc_textarea( $testimonials_description_2 ); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="testimonials_video_url"><?php esc_html_e( 'Video/Image URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="testimonials_video_url" name="testimonials_video_url" value="<?php echo esc_attr( $testimonials_video_url ); ?>" class="large-text" />
                            <p class="description">
                                <?php esc_html_e( 'Supports: YouTube URLs, Vimeo URLs, direct video files (.mp4, .webm, .ogg), or image URLs', 'lawfirm-pro' ); ?><br>
                                <?php esc_html_e( 'Examples: https://www.youtube.com/watch?v=VIDEO_ID or https://vimeo.com/VIDEO_ID', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Testimonials Items -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Testimonials', 'lawfirm-pro' ); ?>
                </h2>
                
                <div id="testimonials-items-container">
                    <?php
                    if ( ! empty( $testimonials_items ) ) {
                        foreach ( $testimonials_items as $index => $item ) {
                            ?>
                            <div class="testimonial-item-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <strong><?php echo esc_html( sprintf( __( 'Testimonial #%d', 'lawfirm-pro' ), $index + 1 ) ); ?></strong>
                                    <button type="button" class="button remove-testimonial-btn" style="background: #dc3545; color: white; border-color: #dc3545;"><?php esc_html_e( 'Remove', 'lawfirm-pro' ); ?></button>
                                </div>
                                <p>
                                    <label><strong><?php esc_html_e( 'Testimonial Text:', 'lawfirm-pro' ); ?></strong></label><br>
                                    <textarea name="testimonial_text[]" rows="3" class="large-text" style="width: 100%;"><?php echo esc_textarea( $item['text'] ); ?></textarea>
                                </p>
                                <p>
                                    <label><strong><?php esc_html_e( 'Client Name:', 'lawfirm-pro' ); ?></strong></label><br>
                                    <input type="text" name="testimonial_name[]" value="<?php echo esc_attr( $item['name'] ); ?>" class="regular-text" style="width: 100%;" />
                                </p>
                                <p>
                                    <label><strong><?php esc_html_e( 'Client Position/Location:', 'lawfirm-pro' ); ?></strong></label><br>
                                    <input type="text" name="testimonial_position[]" value="<?php echo esc_attr( $item['position'] ); ?>" class="regular-text" style="width: 100%;" />
                                </p>
                                <p>
                                    <label><strong><?php esc_html_e( 'Avatar URL:', 'lawfirm-pro' ); ?></strong></label><br>
                                    <input type="hidden" name="testimonial_avatar[]" class="testimonial-avatar-url" value="<?php echo esc_attr( $item['avatar'] ); ?>" />
                                    <div class="testimonial-avatar-preview" style="margin-bottom: 10px;">
                                        <?php if ( ! empty( $item['avatar'] ) ) : ?>
                                            <img src="<?php echo esc_url( $item['avatar'] ); ?>" style="max-width: 100px; height: auto; border: 1px solid #ddd; border-radius: 50%;" />
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" class="button upload-testimonial-avatar"><?php esc_html_e( 'Upload Avatar', 'lawfirm-pro' ); ?></button>
                                    <button type="button" class="button remove-testimonial-avatar" <?php echo empty( $item['avatar'] ) ? 'style="display:none;"' : ''; ?>><?php esc_html_e( 'Remove Avatar', 'lawfirm-pro' ); ?></button>
                                </p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" id="add-testimonial-btn" class="button button-secondary"><?php esc_html_e( 'Add Testimonial', 'lawfirm-pro' ); ?></button>
            </div>
            
            <?php submit_button( __( 'Save Testimonials Section', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var testimonialIndex = <?php echo count( $testimonials_items ); ?>;
        
        // Add Testimonial
        $('#add-testimonial-btn').on('click', function() {
            testimonialIndex++;
            var html = '<div class="testimonial-item-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">' +
                '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">' +
                '<strong><?php esc_html_e( 'Testimonial #', 'lawfirm-pro' ); ?>' + testimonialIndex + '</strong>' +
                '<button type="button" class="button remove-testimonial-btn" style="background: #dc3545; color: white; border-color: #dc3545;"><?php esc_html_e( 'Remove', 'lawfirm-pro' ); ?></button>' +
                '</div>' +
                '<p>' +
                '<label><strong><?php esc_html_e( 'Testimonial Text:', 'lawfirm-pro' ); ?></strong></label><br>' +
                '<textarea name="testimonial_text[]" rows="3" class="large-text" style="width: 100%;"></textarea>' +
                '</p>' +
                '<p>' +
                '<label><strong><?php esc_html_e( 'Client Name:', 'lawfirm-pro' ); ?></strong></label><br>' +
                '<input type="text" name="testimonial_name[]" value="" class="regular-text" style="width: 100%;" />' +
                '</p>' +
                '<p>' +
                '<label><strong><?php esc_html_e( 'Client Position/Location:', 'lawfirm-pro' ); ?></strong></label><br>' +
                '<input type="text" name="testimonial_position[]" value="" class="regular-text" style="width: 100%;" />' +
                '</p>' +
                '<p>' +
                '<label><strong><?php esc_html_e( 'Avatar:', 'lawfirm-pro' ); ?></strong></label><br>' +
                '<input type="hidden" name="testimonial_avatar[]" class="testimonial-avatar-url" value="" />' +
                '<div class="testimonial-avatar-preview" style="margin-bottom: 10px;"></div>' +
                '<button type="button" class="button upload-testimonial-avatar"><?php esc_html_e( 'Upload Avatar', 'lawfirm-pro' ); ?></button>' +
                '<button type="button" class="button remove-testimonial-avatar" style="display:none;"><?php esc_html_e( 'Remove Avatar', 'lawfirm-pro' ); ?></button>' +
                '</p>' +
                '</div>';
            $('#testimonials-items-container').append(html);
        });
        
        // Remove Testimonial
        $(document).on('click', '.remove-testimonial-btn', function() {
            $(this).closest('.testimonial-item-row').remove();
            // Renumber testimonials
            $('#testimonials-items-container .testimonial-item-row').each(function(index) {
                $(this).find('strong').first().text('<?php esc_html_e( 'Testimonial #', 'lawfirm-pro' ); ?>' + (index + 1));
            });
            testimonialIndex = $('#testimonials-items-container .testimonial-item-row').length;
        });
        
        // Upload Avatar
        $(document).on('click', '.upload-testimonial-avatar', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var container = button.parent();
            var avatarInput = container.find('.testimonial-avatar-url');
            var avatarPreview = container.find('.testimonial-avatar-preview');
            var removeButton = container.find('.remove-testimonial-avatar');
            
            // Create a new media uploader instance for each click
            var mediaUploader = wp.media({
                title: '<?php esc_html_e( 'Choose Avatar Image', 'lawfirm-pro' ); ?>',
                button: {
                    text: '<?php esc_html_e( 'Use this image', 'lawfirm-pro' ); ?>'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });
            
            // Store references in closure
            var currentInput = avatarInput;
            var currentPreview = avatarPreview;
            var currentRemoveBtn = removeButton;
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                console.log('Selected image:', attachment.url);
                currentInput.val(attachment.url);
                currentPreview.html('<img src="' + attachment.url + '" style="max-width: 100px; height: auto; border: 1px solid #ddd; border-radius: 50%;" />');
                currentRemoveBtn.show();
            });
            
            mediaUploader.open();
        });
        
        // Remove Avatar
        $(document).on('click', '.remove-testimonial-avatar', function(e) {
            e.preventDefault();
            var container = $(this).closest('p');
            container.find('.testimonial-avatar-url').val('');
            container.find('.testimonial-avatar-preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * Save Testimonials Section settings
 */
function lawfirm_pro_save_testimonials_section() {
    // Section Content
    if ( isset( $_POST['testimonials_title'] ) ) {
        set_theme_mod( 'lawfirm_testimonials_title', sanitize_text_field( $_POST['testimonials_title'] ) );
    }
    if ( isset( $_POST['testimonials_description'] ) ) {
        set_theme_mod( 'lawfirm_testimonials_description', sanitize_textarea_field( $_POST['testimonials_description'] ) );
    }
    if ( isset( $_POST['testimonials_description_2'] ) ) {
        set_theme_mod( 'lawfirm_testimonials_description_2', sanitize_textarea_field( $_POST['testimonials_description_2'] ) );
    }
    if ( isset( $_POST['testimonials_video_url'] ) ) {
        set_theme_mod( 'lawfirm_testimonials_video_url', esc_url_raw( $_POST['testimonials_video_url'] ) );
    }
    
    // Testimonials Items
    if ( isset( $_POST['testimonial_text'] ) && isset( $_POST['testimonial_name'] ) ) {
        $texts = array_map( 'sanitize_textarea_field', $_POST['testimonial_text'] );
        $names = array_map( 'sanitize_text_field', $_POST['testimonial_name'] );
        $positions = isset( $_POST['testimonial_position'] ) ? array_map( 'sanitize_text_field', $_POST['testimonial_position'] ) : array();
        $avatars = isset( $_POST['testimonial_avatar'] ) ? array_map( 'esc_url_raw', $_POST['testimonial_avatar'] ) : array();
        
        $testimonials_items = array();
        foreach ( $texts as $index => $text ) {
            if ( ! empty( $text ) || ! empty( $names[$index] ) ) {
                $testimonials_items[] = array(
                    'text'     => $text,
                    'name'     => isset( $names[$index] ) ? $names[$index] : '',
                    'position' => isset( $positions[$index] ) ? $positions[$index] : '',
                    'avatar'   => isset( $avatars[$index] ) ? $avatars[$index] : '',
                );
            }
        }
        
        set_theme_mod( 'lawfirm_testimonials_items', json_encode( $testimonials_items ) );
    }
}


/**
 * Team Section admin page content
 */
function lawfirm_pro_team_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Enqueue WordPress media uploader
    wp_enqueue_media();

    // Handle form submission
    if ( isset( $_POST['lawfirm_team_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_team_section_nonce'], 'lawfirm_team_section_save' ) ) {
        lawfirm_pro_save_team_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Team Section settings saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $team_title = get_theme_mod( 'lawfirm_team_title', 'Meet Our <span class="text-[#26cf71]">Legal Team</span>' );
    $team_subtitle = get_theme_mod( 'lawfirm_team_subtitle', 'Experienced attorneys dedicated to protecting your rights' );
    
    $team_members = get_theme_mod( 'lawfirm_team_members', '' );
    if ( ! empty( $team_members ) && is_string( $team_members ) ) {
        $team_members = json_decode( $team_members, true );
    }
    if ( ! is_array( $team_members ) ) {
        $team_members = array();
    }
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'Team Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Manage team section content and team members displayed on the homepage.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_team_section_save', 'lawfirm_team_section_nonce' ); ?>
            
            <!-- Section Content -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Section Content', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="team_title"><?php esc_html_e( 'Section Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="team_title" name="team_title" value="<?php echo esc_attr( $team_title ); ?>" class="large-text" />
                            <p class="description"><?php esc_html_e( 'You can use HTML like: Meet Our &lt;span class="text-[#26cf71]"&gt;Legal Team&lt;/span&gt;', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="team_subtitle"><?php esc_html_e( 'Section Subtitle', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="team_subtitle" name="team_subtitle" value="<?php echo esc_attr( $team_subtitle ); ?>" class="large-text" />
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Team Members -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Team Members', 'lawfirm-pro' ); ?>
                </h2>
                
                <div id="team-members-container">
                    <?php
                    if ( ! empty( $team_members ) ) {
                        foreach ( $team_members as $index => $member ) {
                            ?>
                            <div class="team-member-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <strong><?php echo esc_html( sprintf( __( 'Team Member #%d', 'lawfirm-pro' ), $index + 1 ) ); ?></strong>
                                    <button type="button" class="button remove-member-btn" style="background: #dc3545; color: white; border-color: #dc3545;"><?php esc_html_e( 'Remove', 'lawfirm-pro' ); ?></button>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                    <div>
                                        <p>
                                            <label><strong><?php esc_html_e( 'Name:', 'lawfirm-pro' ); ?></strong></label><br>
                                            <input type="text" name="member_name[]" value="<?php echo esc_attr( $member['name'] ); ?>" class="regular-text" style="width: 100%;" />
                                        </p>
                                        <p>
                                            <label><strong><?php esc_html_e( 'Specialty:', 'lawfirm-pro' ); ?></strong></label><br>
                                            <input type="text" name="member_specialty[]" value="<?php echo esc_attr( $member['specialty'] ); ?>" class="regular-text" style="width: 100%;" />
                                        </p>
                                        <p>
                                            <label><strong><?php esc_html_e( 'Description:', 'lawfirm-pro' ); ?></strong></label><br>
                                            <textarea name="member_description[]" rows="4" class="large-text" style="width: 100%;"><?php echo esc_textarea( $member['description'] ); ?></textarea>
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            <label><strong><?php esc_html_e( 'Photo:', 'lawfirm-pro' ); ?></strong></label><br>
                                            <input type="hidden" name="member_image[]" class="member-image-url" value="<?php echo esc_attr( $member['image'] ); ?>" />
                                            <div class="member-image-preview" style="margin-bottom: 10px;">
                                                <?php if ( ! empty( $member['image'] ) ) : ?>
                                                    <img src="<?php echo esc_url( $member['image'] ); ?>" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px;" />
                                                <?php endif; ?>
                                            </div>
                                            <button type="button" class="button upload-member-image"><?php esc_html_e( 'Upload Photo', 'lawfirm-pro' ); ?></button>
                                            <button type="button" class="button remove-member-image" <?php echo empty( $member['image'] ) ? 'style="display:none;"' : ''; ?>><?php esc_html_e( 'Remove Photo', 'lawfirm-pro' ); ?></button>
                                        </p>
                                        <p>
                                            <label><strong><?php esc_html_e( 'Social Media Links:', 'lawfirm-pro' ); ?></strong></label><br>
                                            <input type="url" name="member_twitter[]" value="<?php echo esc_attr( $member['twitter'] ); ?>" placeholder="Twitter URL" class="regular-text" style="width: 100%; margin-bottom: 5px;" /><br>
                                            <input type="url" name="member_facebook[]" value="<?php echo esc_attr( $member['facebook'] ); ?>" placeholder="Facebook URL" class="regular-text" style="width: 100%; margin-bottom: 5px;" /><br>
                                            <input type="url" name="member_instagram[]" value="<?php echo esc_attr( $member['instagram'] ); ?>" placeholder="Instagram URL" class="regular-text" style="width: 100%; margin-bottom: 5px;" /><br>
                                            <input type="url" name="member_linkedin[]" value="<?php echo esc_attr( $member['linkedin'] ); ?>" placeholder="LinkedIn URL" class="regular-text" style="width: 100%;" />
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" id="add-member-btn" class="button button-secondary"><?php esc_html_e( 'Add Team Member', 'lawfirm-pro' ); ?></button>
            </div>
            
            <?php submit_button( __( 'Save Team Section', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var memberIndex = <?php echo count( $team_members ); ?>;
        
        // Add Team Member
        $('#add-member-btn').on('click', function() {
            memberIndex++;
            var html = '<div class="team-member-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">' +
                '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">' +
                '<strong><?php esc_html_e( 'Team Member #', 'lawfirm-pro' ); ?>' + memberIndex + '</strong>' +
                '<button type="button" class="button remove-member-btn" style="background: #dc3545; color: white; border-color: #dc3545;"><?php esc_html_e( 'Remove', 'lawfirm-pro' ); ?></button>' +
                '</div>' +
                '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">' +
                '<div>' +
                '<p><label><strong><?php esc_html_e( 'Name:', 'lawfirm-pro' ); ?></strong></label><br><input type="text" name="member_name[]" value="" class="regular-text" style="width: 100%;" /></p>' +
                '<p><label><strong><?php esc_html_e( 'Specialty:', 'lawfirm-pro' ); ?></strong></label><br><input type="text" name="member_specialty[]" value="" class="regular-text" style="width: 100%;" /></p>' +
                '<p><label><strong><?php esc_html_e( 'Description:', 'lawfirm-pro' ); ?></strong></label><br><textarea name="member_description[]" rows="4" class="large-text" style="width: 100%;"></textarea></p>' +
                '</div>' +
                '<div>' +
                '<p><label><strong><?php esc_html_e( 'Photo:', 'lawfirm-pro' ); ?></strong></label><br><input type="hidden" name="member_image[]" class="member-image-url" value="" /><div class="member-image-preview" style="margin-bottom: 10px;"></div><button type="button" class="button upload-member-image"><?php esc_html_e( 'Upload Photo', 'lawfirm-pro' ); ?></button><button type="button" class="button remove-member-image" style="display:none;"><?php esc_html_e( 'Remove Photo', 'lawfirm-pro' ); ?></button></p>' +
                '<p><label><strong><?php esc_html_e( 'Social Media Links:', 'lawfirm-pro' ); ?></strong></label><br><input type="url" name="member_twitter[]" value="" placeholder="Twitter URL" class="regular-text" style="width: 100%; margin-bottom: 5px;" /><br><input type="url" name="member_facebook[]" value="" placeholder="Facebook URL" class="regular-text" style="width: 100%; margin-bottom: 5px;" /><br><input type="url" name="member_instagram[]" value="" placeholder="Instagram URL" class="regular-text" style="width: 100%; margin-bottom: 5px;" /><br><input type="url" name="member_linkedin[]" value="" placeholder="LinkedIn URL" class="regular-text" style="width: 100%;" /></p>' +
                '</div>' +
                '</div>' +
                '</div>';
            $('#team-members-container').append(html);
        });
        
        // Remove Team Member
        $(document).on('click', '.remove-member-btn', function() {
            $(this).closest('.team-member-row').remove();
            // Renumber members
            $('#team-members-container .team-member-row').each(function(index) {
                $(this).find('strong').first().text('<?php esc_html_e( 'Team Member #', 'lawfirm-pro' ); ?>' + (index + 1));
            });
            memberIndex = $('#team-members-container .team-member-row').length;
        });
        
        // Upload Member Image
        $(document).on('click', '.upload-member-image', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var container = button.parent();
            var imageInput = container.find('.member-image-url');
            var imagePreview = container.find('.member-image-preview');
            var removeButton = container.find('.remove-member-image');
            
            var mediaUploader = wp.media({
                title: '<?php esc_html_e( 'Choose Team Member Photo', 'lawfirm-pro' ); ?>',
                button: {
                    text: '<?php esc_html_e( 'Use this image', 'lawfirm-pro' ); ?>'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });
            
            var currentInput = imageInput;
            var currentPreview = imagePreview;
            var currentRemoveBtn = removeButton;
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                currentInput.val(attachment.url);
                currentPreview.html('<img src="' + attachment.url + '" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px;" />');
                currentRemoveBtn.show();
            });
            
            mediaUploader.open();
        });
        
        // Remove Member Image
        $(document).on('click', '.remove-member-image', function(e) {
            e.preventDefault();
            var container = $(this).closest('p');
            container.find('.member-image-url').val('');
            container.find('.member-image-preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * Save Team Section settings
 */
function lawfirm_pro_save_team_section() {
    // Section Content
    if ( isset( $_POST['team_title'] ) ) {
        set_theme_mod( 'lawfirm_team_title', wp_kses_post( $_POST['team_title'] ) );
    }
    if ( isset( $_POST['team_subtitle'] ) ) {
        set_theme_mod( 'lawfirm_team_subtitle', sanitize_text_field( $_POST['team_subtitle'] ) );
    }
    
    // Team Members
    if ( isset( $_POST['member_name'] ) ) {
        $names = array_map( 'sanitize_text_field', $_POST['member_name'] );
        $specialties = isset( $_POST['member_specialty'] ) ? array_map( 'sanitize_text_field', $_POST['member_specialty'] ) : array();
        $descriptions = isset( $_POST['member_description'] ) ? array_map( 'sanitize_textarea_field', $_POST['member_description'] ) : array();
        $images = isset( $_POST['member_image'] ) ? array_map( 'esc_url_raw', $_POST['member_image'] ) : array();
        $twitter = isset( $_POST['member_twitter'] ) ? array_map( 'esc_url_raw', $_POST['member_twitter'] ) : array();
        $facebook = isset( $_POST['member_facebook'] ) ? array_map( 'esc_url_raw', $_POST['member_facebook'] ) : array();
        $instagram = isset( $_POST['member_instagram'] ) ? array_map( 'esc_url_raw', $_POST['member_instagram'] ) : array();
        $linkedin = isset( $_POST['member_linkedin'] ) ? array_map( 'esc_url_raw', $_POST['member_linkedin'] ) : array();
        
        $team_members = array();
        foreach ( $names as $index => $name ) {
            if ( ! empty( $name ) ) {
                $team_members[] = array(
                    'name'        => $name,
                    'specialty'   => isset( $specialties[$index] ) ? $specialties[$index] : '',
                    'description' => isset( $descriptions[$index] ) ? $descriptions[$index] : '',
                    'image'       => isset( $images[$index] ) ? $images[$index] : '',
                    'twitter'     => isset( $twitter[$index] ) ? $twitter[$index] : '#',
                    'facebook'    => isset( $facebook[$index] ) ? $facebook[$index] : '#',
                    'instagram'   => isset( $instagram[$index] ) ? $instagram[$index] : '#',
                    'linkedin'    => isset( $linkedin[$index] ) ? $linkedin[$index] : '#',
                );
            }
        }
        
        set_theme_mod( 'lawfirm_team_members', json_encode( $team_members ) );
    }
}

/**
 * Footer Section admin page content
 */
function lawfirm_pro_footer_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Handle form submission
    if ( isset( $_POST['lawfirm_footer_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_footer_section_nonce'], 'lawfirm_footer_section_save' ) ) {
        lawfirm_pro_save_footer_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Footer Section settings saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $company_name = get_theme_mod( 'lawfirm_footer_company_name', 'Genius Law and Associates' );
    $company_description = get_theme_mod( 'lawfirm_footer_company_description', 'Your trusted legal partner with over 25 years of professional experience. We offer comprehensive legal solutions for individuals and businesses including family law, corporate law, criminal defense, property disputes, immigration law, and many more specialized legal services.' );
    $address = get_theme_mod( 'lawfirm_footer_address', 'Kathmandu, Nepal' );
    $phone_1 = get_theme_mod( 'lawfirm_footer_phone_1', '+977-1-4497707' );
    $phone_2 = get_theme_mod( 'lawfirm_footer_phone_2', '+977-1-4472741' );
    $cell_1 = get_theme_mod( 'lawfirm_footer_cell_1', '+977-9851063500' );
    $cell_2 = get_theme_mod( 'lawfirm_footer_cell_2', '+977-9741141964' );
    $email_1 = get_theme_mod( 'lawfirm_footer_email_1', 'genilawasso@gmail.com' );
    $email_2 = get_theme_mod( 'lawfirm_footer_email_2', 'gyanrshakya@gmail.com' );
    $copyright_text = get_theme_mod( 'lawfirm_footer_copyright', '© Copyright 2024. All Rights Reserved. Genius Law & Associates. Developed by BlueWribbon.' );
    $twitter_url = get_theme_mod( 'lawfirm_footer_twitter', '#' );
    $facebook_url = get_theme_mod( 'lawfirm_footer_facebook', '#' );
    $youtube_url = get_theme_mod( 'lawfirm_footer_youtube', '#' );
    $linkedin_url = get_theme_mod( 'lawfirm_footer_linkedin', '#' );
    
    $footer_menu_items = get_theme_mod( 'lawfirm_footer_menu_items', '' );
    if ( ! empty( $footer_menu_items ) && is_string( $footer_menu_items ) ) {
        $footer_menu_items = json_decode( $footer_menu_items, true );
    }
    if ( ! is_array( $footer_menu_items ) ) {
        $footer_menu_items = array();
    }
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'Footer Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Manage footer content including company information, contact details, and social media links.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_footer_section_save', 'lawfirm_footer_section_nonce' ); ?>
            
            <!-- Menu Items -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Footer Menu Items', 'lawfirm-pro' ); ?>
                </h2>
                
                <div id="footer-menu-items-container">
                    <?php
                    if ( ! empty( $footer_menu_items ) ) {
                        foreach ( $footer_menu_items as $index => $item ) {
                            ?>
                            <div class="footer-menu-item-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <strong><?php echo esc_html( sprintf( __( 'Menu Item #%d', 'lawfirm-pro' ), $index + 1 ) ); ?></strong>
                                    <button type="button" class="button remove-menu-item-btn" style="background: #dc3545; color: white; border-color: #dc3545;"><?php esc_html_e( 'Remove', 'lawfirm-pro' ); ?></button>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                    <p>
                                        <label><strong><?php esc_html_e( 'Menu Text:', 'lawfirm-pro' ); ?></strong></label><br>
                                        <input type="text" name="menu_text[]" value="<?php echo esc_attr( $item['text'] ); ?>" class="regular-text" style="width: 100%;" placeholder="e.g., Home, Services, About" />
                                    </p>
                                    <p>
                                        <label><strong><?php esc_html_e( 'Menu Link:', 'lawfirm-pro' ); ?></strong></label><br>
                                        <input type="text" name="menu_link[]" value="<?php echo esc_attr( $item['link'] ); ?>" class="regular-text" style="width: 100%;" placeholder="e.g., <?php echo esc_attr( home_url( '/' ) ); ?>, <?php echo esc_attr( home_url( '/contact' ) ); ?>" />
                                        <small style="color: #666; display: block; margin-top: 5px;">
                                            <?php esc_html_e( 'Enter full URL or relative path. Examples:', 'lawfirm-pro' ); ?><br>
                                            <?php esc_html_e( 'Homepage:', 'lawfirm-pro' ); ?> <?php echo esc_html( home_url( '/' ) ); ?><br>
                                            <?php esc_html_e( 'Contact page:', 'lawfirm-pro' ); ?> <?php echo esc_html( home_url( '/contact' ) ); ?><br>
                                            <?php esc_html_e( 'Anchor link:', 'lawfirm-pro' ); ?> #services
                                        </small>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" id="add-menu-item-btn" class="button button-secondary"><?php esc_html_e( 'Add Menu Item', 'lawfirm-pro' ); ?></button>
            </div>
            
            <!-- Company Information -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Company Information', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="company_name"><?php esc_html_e( 'Company Name', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="company_name" name="company_name" value="<?php echo esc_attr( $company_name ); ?>" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="company_description"><?php esc_html_e( 'Company Description', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="company_description" name="company_description" rows="4" class="large-text"><?php echo esc_textarea( $company_description ); ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Contact Information -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Contact Information', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="address"><?php esc_html_e( 'Address', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="address" name="address" value="<?php echo esc_attr( $address ); ?>" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="phone_1"><?php esc_html_e( 'Phone Number 1', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="phone_1" name="phone_1" value="<?php echo esc_attr( $phone_1 ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="phone_2"><?php esc_html_e( 'Phone Number 2', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="phone_2" name="phone_2" value="<?php echo esc_attr( $phone_2 ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="cell_1"><?php esc_html_e( 'Cell Number 1', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="cell_1" name="cell_1" value="<?php echo esc_attr( $cell_1 ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="cell_2"><?php esc_html_e( 'Cell Number 2', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="cell_2" name="cell_2" value="<?php echo esc_attr( $cell_2 ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="email_1"><?php esc_html_e( 'Email Address 1', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="email" id="email_1" name="email_1" value="<?php echo esc_attr( $email_1 ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="email_2"><?php esc_html_e( 'Email Address 2', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="email" id="email_2" name="email_2" value="<?php echo esc_attr( $email_2 ); ?>" class="regular-text" />
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Social Media Links -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Social Media Links', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="twitter_url"><?php esc_html_e( 'Twitter URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="twitter_url" name="twitter_url" value="<?php echo esc_attr( $twitter_url ); ?>" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="facebook_url"><?php esc_html_e( 'Facebook URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="facebook_url" name="facebook_url" value="<?php echo esc_attr( $facebook_url ); ?>" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="youtube_url"><?php esc_html_e( 'YouTube URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="youtube_url" name="youtube_url" value="<?php echo esc_attr( $youtube_url ); ?>" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="linkedin_url"><?php esc_html_e( 'LinkedIn URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo esc_attr( $linkedin_url ); ?>" class="large-text" />
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Copyright -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Copyright', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="copyright_text"><?php esc_html_e( 'Copyright Text', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="copyright_text" name="copyright_text" rows="3" class="large-text" placeholder="<?php esc_attr_e( 'Enter your copyright text', 'lawfirm-pro' ); ?>"><?php echo esc_textarea( $copyright_text ); ?></textarea>
                            <p class="description" style="margin-top: 8px; color: #666;">
                                <?php esc_html_e( 'Enter the copyright text that will appear in the footer.', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button( __( 'Save Footer Section', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var menuItemIndex = <?php echo count( $footer_menu_items ); ?>;
        
        // Add Menu Item
        $('#add-menu-item-btn').on('click', function() {
            menuItemIndex++;
            var html = '<div class="footer-menu-item-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px;">' +
                '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">' +
                '<strong><?php esc_html_e( 'Menu Item #', 'lawfirm-pro' ); ?>' + menuItemIndex + '</strong>' +
                '<button type="button" class="button remove-menu-item-btn" style="background: #dc3545; color: white; border-color: #dc3545;"><?php esc_html_e( 'Remove', 'lawfirm-pro' ); ?></button>' +
                '</div>' +
                '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">' +
                '<p><label><strong><?php esc_html_e( 'Menu Text:', 'lawfirm-pro' ); ?></strong></label><br><input type="text" name="menu_text[]" value="" class="regular-text" style="width: 100%;" placeholder="e.g., Home, Services, About" /></p>' +
                '<p><label><strong><?php esc_html_e( 'Menu Link:', 'lawfirm-pro' ); ?></strong></label><br><input type="text" name="menu_link[]" value="" class="regular-text" style="width: 100%;" placeholder="e.g., <?php echo esc_attr( home_url( '/' ) ); ?>, <?php echo esc_attr( home_url( '/contact' ) ); ?>" /><small style="color: #666; display: block; margin-top: 5px;"><?php esc_html_e( 'Enter full URL or relative path. Examples:', 'lawfirm-pro' ); ?><br><?php esc_html_e( 'Homepage:', 'lawfirm-pro' ); ?> <?php echo esc_html( home_url( '/' ) ); ?><br><?php esc_html_e( 'Contact page:', 'lawfirm-pro' ); ?> <?php echo esc_html( home_url( '/contact' ) ); ?><br><?php esc_html_e( 'Anchor link:', 'lawfirm-pro' ); ?> #services</small></p>' +
                '</div>' +
                '</div>';
            $('#footer-menu-items-container').append(html);
        });
        
        // Remove Menu Item
        $(document).on('click', '.remove-menu-item-btn', function() {
            $(this).closest('.footer-menu-item-row').remove();
            // Renumber menu items
            $('#footer-menu-items-container .footer-menu-item-row').each(function(index) {
                $(this).find('strong').first().text('<?php esc_html_e( 'Menu Item #', 'lawfirm-pro' ); ?>' + (index + 1));
            });
            menuItemIndex = $('#footer-menu-items-container .footer-menu-item-row').length;
        });
    });
    </script>
    <?php
}

/**
 * Save Footer Section settings
 */
function lawfirm_pro_save_footer_section() {
    // Menu Items
    if ( isset( $_POST['menu_text'] ) && isset( $_POST['menu_link'] ) ) {
        $menu_texts = array_map( 'sanitize_text_field', $_POST['menu_text'] );
        $menu_links = array_map( 'sanitize_text_field', $_POST['menu_link'] );
        
        $footer_menu_items = array();
        foreach ( $menu_texts as $index => $text ) {
            if ( ! empty( $text ) || ! empty( $menu_links[$index] ) ) {
                $footer_menu_items[] = array(
                    'text' => $text,
                    'link' => isset( $menu_links[$index] ) ? $menu_links[$index] : '',
                );
            }
        }
        
        set_theme_mod( 'lawfirm_footer_menu_items', json_encode( $footer_menu_items ) );
    }
    
    // Company Information
    if ( isset( $_POST['company_name'] ) ) {
        set_theme_mod( 'lawfirm_footer_company_name', sanitize_text_field( $_POST['company_name'] ) );
    }
    if ( isset( $_POST['company_description'] ) ) {
        set_theme_mod( 'lawfirm_footer_company_description', sanitize_textarea_field( $_POST['company_description'] ) );
    }
    
    // Contact Information
    if ( isset( $_POST['address'] ) ) {
        set_theme_mod( 'lawfirm_footer_address', sanitize_text_field( $_POST['address'] ) );
    }
    if ( isset( $_POST['phone_1'] ) ) {
        set_theme_mod( 'lawfirm_footer_phone_1', sanitize_text_field( $_POST['phone_1'] ) );
    }
    if ( isset( $_POST['phone_2'] ) ) {
        set_theme_mod( 'lawfirm_footer_phone_2', sanitize_text_field( $_POST['phone_2'] ) );
    }
    if ( isset( $_POST['cell_1'] ) ) {
        set_theme_mod( 'lawfirm_footer_cell_1', sanitize_text_field( $_POST['cell_1'] ) );
    }
    if ( isset( $_POST['cell_2'] ) ) {
        set_theme_mod( 'lawfirm_footer_cell_2', sanitize_text_field( $_POST['cell_2'] ) );
    }
    if ( isset( $_POST['email_1'] ) ) {
        set_theme_mod( 'lawfirm_footer_email_1', sanitize_email( $_POST['email_1'] ) );
    }
    if ( isset( $_POST['email_2'] ) ) {
        set_theme_mod( 'lawfirm_footer_email_2', sanitize_email( $_POST['email_2'] ) );
    }
    
    // Social Media Links
    if ( isset( $_POST['twitter_url'] ) ) {
        set_theme_mod( 'lawfirm_footer_twitter', esc_url_raw( $_POST['twitter_url'] ) );
    }
    if ( isset( $_POST['facebook_url'] ) ) {
        set_theme_mod( 'lawfirm_footer_facebook', esc_url_raw( $_POST['facebook_url'] ) );
    }
    if ( isset( $_POST['youtube_url'] ) ) {
        set_theme_mod( 'lawfirm_footer_youtube', esc_url_raw( $_POST['youtube_url'] ) );
    }
    if ( isset( $_POST['linkedin_url'] ) ) {
        set_theme_mod( 'lawfirm_footer_linkedin', esc_url_raw( $_POST['linkedin_url'] ) );
    }
    
    // Copyright Text
    if ( isset( $_POST['copyright_text'] ) ) {
        set_theme_mod( 'lawfirm_footer_copyright', sanitize_textarea_field( $_POST['copyright_text'] ) );
    }
}

/**
 * WhatsApp Section admin page content
 */
function lawfirm_pro_whatsapp_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Handle form submission
    if ( isset( $_POST['lawfirm_whatsapp_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_whatsapp_section_nonce'], 'lawfirm_whatsapp_section_save' ) ) {
        lawfirm_pro_save_whatsapp_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'WhatsApp settings saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $whatsapp_number = get_theme_mod( 'whatsapp_number', '9779842416371' );
    $whatsapp_message = get_theme_mod( 'whatsapp_message', 'Hello, I need legal consultation' );
    $whatsapp_enabled = get_theme_mod( 'whatsapp_enabled', true );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'WhatsApp Floating Button', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Configure the floating WhatsApp button that appears on all pages of your website.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_whatsapp_section_save', 'lawfirm_whatsapp_section_nonce' ); ?>
            
            <!-- WhatsApp Settings -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'WhatsApp Configuration', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="whatsapp_enabled"><?php esc_html_e( 'Enable WhatsApp Button', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" id="whatsapp_enabled" name="whatsapp_enabled" value="1" <?php checked( $whatsapp_enabled, true ); ?> />
                                <?php esc_html_e( 'Show floating WhatsApp button on all pages', 'lawfirm-pro' ); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="whatsapp_number"><?php esc_html_e( 'WhatsApp Number', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="whatsapp_number" name="whatsapp_number" value="<?php echo esc_attr( $whatsapp_number ); ?>" class="regular-text" placeholder="9779842416371" />
                            <p class="description">
                                <?php esc_html_e( 'Enter your WhatsApp number with country code (without + or spaces). Example: 9779842416371 for Nepal', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="whatsapp_message"><?php esc_html_e( 'Default Message', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="whatsapp_message" name="whatsapp_message" rows="3" class="large-text" placeholder="<?php esc_attr_e( 'Hello, I need legal consultation', 'lawfirm-pro' ); ?>"><?php echo esc_textarea( $whatsapp_message ); ?></textarea>
                            <p class="description">
                                <?php esc_html_e( 'This message will be pre-filled when users click the WhatsApp button.', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Preview -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Preview', 'lawfirm-pro' ); ?>
                </h2>
                
                <div style="position: relative; height: 100px; background: #f0f0f1; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                    <div style="position: absolute; bottom: 20px; right: 20px;">
                        <a href="#" onclick="return false;" style="display: flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: #25D366; border-radius: 50%; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-decoration: none;">
                            <svg style="width: 32px; height: 32px; fill: white;" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                    <p style="color: #666; font-size: 14px;"><?php esc_html_e( 'This is how the WhatsApp button will appear on your website', 'lawfirm-pro' ); ?></p>
                </div>
            </div>
            
            <?php submit_button( __( 'Save WhatsApp Settings', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    <?php
}

/**
 * Save WhatsApp Section settings
 */
function lawfirm_pro_save_whatsapp_section() {
    // WhatsApp Enabled
    $whatsapp_enabled = isset( $_POST['whatsapp_enabled'] ) ? true : false;
    set_theme_mod( 'whatsapp_enabled', $whatsapp_enabled );
    
    // WhatsApp Number
    if ( isset( $_POST['whatsapp_number'] ) ) {
        $whatsapp_number = sanitize_text_field( $_POST['whatsapp_number'] );
        // Remove any spaces, dashes, or plus signs
        $whatsapp_number = str_replace( array( ' ', '-', '+' ), '', $whatsapp_number );
        set_theme_mod( 'whatsapp_number', $whatsapp_number );
    }
    
    // WhatsApp Message
    if ( isset( $_POST['whatsapp_message'] ) ) {
        set_theme_mod( 'whatsapp_message', sanitize_textarea_field( $_POST['whatsapp_message'] ) );
    }
}

/**
 * Location/Map Section admin page content
 */
function lawfirm_pro_location_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Handle form submission
    if ( isset( $_POST['lawfirm_location_section_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_location_section_nonce'], 'lawfirm_location_section_save' ) ) {
        lawfirm_pro_save_location_section();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Location/Map settings saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $map_location = get_theme_mod( 'map_location', 'Kathmandu, Nepal' );
    $map_latitude = get_theme_mod( 'map_latitude', '27.7172' );
    $map_longitude = get_theme_mod( 'map_longitude', '85.3240' );
    $map_section_title = get_theme_mod( 'map_section_title', 'Find Our Office' );
    $map_section_description = get_theme_mod( 'map_section_description', 'Visit us at our office in Kathmandu for in-person consultations and legal assistance.' );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'Location/Map Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Configure the map and location information displayed on your contact page.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="" id="location-form">
            <?php wp_nonce_field( 'lawfirm_location_section_save', 'lawfirm_location_section_nonce' ); ?>
            
            <!-- Map Configuration -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Map Configuration', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="map_section_title"><?php esc_html_e( 'Section Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="map_section_title" name="map_section_title" value="<?php echo esc_attr( $map_section_title ); ?>" class="regular-text" />
                            <p class="description">
                                <?php esc_html_e( 'The main heading for the map section (e.g., "Find Our Office").', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="map_section_description"><?php esc_html_e( 'Section Description', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="map_section_description" name="map_section_description" rows="3" class="large-text"><?php echo esc_textarea( $map_section_description ); ?></textarea>
                            <p class="description">
                                <?php esc_html_e( 'A brief description that appears below the section title.', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Map Picker -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Select Your Location', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="location_search"><?php esc_html_e( 'Search Location', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="location_search" class="regular-text" placeholder="<?php esc_attr_e( 'Search for your office location...', 'lawfirm-pro' ); ?>" />
                            <button type="button" id="search_location_btn" class="button button-secondary" style="margin-left: 10px;">
                                <span class="dashicons dashicons-search" style="vertical-align: middle;"></span>
                                <?php esc_html_e( 'Search', 'lawfirm-pro' ); ?>
                            </button>
                            <p class="description">
                                <?php esc_html_e( 'Type your address or location name and click Search, then click on the map to set your exact location.', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
                
                <!-- Interactive Map -->
                <div style="margin-top: 20px;">
                    <div id="map_picker" style="width: 100%; height: 450px; border: 2px solid #ddd; border-radius: 4px;"></div>
                    <p style="margin-top: 10px; color: #666; font-style: italic;">
                        <span class="dashicons dashicons-info" style="color: #26cf71;"></span>
                        <?php esc_html_e( 'Click anywhere on the map to set your office location. You can drag the marker to adjust.', 'lawfirm-pro' ); ?>
                    </p>
                </div>
                
                <!-- Hidden fields for coordinates -->
                <input type="hidden" id="map_latitude" name="map_latitude" value="<?php echo esc_attr( $map_latitude ); ?>" />
                <input type="hidden" id="map_longitude" name="map_longitude" value="<?php echo esc_attr( $map_longitude ); ?>" />
                <input type="hidden" id="map_location" name="map_location" value="<?php echo esc_attr( $map_location ); ?>" />
                
                <!-- Current Location Display -->
                <div style="margin-top: 20px; padding: 15px; background: #f0f9ff; border-left: 4px solid #26cf71; border-radius: 4px;">
                    <p style="margin: 0 0 10px 0; font-weight: 600; color: #1A2B3C;">
                        <?php esc_html_e( 'Selected Location:', 'lawfirm-pro' ); ?>
                    </p>
                    <p style="margin: 0; color: #666;" id="selected_location_display">
                        <?php echo esc_html( $map_location ); ?>
                    </p>
                    <p style="margin: 10px 0 0 0; color: #666; font-size: 13px;">
                        <strong><?php esc_html_e( 'Coordinates:', 'lawfirm-pro' ); ?></strong> 
                        <span id="coordinates_display"><?php echo esc_html( $map_latitude . ', ' . $map_longitude ); ?></span>
                    </p>
                </div>
            </div>
            
            <?php submit_button( __( 'Save Location/Map Settings', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
    (function() {
        let map;
        let marker;
        
        function initMap() {
            const lat = parseFloat(document.getElementById('map_latitude').value) || 27.7172;
            const lng = parseFloat(document.getElementById('map_longitude').value) || 85.3240;
            
            // Initialize map
            map = L.map('map_picker').setView([lat, lng], 15);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);
            
            // Add marker
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);
            
            // Click on map to set location
            map.on('click', function(e) {
                setLocation(e.latlng.lat, e.latlng.lng);
            });
            
            // Drag marker to set location
            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                setLocation(position.lat, position.lng);
            });
            
            // Search button click
            document.getElementById('search_location_btn').addEventListener('click', function() {
                searchLocation();
            });
            
            // Enter key on search input
            document.getElementById('location_search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchLocation();
                }
            });
        }
        
        function searchLocation() {
            const searchInput = document.getElementById('location_search').value;
            if (!searchInput) {
                alert('<?php esc_html_e( 'Please enter a location to search.', 'lawfirm-pro' ); ?>');
                return;
            }
            
            // Show loading
            const btn = document.getElementById('search_location_btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="dashicons dashicons-update-alt" style="vertical-align: middle; animation: rotation 1s infinite linear;"></span> <?php esc_html_e( 'Searching...', 'lawfirm-pro' ); ?>';
            btn.disabled = true;
            
            // Use Nominatim (OpenStreetMap) geocoding service
            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(searchInput))
                .then(response => response.json())
                .then(data => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    
                    if (data && data.length > 0) {
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lng = parseFloat(result.lon);
                        
                        map.setView([lat, lng], 15);
                        setLocation(lat, lng);
                    } else {
                        alert('<?php esc_html_e( 'Location not found. Please try a different search term.', 'lawfirm-pro' ); ?>');
                    }
                })
                .catch(error => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    alert('<?php esc_html_e( 'Error searching location. Please try again.', 'lawfirm-pro' ); ?>');
                });
        }
        
        function setLocation(lat, lng) {
            marker.setLatLng([lat, lng]);
            map.panTo([lat, lng]);
            
            // Update hidden fields
            document.getElementById('map_latitude').value = lat.toFixed(6);
            document.getElementById('map_longitude').value = lng.toFixed(6);
            
            // Get address from coordinates using reverse geocoding
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        const address = data.display_name;
                        document.getElementById('map_location').value = address;
                        document.getElementById('selected_location_display').textContent = address;
                        document.getElementById('coordinates_display').textContent = lat.toFixed(6) + ', ' + lng.toFixed(6);
                    }
                })
                .catch(error => {
                    console.error('Error getting address:', error);
                    document.getElementById('coordinates_display').textContent = lat.toFixed(6) + ', ' + lng.toFixed(6);
                });
        }
        
        // Initialize map when page loads
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initMap);
        } else {
            initMap();
        }
    })();
    </script>
    
    <style>
        .form-table th {
            width: 200px;
        }
        #map_picker {
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(359deg);
            }
        }
    </style>
    <?php
}

/**
 * Save Location/Map Section settings
 */
function lawfirm_pro_save_location_section() {
    // Section Title
    if ( isset( $_POST['map_section_title'] ) ) {
        set_theme_mod( 'map_section_title', sanitize_text_field( $_POST['map_section_title'] ) );
    }
    
    // Section Description
    if ( isset( $_POST['map_section_description'] ) ) {
        set_theme_mod( 'map_section_description', sanitize_textarea_field( $_POST['map_section_description'] ) );
    }
    
    // Location Name
    if ( isset( $_POST['map_location'] ) ) {
        set_theme_mod( 'map_location', sanitize_text_field( $_POST['map_location'] ) );
    }
    
    // Latitude
    if ( isset( $_POST['map_latitude'] ) ) {
        set_theme_mod( 'map_latitude', sanitize_text_field( $_POST['map_latitude'] ) );
    }
    
    // Longitude
    if ( isset( $_POST['map_longitude'] ) ) {
        set_theme_mod( 'map_longitude', sanitize_text_field( $_POST['map_longitude'] ) );
    }
}

/**
 * AJAX Handler for getting practice area data
 */
function lawfirm_pro_get_practice_area_data() {
    $parent_term_id = isset( $_POST['parent_term_id'] ) ? intval( $_POST['parent_term_id'] ) : 0;
    
    if ( ! $parent_term_id ) {
        wp_send_json_error();
    }
    
    // Get subcategories (child terms)
    $subcategories = get_terms( array(
        'taxonomy'   => 'practice_area',
        'hide_empty' => false,
        'parent'     => $parent_term_id,
    ) );
    
    // Get all services for this practice area (including subcategories)
    $term_ids = array( $parent_term_id );
    if ( ! empty( $subcategories ) && ! is_wp_error( $subcategories ) ) {
        foreach ( $subcategories as $subcat ) {
            $term_ids[] = $subcat->term_id;
        }
    }
    
    $services_query = new WP_Query( array(
        'post_type'      => 'legal_service',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'practice_area',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ),
        ),
    ) );
    
    $services = array();
    if ( $services_query->have_posts() ) {
        while ( $services_query->have_posts() ) {
            $services_query->the_post();
            $services[] = array(
                'title'     => get_the_title(),
                'excerpt'   => get_the_excerpt(),
                'permalink' => get_permalink(),
                'image'     => get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ?: 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=400',
            );
        }
        wp_reset_postdata();
    }
    
    $subcategories_data = array();
    if ( ! empty( $subcategories ) && ! is_wp_error( $subcategories ) ) {
        foreach ( $subcategories as $subcat ) {
            $subcategories_data[] = array(
                'term_id' => $subcat->term_id,
                'name'    => $subcat->name,
            );
        }
    }
    
    wp_send_json_success( array(
        'subcategories' => $subcategories_data,
        'services'      => $services,
    ) );
}
add_action( 'wp_ajax_get_practice_area_data', 'lawfirm_pro_get_practice_area_data' );
add_action( 'wp_ajax_nopriv_get_practice_area_data', 'lawfirm_pro_get_practice_area_data' );

/**
 * AJAX Handler for getting services by specific term
 */
function lawfirm_pro_get_services_by_term() {
    $term_id = isset( $_POST['term_id'] ) ? intval( $_POST['term_id'] ) : 0;
    $filter_type = isset( $_POST['filter_type'] ) ? sanitize_text_field( $_POST['filter_type'] ) : 'all';
    
    if ( ! $term_id ) {
        wp_send_json_error();
    }
    
    $term_ids = array( $term_id );
    
    // If "All" filter, include all child terms
    if ( $filter_type === 'all' ) {
        $child_terms = get_terms( array(
            'taxonomy'   => 'practice_area',
            'hide_empty' => false,
            'parent'     => $term_id,
        ) );
        
        if ( ! empty( $child_terms ) && ! is_wp_error( $child_terms ) ) {
            foreach ( $child_terms as $child ) {
                $term_ids[] = $child->term_id;
            }
        }
    }
    
    $services_query = new WP_Query( array(
        'post_type'      => 'legal_service',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'practice_area',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ),
        ),
    ) );
    
    $services = array();
    if ( $services_query->have_posts() ) {
        while ( $services_query->have_posts() ) {
            $services_query->the_post();
            $services[] = array(
                'title'     => get_the_title(),
                'excerpt'   => get_the_excerpt(),
                'permalink' => get_permalink(),
                'image'     => get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ?: 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=400',
            );
        }
        wp_reset_postdata();
    }
    
    wp_send_json_success( array(
        'services' => $services,
    ) );
}
add_action( 'wp_ajax_get_services_by_term', 'lawfirm_pro_get_services_by_term' );
add_action( 'wp_ajax_nopriv_get_services_by_term', 'lawfirm_pro_get_services_by_term' );

/**
 * Seed default practice areas and legal services
 * Run this once to populate the database with sample data
 */
function lawfirm_pro_seed_practice_areas() {
    // Check if already seeded
    if ( get_option( 'lawfirm_pro_seeded' ) ) {
        return;
    }
    
    // Parent Practice Areas with images
    $practice_areas = array(
        'Corporate Law' => array(
            'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=200',
            'subcategories' => array(
                'Company Registration',
                'Compliance',
                'Licensing',
            ),
        ),
        'Family Law' => array(
            'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=200',
            'subcategories' => array(
                'Divorce',
                'Child Custody',
                'Adoption',
            ),
        ),
        'Property Law' => array(
            'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=200',
            'subcategories' => array(
                'Property Disputes',
                'Real Estate Transactions',
                'Land Registration',
            ),
        ),
        'Criminal Law' => array(
            'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=200',
            'subcategories' => array(
                'Criminal Defense',
                'Bail Applications',
                'Appeals',
            ),
        ),
    );
    
    foreach ( $practice_areas as $parent_name => $data ) {
        // Create parent term
        $parent_term = wp_insert_term( $parent_name, 'practice_area' );
        
        if ( ! is_wp_error( $parent_term ) ) {
            $parent_id = $parent_term['term_id'];
            
            // Add image to parent term
            update_term_meta( $parent_id, 'practice_area_image', $data['image'] );
            
            // Create subcategories
            foreach ( $data['subcategories'] as $subcat_name ) {
                $subcat_term = wp_insert_term( $subcat_name, 'practice_area', array(
                    'parent' => $parent_id,
                ) );
                
                if ( ! is_wp_error( $subcat_term ) ) {
                    // Create 2 sample services for each subcategory
                    for ( $i = 1; $i <= 2; $i++ ) {
                        $post_id = wp_insert_post( array(
                            'post_title'   => $subcat_name . ' Service ' . $i,
                            'post_content' => 'Expert legal services for ' . $subcat_name . '. Our experienced attorneys provide comprehensive legal solutions tailored to your needs.',
                            'post_excerpt' => 'Professional ' . $subcat_name . ' services with over 25 years of experience.',
                            'post_status'  => 'publish',
                            'post_type'    => 'legal_service',
                        ) );
                        
                        if ( $post_id ) {
                            // Assign to subcategory
                            wp_set_object_terms( $post_id, $subcat_term['term_id'], 'practice_area' );
                        }
                    }
                }
            }
        }
    }
    
    // Mark as seeded
    update_option( 'lawfirm_pro_seeded', true );
}
// Run seed function on theme activation
add_action( 'after_switch_theme', 'lawfirm_pro_seed_practice_areas' );


/**
 * Add admin notice to seed practice areas
 */
function lawfirm_pro_seed_admin_notice() {
    if ( ! get_option( 'lawfirm_pro_seeded' ) && current_user_can( 'manage_options' ) ) {
        ?>
        <div class="notice notice-info is-dismissible">
            <p>
                <strong>Genius Law Theme:</strong> 
                Click here to seed sample Practice Areas and Legal Services: 
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=seed-practice-areas' ) ); ?>" class="button button-primary">Seed Sample Data</a>
            </p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'lawfirm_pro_seed_admin_notice' );

/**
 * Add seed page to admin menu
 */
function lawfirm_pro_add_seed_menu() {
    add_submenu_page(
        null, // Hidden from menu
        'Seed Practice Areas',
        'Seed Practice Areas',
        'manage_options',
        'seed-practice-areas',
        'lawfirm_pro_seed_page_callback'
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_seed_menu' );

/**
 * Seed page callback
 */
function lawfirm_pro_seed_page_callback() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Run seed function
    lawfirm_pro_seed_practice_areas();
    
    ?>
    <div class="wrap">
        <h1>Sample Data Seeded Successfully!</h1>
        <p>Practice Areas and Legal Services have been created.</p>
        <p><a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=practice_area&post_type=legal_service' ) ); ?>" class="button button-primary">View Practice Areas</a></p>
        <p><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=legal_service' ) ); ?>" class="button button-primary">View Legal Services</a></p>
        <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button">View Homepage</a></p>
    </div>
    <?php
}


/**
 * Update existing practice areas with images
 */
function lawfirm_pro_update_practice_area_images() {
    $images = array(
        'Corporate Law' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=200',
        'Family Law' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=200',
        'Property Law' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=200',
        'Criminal Law' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=200',
    );
    
    foreach ( $images as $term_name => $image_url ) {
        $term = get_term_by( 'name', $term_name, 'practice_area' );
        if ( $term && ! is_wp_error( $term ) ) {
            update_term_meta( $term->term_id, 'practice_area_image', $image_url );
            error_log( 'Updated image for ' . $term_name . ': ' . $image_url );
        }
    }
    
    echo '<div class="notice notice-success is-dismissible"><p>Practice area images updated successfully!</p></div>';
}

// Add a menu item to update images
function lawfirm_pro_add_update_images_menu() {
    add_submenu_page(
        null,
        'Update Practice Area Images',
        'Update Practice Area Images',
        'manage_options',
        'update-practice-area-images',
        'lawfirm_pro_update_images_page'
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_update_images_menu' );

function lawfirm_pro_update_images_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    lawfirm_pro_update_practice_area_images();
    ?>
    <div class="wrap">
        <h1>Practice Area Images Updated!</h1>
        <p>All practice area images have been updated.</p>
        <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-primary">View Homepage</a></p>
    </div>
    <?php
}

/**
 * Force update practice area images on admin init (run once)
 */
function lawfirm_pro_force_update_images() {
    if ( ! get_option( 'lawfirm_pro_images_updated' ) && current_user_can( 'manage_options' ) ) {
        $images = array(
            'Corporate Law' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=200',
            'Family Law' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=200',
            'Property Law' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=200',
            'Criminal Law' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=200',
        );
        
        foreach ( $images as $term_name => $image_url ) {
            $term = get_term_by( 'name', $term_name, 'practice_area' );
            if ( $term && ! is_wp_error( $term ) ) {
                update_term_meta( $term->term_id, 'practice_area_image', $image_url );
            }
        }
        
        update_option( 'lawfirm_pro_images_updated', true );
    }
}
add_action( 'admin_init', 'lawfirm_pro_force_update_images' );


/**
 * Register ACF Fields for Pro Bono Page Template
 */
if (function_exists('acf_add_local_field_group')) {
    add_action('acf/init', 'register_pro_bono_acf_fields');
}

function register_pro_bono_acf_fields() {
    acf_add_local_field_group(array(
        'key' => 'group_pro_bono_page',
        'title' => 'Pro Bono Page Fields',
        'fields' => array(
            // Hero Section
            array(
                'key' => 'field_hero_tab',
                'label' => 'Hero Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_pro_bono_badge',
                'label' => 'Badge Text',
                'name' => 'pro_bono_badge',
                'type' => 'text',
                'placeholder' => 'Pro Bono Legal Support',
            ),
            array(
                'key' => 'field_pro_bono_title',
                'label' => 'Hero Title',
                'name' => 'pro_bono_title',
                'type' => 'text',
                'placeholder' => 'Access to Justice for Those Who Need It Most',
            ),
            array(
                'key' => 'field_pro_bono_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'pro_bono_subtitle',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_pro_bono_background_image',
                'label' => 'Background Image',
                'name' => 'pro_bono_background_image',
                'type' => 'image',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_pro_bono_primary_button_text',
                'label' => 'Primary Button Text',
                'name' => 'pro_bono_primary_button_text',
                'type' => 'text',
                'placeholder' => 'Apply for Assistance',
            ),
            array(
                'key' => 'field_pro_bono_primary_button_link',
                'label' => 'Primary Button Link',
                'name' => 'pro_bono_primary_button_link',
                'type' => 'url',
            ),
            array(
                'key' => 'field_pro_bono_secondary_button_text',
                'label' => 'Secondary Button Text',
                'name' => 'pro_bono_secondary_button_text',
                'type' => 'text',
                'placeholder' => 'Contact Our Team',
            ),
            array(
                'key' => 'field_pro_bono_secondary_button_link',
                'label' => 'Secondary Button Link',
                'name' => 'pro_bono_secondary_button_link',
                'type' => 'url',
            ),
            
            // Intro Section
            array(
                'key' => 'field_intro_tab',
                'label' => 'Intro Section',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_pro_bono_intro_title',
                'label' => 'Intro Title',
                'name' => 'pro_bono_intro_title',
                'type' => 'text',
                'placeholder' => 'What Pro Bono Means',
            ),
            array(
                'key' => 'field_pro_bono_intro_description',
                'label' => 'Intro Description',
                'name' => 'pro_bono_intro_description',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            
            // Eligibility Section
            array(
                'key' => 'field_eligibility_tab',
                'label' => 'Eligibility Section',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_eligibility_section_title',
                'label' => 'Section Title',
                'name' => 'eligibility_section_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_eligibility_section_description',
                'label' => 'Section Description',
                'name' => 'eligibility_section_description',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_eligibility_items',
                'label' => 'Eligibility Items',
                'name' => 'eligibility_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Item',
                'sub_fields' => array(
                    array(
                        'key' => 'field_eligibility_title',
                        'label' => 'Title',
                        'name' => 'eligibility_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_eligibility_description',
                        'label' => 'Description',
                        'name' => 'eligibility_description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
            
            // Supported Cases Section
            array(
                'key' => 'field_supported_cases_tab',
                'label' => 'Supported Cases',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_supported_cases_section_title',
                'label' => 'Section Title',
                'name' => 'supported_cases_section_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_supported_cases_section_description',
                'label' => 'Section Description',
                'name' => 'supported_cases_section_description',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_supported_cases',
                'label' => 'Supported Cases',
                'name' => 'supported_cases',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Case',
                'sub_fields' => array(
                    array(
                        'key' => 'field_case_title',
                        'label' => 'Case Title',
                        'name' => 'case_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_case_description',
                        'label' => 'Case Description',
                        'name' => 'case_description',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'field_case_icon',
                        'label' => 'Icon (optional)',
                        'name' => 'case_icon',
                        'type' => 'text',
                        'placeholder' => 'users, heart, briefcase, etc.',
                    ),
                ),
            ),
            
            // Process Section
            array(
                'key' => 'field_process_tab',
                'label' => 'Process Section',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_process_section_title',
                'label' => 'Section Title',
                'name' => 'process_section_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_process_section_description',
                'label' => 'Section Description',
                'name' => 'process_section_description',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_process_steps',
                'label' => 'Process Steps',
                'name' => 'process_steps',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Step',
                'sub_fields' => array(
                    array(
                        'key' => 'field_step_number',
                        'label' => 'Step Number',
                        'name' => 'step_number',
                        'type' => 'text',
                        'placeholder' => '01',
                    ),
                    array(
                        'key' => 'field_step_title',
                        'label' => 'Step Title',
                        'name' => 'step_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_step_description',
                        'label' => 'Step Description',
                        'name' => 'step_description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
            
            // Trust Section
            array(
                'key' => 'field_trust_tab',
                'label' => 'Trust Section',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_trust_section_title',
                'label' => 'Section Title',
                'name' => 'trust_section_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_trust_section_description',
                'label' => 'Section Description',
                'name' => 'trust_section_description',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_trust_items',
                'label' => 'Trust Items',
                'name' => 'trust_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Item',
                'sub_fields' => array(
                    array(
                        'key' => 'field_trust_title',
                        'label' => 'Title',
                        'name' => 'trust_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_trust_description',
                        'label' => 'Description',
                        'name' => 'trust_description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
            
            // FAQ Section
            array(
                'key' => 'field_faq_tab',
                'label' => 'FAQ Section',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_faq_section_title',
                'label' => 'Section Title',
                'name' => 'faq_section_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_section_description',
                'label' => 'Section Description',
                'name' => 'faq_section_description',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_pro_bono_faqs',
                'label' => 'FAQs',
                'name' => 'pro_bono_faqs',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add FAQ',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_question',
                        'label' => 'Question',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_answer',
                        'label' => 'Answer',
                        'name' => 'answer',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
            
            // Case Documents Section
            array(
                'key' => 'field_case_documents_tab',
                'label' => 'Case Documents',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_case_list_section_title',
                'label' => 'Section Title',
                'name' => 'case_list_section_title',
                'type' => 'text',
                'placeholder' => 'Important Legal Cases & Documents',
            ),
            array(
                'key' => 'field_case_list_section_description',
                'label' => 'Section Description',
                'name' => 'case_list_section_description',
                'type' => 'textarea',
                'rows' => 3,
                'placeholder' => 'Access key legal documents and landmark cases...',
            ),
            array(
                'key' => 'field_case_documents',
                'label' => 'Case Documents',
                'name' => 'case_documents',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Case Document',
                'sub_fields' => array(
                    array(
                        'key' => 'field_case_title',
                        'label' => 'Case Title',
                        'name' => 'case_title',
                        'type' => 'text',
                        'required' => 1,
                        'placeholder' => 'e.g., Sangha Ratna Shakya vs HMG',
                    ),
                    array(
                        'key' => 'field_case_attachment',
                        'label' => 'Document Attachment',
                        'name' => 'case_attachment',
                        'type' => 'file',
                        'return_format' => 'array',
                        'library' => 'all',
                        'instructions' => 'Upload PDF, DOC, or other document file',
                    ),
                    array(
                        'key' => 'field_case_link_behavior',
                        'label' => 'Link Behavior',
                        'name' => 'case_link_behavior',
                        'type' => 'select',
                        'choices' => array(
                            'open' => 'Open in new tab',
                            'download' => 'Download file',
                            'both' => 'Both (View & Download buttons)',
                        ),
                        'default_value' => 'both',
                    ),
                    array(
                        'key' => 'field_case_optional_note',
                        'label' => 'Optional Note',
                        'name' => 'case_optional_note',
                        'type' => 'text',
                        'placeholder' => 'e.g., Landmark public interest case',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/template-probono.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}


/**
 * Include Pro Bono Meta Boxes (Custom meta boxes without ACF)
 */
require_once get_template_directory() . '/inc/probono-meta-boxes.php';

/**
 * Include About Sections - DISABLED (About page is now static)
 * The static about page can be found in templates/template-about.php
 */
// require_once get_template_directory() . '/inc/about-sections.php';

/**
 * About CTA Section admin page
 */
function lawfirm_pro_aboutcta_section_page() {
    if(!current_user_can('manage_options')) return;
    if(isset($_POST['aboutcta_nonce']) && wp_verify_nonce($_POST['aboutcta_nonce'],'aboutcta_save')) {
        lawfirm_pro_save_aboutcta_section();
        echo '<div class="notice notice-success is-dismissible"><p>About CTA Section saved successfully!</p></div>';
    }
    $title = get_theme_mod('aboutcta_title','Ready to Get Started?');
    $subtitle = get_theme_mod('aboutcta_subtitle','Schedule a free consultation with our expert legal team today');
    $btn1_text = get_theme_mod('aboutcta_btn1_text','Call Us Now');
    $btn1_url = get_theme_mod('aboutcta_btn1_url','tel:+97714497707');
    $btn2_text = get_theme_mod('aboutcta_btn2_text','Email Us');
    $btn2_url = get_theme_mod('aboutcta_btn2_url','mailto:genilawasso@gmail.com');
    ?>
    <div class="wrap">
        <h1>About CTA Section</h1>
        <p>Customize the call-to-action section at the bottom of the About page.</p>
        <form method="post">
            <?php wp_nonce_field('aboutcta_save','aboutcta_nonce'); ?>
            <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;box-shadow:0 1px 1px rgba(0,0,0,.04);">
                <table class="form-table">
                    <tr>
                        <th><label for="aboutcta_title">Title</label></th>
                        <td><input type="text" id="aboutcta_title" name="aboutcta_title" value="<?php echo esc_attr($title); ?>" class="large-text" /></td>
                    </tr>
                    <tr>
                        <th><label for="aboutcta_subtitle">Subtitle</label></th>
                        <td><textarea id="aboutcta_subtitle" name="aboutcta_subtitle" rows="2" class="large-text"><?php echo esc_textarea($subtitle); ?></textarea></td>
                    </tr>
                </table>
                <hr style="margin:30px 0;border:0;border-top:1px solid #ddd;">
                <h2>Button 1</h2>
                <table class="form-table">
                    <tr>
                        <th><label for="aboutcta_btn1_text">Button 1 Text</label></th>
                        <td><input type="text" id="aboutcta_btn1_text" name="aboutcta_btn1_text" value="<?php echo esc_attr($btn1_text); ?>" class="regular-text" /></td>
                    </tr>
                    <tr>
                        <th><label for="aboutcta_btn1_url">Button 1 URL</label></th>
                        <td><input type="text" id="aboutcta_btn1_url" name="aboutcta_btn1_url" value="<?php echo esc_attr($btn1_url); ?>" class="large-text" />
                        <p class="description">Use tel:+1234567890 for phone or mailto:email@example.com for email</p></td>
                    </tr>
                </table>
                <hr style="margin:30px 0;border:0;border-top:1px solid #ddd;">
                <h2>Button 2</h2>
                <table class="form-table">
                    <tr>
                        <th><label for="aboutcta_btn2_text">Button 2 Text</label></th>
                        <td><input type="text" id="aboutcta_btn2_text" name="aboutcta_btn2_text" value="<?php echo esc_attr($btn2_text); ?>" class="regular-text" /></td>
                    </tr>
                    <tr>
                        <th><label for="aboutcta_btn2_url">Button 2 URL</label></th>
                        <td><input type="text" id="aboutcta_btn2_url" name="aboutcta_btn2_url" value="<?php echo esc_attr($btn2_url); ?>" class="large-text" />
                        <p class="description">Use tel:+1234567890 for phone or mailto:email@example.com for email</p></td>
                    </tr>
                </table>
            </div>
            <?php submit_button('Save About CTA Section'); ?>
        </form>
    </div>
    <?php
}

/**
 * Save About CTA Section
 */
function lawfirm_pro_save_aboutcta_section() {
    if(isset($_POST['aboutcta_title'])) set_theme_mod('aboutcta_title',sanitize_text_field(wp_unslash($_POST['aboutcta_title'])));
    if(isset($_POST['aboutcta_subtitle'])) set_theme_mod('aboutcta_subtitle',sanitize_textarea_field(wp_unslash($_POST['aboutcta_subtitle'])));
    if(isset($_POST['aboutcta_btn1_text'])) set_theme_mod('aboutcta_btn1_text',sanitize_text_field(wp_unslash($_POST['aboutcta_btn1_text'])));
    if(isset($_POST['aboutcta_btn1_url'])) set_theme_mod('aboutcta_btn1_url',esc_url_raw(wp_unslash($_POST['aboutcta_btn1_url'])));
    if(isset($_POST['aboutcta_btn2_text'])) set_theme_mod('aboutcta_btn2_text',sanitize_text_field(wp_unslash($_POST['aboutcta_btn2_text'])));
    if(isset($_POST['aboutcta_btn2_url'])) set_theme_mod('aboutcta_btn2_url',esc_url_raw(wp_unslash($_POST['aboutcta_btn2_url'])));
}

/**
 * Add FAQ Page parent menu with submenus
 */
function lawfirm_pro_add_faqpage_menu() {
    // Add parent menu
    add_menu_page(
        __( 'FAQ Page', 'lawfirm-pro' ),
        __( 'FAQ Page', 'lawfirm-pro' ),
        'manage_options',
        'faqpage-sections',
        'lawfirm_pro_faqhero_section_page',
        'dashicons-editor-help',
        27
    );
    
    // Add submenu items
    add_submenu_page(
        'faqpage-sections',
        __( 'FAQ Hero', 'lawfirm-pro' ),
        __( 'FAQ Hero', 'lawfirm-pro' ),
        'manage_options',
        'faqpage-sections',
        'lawfirm_pro_faqhero_section_page'
    );
    
    add_submenu_page(
        'faqpage-sections',
        __( 'FAQ Categories', 'lawfirm-pro' ),
        __( 'FAQ Categories', 'lawfirm-pro' ),
        'manage_options',
        'faqcategories-section',
        'lawfirm_pro_faqcategories_section_page'
    );
    
    add_submenu_page(
        'faqpage-sections',
        __( 'FAQ CTA', 'lawfirm-pro' ),
        __( 'FAQ CTA', 'lawfirm-pro' ),
        'manage_options',
        'faqcta-section',
        'lawfirm_pro_faqcta_section_page'
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_faqpage_menu' );

/**
 * FAQ Hero Section admin page
 */
function lawfirm_pro_faqhero_section_page() {
    if(!current_user_can('manage_options')) return;
    if(isset($_POST['faqhero_nonce']) && wp_verify_nonce($_POST['faqhero_nonce'],'faqhero_save')) {
        lawfirm_pro_save_faqhero_section();
        echo '<div class="notice notice-success is-dismissible"><p>FAQ Hero Section saved successfully!</p></div>';
    }
    $title = get_theme_mod('faqhero_title','Frequently <span class="text-[#26cf71]">Asked Questions</span>');
    $subtitle = get_theme_mod('faqhero_subtitle','Find answers to common legal questions');
    ?>
    <div class="wrap">
        <h1>FAQ Hero Section</h1>
        <p>Customize the hero section at the top of the FAQ page.</p>
        <form method="post">
            <?php wp_nonce_field('faqhero_save','faqhero_nonce'); ?>
            <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;box-shadow:0 1px 1px rgba(0,0,0,.04);">
                <table class="form-table">
                    <tr>
                        <th><label for="faqhero_title">Title</label></th>
                        <td>
                            <input type="text" id="faqhero_title" name="faqhero_title" value="<?php echo esc_attr($title); ?>" class="large-text" />
                            <p class="description">You can use HTML like: Frequently &lt;span class="text-[#26cf71]"&gt;Asked Questions&lt;/span&gt;</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="faqhero_subtitle">Subtitle</label></th>
                        <td><input type="text" id="faqhero_subtitle" name="faqhero_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="large-text" /></td>
                    </tr>
                </table>
            </div>
            <?php submit_button('Save FAQ Hero Section'); ?>
        </form>
    </div>
    <?php
}

/**
 * Save FAQ Hero Section
 */
function lawfirm_pro_save_faqhero_section() {
    if(isset($_POST['faqhero_title'])) set_theme_mod('faqhero_title',wp_kses_post(wp_unslash($_POST['faqhero_title'])));
    if(isset($_POST['faqhero_subtitle'])) set_theme_mod('faqhero_subtitle',sanitize_text_field(wp_unslash($_POST['faqhero_subtitle'])));
}

/**
 * FAQ Categories Section admin page
 */
function lawfirm_pro_faqcategories_section_page() {
    if(!current_user_can('manage_options')) return;
    if(isset($_POST['faqcategories_nonce']) && wp_verify_nonce($_POST['faqcategories_nonce'],'faqcategories_save')) {
        lawfirm_pro_save_faqcategories_section();
        echo '<div class="notice notice-success is-dismissible"><p>FAQ Categories saved successfully!</p></div>';
    }
    
    // Get saved categories
    $categories = get_theme_mod('faq_categories','');
    if(!empty($categories) && is_string($categories)) {
        $categories = json_decode($categories,true);
    }
    if(!is_array($categories) || empty($categories)) {
        $categories = array(
            array(
                'name' => 'General Questions',
                'faqs' => array(
                    array('question'=>'What is Genius Law and Associates?','answer'=>'Genius Law and Associates is a comprehensive legal services firm that connects you with experienced attorneys for all your legal needs including family law, corporate law, criminal defense, property disputes, and more.'),
                    array('question'=>'How can I schedule a legal consultation?','answer'=>'You can schedule a consultation by calling us at +977-1-4497707 or +977-9851063500, emailing us at genilawasso@gmail.com, or using our WhatsApp contact button. We offer free initial consultations for most cases.'),
                    array('question'=>'What are your office hours?','answer'=>'Our office is open Sunday to Friday from 10:00 AM to 5:00 PM. We are closed on Saturdays and public holidays. However, we can arrange appointments outside regular hours for urgent matters.'),
                    array('question'=>'Do you offer free consultations?','answer'=>'Yes, we offer free initial consultations for most practice areas. This allows us to understand your case and provide you with an overview of your legal options without any obligation.'),
                )
            ),
            array(
                'name' => 'Practice Areas & Services',
                'faqs' => array(
                    array('question'=>'What types of legal services do you provide?','answer'=>'We offer a wide range of legal services including family law, criminal defense, corporate law, property disputes, immigration law, contract drafting, employment law, personal injury, and many more specialized legal services.'),
                    array('question'=>'How long does a typical case take?','answer'=>'The duration varies depending on the complexity of the case and the legal process involved. Simple matters may be resolved in a few weeks, while complex litigation can take several months to years. We provide realistic timelines during your consultation.'),
                    array('question'=>'What should I bring to my first consultation?','answer'=>'Please bring any relevant documents related to your case, such as contracts, court papers, correspondence, identification documents, and a list of questions you want to discuss. The more information you provide, the better we can assess your situation.'),
                    array('question'=>'How much do your legal services cost?','answer'=>'Our fees vary depending on the type and complexity of the case. We offer transparent pricing and will discuss all costs during your initial consultation. We also offer flexible payment plans for qualifying clients.'),
                )
            ),
            array(
                'name' => 'Process & Procedures',
                'faqs' => array(
                    array('question'=>'How are your attorneys selected?','answer'=>'All our attorneys are licensed professionals with extensive experience in their practice areas. They undergo rigorous verification including bar association membership, case history review, and client satisfaction assessments.'),
                    array('question'=>'What locations does Genius Law and Associates serve?','answer'=>'We currently provide legal services in Kathmandu, Lalitpur, Bhaktapur, Pokhara, and other major cities across Nepal. We also handle cases in district and supreme courts nationwide.'),
                    array('question'=>'Can you handle cases outside of Kathmandu?','answer'=>'Yes, we handle cases throughout Nepal. Our attorneys are experienced in appearing before district courts, high courts, and the Supreme Court across the country.'),
                    array('question'=>'How do I know if I need a lawyer?','answer'=>'If you are facing legal issues, involved in a dispute, need to draft or review contracts, or require legal advice on any matter, it is advisable to consult with an attorney. We can help you understand your rights and options.'),
                )
            ),
            array(
                'name' => 'Confidentiality & Ethics',
                'faqs' => array(
                    array('question'=>'Is my information confidential?','answer'=>'Absolutely. Attorney-client privilege protects all communications between you and your lawyer. We maintain strict confidentiality and will never disclose your information without your explicit consent, except as required by law.'),
                    array('question'=>'What if I need to change my lawyer?','answer'=>'You have the right to change your lawyer at any time. We will cooperate fully in transferring your case files and information to your new attorney. However, we encourage open communication to resolve any concerns first.'),
                    array('question'=>'Do you provide legal services in English?','answer'=>'Yes, our attorneys are fluent in both Nepali and English. We can provide legal services and documentation in either language based on your preference.'),
                )
            )
        );
    }
    ?>
    <div class="wrap">
        <h1>FAQ Categories</h1>
        <p>Manage FAQ categories and questions.</p>
        <form method="post">
            <?php wp_nonce_field('faqcategories_save','faqcategories_nonce'); ?>
            <div id="faq-categories-container">
                <?php foreach($categories as $cat_index => $category): ?>
                <div class="faq-category-block" style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;box-shadow:0 1px 1px rgba(0,0,0,.04);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                        <h2 style="margin:0;">Category #<?php echo $cat_index+1; ?></h2>
                        <button type="button" class="button remove-category-btn" style="background:#dc3545;color:white;border-color:#dc3545;">Remove Category</button>
                    </div>
                    <table class="form-table">
                        <tr>
                            <th><label>Category Name</label></th>
                            <td><input type="text" name="category_name[]" value="<?php echo esc_attr($category['name']); ?>" class="large-text" /></td>
                        </tr>
                    </table>
                    <hr style="margin:20px 0;">
                    <h3>FAQs in this Category</h3>
                    <div class="faqs-container">
                        <?php if(!empty($category['faqs'])): foreach($category['faqs'] as $faq_index => $faq): ?>
                        <div class="faq-item-block" style="background:#f9f9f9;padding:15px;margin:10px 0;border:1px solid #ddd;border-radius:4px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                <strong>FAQ #<?php echo $faq_index+1; ?></strong>
                                <button type="button" class="button remove-faq-btn" style="background:#dc3545;color:white;border-color:#dc3545;">Remove</button>
                            </div>
                            <p>
                                <label><strong>Question:</strong></label><br>
                                <input type="text" name="category_<?php echo $cat_index; ?>_question[]" value="<?php echo esc_attr($faq['question']); ?>" class="large-text" style="width:100%;" />
                            </p>
                            <p>
                                <label><strong>Answer:</strong></label><br>
                                <textarea name="category_<?php echo $cat_index; ?>_answer[]" rows="3" class="large-text" style="width:100%;"><?php echo esc_textarea($faq['answer']); ?></textarea>
                            </p>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                    <button type="button" class="button add-faq-btn">Add FAQ to this Category</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-category-btn" class="button button-secondary">Add New Category</button>
            <?php submit_button('Save FAQ Categories'); ?>
        </form>
    </div>
    <script>
    jQuery(document).ready(function($) {
        var categoryIndex = <?php echo count($categories); ?>;
        
        // Add Category
        $('#add-category-btn').on('click', function() {
            categoryIndex++;
            var html = '<div class="faq-category-block" style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;box-shadow:0 1px 1px rgba(0,0,0,.04);">' +
                '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">' +
                '<h2 style="margin:0;">Category #' + categoryIndex + '</h2>' +
                '<button type="button" class="button remove-category-btn" style="background:#dc3545;color:white;border-color:#dc3545;">Remove Category</button>' +
                '</div>' +
                '<table class="form-table">' +
                '<tr><th><label>Category Name</label></th>' +
                '<td><input type="text" name="category_name[]" value="" class="large-text" /></td></tr>' +
                '</table>' +
                '<hr style="margin:20px 0;">' +
                '<h3>FAQs in this Category</h3>' +
                '<div class="faqs-container"></div>' +
                '<button type="button" class="button add-faq-btn">Add FAQ to this Category</button>' +
                '</div>';
            $('#faq-categories-container').append(html);
        });
        
        // Remove Category
        $(document).on('click', '.remove-category-btn', function() {
            $(this).closest('.faq-category-block').remove();
            renumberCategories();
        });
        
        // Add FAQ
        $(document).on('click', '.add-faq-btn', function() {
            var categoryBlock = $(this).closest('.faq-category-block');
            var catIdx = $('.faq-category-block').index(categoryBlock);
            var faqCount = categoryBlock.find('.faq-item-block').length + 1;
            var html = '<div class="faq-item-block" style="background:#f9f9f9;padding:15px;margin:10px 0;border:1px solid #ddd;border-radius:4px;">' +
                '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">' +
                '<strong>FAQ #' + faqCount + '</strong>' +
                '<button type="button" class="button remove-faq-btn" style="background:#dc3545;color:white;border-color:#dc3545;">Remove</button>' +
                '</div>' +
                '<p><label><strong>Question:</strong></label><br>' +
                '<input type="text" name="category_' + catIdx + '_question[]" value="" class="large-text" style="width:100%;" /></p>' +
                '<p><label><strong>Answer:</strong></label><br>' +
                '<textarea name="category_' + catIdx + '_answer[]" rows="3" class="large-text" style="width:100%;"></textarea></p>' +
                '</div>';
            categoryBlock.find('.faqs-container').append(html);
        });
        
        // Remove FAQ
        $(document).on('click', '.remove-faq-btn', function() {
            $(this).closest('.faq-item-block').remove();
        });
        
        function renumberCategories() {
            $('.faq-category-block').each(function(index) {
                $(this).find('h2').first().text('Category #' + (index + 1));
                // Update input names
                $(this).find('.faq-item-block').each(function() {
                    $(this).find('input[name^="category_"]').attr('name', 'category_' + index + '_question[]');
                    $(this).find('textarea[name^="category_"]').attr('name', 'category_' + index + '_answer[]');
                });
            });
            categoryIndex = $('.faq-category-block').length;
        }
    });
    </script>
    <?php
}

/**
 * Save FAQ Categories Section
 */
function lawfirm_pro_save_faqcategories_section() {
    $categories = array();
    if(isset($_POST['category_name']) && is_array($_POST['category_name'])) {
        foreach($_POST['category_name'] as $cat_index => $cat_name) {
            $faqs = array();
            $question_key = 'category_'.$cat_index.'_question';
            $answer_key = 'category_'.$cat_index.'_answer';
            if(isset($_POST[$question_key]) && is_array($_POST[$question_key])) {
                foreach($_POST[$question_key] as $faq_index => $question) {
                    $answer = isset($_POST[$answer_key][$faq_index]) ? $_POST[$answer_key][$faq_index] : '';
                    if(!empty($question) || !empty($answer)) {
                        $faqs[] = array(
                            'question' => sanitize_text_field(wp_unslash($question)),
                            'answer' => sanitize_textarea_field(wp_unslash($answer))
                        );
                    }
                }
            }
            $categories[] = array(
                'name' => sanitize_text_field(wp_unslash($cat_name)),
                'faqs' => $faqs
            );
        }
    }
    set_theme_mod('faq_categories',json_encode($categories));
}

/**
 * FAQ CTA Section admin page
 */
function lawfirm_pro_faqcta_section_page() {
    if(!current_user_can('manage_options')) return;
    if(isset($_POST['faqcta_nonce']) && wp_verify_nonce($_POST['faqcta_nonce'],'faqcta_save')) {
        lawfirm_pro_save_faqcta_section();
        echo '<div class="notice notice-success is-dismissible"><p>FAQ CTA Section saved successfully!</p></div>';
    }
    $title = get_theme_mod('faqcta_title','Still Have Questions?');
    $subtitle = get_theme_mod('faqcta_subtitle','Our legal team is here to help. Contact us for a free consultation.');
    $btn1_text = get_theme_mod('faqcta_btn1_text','Call Us Now');
    $btn1_url = get_theme_mod('faqcta_btn1_url','tel:+97714497707');
    $btn2_text = get_theme_mod('faqcta_btn2_text','Email Us');
    $btn2_url = get_theme_mod('faqcta_btn2_url','mailto:genilawasso@gmail.com');
    ?>
    <div class="wrap">
        <h1>FAQ CTA Section</h1>
        <p>Customize the call-to-action section at the bottom of the FAQ page.</p>
        <form method="post">
            <?php wp_nonce_field('faqcta_save','faqcta_nonce'); ?>
            <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;box-shadow:0 1px 1px rgba(0,0,0,.04);">
                <table class="form-table">
                    <tr>
                        <th><label for="faqcta_title">Title</label></th>
                        <td><input type="text" id="faqcta_title" name="faqcta_title" value="<?php echo esc_attr($title); ?>" class="large-text" /></td>
                    </tr>
                    <tr>
                        <th><label for="faqcta_subtitle">Subtitle</label></th>
                        <td><textarea id="faqcta_subtitle" name="faqcta_subtitle" rows="2" class="large-text"><?php echo esc_textarea($subtitle); ?></textarea></td>
                    </tr>
                </table>
                <hr style="margin:30px 0;border:0;border-top:1px solid #ddd;">
                <h2>Button 1</h2>
                <table class="form-table">
                    <tr>
                        <th><label for="faqcta_btn1_text">Button 1 Text</label></th>
                        <td><input type="text" id="faqcta_btn1_text" name="faqcta_btn1_text" value="<?php echo esc_attr($btn1_text); ?>" class="regular-text" /></td>
                    </tr>
                    <tr>
                        <th><label for="faqcta_btn1_url">Button 1 URL</label></th>
                        <td><input type="text" id="faqcta_btn1_url" name="faqcta_btn1_url" value="<?php echo esc_attr($btn1_url); ?>" class="large-text" />
                        <p class="description">Use tel:+1234567890 for phone or mailto:email@example.com for email</p></td>
                    </tr>
                </table>
                <hr style="margin:30px 0;border:0;border-top:1px solid #ddd;">
                <h2>Button 2</h2>
                <table class="form-table">
                    <tr>
                        <th><label for="faqcta_btn2_text">Button 2 Text</label></th>
                        <td><input type="text" id="faqcta_btn2_text" name="faqcta_btn2_text" value="<?php echo esc_attr($btn2_text); ?>" class="regular-text" /></td>
                    </tr>
                    <tr>
                        <th><label for="faqcta_btn2_url">Button 2 URL</label></th>
                        <td><input type="text" id="faqcta_btn2_url" name="faqcta_btn2_url" value="<?php echo esc_attr($btn2_url); ?>" class="large-text" />
                        <p class="description">Use tel:+1234567890 for phone or mailto:email@example.com for email</p></td>
                    </tr>
                </table>
            </div>
            <?php submit_button('Save FAQ CTA Section'); ?>
        </form>
    </div>
    <?php
}

/**
 * Save FAQ CTA Section
 */
function lawfirm_pro_save_faqcta_section() {
    if(isset($_POST['faqcta_title'])) set_theme_mod('faqcta_title',sanitize_text_field(wp_unslash($_POST['faqcta_title'])));
    if(isset($_POST['faqcta_subtitle'])) set_theme_mod('faqcta_subtitle',sanitize_textarea_field(wp_unslash($_POST['faqcta_subtitle'])));
    if(isset($_POST['faqcta_btn1_text'])) set_theme_mod('faqcta_btn1_text',sanitize_text_field(wp_unslash($_POST['faqcta_btn1_text'])));
    if(isset($_POST['faqcta_btn1_url'])) set_theme_mod('faqcta_btn1_url',esc_url_raw(wp_unslash($_POST['faqcta_btn1_url'])));
    if(isset($_POST['faqcta_btn2_text'])) set_theme_mod('faqcta_btn2_text',sanitize_text_field(wp_unslash($_POST['faqcta_btn2_text'])));
    if(isset($_POST['faqcta_btn2_url'])) set_theme_mod('faqcta_btn2_url',esc_url_raw(wp_unslash($_POST['faqcta_btn2_url'])));
}
