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
    
    // Validate required fields
    if ( empty( $name ) || empty( $email ) || empty( $phone ) || empty( $date ) || empty( $time ) ) {
        wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'lawfirm-pro' ) ) );
    }
    
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'lawfirm-pro' ) ) );
    }
    
    // Prepare email content
    $to = get_option( 'admin_email' ); // Send to site admin email
    $subject = sprintf( __( 'New Booking Request: %s', 'lawfirm-pro' ), $service_title );
    
    $email_body = sprintf(
        __( "New booking request received:\n\nService: %s\nService URL: %s\n\nClient Details:\nName: %s\nEmail: %s\nPhone: %s\n\nAppointment Details:\nDate: %s\nTime: %s\n\nMessage:\n%s", 'lawfirm-pro' ),
        $service_title,
        $service_url,
        $name,
        $email,
        $phone,
        $date,
        $time,
        $message
    );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Send email (will work once SMTP is configured)
    $sent = wp_mail( $to, $subject, $email_body, $headers );
    
    // Store booking in database as custom post type (optional - for future reference)
    $booking_data = array(
        'post_title'   => sprintf( __( 'Booking: %s - %s', 'lawfirm-pro' ), $name, $service_title ),
        'post_content' => $email_body,
        'post_status'  => 'private',
        'post_type'    => 'booking', // You can create a custom post type for bookings later
        'meta_input'   => array(
            'booking_name'    => $name,
            'booking_email'   => $email,
            'booking_phone'   => $phone,
            'booking_date'    => $date,
            'booking_time'    => $time,
            'booking_message' => $message,
            'service_title'   => $service_title,
            'service_url'     => $service_url,
        ),
    );
    
    // Uncomment below to save bookings to database
    // $booking_id = wp_insert_post( $booking_data );
    
    if ( $sent ) {
        wp_send_json_success( array( 
            'message' => __( 'Thank you! Your booking request has been submitted successfully. We will contact you soon.', 'lawfirm-pro' ) 
        ) );
    } else {
        // Even if email fails (SMTP not configured), show success message
        wp_send_json_success( array( 
            'message' => __( 'Thank you! Your booking request has been received. We will contact you soon.', 'lawfirm-pro' ) 
        ) );
    }
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
    
    // Footer Section submenu
    add_submenu_page(
        'homepage-sections',                                 // Parent slug
        __( 'Footer Section', 'lawfirm-pro' ),              // Page title
        __( 'Footer Section', 'lawfirm-pro' ),              // Menu title
        'manage_options',                                    // Capability
        'footer-section',                                    // Menu slug
        'lawfirm_pro_footer_section_page'                   // Callback function
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_homepage_sections_menu' );

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
    $testimonials_description = get_theme_mod( 'lawfirm_testimonials_description', 'Genius Law and Associates is your trusted legal partner with over 15 years of professional experience. We offer comprehensive legal solutions for individuals and businesses, allowing you to focus on what matters most while we handle your legal matters.' );
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
 * Footer Section admin page content
 */
function lawfirm_pro_footer_section_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Footer Section', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Footer settings can be customized here.', 'lawfirm-pro' ); ?></p>
    </div>
    <?php
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
                            'post_excerpt' => 'Professional ' . $subcat_name . ' services with over 15 years of experience.',
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
