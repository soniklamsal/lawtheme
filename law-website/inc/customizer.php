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
