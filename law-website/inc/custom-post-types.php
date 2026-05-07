<?php
/**
 * Register custom post types
 *
 * @package LawFirm_Pro
 */

function lawfirm_pro_register_post_types() {
    // Register Legal Service Custom Post Type
    register_post_type( 'legal_service', array(
        'labels' => array(
            'name'               => esc_html__( 'Legal Services', 'lawfirm-pro' ),
            'singular_name'      => esc_html__( 'Legal Service', 'lawfirm-pro' ),
            'add_new'            => esc_html__( 'Add New', 'lawfirm-pro' ),
            'add_new_item'       => esc_html__( 'Add New Legal Service', 'lawfirm-pro' ),
            'edit_item'          => esc_html__( 'Edit Legal Service', 'lawfirm-pro' ),
            'new_item'           => esc_html__( 'New Legal Service', 'lawfirm-pro' ),
            'view_item'          => esc_html__( 'View Legal Service', 'lawfirm-pro' ),
            'search_items'       => esc_html__( 'Search Legal Services', 'lawfirm-pro' ),
            'not_found'          => esc_html__( 'No legal services found', 'lawfirm-pro' ),
            'not_found_in_trash' => esc_html__( 'No legal services found in trash', 'lawfirm-pro' ),
        ),
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'legal_service' ),
        'capability_type'     => 'post',
        'menu_icon'           => 'dashicons-businessperson',
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments' ),
        'show_in_rest'        => true,
    ) );
    
    // Register AMC Package Custom Post Type
    register_post_type( 'amc_package', array(
        'labels' => array(
            'name'               => esc_html__( 'AMC Packages', 'lawfirm-pro' ),
            'singular_name'      => esc_html__( 'AMC Package', 'lawfirm-pro' ),
            'add_new'            => esc_html__( 'Add New', 'lawfirm-pro' ),
            'add_new_item'       => esc_html__( 'Add New Package', 'lawfirm-pro' ),
            'edit_item'          => esc_html__( 'Edit Package', 'lawfirm-pro' ),
            'new_item'           => esc_html__( 'New Package', 'lawfirm-pro' ),
            'view_item'          => esc_html__( 'View Package', 'lawfirm-pro' ),
            'search_items'       => esc_html__( 'Search Packages', 'lawfirm-pro' ),
            'not_found'          => esc_html__( 'No packages found', 'lawfirm-pro' ),
            'not_found_in_trash' => esc_html__( 'No packages found in trash', 'lawfirm-pro' ),
        ),
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'amc-packages' ),
        'capability_type'     => 'post',
        'menu_icon'           => 'dashicons-portfolio',
        'menu_position'       => 29,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest'        => true,
    ) );
}
add_action( 'init', 'lawfirm_pro_register_post_types' );

// Flush rewrite rules once after theme activation
function lawfirm_pro_flush_rewrite_once() {
    if ( get_option( 'lawfirm_pro_flush_done' ) != 'yes' ) {
        lawfirm_pro_register_post_types();
        flush_rewrite_rules();
        update_option( 'lawfirm_pro_flush_done', 'yes' );
    }
}
add_action( 'init', 'lawfirm_pro_flush_rewrite_once', 999 );

// Add custom meta boxes for Legal Service fields
function lawfirm_pro_add_service_meta_boxes() {
    add_meta_box(
        'service_details',
        esc_html__( 'Service Details', 'lawfirm-pro' ),
        'lawfirm_pro_service_details_callback',
        'legal_service',
        'normal',
        'high'
    );
    
    add_meta_box(
        'service_content',
        esc_html__( 'Service Content', 'lawfirm-pro' ),
        'lawfirm_pro_service_content_callback',
        'legal_service',
        'normal',
        'high'
    );
    
    add_meta_box(
        'service_display_options',
        esc_html__( 'Display Options', 'lawfirm-pro' ),
        'lawfirm_pro_service_display_options_callback',
        'legal_service',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'lawfirm_pro_add_service_meta_boxes' );

// Meta box callback
function lawfirm_pro_service_details_callback( $post ) {
    wp_nonce_field( 'lawfirm_pro_save_service_details', 'lawfirm_pro_service_details_nonce' );
    
    $provider_name = get_post_meta( $post->ID, 'provider_name', true );
    $service_rating = get_post_meta( $post->ID, 'service_rating', true );
    $review_count = get_post_meta( $post->ID, 'review_count', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="provider_name"><?php esc_html_e( 'Provider Name', 'lawfirm-pro' ); ?></label></th>
            <td>
                <input type="text" id="provider_name" name="provider_name" value="<?php echo esc_attr( $provider_name ); ?>" class="regular-text" />
                <p class="description"><?php esc_html_e( 'e.g., Genius Law', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="service_rating"><?php esc_html_e( 'Service Rating', 'lawfirm-pro' ); ?></label></th>
            <td>
                <input type="number" id="service_rating" name="service_rating" value="<?php echo esc_attr( $service_rating ); ?>" step="0.1" min="0" max="5" class="small-text" />
                <p class="description"><?php esc_html_e( 'Rating out of 5 (e.g., 4.9)', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="review_count"><?php esc_html_e( 'Review Count', 'lawfirm-pro' ); ?></label></th>
            <td>
                <input type="number" id="review_count" name="review_count" value="<?php echo esc_attr( $review_count ); ?>" class="small-text" />
                <p class="description"><?php esc_html_e( 'Number of reviews (e.g., 127)', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// Service Content meta box callback
function lawfirm_pro_service_content_callback( $post ) {
    wp_nonce_field( 'lawfirm_pro_save_service_content', 'lawfirm_pro_service_content_nonce' );
    
    $gallery = get_post_meta( $post->ID, 'service_gallery', true );
    $short_desc = get_post_meta( $post->ID, 'service_short_description', true );
    $full_desc = get_post_meta( $post->ID, 'service_full_description', true );
    
    if ( ! is_array( $gallery ) ) $gallery = array();
    if ( ! is_array( $short_desc ) ) $short_desc = array();
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php esc_html_e( 'Gallery Images', 'lawfirm-pro' ); ?></label></th>
            <td>
                <div id="service-gallery-container">
                    <?php
                    if ( ! empty( $gallery ) ) {
                        foreach ( $gallery as $index => $image_id ) {
                            $image_url = wp_get_attachment_url( $image_id );
                            if ( $image_url ) {
                                echo '<div class="gallery-image-wrapper" style="display: inline-block; margin: 5px; position: relative;">';
                                echo '<img src="' . esc_url( $image_url ) . '" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ddd; border-radius: 4px;" />';
                                echo '<input type="hidden" name="service_gallery[]" value="' . esc_attr( $image_id ) . '" />';
                                echo '<button type="button" class="remove-gallery-image" style="position: absolute; top: -5px; right: -5px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">&times;</button>';
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                </div>
                <p>
                    <button type="button" class="button" id="add-gallery-images"><?php esc_html_e( 'Add Images', 'lawfirm-pro' ); ?></button>
                </p>
                <p class="description"><?php esc_html_e( 'Upload multiple images for the service gallery/slider', 'lawfirm-pro' ); ?></p>
                
                <script>
                jQuery(document).ready(function($) {
                    var galleryFrame;
                    
                    $('#add-gallery-images').on('click', function(e) {
                        e.preventDefault();
                        
                        if (galleryFrame) {
                            galleryFrame.open();
                            return;
                        }
                        
                        galleryFrame = wp.media({
                            title: '<?php esc_html_e( 'Select Gallery Images', 'lawfirm-pro' ); ?>',
                            button: {
                                text: '<?php esc_html_e( 'Add to Gallery', 'lawfirm-pro' ); ?>'
                            },
                            multiple: true
                        });
                        
                        galleryFrame.on('select', function() {
                            var selection = galleryFrame.state().get('selection');
                            selection.map(function(attachment) {
                                attachment = attachment.toJSON();
                                var html = '<div class="gallery-image-wrapper" style="display: inline-block; margin: 5px; position: relative;">';
                                html += '<img src="' + attachment.url + '" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ddd; border-radius: 4px;" />';
                                html += '<input type="hidden" name="service_gallery[]" value="' + attachment.id + '" />';
                                html += '<button type="button" class="remove-gallery-image" style="position: absolute; top: -5px; right: -5px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">&times;</button>';
                                html += '</div>';
                                $('#service-gallery-container').append(html);
                            });
                        });
                        
                        galleryFrame.open();
                    });
                    
                    $(document).on('click', '.remove-gallery-image', function() {
                        $(this).closest('.gallery-image-wrapper').remove();
                    });
                });
                </script>
            </td>
        </tr>
        <tr>
            <th><label for="service_full_description"><?php esc_html_e( 'Short Description', 'lawfirm-pro' ); ?></label></th>
            <td>
                <?php
                wp_editor( $full_desc, 'service_full_description', array(
                    'textarea_name' => 'service_full_description',
                    'textarea_rows' => 10,
                    'media_buttons' => false,
                    'teeny' => true,
                ) );
                ?>
                <p class="description"><?php esc_html_e( 'Brief description of the service', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label><?php esc_html_e( 'Key Features (Bullet Points)', 'lawfirm-pro' ); ?></label></th>
            <td>
                <?php for ( $i = 0; $i < 5; $i++ ) : ?>
                    <input type="text" name="service_short_description[]" value="<?php echo esc_attr( isset( $short_desc[$i] ) ? $short_desc[$i] : '' ); ?>" class="regular-text" style="margin-bottom: 8px; display: block;" placeholder="<?php echo esc_attr( sprintf( __( 'Bullet point %d', 'lawfirm-pro' ), $i + 1 ) ); ?>" />
                <?php endfor; ?>
                <p class="description"><?php esc_html_e( 'Enter up to 5 key points about this service', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// Display Options meta box callback
function lawfirm_pro_service_display_options_callback( $post ) {
    wp_nonce_field( 'lawfirm_pro_save_display_options', 'lawfirm_pro_display_options_nonce' );
    
    $is_featured = get_post_meta( $post->ID, 'is_featured_service', true );
    $is_popular = get_post_meta( $post->ID, 'is_popular_service', true );
    ?>
    <div style="padding: 10px 0;">
        <p>
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" name="is_featured_service" value="1" <?php checked( $is_featured, '1' ); ?> />
                <strong><?php esc_html_e( 'Featured Legal Service', 'lawfirm-pro' ); ?></strong>
            </label>
            <span class="description" style="display: block; margin-left: 24px; color: #666;">
                <?php esc_html_e( 'Display in Featured Legal Services section on homepage', 'lawfirm-pro' ); ?>
            </span>
        </p>
        
        <p style="margin-top: 15px;">
            <label style="display: block; margin-bottom: 10px;">
                <input type="checkbox" name="is_popular_service" value="1" <?php checked( $is_popular, '1' ); ?> />
                <strong><?php esc_html_e( 'Popular Legal Service', 'lawfirm-pro' ); ?></strong>
            </label>
            <span class="description" style="display: block; margin-left: 24px; color: #666;">
                <?php esc_html_e( 'Display in Popular Legal Services section on homepage', 'lawfirm-pro' ); ?>
            </span>
        </p>
    </div>
    <?php
}

// Save meta box data
function lawfirm_pro_save_service_details( $post_id ) {
    if ( ! isset( $_POST['lawfirm_pro_service_details_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['lawfirm_pro_service_details_nonce'], 'lawfirm_pro_save_service_details' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['provider_name'] ) ) {
        update_post_meta( $post_id, 'provider_name', sanitize_text_field( $_POST['provider_name'] ) );
    }
    
    if ( isset( $_POST['service_rating'] ) ) {
        update_post_meta( $post_id, 'service_rating', sanitize_text_field( $_POST['service_rating'] ) );
    }
    
    if ( isset( $_POST['review_count'] ) ) {
        update_post_meta( $post_id, 'review_count', absint( $_POST['review_count'] ) );
    }
}
add_action( 'save_post', 'lawfirm_pro_save_service_details' );

// Save service content meta box data
function lawfirm_pro_save_service_content( $post_id ) {
    if ( ! isset( $_POST['lawfirm_pro_service_content_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['lawfirm_pro_service_content_nonce'], 'lawfirm_pro_save_service_content' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save gallery images
    if ( isset( $_POST['service_gallery'] ) && is_array( $_POST['service_gallery'] ) ) {
        $gallery = array_map( 'absint', $_POST['service_gallery'] );
        update_post_meta( $post_id, 'service_gallery', $gallery );
    } else {
        delete_post_meta( $post_id, 'service_gallery' );
    }
    
    // Save short description bullets
    if ( isset( $_POST['service_short_description'] ) && is_array( $_POST['service_short_description'] ) ) {
        $short_desc = array_filter( array_map( 'sanitize_text_field', $_POST['service_short_description'] ) );
        update_post_meta( $post_id, 'service_short_description', $short_desc );
    } else {
        delete_post_meta( $post_id, 'service_short_description' );
    }
    
    // Save full description
    if ( isset( $_POST['service_full_description'] ) ) {
        update_post_meta( $post_id, 'service_full_description', wp_kses_post( $_POST['service_full_description'] ) );
    }
}
add_action( 'save_post', 'lawfirm_pro_save_service_content' );

// Save display options meta box data
function lawfirm_pro_save_display_options( $post_id ) {
    if ( ! isset( $_POST['lawfirm_pro_display_options_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['lawfirm_pro_display_options_nonce'], 'lawfirm_pro_save_display_options' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save Featured Service checkbox
    if ( isset( $_POST['is_featured_service'] ) ) {
        update_post_meta( $post_id, 'is_featured_service', '1' );
    } else {
        delete_post_meta( $post_id, 'is_featured_service' );
    }
    
    // Save Popular Service checkbox
    if ( isset( $_POST['is_popular_service'] ) ) {
        update_post_meta( $post_id, 'is_popular_service', '1' );
    } else {
        delete_post_meta( $post_id, 'is_popular_service' );
    }
}
add_action( 'save_post', 'lawfirm_pro_save_display_options' );
