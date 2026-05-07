<?php
/**
 * AMC Package Meta Boxes
 * 
 * @package LawFirm_Pro
 */

// Add meta boxes for AMC Package
function lawfirm_add_amc_package_meta_boxes() {
    add_meta_box(
        'amc_package_hero',
        __( 'Hero Section', 'lawfirm-pro' ),
        'lawfirm_amc_package_hero_callback',
        'amc_package',
        'normal',
        'high'
    );
    
    add_meta_box(
        'amc_package_pricing',
        __( 'Pricing Plans', 'lawfirm-pro' ),
        'lawfirm_amc_package_pricing_callback',
        'amc_package',
        'normal',
        'high'
    );
    
    add_meta_box(
        'amc_package_benefits',
        __( 'Why Choose Us', 'lawfirm-pro' ),
        'lawfirm_amc_package_benefits_callback',
        'amc_package',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'lawfirm_add_amc_package_meta_boxes' );

// Hero Section Meta Box
function lawfirm_amc_package_hero_callback( $post ) {
    wp_nonce_field( 'amc_package_meta_nonce', 'amc_package_meta_nonce' );
    
    $hero_subtitle = get_post_meta( $post->ID, '_hero_subtitle', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hero_subtitle"><?php _e( 'Hero Subtitle', 'lawfirm-pro' ); ?></label></th>
            <td>
                <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?php echo esc_attr( $hero_subtitle ); ?>" class="large-text" placeholder="Reliable maintenance service for your systems with expert support." />
                <p class="description"><?php _e( 'Subtitle text displayed below the title in hero section', 'lawfirm-pro' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// Pricing Plans Meta Box
function lawfirm_amc_package_pricing_callback( $post ) {
    // Basic Plan
    $basic_name = get_post_meta( $post->ID, '_basic_name', true );
    $basic_price = get_post_meta( $post->ID, '_basic_price', true );
    $basic_billing = get_post_meta( $post->ID, '_basic_billing', true );
    $basic_features = get_post_meta( $post->ID, '_basic_features', true );
    
    // Standard Plan
    $standard_name = get_post_meta( $post->ID, '_standard_name', true );
    $standard_price = get_post_meta( $post->ID, '_standard_price', true );
    $standard_billing = get_post_meta( $post->ID, '_standard_billing', true );
    $standard_features = get_post_meta( $post->ID, '_standard_features', true );
    
    // Premium Plan
    $premium_name = get_post_meta( $post->ID, '_premium_name', true );
    $premium_price = get_post_meta( $post->ID, '_premium_price', true );
    $premium_billing = get_post_meta( $post->ID, '_premium_billing', true );
    $premium_features = get_post_meta( $post->ID, '_premium_features', true );
    ?>
    
    <!-- BASIC PLAN -->
    <div style="margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-left: 4px solid #ff8c42;">
        <h3 style="margin-top: 0;">Basic Plan</h3>
        <table class="form-table">
            <tr>
                <th style="width: 150px;"><label for="basic_name"><?php _e( 'Plan Name', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <input type="text" id="basic_name" name="basic_name" value="<?php echo esc_attr( $basic_name ); ?>" class="regular-text" placeholder="BASIC" />
                </td>
            </tr>
            <tr>
                <th><label for="basic_price"><?php _e( 'Description', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <textarea id="basic_price" name="basic_price" rows="2" class="large-text" placeholder="Brief description of this plan"><?php echo esc_textarea( $basic_price ); ?></textarea>
                    <p class="description"><?php _e( 'Short description displayed below plan name', 'lawfirm-pro' ); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="basic_billing"><?php _e( 'Billing Period', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <input type="text" id="basic_billing" name="basic_billing" value="<?php echo esc_attr( $basic_billing ); ?>" class="regular-text" placeholder="Monthly Billing" />
                </td>
            </tr>
            <tr>
                <th><label for="basic_features"><?php _e( 'Features', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <textarea id="basic_features" name="basic_features" rows="6" class="large-text" placeholder="One feature per line"><?php echo esc_textarea( $basic_features ); ?></textarea>
                    <p class="description"><?php _e( 'Enter one feature per line', 'lawfirm-pro' ); ?></p>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- STANDARD PLAN -->
    <div style="margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-left: 4px solid #ff8c42;">
        <h3 style="margin-top: 0;">Standard Plan</h3>
        <table class="form-table">
            <tr>
                <th style="width: 150px;"><label for="standard_name"><?php _e( 'Plan Name', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <input type="text" id="standard_name" name="standard_name" value="<?php echo esc_attr( $standard_name ); ?>" class="regular-text" placeholder="STANDARD" />
                </td>
            </tr>
            <tr>
                <th><label for="standard_price"><?php _e( 'Description', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <textarea id="standard_price" name="standard_price" rows="2" class="large-text" placeholder="Brief description of this plan"><?php echo esc_textarea( $standard_price ); ?></textarea>
                    <p class="description"><?php _e( 'Short description displayed below plan name', 'lawfirm-pro' ); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="standard_billing"><?php _e( 'Billing Period', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <input type="text" id="standard_billing" name="standard_billing" value="<?php echo esc_attr( $standard_billing ); ?>" class="regular-text" placeholder="Quarterly Billing" />
                </td>
            </tr>
            <tr>
                <th><label for="standard_features"><?php _e( 'Features', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <textarea id="standard_features" name="standard_features" rows="6" class="large-text" placeholder="One feature per line"><?php echo esc_textarea( $standard_features ); ?></textarea>
                    <p class="description"><?php _e( 'Enter one feature per line', 'lawfirm-pro' ); ?></p>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- PREMIUM PLAN -->
    <div style="margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-left: 4px solid #ff8c42;">
        <h3 style="margin-top: 0;">Premium Plan</h3>
        <table class="form-table">
            <tr>
                <th style="width: 150px;"><label for="premium_name"><?php _e( 'Plan Name', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <input type="text" id="premium_name" name="premium_name" value="<?php echo esc_attr( $premium_name ); ?>" class="regular-text" placeholder="PREMIUM" />
                </td>
            </tr>
            <tr>
                <th><label for="premium_price"><?php _e( 'Description', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <textarea id="premium_price" name="premium_price" rows="2" class="large-text" placeholder="Brief description of this plan"><?php echo esc_textarea( $premium_price ); ?></textarea>
                    <p class="description"><?php _e( 'Short description displayed below plan name', 'lawfirm-pro' ); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="premium_billing"><?php _e( 'Billing Period', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <input type="text" id="premium_billing" name="premium_billing" value="<?php echo esc_attr( $premium_billing ); ?>" class="regular-text" placeholder="Yearly Billing" />
                </td>
            </tr>
            <tr>
                <th><label for="premium_features"><?php _e( 'Features', 'lawfirm-pro' ); ?></label></th>
                <td>
                    <textarea id="premium_features" name="premium_features" rows="6" class="large-text" placeholder="One feature per line"><?php echo esc_textarea( $premium_features ); ?></textarea>
                    <p class="description"><?php _e( 'Enter one feature per line', 'lawfirm-pro' ); ?></p>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

// Why Choose Us Meta Box
function lawfirm_amc_package_benefits_callback( $post ) {
    $benefits = get_post_meta( $post->ID, '_benefits', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="benefits"><?php _e( 'Benefits', 'lawfirm-pro' ); ?></label></th>
            <td>
                <textarea id="benefits" name="benefits" rows="10" class="large-text" placeholder="Title|Description (one per line)"><?php echo esc_textarea( $benefits ); ?></textarea>
                <p class="description">
                    <?php _e( 'Enter benefits in format: <strong>Title|Description</strong> (one per line)', 'lawfirm-pro' ); ?><br>
                    <?php _e( 'Example: Expert Technicians|Highly trained professionals for reliable service.', 'lawfirm-pro' ); ?>
                </p>
            </td>
        </tr>
    </table>
    <?php
}

// Save meta box data
function lawfirm_save_amc_package_meta( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['amc_package_meta_nonce'] ) || ! wp_verify_nonce( $_POST['amc_package_meta_nonce'], 'amc_package_meta_nonce' ) ) {
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
    
    // Save Hero Subtitle
    if ( isset( $_POST['hero_subtitle'] ) ) {
        update_post_meta( $post_id, '_hero_subtitle', sanitize_text_field( $_POST['hero_subtitle'] ) );
    }
    
    // Save Basic Plan
    if ( isset( $_POST['basic_name'] ) ) {
        update_post_meta( $post_id, '_basic_name', sanitize_text_field( $_POST['basic_name'] ) );
    }
    if ( isset( $_POST['basic_price'] ) ) {
        update_post_meta( $post_id, '_basic_price', sanitize_textarea_field( $_POST['basic_price'] ) );
    }
    if ( isset( $_POST['basic_billing'] ) ) {
        update_post_meta( $post_id, '_basic_billing', sanitize_text_field( $_POST['basic_billing'] ) );
    }
    if ( isset( $_POST['basic_features'] ) ) {
        update_post_meta( $post_id, '_basic_features', sanitize_textarea_field( $_POST['basic_features'] ) );
    }
    
    // Save Standard Plan
    if ( isset( $_POST['standard_name'] ) ) {
        update_post_meta( $post_id, '_standard_name', sanitize_text_field( $_POST['standard_name'] ) );
    }
    if ( isset( $_POST['standard_price'] ) ) {
        update_post_meta( $post_id, '_standard_price', sanitize_textarea_field( $_POST['standard_price'] ) );
    }
    if ( isset( $_POST['standard_billing'] ) ) {
        update_post_meta( $post_id, '_standard_billing', sanitize_text_field( $_POST['standard_billing'] ) );
    }
    if ( isset( $_POST['standard_features'] ) ) {
        update_post_meta( $post_id, '_standard_features', sanitize_textarea_field( $_POST['standard_features'] ) );
    }
    
    // Save Premium Plan
    if ( isset( $_POST['premium_name'] ) ) {
        update_post_meta( $post_id, '_premium_name', sanitize_text_field( $_POST['premium_name'] ) );
    }
    if ( isset( $_POST['premium_price'] ) ) {
        update_post_meta( $post_id, '_premium_price', sanitize_textarea_field( $_POST['premium_price'] ) );
    }
    if ( isset( $_POST['premium_billing'] ) ) {
        update_post_meta( $post_id, '_premium_billing', sanitize_text_field( $_POST['premium_billing'] ) );
    }
    if ( isset( $_POST['premium_features'] ) ) {
        update_post_meta( $post_id, '_premium_features', sanitize_textarea_field( $_POST['premium_features'] ) );
    }
    
    // Save Benefits
    if ( isset( $_POST['benefits'] ) ) {
        update_post_meta( $post_id, '_benefits', sanitize_textarea_field( $_POST['benefits'] ) );
    }
}
add_action( 'save_post_amc_package', 'lawfirm_save_amc_package_meta' );
