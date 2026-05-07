<?php
/**
 * Theme Customizer
 *
 * @package LawFirm_Pro
 */

/* =========================================
   Custom Range Control
========================================= */
if ( class_exists( 'WP_Customize_Control' ) ) {
    class LawFirm_Pro_Range_Control extends WP_Customize_Control {
        public $type = 'range';

        public function render_content() {
            ?>
            <label>
                <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php endif; ?>

                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description">
                        <?php echo esc_html( $this->description ); ?>
                    </span>
                <?php endif; ?>

                <div style="display:flex;align-items:center;gap:10px;margin-top:8px;">
                    <input 
                        type="range"
                        <?php $this->input_attrs(); ?>
                        value="<?php echo esc_attr( $this->value() ); ?>"
                        <?php $this->link(); ?>
                        style="flex:1;"
                    />

                    <input 
                        type="number"
                        <?php $this->input_attrs(); ?>
                        value="<?php echo esc_attr( $this->value() ); ?>"
                        <?php $this->link(); ?>
                        style="width:70px;text-align:center;"
                    />
                </div>
            </label>
            <?php
        }
    }
    
    /* =========================================
       Custom HTML Control for Location Map Instructions
    ========================================= */
    class LawFirm_Pro_Custom_HTML_Control extends WP_Customize_Control {
        public $type = 'custom_html';

        public function render_content() {
            ?>
            <label>
                <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php endif; ?>
            </label>
            
            <div style="background: #f0f0f1; padding: 15px; border-radius: 4px; margin: 10px 0;">
                <p style="margin: 0 0 10px 0; font-size: 13px; line-height: 1.6;">
                    <strong>Option 1: Use Default Location</strong><br>
                    Click the button below to load Genius Law and Associates location.
                </p>
                <button type="button" id="use-default-map-btn" class="button button-primary" style="width: 100%; margin-bottom: 15px;">
                    Use Default Map (Genius Law Location)
                </button>
                
                <p style="margin: 10px 0; font-size: 13px; line-height: 1.6; border-top: 1px solid #ddd; padding-top: 15px;">
                    <strong>Option 2: Use Custom Location</strong><br>
                    Type your address or location name and click Search, then click on the map to set your exact location.
                </p>
                <a href="https://www.google.com/maps" target="_blank" class="button button-secondary" style="width: 100%;">
                    Open Google Maps to Get Embed Code
                </a>
                <p style="margin: 10px 0 0 0; font-size: 12px; color: #666; line-height: 1.5;">
                    <em>Instructions:</em> Search your location → Click "Share" → Click "Embed a map" → Copy the iframe code → Paste it in the "Google Maps Embed Code" field above.
                </p>
            </div>
            <?php
        }
    }
    
    /* =========================================
       Custom FAQ Repeater Control
    ========================================= */
    class LawFirm_Pro_FAQ_Repeater_Control extends WP_Customize_Control {
        public $type = 'faq_repeater';

        public function render_content() {
            $values = json_decode( $this->value(), true );
            if ( ! is_array( $values ) ) {
                $values = array();
            }
            ?>
            <label>
                <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description">
                        <?php echo esc_html( $this->description ); ?>
                    </span>
                <?php endif; ?>
            </label>
            
            <div class="faq-repeater-wrapper" style="margin-top:10px;">
                <div class="faq-items">
                    <?php foreach ( $values as $index => $item ) : ?>
                        <div class="faq-item" style="border:1px solid #ddd;padding:15px;margin-bottom:10px;background:#f9f9f9;border-radius:4px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                <strong>FAQ #<?php echo $index + 1; ?></strong>
                                <button type="button" class="button remove-faq-item" style="background:#dc3545;color:white;border:none;padding:5px 10px;cursor:pointer;border-radius:3px;">Remove</button>
                            </div>
                            <div style="margin-bottom:10px;">
                                <label style="display:block;margin-bottom:5px;font-weight:600;">Question:</label>
                                <input type="text" class="faq-question" value="<?php echo esc_attr( $item['question'] ); ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:3px;" />
                            </div>
                            <div>
                                <label style="display:block;margin-bottom:5px;font-weight:600;">Answer:</label>
                                <textarea class="faq-answer" rows="3" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:3px;"><?php echo esc_textarea( $item['answer'] ); ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" class="button button-primary add-faq-item" style="margin-top:10px;">Add FAQ</button>
                
                <input type="hidden" class="faq-repeater-value" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
            </div>
            
            <script>
            (function($) {
                $(document).ready(function() {
                    var wrapper = $('.faq-repeater-wrapper');
                    var itemsContainer = wrapper.find('.faq-items');
                    var hiddenInput = wrapper.find('.faq-repeater-value');
                    
                    // Add new FAQ
                    wrapper.on('click', '.add-faq-item', function() {
                        var index = itemsContainer.find('.faq-item').length;
                        var newItem = '<div class="faq-item" style="border:1px solid #ddd;padding:15px;margin-bottom:10px;background:#f9f9f9;border-radius:4px;">' +
                            '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">' +
                            '<strong>FAQ #' + (index + 1) + '</strong>' +
                            '<button type="button" class="button remove-faq-item" style="background:#dc3545;color:white;border:none;padding:5px 10px;cursor:pointer;border-radius:3px;">Remove</button>' +
                            '</div>' +
                            '<div style="margin-bottom:10px;">' +
                            '<label style="display:block;margin-bottom:5px;font-weight:600;">Question:</label>' +
                            '<input type="text" class="faq-question" value="" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:3px;" />' +
                            '</div>' +
                            '<div>' +
                            '<label style="display:block;margin-bottom:5px;font-weight:600;">Answer:</label>' +
                            '<textarea class="faq-answer" rows="3" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:3px;"></textarea>' +
                            '</div>' +
                            '</div>';
                        itemsContainer.append(newItem);
                        updateFAQValue();
                    });
                    
                    // Remove FAQ
                    wrapper.on('click', '.remove-faq-item', function() {
                        $(this).closest('.faq-item').remove();
                        updateFAQNumbers();
                        updateFAQValue();
                    });
                    
                    // Update value on input change
                    wrapper.on('input', '.faq-question, .faq-answer', function() {
                        updateFAQValue();
                    });
                    
                    function updateFAQNumbers() {
                        itemsContainer.find('.faq-item').each(function(index) {
                            $(this).find('strong').text('FAQ #' + (index + 1));
                        });
                    }
                    
                    function updateFAQValue() {
                        var faqs = [];
                        itemsContainer.find('.faq-item').each(function() {
                            var question = $(this).find('.faq-question').val();
                            var answer = $(this).find('.faq-answer').val();
                            if (question || answer) {
                                faqs.push({
                                    question: question,
                                    answer: answer
                                });
                            }
                        });
                        hiddenInput.val(JSON.stringify(faqs)).trigger('change');
                    }
                });
            })(jQuery);
            </script>
            <?php
        }
    }
}


/* =========================================
   Register Customizer Settings
========================================= */
function lawfirm_pro_customize_register( $wp_customize ) {

    /* ========= LOGO SIZE (Inside Site Identity) ========= */

    // Logo Width
    $wp_customize->add_setting( 'logo_width', array(
        'default'           => 150,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new LawFirm_Pro_Range_Control(
        $wp_customize,
        'logo_width',
        array(
            'label'       => esc_html__( 'Logo Width (px)', 'lawfirm-pro' ),
            'section'     => 'title_tagline',
            'input_attrs' => array(
                'min'  => 50,
                'max'  => 400,
                'step' => 5,
            ),
        )
    ) );

    // Logo Height
    $wp_customize->add_setting( 'logo_height', array(
        'default'           => 60,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new LawFirm_Pro_Range_Control(
        $wp_customize,
        'logo_height',
        array(
            'label'       => esc_html__( 'Logo Height (px)', 'lawfirm-pro' ),
            'section'     => 'title_tagline',
            'input_attrs' => array(
                'min'  => 30,
                'max'  => 200,
                'step' => 5,
            ),
        )
    ) );


    /* ========= HOMEPAGE SECTIONS PANEL ========= */
    
    // Create a new panel for Homepage Sections
    $wp_customize->add_panel( 'homepage_sections_panel', array(
        'title'       => esc_html__( 'Homepage Sections', 'lawfirm-pro' ),
        'description' => esc_html__( 'Manage content for all homepage sections', 'lawfirm-pro' ),
        'priority'    => 30,
    ) );


    /* ========= HERO SECTION (Moved to Homepage Sections Panel) ========= */

    // Hero Section - now under Homepage Sections panel
    $wp_customize->add_section( 'hero_section', array(
        'title'       => esc_html__( 'Hero Section', 'lawfirm-pro' ),
        'description' => esc_html__( 'Customize the hero section content (appears at the top after navbar)', 'lawfirm-pro' ),
        'panel'       => 'homepage_sections_panel',
        'priority'    => 10,
    ) );

    $wp_customize->add_setting( 'hero_title', array(
        'default'           => esc_html__( 'Experienced Legal Representation', 'lawfirm-pro' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'hero_title', array(
        'label'   => esc_html__( 'Hero Title', 'lawfirm-pro' ),
        'section' => 'hero_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'hero_subtitle', array(
        'default'           => esc_html__( 'Protecting your rights with integrity and excellence', 'lawfirm-pro' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'hero_subtitle', array(
        'label'   => esc_html__( 'Hero Subtitle', 'lawfirm-pro' ),
        'section' => 'hero_section',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'hero_button_text', array(
        'default'           => esc_html__( 'Free Consultation', 'lawfirm-pro' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'hero_button_text', array(
        'label'   => esc_html__( 'Button Text', 'lawfirm-pro' ),
        'section' => 'hero_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'hero_button_url', array(
        'default'           => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'hero_button_url', array(
        'label'   => esc_html__( 'Button URL', 'lawfirm-pro' ),
        'section' => 'hero_section',
        'type'    => 'url',
    ) );


    /* ========= FAQ SECTION (Moved to Homepage Sections Panel) ========= */

    // FAQ Section - now under Homepage Sections panel
    $wp_customize->add_section( 'faq_section', array(
        'title'       => esc_html__( 'FAQ Section', 'lawfirm-pro' ),
        'description' => esc_html__( 'Manage FAQ items and statistics displayed on the homepage', 'lawfirm-pro' ),
        'panel'       => 'homepage_sections_panel',
        'priority'    => 20,
    ) );

    // FAQ Items Repeater
    $wp_customize->add_setting( 'lawfirm_faq_items', array(
        'default'           => '',
        'sanitize_callback' => 'lawfirm_pro_sanitize_faq_repeater',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new LawFirm_Pro_FAQ_Repeater_Control(
        $wp_customize,
        'lawfirm_faq_items',
        array(
            'label'       => esc_html__( 'FAQ Items', 'lawfirm-pro' ),
            'description' => esc_html__( 'Add, edit, or remove FAQ items', 'lawfirm-pro' ),
            'section'     => 'faq_section',
        )
    ) );

    // Statistics - Cases Won Number
    $wp_customize->add_setting( 'lawfirm_cases_won_number', array(
        'default'           => '500',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'lawfirm_cases_won_number', array(
        'label'   => esc_html__( 'Cases Won - Number', 'lawfirm-pro' ),
        'section' => 'faq_section',
        'type'    => 'number',
    ) );

    // Statistics - Cases Won Label
    $wp_customize->add_setting( 'lawfirm_cases_won_label', array(
        'default'           => 'Cases Won',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'lawfirm_cases_won_label', array(
        'label'   => esc_html__( 'Cases Won - Label', 'lawfirm-pro' ),
        'section' => 'faq_section',
        'type'    => 'text',
    ) );

    // Statistics - Attorneys Number
    $wp_customize->add_setting( 'lawfirm_attorneys_number', array(
        'default'           => '50',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'lawfirm_attorneys_number', array(
        'label'   => esc_html__( 'Attorneys - Number', 'lawfirm-pro' ),
        'section' => 'faq_section',
        'type'    => 'number',
    ) );

    // Statistics - Attorneys Label
    $wp_customize->add_setting( 'lawfirm_attorneys_label', array(
        'default'           => 'Expert Attorneys',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'lawfirm_attorneys_label', array(
        'label'   => esc_html__( 'Attorneys - Label', 'lawfirm-pro' ),
        'section' => 'faq_section',
        'type'    => 'text',
    ) );

    // Statistics - Practice Areas Number
    $wp_customize->add_setting( 'lawfirm_practice_areas_number', array(
        'default'           => '25',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'lawfirm_practice_areas_number', array(
        'label'   => esc_html__( 'Practice Areas - Number', 'lawfirm-pro' ),
        'section' => 'faq_section',
        'type'    => 'number',
    ) );

    // Statistics - Practice Areas Label
    $wp_customize->add_setting( 'lawfirm_practice_areas_label', array(
        'default'           => 'Practice Areas',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'lawfirm_practice_areas_label', array(
        'label'   => esc_html__( 'Practice Areas - Label', 'lawfirm-pro' ),
        'section' => 'faq_section',
        'type'    => 'text',
    ) );

}
add_action( 'customize_register', 'lawfirm_pro_customize_register' );


/* =========================================
   Sanitize FAQ Repeater
========================================= */
function lawfirm_pro_sanitize_faq_repeater( $input ) {
    $decoded = json_decode( $input, true );
    
    if ( ! is_array( $decoded ) ) {
        return '';
    }
    
    $sanitized = array();
    foreach ( $decoded as $item ) {
        if ( isset( $item['question'] ) || isset( $item['answer'] ) ) {
            $sanitized[] = array(
                'question' => isset( $item['question'] ) ? sanitize_text_field( $item['question'] ) : '',
                'answer'   => isset( $item['answer'] ) ? sanitize_textarea_field( $item['answer'] ) : '',
            );
        }
    }
    
    return json_encode( $sanitized );
}


/* =========================================
   Output Logo CSS Dynamically
========================================= */
function lawfirm_pro_logo_css() {

    $logo_width  = get_theme_mod( 'logo_width', 150 );
    $logo_height = get_theme_mod( 'logo_height', 60 );
    ?>
    <style>
        .custom-logo-link {
            display: flex;
            align-items: center;
        }

        .custom-logo {
            width: <?php echo esc_attr( $logo_width ); ?>px;
            height: <?php echo esc_attr( $logo_height ); ?>px;
            object-fit: contain;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'lawfirm_pro_logo_css' );


/* =========================================
   FOOTER SOCIAL MEDIA SECTION
========================================= */
function lawfirm_pro_footer_social_customize_register( $wp_customize ) {
    
    // Add Footer Section
    $wp_customize->add_section( 'footer_social_section', array(
        'title'       => esc_html__( 'Footer Social Media', 'lawfirm-pro' ),
        'description' => esc_html__( 'Manage social media links in footer', 'lawfirm-pro' ),
        'priority'    => 120,
    ) );

    // Twitter/X
    $wp_customize->add_setting( 'footer_twitter_enable', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'footer_twitter_enable', array(
        'label'   => esc_html__( 'Enable Twitter/X', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'footer_twitter_url', array(
        'default'           => 'https://twitter.com',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_twitter_url', array(
        'label'   => esc_html__( 'Twitter/X URL', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'url',
    ) );

    // Facebook
    $wp_customize->add_setting( 'footer_facebook_enable', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'footer_facebook_enable', array(
        'label'   => esc_html__( 'Enable Facebook', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'footer_facebook_url', array(
        'default'           => 'https://facebook.com',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_facebook_url', array(
        'label'   => esc_html__( 'Facebook URL', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'url',
    ) );

    // YouTube
    $wp_customize->add_setting( 'footer_youtube_enable', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'footer_youtube_enable', array(
        'label'   => esc_html__( 'Enable YouTube', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'footer_youtube_url', array(
        'default'           => 'https://youtube.com',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_youtube_url', array(
        'label'   => esc_html__( 'YouTube URL', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'url',
    ) );

    // LinkedIn
    $wp_customize->add_setting( 'footer_linkedin_enable', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'footer_linkedin_enable', array(
        'label'   => esc_html__( 'Enable LinkedIn', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'footer_linkedin_url', array(
        'default'           => 'https://linkedin.com',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_linkedin_url', array(
        'label'   => esc_html__( 'LinkedIn URL', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'url',
    ) );

    // Instagram
    $wp_customize->add_setting( 'footer_instagram_enable', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'footer_instagram_enable', array(
        'label'   => esc_html__( 'Enable Instagram', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'footer_instagram_url', array(
        'default'           => 'https://instagram.com',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_instagram_url', array(
        'label'   => esc_html__( 'Instagram URL', 'lawfirm-pro' ),
        'section' => 'footer_social_section',
        'type'    => 'url',
    ) );
}
add_action( 'customize_register', 'lawfirm_pro_footer_social_customize_register' );


/* =========================================
   LOCATION/MAP SECTION
========================================= */
function lawfirm_pro_location_map_customize_register( $wp_customize ) {
    
    // Add Location/Map Section
    $wp_customize->add_section( 'location_map_section', array(
        'title'       => esc_html__( 'Location/Map Section', 'lawfirm-pro' ),
        'description' => esc_html__( 'Manage Google Maps embed code for your location', 'lawfirm-pro' ),
        'priority'    => 125,
    ) );

    // Enable/Disable Map
    $wp_customize->add_setting( 'location_map_enable', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'location_map_enable', array(
        'label'       => esc_html__( 'Enable Location Map', 'lawfirm-pro' ),
        'description' => esc_html__( 'Show/hide the location map on your website', 'lawfirm-pro' ),
        'section'     => 'location_map_section',
        'type'        => 'checkbox',
    ) );

    // Map Iframe Code
    $wp_customize->add_setting( 'location_map_iframe', array(
        'default'           => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4347.103267097102!2d85.33760347611336!3d27.689982226255896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19005abd0c41%3A0xaf0808f7ef57c1a5!2sGenius%20Law%20and%20Associates!5e1!3m2!1sen!2snp!4v1775798509450!5m2!1sen!2snp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        'sanitize_callback' => 'lawfirm_pro_sanitize_iframe',
    ) );
    $wp_customize->add_control( 'location_map_iframe', array(
        'label'       => esc_html__( 'Google Maps Embed Code', 'lawfirm-pro' ),
        'description' => esc_html__( 'Paste your Google Maps iframe embed code here. Click "Use Default Map" button below to load Genius Law location.', 'lawfirm-pro' ),
        'section'     => 'location_map_section',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows' => 6,
            'placeholder' => '<iframe src="..." width="100%" height="450" ...></iframe>',
        ),
    ) );

    // Add custom HTML control with instructions and button
    $wp_customize->add_setting( 'location_map_instructions', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( new LawFirm_Pro_Custom_HTML_Control(
        $wp_customize,
        'location_map_instructions',
        array(
            'label'       => esc_html__( 'Quick Setup', 'lawfirm-pro' ),
            'section'     => 'location_map_section',
            'description' => '',
        )
    ) );

    // Map Section Title
    $wp_customize->add_setting( 'location_map_title', array(
        'default'           => 'Our Location',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'location_map_title', array(
        'label'   => esc_html__( 'Map Section Title', 'lawfirm-pro' ),
        'section' => 'location_map_section',
        'type'    => 'text',
    ) );

    // Map Section Description
    $wp_customize->add_setting( 'location_map_description', array(
        'default'           => 'Visit us at our office location',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'location_map_description', array(
        'label'   => esc_html__( 'Map Section Description', 'lawfirm-pro' ),
        'section' => 'location_map_section',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'lawfirm_pro_location_map_customize_register' );

/* =========================================
   Sanitize iframe code
========================================= */
function lawfirm_pro_sanitize_iframe( $input ) {
    // Allow iframe tags with specific attributes
    $allowed_html = array(
        'iframe' => array(
            'src'                   => true,
            'width'                 => true,
            'height'                => true,
            'style'                 => true,
            'allowfullscreen'       => true,
            'loading'               => true,
            'referrerpolicy'        => true,
            'frameborder'           => true,
            'allow'                 => true,
        ),
    );
    return wp_kses( $input, $allowed_html );
}

/* =========================================
   Add JavaScript for Default Map Button
========================================= */
function lawfirm_pro_customizer_scripts() {
    ?>
    <script type="text/javascript">
    (function($) {
        wp.customize.bind('ready', function() {
            // Handle "Use Default Map" button click
            $(document).on('click', '#use-default-map-btn', function(e) {
                e.preventDefault();
                
                // Default Genius Law and Associates map iframe
                var defaultMapIframe = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4347.103267097102!2d85.33760347611336!3d27.689982226255896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19005abd0c41%3A0xaf0808f7ef57c1a5!2sGenius%20Law%20and%20Associates!5e1!3m2!1sen!2snp!4v1775798509450!5m2!1sen!2snp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                
                // Set the value in the customizer
                wp.customize('location_map_iframe').set(defaultMapIframe);
                
                // Change button text temporarily
                var $btn = $(this);
                var originalText = $btn.text();
                $btn.text('✓ Default Map Loaded!').css('background-color', '#46b450');
                
                // Reset button after 2 seconds
                setTimeout(function() {
                    $btn.text(originalText).css('background-color', '');
                }, 2000);
            });
        });
    })(jQuery);
    </script>
    <?php
}
add_action( 'customize_controls_print_footer_scripts', 'lawfirm_pro_customizer_scripts' );
