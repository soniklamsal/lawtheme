<?php
/**
 * Gmail SMTP Settings for WordPress
 * 
 * This file provides a complete SMTP configuration system for WordPress
 * allowing all emails to be sent through Gmail SMTP without any plugin.
 * 
 * HOW TO GET GMAIL APP PASSWORD:
 * 1. Go to your Google Account (myaccount.google.com)
 * 2. Select Security
 * 3. Under "Signing in to Google," select 2-Step Verification (you must enable this first)
 * 4. At the bottom, select App passwords
 * 5. Select "Mail" and your device
 * 6. Generate and copy the 16-character password
 * 7. Use this password in the SMTP settings below
 * 
 * @package LawFirm_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add SMTP Settings page to WordPress admin
 */
function lawfirm_smtp_add_admin_menu() {
    add_options_page(
        __( 'SMTP Settings', 'lawfirm-pro' ),
        __( 'SMTP Settings', 'lawfirm-pro' ),
        'manage_options',
        'smtp-settings',
        'lawfirm_smtp_settings_page'
    );
}
add_action( 'admin_menu', 'lawfirm_smtp_add_admin_menu' );

/**
 * Register SMTP settings
 */
function lawfirm_smtp_register_settings() {
    register_setting( 'lawfirm_smtp_settings', 'lawfirm_smtp_host' );
    register_setting( 'lawfirm_smtp_settings', 'lawfirm_smtp_port' );
    register_setting( 'lawfirm_smtp_settings', 'lawfirm_smtp_encryption' );
    register_setting( 'lawfirm_smtp_settings', 'lawfirm_smtp_username' );
    register_setting( 'lawfirm_smtp_settings', 'lawfirm_smtp_password' );
    register_setting( 'lawfirm_smtp_settings', 'lawfirm_smtp_from_email' );
    register_setting( 'lawfirm_smtp_settings', 'lawfirm_smtp_from_name' );
}
add_action( 'admin_init', 'lawfirm_smtp_register_settings' );

/**
 * SMTP Settings Page HTML
 */
function lawfirm_smtp_settings_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Get current settings
    $smtp_host = get_option( 'lawfirm_smtp_host', 'smtp.gmail.com' );
    $smtp_port = get_option( 'lawfirm_smtp_port', '587' );
    $smtp_encryption = get_option( 'lawfirm_smtp_encryption', 'tls' );
    $smtp_username = get_option( 'lawfirm_smtp_username', '' );
    $smtp_password = get_option( 'lawfirm_smtp_password', '' );
    $smtp_from_email = get_option( 'lawfirm_smtp_from_email', '' );
    $smtp_from_name = get_option( 'lawfirm_smtp_from_name', get_bloginfo( 'name' ) );
    
    // Handle test email
    $test_message = '';
    if ( isset( $_POST['send_test_email'] ) && check_admin_referer( 'smtp_test_email', 'smtp_test_nonce' ) ) {
        $test_email = sanitize_email( $_POST['test_email'] );
        if ( is_email( $test_email ) ) {
            $result = lawfirm_smtp_send_test_email( $test_email );
            if ( $result ) {
                $test_message = '<div class="notice notice-success"><p>' . __( 'Test email sent successfully! Check your inbox.', 'lawfirm-pro' ) . '</p></div>';
            } else {
                $test_message = '<div class="notice notice-error"><p>' . __( 'Failed to send test email. Please check your SMTP settings.', 'lawfirm-pro' ) . '</p></div>';
            }
        } else {
            $test_message = '<div class="notice notice-error"><p>' . __( 'Please enter a valid email address.', 'lawfirm-pro' ) . '</p></div>';
        }
    }
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <?php echo $test_message; ?>
        
        <?php settings_errors(); ?>
        
        <!-- Instructions -->
        <div class="notice notice-info" style="margin: 20px 0; padding: 15px;">
            <h3 style="margin-top: 0;"><?php _e( 'How to Get Gmail App Password:', 'lawfirm-pro' ); ?></h3>
            <ol style="margin-left: 20px;">
                <li><?php _e( 'Go to your Google Account (myaccount.google.com)', 'lawfirm-pro' ); ?></li>
                <li><?php _e( 'Select Security', 'lawfirm-pro' ); ?></li>
                <li><?php _e( 'Under "Signing in to Google," enable 2-Step Verification (required)', 'lawfirm-pro' ); ?></li>
                <li><?php _e( 'At the bottom, select App passwords', 'lawfirm-pro' ); ?></li>
                <li><?php _e( 'Select "Mail" and your device', 'lawfirm-pro' ); ?></li>
                <li><?php _e( 'Generate and copy the 16-character password', 'lawfirm-pro' ); ?></li>
                <li><?php _e( 'Use this password in the "Password" field below', 'lawfirm-pro' ); ?></li>
            </ol>
            <p><strong><?php _e( 'Note:', 'lawfirm-pro' ); ?></strong> <?php _e( 'Never use your regular Gmail password. Always use an App Password.', 'lawfirm-pro' ); ?></p>
        </div>
        
        <!-- SMTP Settings Form -->
        <form method="post" action="options.php">
            <?php settings_fields( 'lawfirm_smtp_settings' ); ?>
            
            <table class="form-table" role="presentation">
                <tbody>
                    <!-- SMTP Host -->
                    <tr>
                        <th scope="row">
                            <label for="lawfirm_smtp_host"><?php _e( 'SMTP Host', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" 
                                   id="lawfirm_smtp_host" 
                                   name="lawfirm_smtp_host" 
                                   value="<?php echo esc_attr( $smtp_host ); ?>" 
                                   class="regular-text" 
                                   placeholder="smtp.gmail.com" />
                            <p class="description"><?php _e( 'Gmail SMTP server address (default: smtp.gmail.com)', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <!-- SMTP Port -->
                    <tr>
                        <th scope="row">
                            <label for="lawfirm_smtp_port"><?php _e( 'SMTP Port', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="number" 
                                   id="lawfirm_smtp_port" 
                                   name="lawfirm_smtp_port" 
                                   value="<?php echo esc_attr( $smtp_port ); ?>" 
                                   class="small-text" 
                                   placeholder="587" />
                            <p class="description"><?php _e( 'SMTP port (587 for TLS, 465 for SSL)', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <!-- Encryption -->
                    <tr>
                        <th scope="row">
                            <label for="lawfirm_smtp_encryption"><?php _e( 'Encryption', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <select id="lawfirm_smtp_encryption" name="lawfirm_smtp_encryption">
                                <option value="tls" <?php selected( $smtp_encryption, 'tls' ); ?>>TLS</option>
                                <option value="ssl" <?php selected( $smtp_encryption, 'ssl' ); ?>>SSL</option>
                            </select>
                            <p class="description"><?php _e( 'Encryption type (TLS recommended for Gmail)', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <!-- Username -->
                    <tr>
                        <th scope="row">
                            <label for="lawfirm_smtp_username"><?php _e( 'Username (Gmail Address)', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="email" 
                                   id="lawfirm_smtp_username" 
                                   name="lawfirm_smtp_username" 
                                   value="<?php echo esc_attr( $smtp_username ); ?>" 
                                   class="regular-text" 
                                   placeholder="your-email@gmail.com" />
                            <p class="description"><?php _e( 'Your full Gmail address', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <!-- Password -->
                    <tr>
                        <th scope="row">
                            <label for="lawfirm_smtp_password"><?php _e( 'Password (App Password)', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <div style="position: relative; display: inline-block; width: 100%; max-width: 400px;">
                                <input type="password" 
                                       id="lawfirm_smtp_password" 
                                       name="lawfirm_smtp_password" 
                                       value="<?php echo esc_attr( $smtp_password ); ?>" 
                                       class="regular-text" 
                                       style="padding-right: 45px; width: 100%;"
                                       placeholder="16-character app password" />
                                <button type="button" 
                                        id="toggle_password" 
                                        style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 5px 10px; color: #2271b1;"
                                        title="<?php esc_attr_e( 'Show/Hide Password', 'lawfirm-pro' ); ?>">
                                    <span class="dashicons dashicons-visibility" id="password_icon"></span>
                                </button>
                            </div>
                            <p class="description">
                                <strong style="color: #d63638;"><?php _e( 'Important:', 'lawfirm-pro' ); ?></strong> 
                                <?php _e( 'Use Gmail App Password, NOT your regular Gmail password', 'lawfirm-pro' ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- From Email -->
                    <tr>
                        <th scope="row">
                            <label for="lawfirm_smtp_from_email"><?php _e( 'From Email', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="email" 
                                   id="lawfirm_smtp_from_email" 
                                   name="lawfirm_smtp_from_email" 
                                   value="<?php echo esc_attr( $smtp_from_email ); ?>" 
                                   class="regular-text" 
                                   placeholder="noreply@yourdomain.com" />
                            <p class="description"><?php _e( 'Email address that appears in the "From" field (usually same as username)', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                    
                    <!-- From Name -->
                    <tr>
                        <th scope="row">
                            <label for="lawfirm_smtp_from_name"><?php _e( 'From Name', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="text" 
                                   id="lawfirm_smtp_from_name" 
                                   name="lawfirm_smtp_from_name" 
                                   value="<?php echo esc_attr( $smtp_from_name ); ?>" 
                                   class="regular-text" 
                                   placeholder="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
                            <p class="description"><?php _e( 'Name that appears in the "From" field', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <?php submit_button( __( 'Save SMTP Settings', 'lawfirm-pro' ) ); ?>
        </form>
        
        <!-- Test Email Section -->
        <hr style="margin: 40px 0;">
        
        <h2><?php _e( 'Send Test Email', 'lawfirm-pro' ); ?></h2>
        <p><?php _e( 'Send a test email to verify your SMTP settings are working correctly.', 'lawfirm-pro' ); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'smtp_test_email', 'smtp_test_nonce' ); ?>
            
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="test_email"><?php _e( 'Send Test Email To', 'lawfirm-pro' ); ?></label>
                        </th>
                        <td>
                            <input type="email" 
                                   id="test_email" 
                                   name="test_email" 
                                   value="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>" 
                                   class="regular-text" 
                                   required />
                            <p class="description"><?php _e( 'Enter the email address where you want to receive the test email', 'lawfirm-pro' ); ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <p class="submit">
                <button type="submit" name="send_test_email" class="button button-secondary">
                    <?php _e( 'Send Test Email', 'lawfirm-pro' ); ?>
                </button>
            </p>
        </form>
        
        <!-- Status Information -->
        <div style="background: #f0f0f1; padding: 15px; border-left: 4px solid #2271b1; margin-top: 20px;">
            <h3 style="margin-top: 0;"><?php _e( 'Current Configuration Status', 'lawfirm-pro' ); ?></h3>
            <ul style="margin-left: 20px;">
                <li><strong><?php _e( 'SMTP Host:', 'lawfirm-pro' ); ?></strong> <?php echo esc_html( $smtp_host ? $smtp_host : __( 'Not configured', 'lawfirm-pro' ) ); ?></li>
                <li><strong><?php _e( 'SMTP Port:', 'lawfirm-pro' ); ?></strong> <?php echo esc_html( $smtp_port ? $smtp_port : __( 'Not configured', 'lawfirm-pro' ) ); ?></li>
                <li><strong><?php _e( 'Encryption:', 'lawfirm-pro' ); ?></strong> <?php echo esc_html( strtoupper( $smtp_encryption ) ); ?></li>
                <li><strong><?php _e( 'Username:', 'lawfirm-pro' ); ?></strong> <?php echo esc_html( $smtp_username ? $smtp_username : __( 'Not configured', 'lawfirm-pro' ) ); ?></li>
                <li><strong><?php _e( 'Password:', 'lawfirm-pro' ); ?></strong> <?php echo $smtp_password ? __( 'Configured (hidden)', 'lawfirm-pro' ) : '<span style="color: #d63638;">' . __( 'Not configured', 'lawfirm-pro' ) . '</span>'; ?></li>
                <li><strong><?php _e( 'From Email:', 'lawfirm-pro' ); ?></strong> <?php echo esc_html( $smtp_from_email ? $smtp_from_email : __( 'Not configured', 'lawfirm-pro' ) ); ?></li>
                <li><strong><?php _e( 'From Name:', 'lawfirm-pro' ); ?></strong> <?php echo esc_html( $smtp_from_name ? $smtp_from_name : __( 'Not configured', 'lawfirm-pro' ) ); ?></li>
            </ul>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Toggle password visibility
        $('#toggle_password').on('click', function() {
            var passwordField = $('#lawfirm_smtp_password');
            var passwordIcon = $('#password_icon');
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                passwordIcon.removeClass('dashicons-visibility').addClass('dashicons-hidden');
            } else {
                passwordField.attr('type', 'password');
                passwordIcon.removeClass('dashicons-hidden').addClass('dashicons-visibility');
            }
        });
    });
    </script>
    <?php
}

/**
 * Configure PHPMailer to use SMTP with Gmail
 */
function lawfirm_smtp_configure_phpmailer( $phpmailer ) {
    // Get SMTP settings
    $smtp_host = get_option( 'lawfirm_smtp_host', 'smtp.gmail.com' );
    $smtp_port = get_option( 'lawfirm_smtp_port', '587' );
    $smtp_encryption = get_option( 'lawfirm_smtp_encryption', 'tls' );
    $smtp_username = get_option( 'lawfirm_smtp_username', '' );
    $smtp_password = get_option( 'lawfirm_smtp_password', '' );
    
    // Only configure if we have credentials
    if ( empty( $smtp_username ) || empty( $smtp_password ) ) {
        return;
    }
    
    // Configure PHPMailer
    $phpmailer->isSMTP();
    $phpmailer->Host = $smtp_host;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = $smtp_port;
    $phpmailer->Username = $smtp_username;
    $phpmailer->Password = $smtp_password;
    $phpmailer->SMTPSecure = $smtp_encryption;
    $phpmailer->From = get_option( 'lawfirm_smtp_from_email', $smtp_username );
    $phpmailer->FromName = get_option( 'lawfirm_smtp_from_name', get_bloginfo( 'name' ) );
    
    // Additional settings for better compatibility
    $phpmailer->SMTPAutoTLS = true;
    $phpmailer->Timeout = 30;
    
    // Enable debug output in development (comment out in production)
    // $phpmailer->SMTPDebug = 2;
    // $phpmailer->Debugoutput = 'html';
}
add_action( 'phpmailer_init', 'lawfirm_smtp_configure_phpmailer' );

/**
 * Set From Email and From Name for all WordPress emails
 */
function lawfirm_smtp_from_email( $original_email_address ) {
    $from_email = get_option( 'lawfirm_smtp_from_email', '' );
    return $from_email ? $from_email : $original_email_address;
}
add_filter( 'wp_mail_from', 'lawfirm_smtp_from_email' );

function lawfirm_smtp_from_name( $original_email_from ) {
    $from_name = get_option( 'lawfirm_smtp_from_name', '' );
    return $from_name ? $from_name : $original_email_from;
}
add_filter( 'wp_mail_from_name', 'lawfirm_smtp_from_name' );

/**
 * Send test email
 */
function lawfirm_smtp_send_test_email( $to_email ) {
    $subject = __( 'SMTP Test Email from ', 'lawfirm-pro' ) . get_bloginfo( 'name' );
    
    $message = '<html><body>';
    $message .= '<h2>' . __( 'SMTP Configuration Test', 'lawfirm-pro' ) . '</h2>';
    $message .= '<p>' . __( 'Congratulations! Your SMTP settings are working correctly.', 'lawfirm-pro' ) . '</p>';
    $message .= '<p><strong>' . __( 'Test Details:', 'lawfirm-pro' ) . '</strong></p>';
    $message .= '<ul>';
    $message .= '<li><strong>' . __( 'Sent from:', 'lawfirm-pro' ) . '</strong> ' . get_bloginfo( 'name' ) . '</li>';
    $message .= '<li><strong>' . __( 'Website:', 'lawfirm-pro' ) . '</strong> ' . get_bloginfo( 'url' ) . '</li>';
    $message .= '<li><strong>' . __( 'Date/Time:', 'lawfirm-pro' ) . '</strong> ' . current_time( 'mysql' ) . '</li>';
    $message .= '<li><strong>' . __( 'SMTP Host:', 'lawfirm-pro' ) . '</strong> ' . get_option( 'lawfirm_smtp_host', 'Not configured' ) . '</li>';
    $message .= '<li><strong>' . __( 'SMTP Port:', 'lawfirm-pro' ) . '</strong> ' . get_option( 'lawfirm_smtp_port', 'Not configured' ) . '</li>';
    $message .= '</ul>';
    $message .= '<p>' . __( 'If you received this email, your WordPress site is successfully configured to send emails via Gmail SMTP.', 'lawfirm-pro' ) . '</p>';
    $message .= '</body></html>';
    
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );
    
    return wp_mail( $to_email, $subject, $message, $headers );
}

/**
 * Add settings link to plugins page (if used as plugin)
 */
function lawfirm_smtp_add_settings_link( $links ) {
    $settings_link = '<a href="' . admin_url( 'options-general.php?page=smtp-settings' ) . '">' . __( 'Settings', 'lawfirm-pro' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
// Uncomment the line below if you convert this to a standalone plugin
// add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'lawfirm_smtp_add_settings_link' );
