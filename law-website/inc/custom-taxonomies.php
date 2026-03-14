<?php
/**
 * Register custom taxonomies
 *
 * @package LawFirm_Pro
 */

function lawfirm_pro_register_taxonomies() {
    // Register Practice Area Taxonomy (Hierarchical)
    register_taxonomy( 'practice_area', 'legal_service', array(
        'labels' => array(
            'name'              => esc_html__( 'Practice Areas', 'lawfirm-pro' ),
            'singular_name'     => esc_html__( 'Practice Area', 'lawfirm-pro' ),
            'search_items'      => esc_html__( 'Search Practice Areas', 'lawfirm-pro' ),
            'all_items'         => esc_html__( 'All Practice Areas', 'lawfirm-pro' ),
            'parent_item'       => esc_html__( 'Parent Practice Area', 'lawfirm-pro' ),
            'parent_item_colon' => esc_html__( 'Parent Practice Area:', 'lawfirm-pro' ),
            'edit_item'         => esc_html__( 'Edit Practice Area', 'lawfirm-pro' ),
            'update_item'       => esc_html__( 'Update Practice Area', 'lawfirm-pro' ),
            'add_new_item'      => esc_html__( 'Add New Practice Area', 'lawfirm-pro' ),
            'new_item_name'     => esc_html__( 'New Practice Area Name', 'lawfirm-pro' ),
            'menu_name'         => esc_html__( 'Practice Areas', 'lawfirm-pro' ),
        ),
        'public'            => true,
        'publicly_queryable' => true,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'query_var'         => true,
        'rewrite'           => array(
            'slug'         => 'practice_area',
            'with_front'   => false,
            'hierarchical' => true,
        ),
        'show_in_rest'      => true,
    ) );
}
add_action( 'init', 'lawfirm_pro_register_taxonomies' );

// Force flush rewrite rules once after taxonomy update
function lawfirm_pro_maybe_flush_rewrite_rules() {
    $flush_version = get_option( 'lawfirm_pro_rewrite_version', '0' );
    $current_version = '1.1'; // Increment this when you need to flush again
    
    if ( version_compare( $flush_version, $current_version, '<' ) ) {
        flush_rewrite_rules();
        update_option( 'lawfirm_pro_rewrite_version', $current_version );
    }
}
add_action( 'init', 'lawfirm_pro_maybe_flush_rewrite_rules', 999 );

// Enqueue media uploader scripts - MUST be called before footer
function lawfirm_pro_enqueue_taxonomy_media() {
    global $pagenow, $taxnow;
    
    // Check if we're on taxonomy edit pages
    if ( ( $pagenow === 'term.php' || $pagenow === 'edit-tags.php' ) && $taxnow === 'practice_area' ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'lawfirm_pro_enqueue_taxonomy_media' );

// Add image field to Practice Area taxonomy - Add form
function lawfirm_pro_practice_area_add_form_fields() {
    ?>
    <div class="form-field term-image-wrap">
        <label for="practice_area_image"><?php esc_html_e( 'Practice Area Image', 'lawfirm-pro' ); ?></label>
        <input type="hidden" id="practice_area_image" name="practice_area_image" value="" />
        <div id="practice_area_image_preview" style="margin: 10px 0;"></div>
        <button type="button" class="button practice_area_image_upload"><?php esc_html_e( 'Upload Image', 'lawfirm-pro' ); ?></button>
        <button type="button" class="button practice_area_image_remove" style="display:none; margin-left: 5px;"><?php esc_html_e( 'Remove Image', 'lawfirm-pro' ); ?></button>
        <p class="description"><?php esc_html_e( 'Upload an image for this practice area (will be displayed on homepage)', 'lawfirm-pro' ); ?></p>
    </div>
    <?php
}
add_action( 'practice_area_add_form_fields', 'lawfirm_pro_practice_area_add_form_fields' );

// Add image field to Practice Area taxonomy - Edit form
function lawfirm_pro_practice_area_edit_form_fields( $term ) {
    $image_id = get_term_meta( $term->term_id, 'practice_area_image', true );
    $image_url = $image_id ? wp_get_attachment_url( $image_id ) : '';
    ?>
    <tr class="form-field term-image-wrap">
        <th scope="row">
            <label for="practice_area_image"><?php esc_html_e( 'Practice Area Image', 'lawfirm-pro' ); ?></label>
        </th>
        <td>
            <input type="hidden" id="practice_area_image" name="practice_area_image" value="<?php echo esc_attr( $image_id ); ?>" />
            <div id="practice_area_image_preview" style="margin-bottom: 10px;">
                <?php if ( $image_url ) : ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" style="max-width: 200px; height: auto; display: block; border: 1px solid #ddd; padding: 5px; background: #fff;" />
                <?php endif; ?>
            </div>
            <button type="button" class="button practice_area_image_upload"><?php esc_html_e( 'Upload Image', 'lawfirm-pro' ); ?></button>
            <button type="button" class="button practice_area_image_remove" style="<?php echo $image_url ? '' : 'display:none;'; ?> margin-left: 5px;"><?php esc_html_e( 'Remove Image', 'lawfirm-pro' ); ?></button>
            <p class="description"><?php esc_html_e( 'Upload an image for this practice area (will be displayed on homepage)', 'lawfirm-pro' ); ?></p>
        </td>
    </tr>
    <?php
}
add_action( 'practice_area_edit_form_fields', 'lawfirm_pro_practice_area_edit_form_fields' );

// Save Practice Area image
function lawfirm_pro_save_practice_area_image( $term_id ) {
    if ( isset( $_POST['practice_area_image'] ) ) {
        $image_id = absint( $_POST['practice_area_image'] );
        if ( $image_id > 0 ) {
            update_term_meta( $term_id, 'practice_area_image', $image_id );
        } else {
            delete_term_meta( $term_id, 'practice_area_image' );
        }
    }
}
add_action( 'created_practice_area', 'lawfirm_pro_save_practice_area_image' );
add_action( 'edited_practice_area', 'lawfirm_pro_save_practice_area_image' );

// Add JavaScript for media uploader
function lawfirm_pro_taxonomy_image_script() {
    global $pagenow, $taxnow;
    
    // Only load on practice_area taxonomy pages
    if ( ( $pagenow === 'term.php' || $pagenow === 'edit-tags.php' ) && $taxnow === 'practice_area' ) {
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            'use strict';
            
            var file_frame;
            var $uploadButton = $('.practice_area_image_upload');
            var $removeButton = $('.practice_area_image_remove');
            var $imageField = $('#practice_area_image');
            var $imagePreview = $('#practice_area_image_preview');
            
            // Upload button click
            $uploadButton.on('click', function(e) {
                e.preventDefault();
                
                // If the media frame already exists, reopen it
                if (file_frame) {
                    file_frame.open();
                    return;
                }
                
                // Create the media frame
                file_frame = wp.media({
                    title: '<?php echo esc_js( __( 'Select Practice Area Image', 'lawfirm-pro' ) ); ?>',
                    button: {
                        text: '<?php echo esc_js( __( 'Use this image', 'lawfirm-pro' ) ); ?>'
                    },
                    library: {
                        type: 'image'
                    },
                    multiple: false
                });
                
                // When an image is selected, run a callback
                file_frame.on('select', function() {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    
                    // Set the image ID
                    $imageField.val(attachment.id);
                    
                    // Display the image preview
                    $imagePreview.html('<img src="' + attachment.url + '" style="max-width: 200px; height: auto; display: block; border: 1px solid #ddd; padding: 5px; background: #fff;" />');
                    
                    // Show remove button
                    $removeButton.show();
                });
                
                // Open the media frame
                file_frame.open();
            });
            
            // Remove button click
            $removeButton.on('click', function(e) {
                e.preventDefault();
                
                // Clear the image field
                $imageField.val('');
                
                // Clear the preview
                $imagePreview.html('');
                
                // Hide remove button
                $(this).hide();
            });
        });
        </script>
        <?php
    }
}
add_action( 'admin_footer', 'lawfirm_pro_taxonomy_image_script' );
