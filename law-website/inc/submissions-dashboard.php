<?php
/**
 * Submissions Dashboard - View all bookings and contact forms
 *
 * @package LawFirm_Pro
 */

// Save booking to database
function lawfirm_pro_save_booking_to_db( $data ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'lawfirm_submissions';
    
    $wpdb->insert(
        $table_name,
        array(
            'type' => 'booking',
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => isset( $data['message'] ) ? $data['message'] : '',
            'service_title' => isset( $data['service_title'] ) ? $data['service_title'] : '',
            'package_type' => isset( $data['package_type'] ) ? $data['package_type'] : '',
            'booking_date' => isset( $data['booking_date'] ) ? $data['booking_date'] : '',
            'booking_time' => isset( $data['booking_time'] ) ? $data['booking_time'] : '',
            'status' => 'new'
        )
    );
}

// Save contact form to database
function lawfirm_pro_save_contact_to_db( $data ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'lawfirm_submissions';
    
    $wpdb->insert(
        $table_name,
        array(
            'type' => 'contact',
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => isset( $data['phone'] ) ? $data['phone'] : '',
            'subject' => isset( $data['subject'] ) ? $data['subject'] : '',
            'message' => isset( $data['message'] ) ? $data['message'] : '',
            'status' => 'new'
        )
    );
}

// Add admin menu
function lawfirm_pro_add_submissions_menu() {
    add_menu_page(
        'Submissions',
        'Submissions',
        'manage_options',
        'lawfirm-submissions',
        'lawfirm_pro_submissions_page',
        'dashicons-email-alt',
        25
    );
}
add_action( 'admin_menu', 'lawfirm_pro_add_submissions_menu' );

// Submissions dashboard page
function lawfirm_pro_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'lawfirm_submissions';
    
    // Handle status update
    if ( isset( $_POST['update_status'] ) && isset( $_POST['submission_id'] ) && isset( $_POST['new_status'] ) ) {
        check_admin_referer( 'update_submission_status' );
        $wpdb->update(
            $table_name,
            array( 'status' => sanitize_text_field( $_POST['new_status'] ) ),
            array( 'id' => intval( $_POST['submission_id'] ) )
        );
    }
    
    // Handle delete
    if ( isset( $_POST['delete_submission'] ) && isset( $_POST['submission_id'] ) ) {
        check_admin_referer( 'delete_submission' );
        $wpdb->delete( $table_name, array( 'id' => intval( $_POST['submission_id'] ) ) );
    }
    
    // Get filter
    $filter = isset( $_GET['filter'] ) ? sanitize_text_field( $_GET['filter'] ) : 'all';
    $status_filter = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : 'all';
    
    // Build query
    $where = array();
    if ( $filter !== 'all' ) {
        $where[] = $wpdb->prepare( "type = %s", $filter );
    }
    if ( $status_filter !== 'all' ) {
        $where[] = $wpdb->prepare( "status = %s", $status_filter );
    }
    
    $where_clause = ! empty( $where ) ? 'WHERE ' . implode( ' AND ', $where ) : '';
    
    // Get submissions
    $submissions = $wpdb->get_results( "SELECT * FROM $table_name $where_clause ORDER BY created_at DESC" );
    
    // Get counts
    $total_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
    $booking_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE type = 'booking'" );
    $contact_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE type = 'contact'" );
    $new_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'new'" );
    ?>
    
    <div class="wrap" style="margin: 20px;">
        <h1 style="margin-bottom: 30px; font-size: 28px; font-weight: 600;">📬 Submissions Dashboard</h1>
        
        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; border-radius: 12px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Total Submissions</div>
                <div style="font-size: 32px; font-weight: bold;"><?php echo $total_count; ?></div>
            </div>
            <div style="background: linear-gradient(135deg, #26cf71 0%, #1eb863 100%); padding: 20px; border-radius: 12px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Bookings</div>
                <div style="font-size: 32px; font-weight: bold;"><?php echo $booking_count; ?></div>
            </div>
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; border-radius: 12px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Contact Forms</div>
                <div style="font-size: 32px; font-weight: bold;"><?php echo $contact_count; ?></div>
            </div>
            <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 20px; border-radius: 12px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">New / Unread</div>
                <div style="font-size: 32px; font-weight: bold;"><?php echo $new_count; ?></div>
            </div>
        </div>
        
        <!-- Filters -->
        <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                <span style="font-weight: 600; color: #333;">Filter:</span>
                <a href="?page=lawfirm-submissions&filter=all&status=<?php echo $status_filter; ?>" 
                   style="padding: 8px 16px; border-radius: 6px; text-decoration: none; <?php echo $filter === 'all' ? 'background: #26cf71; color: white;' : 'background: #f3f4f6; color: #666;'; ?>">
                    All
                </a>
                <a href="?page=lawfirm-submissions&filter=booking&status=<?php echo $status_filter; ?>" 
                   style="padding: 8px 16px; border-radius: 6px; text-decoration: none; <?php echo $filter === 'booking' ? 'background: #26cf71; color: white;' : 'background: #f3f4f6; color: #666;'; ?>">
                    Bookings
                </a>
                <a href="?page=lawfirm-submissions&filter=contact&status=<?php echo $status_filter; ?>" 
                   style="padding: 8px 16px; border-radius: 6px; text-decoration: none; <?php echo $filter === 'contact' ? 'background: #26cf71; color: white;' : 'background: #f3f4f6; color: #666;'; ?>">
                    Contact Forms
                </a>
                
                <span style="margin-left: 20px; font-weight: 600; color: #333;">Status:</span>
                <a href="?page=lawfirm-submissions&filter=<?php echo $filter; ?>&status=all" 
                   style="padding: 8px 16px; border-radius: 6px; text-decoration: none; <?php echo $status_filter === 'all' ? 'background: #667eea; color: white;' : 'background: #f3f4f6; color: #666;'; ?>">
                    All
                </a>
                <a href="?page=lawfirm-submissions&filter=<?php echo $filter; ?>&status=new" 
                   style="padding: 8px 16px; border-radius: 6px; text-decoration: none; <?php echo $status_filter === 'new' ? 'background: #667eea; color: white;' : 'background: #f3f4f6; color: #666;'; ?>">
                    New
                </a>
                <a href="?page=lawfirm-submissions&filter=<?php echo $filter; ?>&status=contacted" 
                   style="padding: 8px 16px; border-radius: 6px; text-decoration: none; <?php echo $status_filter === 'contacted' ? 'background: #667eea; color: white;' : 'background: #f3f4f6; color: #666;'; ?>">
                    Contacted
                </a>
                <a href="?page=lawfirm-submissions&filter=<?php echo $filter; ?>&status=completed" 
                   style="padding: 8px 16px; border-radius: 6px; text-decoration: none; <?php echo $status_filter === 'completed' ? 'background: #667eea; color: white;' : 'background: #f3f4f6; color: #666;'; ?>">
                    Completed
                </a>
            </div>
        </div>
        
        <!-- Submissions List -->
        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow: hidden;">
            <?php if ( empty( $submissions ) ) : ?>
                <div style="padding: 60px 20px; text-align: center; color: #999;">
                    <div style="font-size: 48px; margin-bottom: 10px;">📭</div>
                    <div style="font-size: 18px;">No submissions found</div>
                </div>
            <?php else : ?>
                <?php foreach ( $submissions as $submission ) : ?>
                    <div style="border-bottom: 1px solid #f0f0f0; padding: 20px; transition: background 0.2s;" 
                         onmouseover="this.style.background='#f9fafb'" 
                         onmouseout="this.style.background='white'">
                        
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; <?php echo $submission->type === 'booking' ? 'background: #dbeafe; color: #1e40af;' : 'background: #fce7f3; color: #be185d;'; ?>">
                                        <?php echo $submission->type === 'booking' ? '📅 Booking' : '✉️ Contact'; ?>
                                    </span>
                                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; 
                                        <?php 
                                        if ( $submission->status === 'new' ) echo 'background: #fef3c7; color: #92400e;';
                                        elseif ( $submission->status === 'contacted' ) echo 'background: #dbeafe; color: #1e40af;';
                                        else echo 'background: #d1fae5; color: #065f46;';
                                        ?>">
                                        <?php echo $submission->status; ?>
                                    </span>
                                    <span style="color: #999; font-size: 13px;">
                                        <?php echo date( 'M j, Y \a\t g:i A', strtotime( $submission->created_at ) ); ?>
                                    </span>
                                </div>
                                
                                <h3 style="margin: 0 0 10px 0; font-size: 18px; font-weight: 600; color: #1a2b3c;">
                                    <?php echo esc_html( $submission->name ); ?>
                                </h3>
                                
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; margin-bottom: 10px;">
                                    <div style="display: flex; align-items: center; gap: 8px; color: #666; font-size: 14px;">
                                        <span>📧</span>
                                        <a href="mailto:<?php echo esc_attr( $submission->email ); ?>" style="color: #26cf71; text-decoration: none;">
                                            <?php echo esc_html( $submission->email ); ?>
                                        </a>
                                    </div>
                                    <?php if ( ! empty( $submission->phone ) ) : ?>
                                        <div style="display: flex; align-items: center; gap: 8px; color: #666; font-size: 14px;">
                                            <span>📱</span>
                                            <a href="tel:<?php echo esc_attr( $submission->phone ); ?>" style="color: #26cf71; text-decoration: none;">
                                                <?php echo esc_html( $submission->phone ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ( $submission->type === 'booking' ) : ?>
                                    <div style="background: #f9fafb; padding: 12px; border-radius: 8px; margin-top: 10px;">
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; font-size: 13px;">
                                            <?php if ( ! empty( $submission->service_title ) ) : ?>
                                                <div>
                                                    <span style="color: #999; display: block; margin-bottom: 2px;">Service:</span>
                                                    <span style="color: #333; font-weight: 600;"><?php echo esc_html( $submission->service_title ); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $submission->package_type ) ) : ?>
                                                <div>
                                                    <span style="color: #999; display: block; margin-bottom: 2px;">Package:</span>
                                                    <span style="color: #26cf71; font-weight: 600;"><?php echo esc_html( $submission->package_type ); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $submission->booking_date ) ) : ?>
                                                <div>
                                                    <span style="color: #999; display: block; margin-bottom: 2px;">Date:</span>
                                                    <span style="color: #333; font-weight: 600;"><?php echo esc_html( date( 'M j, Y', strtotime( $submission->booking_date ) ) ); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $submission->booking_time ) ) : ?>
                                                <div>
                                                    <span style="color: #999; display: block; margin-bottom: 2px;">Time:</span>
                                                    <span style="color: #333; font-weight: 600;"><?php echo esc_html( $submission->booking_time ); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php if ( ! empty( $submission->subject ) ) : ?>
                                        <div style="color: #666; font-size: 14px; margin-top: 5px;">
                                            <strong>Subject:</strong> <?php echo esc_html( $submission->subject ); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php if ( ! empty( $submission->message ) ) : ?>
                                    <div style="margin-top: 12px; padding: 12px; background: #f9fafb; border-left: 3px solid #26cf71; border-radius: 4px;">
                                        <div style="color: #999; font-size: 12px; margin-bottom: 5px; font-weight: 600;">MESSAGE:</div>
                                        <div style="color: #333; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">
                                            <?php echo esc_html( $submission->message ); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div style="margin-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                                <form method="post" style="margin: 0;">
                                    <?php wp_nonce_field( 'update_submission_status' ); ?>
                                    <input type="hidden" name="submission_id" value="<?php echo $submission->id; ?>">
                                    <select name="new_status" onchange="this.form.submit()" style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; cursor: pointer;">
                                        <option value="new" <?php selected( $submission->status, 'new' ); ?>>New</option>
                                        <option value="contacted" <?php selected( $submission->status, 'contacted' ); ?>>Contacted</option>
                                        <option value="completed" <?php selected( $submission->status, 'completed' ); ?>>Completed</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                                
                                <form method="post" onsubmit="return confirm('Are you sure you want to delete this submission?');" style="margin: 0;">
                                    <?php wp_nonce_field( 'delete_submission' ); ?>
                                    <input type="hidden" name="submission_id" value="<?php echo $submission->id; ?>">
                                    <button type="submit" name="delete_submission" style="padding: 6px 10px; background: #fee; color: #c00; border: 1px solid #fcc; border-radius: 6px; font-size: 13px; cursor: pointer; width: 100%;">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <?php
}
