<?php
/**
 * Contact Information Settings
 *
 * @package LawFirm_Pro
 */

/**
 * Add Contact Info menu page
 */
function lawfirm_pro_add_contact_info_menu() {
    add_menu_page(
        __( 'Contact Info', 'lawfirm-pro' ),
        __( 'Contact Info', 'lawfirm-pro' ),
        'manage_options',
        'contact-info-settings',
        'lawfirm_pro_contact_info_page',
        'dashicons-phone',
        35
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_contact_info_menu' );

/**
 * Contact Info admin page
 */
function lawfirm_pro_contact_info_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Handle form submission
    if ( isset( $_POST['lawfirm_contact_info_nonce'] ) && wp_verify_nonce( $_POST['lawfirm_contact_info_nonce'], 'lawfirm_contact_info_save' ) ) {
        lawfirm_pro_save_contact_info();
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Contact Information saved successfully!', 'lawfirm-pro' ) . '</p></div>';
    }

    // Get current values
    $phone_1 = get_option( 'lawfirm_contact_phone_1', '+977-1-4497707' );
    $phone_2 = get_option( 'lawfirm_contact_phone_2', '+977-1-4472741' );
    $mobile_1 = get_option( 'lawfirm_contact_mobile_1', '+977-9851063500' );
    $mobile_2 = get_option( 'lawfirm_contact_mobile_2', '+977-9741141964' );
    $email_1 = get_option( 'lawfirm_contact_email_1', 'genilawasso@gmail.com' );
    $email_2 = get_option( 'lawfirm_contact_email_2', 'gyanrshakya@gmail.com' );
    $location = get_option( 'lawfirm_contact_location', 'Kali Marg, Naya Baneshwar, Baneshwar, Kathmandu-31, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44703, Nepal' );
    
    // Social Media
    $facebook = get_option( 'lawfirm_contact_facebook', 'https://facebook.com' );
    $twitter = get_option( 'lawfirm_contact_twitter', 'https://twitter.com' );
    $linkedin = get_option( 'lawfirm_contact_linkedin', 'https://linkedin.com' );
    
    // Section Settings
    $section_title = get_option( 'lawfirm_contact_section_title', 'Contact Information' );
    $section_description = get_option( 'lawfirm_contact_section_description', 'Have questions about our legal services? Contact us and our team will guide you through your legal matters.' );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'Contact Information Settings', 'lawfirm-pro' ); ?></h1>
        <p><?php esc_html_e( 'Manage all contact information displayed on your website.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'lawfirm_contact_info_save', 'lawfirm_contact_info_nonce' ); ?>
            
            <!-- Section Content -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Section Content', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="section_title"><?php esc_html_e( 'Section Title', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="section_title" name="section_title" value="<?php echo esc_attr( $section_title ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" />
                            <p class="description"><?php esc_html_e( 'Title displayed at the top of contact section', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="section_description"><?php esc_html_e( 'Section Description', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="section_description" name="section_description" rows="3" class="large-text" style="width: 100%; max-width: 600px;"><?php echo esc_textarea( $section_description ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Brief description below the title', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Phone Numbers -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Phone Numbers', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="phone_1"><?php esc_html_e( 'Phone 1', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="phone_1" name="phone_1" value="<?php echo esc_attr( $phone_1 ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Primary office phone number', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="phone_2"><?php esc_html_e( 'Phone 2', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="phone_2" name="phone_2" value="<?php echo esc_attr( $phone_2 ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Secondary office phone number', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Mobile Numbers -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Mobile Numbers', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="mobile_1"><?php esc_html_e( 'Mobile 1', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="mobile_1" name="mobile_1" value="<?php echo esc_attr( $mobile_1 ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Primary mobile number', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="mobile_2"><?php esc_html_e( 'Mobile 2', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="mobile_2" name="mobile_2" value="<?php echo esc_attr( $mobile_2 ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Secondary mobile number', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Email Addresses -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Email Addresses', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="email_1"><?php esc_html_e( 'Email 1', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="email" id="email_1" name="email_1" value="<?php echo esc_attr( $email_1 ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Primary email address', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="email_2"><?php esc_html_e( 'Email 2', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="email" id="email_2" name="email_2" value="<?php echo esc_attr( $email_2 ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Secondary email address', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Location -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Office Location', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="location"><?php esc_html_e( 'Full Address', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <textarea id="location" name="location" rows="3" class="large-text" style="width: 100%; max-width: 600px;"><?php echo esc_textarea( $location ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Complete office address', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Social Media -->
            <div style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <h2 style="margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
                    <?php esc_html_e( 'Social Media Links', 'lawfirm-pro' ); ?>
                </h2>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="facebook"><?php esc_html_e( 'Facebook URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="facebook" name="facebook" value="<?php echo esc_attr( $facebook ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" placeholder="https://facebook.com/yourpage" />
                            <p class="description"><?php esc_html_e( 'Your Facebook page URL', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="twitter"><?php esc_html_e( 'Twitter/X URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="twitter" name="twitter" value="<?php echo esc_attr( $twitter ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" placeholder="https://twitter.com/yourhandle" />
                            <p class="description"><?php esc_html_e( 'Your Twitter/X profile URL', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="linkedin"><?php esc_html_e( 'LinkedIn URL', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="url" id="linkedin" name="linkedin" value="<?php echo esc_attr( $linkedin ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" placeholder="https://linkedin.com/company/yourcompany" />
                            <p class="description"><?php esc_html_e( 'Your LinkedIn company page URL', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button( __( 'Save Contact Information', 'lawfirm-pro' ) ); ?>
        </form>
    </div>
    <?php
}

/**
 * Save Contact Info settings
 */
function lawfirm_pro_save_contact_info() {
    // Section Content
    if ( isset( $_POST['section_title'] ) ) {
        update_option( 'lawfirm_contact_section_title', sanitize_text_field( $_POST['section_title'] ) );
    }
    if ( isset( $_POST['section_description'] ) ) {
        update_option( 'lawfirm_contact_section_description', sanitize_textarea_field( $_POST['section_description'] ) );
    }
    
    // Phone Numbers
    if ( isset( $_POST['phone_1'] ) ) {
        update_option( 'lawfirm_contact_phone_1', sanitize_text_field( $_POST['phone_1'] ) );
    }
    if ( isset( $_POST['phone_2'] ) ) {
        update_option( 'lawfirm_contact_phone_2', sanitize_text_field( $_POST['phone_2'] ) );
    }
    
    // Mobile Numbers
    if ( isset( $_POST['mobile_1'] ) ) {
        update_option( 'lawfirm_contact_mobile_1', sanitize_text_field( $_POST['mobile_1'] ) );
    }
    if ( isset( $_POST['mobile_2'] ) ) {
        update_option( 'lawfirm_contact_mobile_2', sanitize_text_field( $_POST['mobile_2'] ) );
    }
    
    // Email Addresses
    if ( isset( $_POST['email_1'] ) ) {
        update_option( 'lawfirm_contact_email_1', sanitize_email( $_POST['email_1'] ) );
    }
    if ( isset( $_POST['email_2'] ) ) {
        update_option( 'lawfirm_contact_email_2', sanitize_email( $_POST['email_2'] ) );
    }
    
    // Location
    if ( isset( $_POST['location'] ) ) {
        update_option( 'lawfirm_contact_location', sanitize_textarea_field( $_POST['location'] ) );
    }
    
    // Social Media
    if ( isset( $_POST['facebook'] ) ) {
        update_option( 'lawfirm_contact_facebook', esc_url_raw( $_POST['facebook'] ) );
    }
    if ( isset( $_POST['twitter'] ) ) {
        update_option( 'lawfirm_contact_twitter', esc_url_raw( $_POST['twitter'] ) );
    }
    if ( isset( $_POST['linkedin'] ) ) {
        update_option( 'lawfirm_contact_linkedin', esc_url_raw( $_POST['linkedin'] ) );
    }
}
