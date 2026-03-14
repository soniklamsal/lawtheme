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


    /* ========= HERO SECTION ========= */

    $wp_customize->add_section( 'hero_section', array(
        'title'    => esc_html__( 'Hero Section', 'lawfirm-pro' ),
        'priority' => 30,
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


    /* ========= CONTACT INFO ========= */

    $wp_customize->add_section( 'contact_info', array(
        'title'    => esc_html__( 'Contact Information', 'lawfirm-pro' ),
        'priority' => 40,
    ) );

    $wp_customize->add_setting( 'contact_phone', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'contact_phone', array(
        'label'   => esc_html__( 'Phone Number', 'lawfirm-pro' ),
        'section' => 'contact_info',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'contact_email', array(
        'sanitize_callback' => 'sanitize_email',
    ) );

    $wp_customize->add_control( 'contact_email', array(
        'label'   => esc_html__( 'Email Address', 'lawfirm-pro' ),
        'section' => 'contact_info',
        'type'    => 'email',
    ) );

    $wp_customize->add_setting( 'contact_address', array(
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'contact_address', array(
        'label'   => esc_html__( 'Address', 'lawfirm-pro' ),
        'section' => 'contact_info',
        'type'    => 'textarea',
    ) );

}
add_action( 'customize_register', 'lawfirm_pro_customize_register' );


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
