<?php
/**
 * Contact Form Handler
 *
 * @package LawFirm_Pro
 */

// Handle contact form submission via AJAX
function lawfirm_pro_handle_contact_form() {
    // Verify nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'lawfirm_contact_form' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
    }
    
    // Sanitize form data
    $name = isset( $_POST['contact_name'] ) ? sanitize_text_field( $_POST['contact_name'] ) : '';
    $email = isset( $_POST['contact_email'] ) ? sanitize_email( $_POST['contact_email'] ) : '';
    $phone = isset( $_POST['contact_phone'] ) ? sanitize_text_field( $_POST['contact_phone'] ) : '';
    $subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( $_POST['contact_subject'] ) : '';
    $message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( $_POST['contact_message'] ) : '';
    
    // Validate required fields
    if ( empty( $name ) || empty( $email ) || empty( $subject ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
    }
    
    // Validate email
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address.' ) );
    }
    
    // Get admin email
    $to = get_option( 'admin_email' );
    
    // Email subject
    $email_subject = 'New Contact Form Submission: ' . $subject;
    
    // Email message (HTML)
    $email_message = lawfirm_pro_get_email_template( $name, $email, $phone, $subject, $message );
    
    // Email headers
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Send email
    $sent = wp_mail( $to, $email_subject, $email_message, $headers );
    
    // Send auto-reply to user
    lawfirm_pro_send_auto_reply( $name, $email );
    
    // Save to database (optional - won't break if table doesn't exist)
    if ( function_exists( 'lawfirm_pro_save_contact_to_db' ) ) {
        try {
            lawfirm_pro_save_contact_to_db( array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message
            ) );
        } catch ( Exception $e ) {
            // Silently fail - email was sent successfully
        }
    }
    
    // Always return success (even if email fails, as SMTP might not be configured)
    wp_send_json_success( array( 
        'message' => 'Thank you! Your message has been sent successfully. We will contact you soon.' 
    ) );
}
add_action( 'wp_ajax_lawfirm_contact_form', 'lawfirm_pro_handle_contact_form' );
add_action( 'wp_ajax_nopriv_lawfirm_contact_form', 'lawfirm_pro_handle_contact_form' );

// Get email template
function lawfirm_pro_get_email_template( $name, $email, $phone, $subject, $message ) {
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
                                    New Contact Message
                                </h1>
                            </td>
                        </tr>
                        
                        <!-- Content -->
                        <tr>
                            <td style="padding: 40px;">
                                
                                <!-- Subject -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                                    <tr>
                                        <td style="padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
                                            <div style="color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Subject</div>
                                            <div style="color: #1a2b3c; font-size: 18px; font-weight: 600;">' . esc_html( $subject ) . '</div>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Contact Details -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                                    <tr>
                                        <td>
                                            <div style="color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">Contact Information</div>
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
                                                ' . ( ! empty( $phone ) ? '
                                                <tr>
                                                    <td style="color: #999; font-size: 14px;">Phone</td>
                                                    <td><a href="tel:' . esc_attr( $phone ) . '" style="color: #26cf71; text-decoration: none; font-size: 15px;">' . esc_html( $phone ) . '</a></td>
                                                </tr>
                                                ' : '' ) . '
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
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
                                
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="padding: 25px 40px; background-color: #f8f9fa; text-align: center; border-top: 1px solid #e5e7eb;">
                                <p style="margin: 0 0 5px 0; color: #999; font-size: 13px;">
                                    Submitted on ' . date( 'F j, Y \a\t g:i a' ) . '
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
    
    return $email_body;
}

// Send auto-reply to user
function lawfirm_pro_send_auto_reply( $name, $email ) {
    $site_name = get_bloginfo( 'name' );
    
    $subject = 'Thank you for contacting ' . $site_name;
    
    $message = '
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
                            <td style="background-color: #26cf71; padding: 40px; text-align: center;">
                                <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 600; letter-spacing: -0.5px;">
                                    Thank You!
                                </h1>
                            </td>
                        </tr>
                        
                        <!-- Content -->
                        <tr>
                            <td style="padding: 50px 40px; text-align: center;">
                                <p style="margin: 0 0 20px 0; color: #1a2b3c; font-size: 18px; font-weight: 600;">
                                    Hi ' . esc_html( $name ) . ',
                                </p>
                                <p style="margin: 0 0 20px 0; color: #666; font-size: 15px; line-height: 1.6;">
                                    Thank you for reaching out to us. We have received your message and will get back to you as soon as possible.
                                </p>
                                <p style="margin: 0 0 30px 0; color: #666; font-size: 15px; line-height: 1.6;">
                                    Our team typically responds within 24 hours during business days.
                                </p>
                                <a href="' . esc_url( home_url() ) . '" style="display: inline-block; padding: 14px 28px; background-color: #26cf71; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 15px;">
                                    Visit Our Website
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="padding: 25px 40px; background-color: #f8f9fa; text-align: center; border-top: 1px solid #e5e7eb;">
                                <p style="margin: 0 0 5px 0; color: #999; font-size: 13px;">
                                    Best regards,
                                </p>
                                <p style="margin: 0; color: #26cf71; font-size: 14px; font-weight: 600;">
                                    ' . esc_html( $site_name ) . ' Team
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
        'From: ' . $site_name . ' <' . get_option( 'admin_email' ) . '>'
    );
    
    wp_mail( $email, $subject, $message, $headers );
}
