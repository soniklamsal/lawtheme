<?php
/**
 * About Sections Custom Post Type and Meta Boxes
 *
 * @package LawFirm_Pro
 */

// Register About Sections Custom Post Type
function lawfirm_pro_register_about_sections() {
    $labels = array(
        'name'                  => _x( 'About Sections', 'Post Type General Name', 'lawfirm-pro' ),
        'singular_name'         => _x( 'About Section', 'Post Type Singular Name', 'lawfirm-pro' ),
        'menu_name'             => __( 'About Sections', 'lawfirm-pro' ),
        'name_admin_bar'        => __( 'About Section', 'lawfirm-pro' ),
        'archives'              => __( 'About Section Archives', 'lawfirm-pro' ),
        'attributes'            => __( 'About Section Attributes', 'lawfirm-pro' ),
        'parent_item_colon'     => __( 'Parent About Section:', 'lawfirm-pro' ),
        'all_items'             => __( 'All About Sections', 'lawfirm-pro' ),
        'add_new_item'          => __( 'Add New About Section', 'lawfirm-pro' ),
        'add_new'               => __( 'Add New', 'lawfirm-pro' ),
        'new_item'              => __( 'New About Section', 'lawfirm-pro' ),
        'edit_item'             => __( 'Edit About Section', 'lawfirm-pro' ),
        'update_item'           => __( 'Update About Section', 'lawfirm-pro' ),
        'view_item'             => __( 'View About Section', 'lawfirm-pro' ),
        'view_items'            => __( 'View About Sections', 'lawfirm-pro' ),
        'search_items'          => __( 'Search About Section', 'lawfirm-pro' ),
        'not_found'             => __( 'Not found', 'lawfirm-pro' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'lawfirm-pro' ),
        'featured_image'        => __( 'Featured Image', 'lawfirm-pro' ),
        'set_featured_image'    => __( 'Set featured image', 'lawfirm-pro' ),
        'remove_featured_image' => __( 'Remove featured image', 'lawfirm-pro' ),
        'use_featured_image'    => __( 'Use as featured image', 'lawfirm-pro' ),
        'insert_into_item'      => __( 'Insert into about section', 'lawfirm-pro' ),
        'uploaded_to_this_item' => __( 'Uploaded to this about section', 'lawfirm-pro' ),
        'items_list'            => __( 'About Sections list', 'lawfirm-pro' ),
        'items_list_navigation' => __( 'About Sections list navigation', 'lawfirm-pro' ),
        'filter_items_list'     => __( 'Filter about sections list', 'lawfirm-pro' ),
    );
    
    $args = array(
        'label'                 => __( 'About Section', 'lawfirm-pro' ),
        'description'           => __( 'About sections for the website', 'lawfirm-pro' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-info',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type( 'about_section', $args );
}
add_action( 'init', 'lawfirm_pro_register_about_sections', 0 );

// Add Meta Boxes for About Section
function lawfirm_pro_add_about_section_meta_boxes() {
    add_meta_box(
        'about_section_details',
        __( 'About Section Details', 'lawfirm-pro' ),
        'lawfirm_pro_about_section_meta_box_callback',
        'about_section',
        'normal',
        'high'
    );
    
    add_meta_box(
        'about_section_location',
        __( 'Display Location', 'lawfirm-pro' ),
        'lawfirm_pro_about_section_location_callback',
        'about_section',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'lawfirm_pro_add_about_section_meta_boxes' );

// Meta Box Callback - About Section Details
function lawfirm_pro_about_section_meta_box_callback( $post ) {
    wp_nonce_field( 'lawfirm_pro_about_section_nonce', 'lawfirm_pro_about_section_nonce_field' );
    
    $subtitle = get_post_meta( $post->ID, '_about_subtitle', true );
    $years = get_post_meta( $post->ID, '_about_years', true );
    $button_text = get_post_meta( $post->ID, '_about_button_text', true );
    $button_url = get_post_meta( $post->ID, '_about_button_url', true );
    ?>
    
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="about_subtitle"><?php _e( 'Subtitle', 'lawfirm-pro' ); ?></label>
            </th>
            <td>
                <input type="text" id="about_subtitle" name="about_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" class="regular-text" placeholder="e.g., Your trusted legal partner with over 25 years of excellence">
                <p class="description"><?php _e( 'The subtitle that appears below the main title.', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="about_years"><?php _e( 'Years of Experience', 'lawfirm-pro' ); ?></label>
            </th>
            <td>
                <input type="number" id="about_years" name="about_years" value="<?php echo esc_attr( $years ); ?>" class="small-text" placeholder="25">
                <p class="description"><?php _e( 'Number of years in business (optional).', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="about_button_text"><?php _e( 'Button Text', 'lawfirm-pro' ); ?></label>
            </th>
            <td>
                <input type="text" id="about_button_text" name="about_button_text" value="<?php echo esc_attr( $button_text ); ?>" class="regular-text" placeholder="Learn More">
                <p class="description"><?php _e( 'Text for the call-to-action button (optional).', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="about_button_url"><?php _e( 'Button URL', 'lawfirm-pro' ); ?></label>
            </th>
            <td>
                <input type="url" id="about_button_url" name="about_button_url" value="<?php echo esc_url( $button_url ); ?>" class="regular-text" placeholder="https://example.com/about">
                <p class="description"><?php _e( 'URL for the button link (optional).', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
    </table>
    
    <p><strong><?php _e( 'Main Content:', 'lawfirm-pro' ); ?></strong></p>
    <p class="description"><?php _e( 'Use the editor above to add the main content for this about section.', 'lawfirm-pro' ); ?></p>
    <?php
}

// Meta Box Callback - Display Location
function lawfirm_pro_about_section_location_callback( $post ) {
    $section_id = get_post_meta( $post->ID, '_about_section_id', true );
    ?>
    
    <p>
        <label for="about_section_id"><strong><?php _e( 'Section Identifier', 'lawfirm-pro' ); ?></strong></label>
    </p>
    <p>
        <select id="about_section_id" name="about_section_id" class="widefat">
            <option value=""><?php _e( 'Select Location', 'lawfirm-pro' ); ?></option>
            <option value="geniuslaw" <?php selected( $section_id, 'geniuslaw' ); ?>><?php _e( 'Genius Law (Home Page)', 'lawfirm-pro' ); ?></option>
            <option value="about-page" <?php selected( $section_id, 'about-page' ); ?>><?php _e( 'About Page', 'lawfirm-pro' ); ?></option>
            <option value="footer" <?php selected( $section_id, 'footer' ); ?>><?php _e( 'Footer Section', 'lawfirm-pro' ); ?></option>
        </select>
    </p>
    <p class="description">
        <?php _e( 'Choose where this about section should be displayed on the website.', 'lawfirm-pro' ); ?>
    </p>
    
    <hr>
    
    <p>
        <label>
            <input type="checkbox" name="about_section_active" value="1" <?php checked( get_post_meta( $post->ID, '_about_section_active', true ), '1' ); ?>>
            <?php _e( 'Active', 'lawfirm-pro' ); ?>
        </label>
    </p>
    <p class="description">
        <?php _e( 'Uncheck to hide this section without deleting it.', 'lawfirm-pro' ); ?>
    </p>
    <?php
}

// Save Meta Box Data
function lawfirm_pro_save_about_section_meta( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['lawfirm_pro_about_section_nonce_field'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['lawfirm_pro_about_section_nonce_field'], 'lawfirm_pro_about_section_nonce' ) ) {
        return;
    }
    
    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save subtitle
    if ( isset( $_POST['about_subtitle'] ) ) {
        update_post_meta( $post_id, '_about_subtitle', sanitize_text_field( $_POST['about_subtitle'] ) );
    }
    
    // Save years
    if ( isset( $_POST['about_years'] ) ) {
        update_post_meta( $post_id, '_about_years', absint( $_POST['about_years'] ) );
    }
    
    // Save button text
    if ( isset( $_POST['about_button_text'] ) ) {
        update_post_meta( $post_id, '_about_button_text', sanitize_text_field( $_POST['about_button_text'] ) );
    }
    
    // Save button URL
    if ( isset( $_POST['about_button_url'] ) ) {
        update_post_meta( $post_id, '_about_button_url', esc_url_raw( $_POST['about_button_url'] ) );
    }
    
    // Save section ID
    if ( isset( $_POST['about_section_id'] ) ) {
        update_post_meta( $post_id, '_about_section_id', sanitize_text_field( $_POST['about_section_id'] ) );
    }
    
    // Save active status
    $active = isset( $_POST['about_section_active'] ) ? '1' : '0';
    update_post_meta( $post_id, '_about_section_active', $active );
}
add_action( 'save_post_about_section', 'lawfirm_pro_save_about_section_meta' );

// Helper function to get about section by ID
function lawfirm_pro_get_about_section( $section_id = 'geniuslaw' ) {
    $args = array(
        'post_type'      => 'about_section',
        'posts_per_page' => 1,
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => '_about_section_id',
                'value'   => $section_id,
                'compare' => '='
            ),
            array(
                'key'     => '_about_section_active',
                'value'   => '1',
                'compare' => '='
            )
        )
    );
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) {
        $query->the_post();
        
        $section = array(
            'title'       => get_the_title(),
            'subtitle'    => get_post_meta( get_the_ID(), '_about_subtitle', true ),
            'content'     => get_the_content(),
            'years'       => get_post_meta( get_the_ID(), '_about_years', true ),
            'button_text' => get_post_meta( get_the_ID(), '_about_button_text', true ),
            'button_url'  => get_post_meta( get_the_ID(), '_about_button_url', true ),
            'image'       => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
        );
        
        wp_reset_postdata();
        
        return $section;
    }
    
    wp_reset_postdata();
    return false;
}

// Add custom columns to About Sections list
function lawfirm_pro_about_section_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['section_location'] = __( 'Location', 'lawfirm-pro' );
    $new_columns['active_status'] = __( 'Status', 'lawfirm-pro' );
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter( 'manage_about_section_posts_columns', 'lawfirm_pro_about_section_columns' );

// Populate custom columns
function lawfirm_pro_about_section_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'section_location':
            $section_id = get_post_meta( $post_id, '_about_section_id', true );
            $locations = array(
                'geniuslaw'   => __( 'Genius Law (Home)', 'lawfirm-pro' ),
                'about-page'  => __( 'About Page', 'lawfirm-pro' ),
                'footer'      => __( 'Footer', 'lawfirm-pro' ),
            );
            echo isset( $locations[ $section_id ] ) ? esc_html( $locations[ $section_id ] ) : '—';
            break;
            
        case 'active_status':
            $active = get_post_meta( $post_id, '_about_section_active', true );
            if ( $active === '1' ) {
                echo '<span style="color: green;">● ' . __( 'Active', 'lawfirm-pro' ) . '</span>';
            } else {
                echo '<span style="color: red;">● ' . __( 'Inactive', 'lawfirm-pro' ) . '</span>';
            }
            break;
    }
}
add_action( 'manage_about_section_posts_custom_column', 'lawfirm_pro_about_section_column_content', 10, 2 );