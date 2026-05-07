<?php
/**
 * Template Name: About Page
 * 
 * Static About page template - all content is hardcoded
 *
 * @package LawFirm_Pro
 */

get_header();

// Get About Hero section data from theme mods
$abouthero_title = get_theme_mod( 'abouthero_title', 'About <span class="text-[#26cf71]">Genius Law</span>' );
$abouthero_subtitle = get_theme_mod( 'abouthero_subtitle', 'Your trusted legal partner with over 25 years of excellence' );

// Get About Status section data from theme mods
$aboutstatus_title = get_theme_mod( 'aboutstatus_title', 'Our <span class="text-[#26cf71]">Status</span>' );
$aboutstatus_content_1 = get_theme_mod( 'aboutstatus_content_1', "Genius Law and Associates was founded with common mission of faire justice for the victim's People / Clients; to provide exceptional Legal services with integrity, dedication and expertise, for ours 25 years. It's has been serving Individuals, Families, Industrials Businesses, Banking and Corporate an across of Nepal." );
$aboutstatus_content_2 = get_theme_mod( 'aboutstatus_content_2', "It's firm has grown from a Legal practice to be one the most respected services providers in the region. It's pride ourselves on our commitment to our clients and our track record of successful outcomes its mission." );
$aboutstatus_years = get_theme_mod( 'aboutstatus_years', '25' );
$aboutstatus_image = get_theme_mod( 'aboutstatus_image', 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800' );

// Get About Values section data from theme mods
$aboutvalues_title = get_theme_mod( 'aboutvalues_title', 'Our Core <span class="text-[#26cf71]">Values</span>' );
$aboutvalues_subtitle = get_theme_mod( 'aboutvalues_subtitle', 'These principles guide everything we do and define who we are as a firm' );
$aboutvalues_1_title = get_theme_mod( 'aboutvalues_1_title', 'Integrity' );
$aboutvalues_1_desc = get_theme_mod( 'aboutvalues_1_desc', 'We uphold the highest ethical standards in all our dealings, ensuring honesty and transparency with every client.' );
$aboutvalues_2_title = get_theme_mod( 'aboutvalues_2_title', 'Excellence' );
$aboutvalues_2_desc = get_theme_mod( 'aboutvalues_2_desc', 'We strive for excellence in every case, combining legal expertise with innovative strategies to achieve the best outcomes.' );
$aboutvalues_3_title = get_theme_mod( 'aboutvalues_3_title', 'Client-Focused' );
$aboutvalues_3_desc = get_theme_mod( 'aboutvalues_3_desc', 'Your needs are our priority. We provide personalized attention and tailored legal solutions for each unique situation.' );

// Get About Choose Us section data from theme mods
$aboutchooseus_title = get_theme_mod( 'aboutchooseus_title', 'Why Choose <span class="text-[#26cf71]">Genius Law</span>' );
$aboutchooseus_subtitle = get_theme_mod( 'aboutchooseus_subtitle', 'We stand out from other law firms through our commitment to excellence and client satisfaction' );
$aboutchooseus_1_title = get_theme_mod( 'aboutchooseus_1_title', 'Proven Track Record' );
$aboutchooseus_1_desc = get_theme_mod( 'aboutchooseus_1_desc', 'Over 500 successful cases with a high success rate across all practice areas.' );
$aboutchooseus_2_title = get_theme_mod( 'aboutchooseus_2_title', '24/7 Availability' );
$aboutchooseus_2_desc = get_theme_mod( 'aboutchooseus_2_desc', "We're here when you need us most, with round-the-clock support for urgent matters." );
$aboutchooseus_3_title = get_theme_mod( 'aboutchooseus_3_title', 'Transparent Pricing' );
$aboutchooseus_3_desc = get_theme_mod( 'aboutchooseus_3_desc', 'Clear, upfront pricing with no hidden fees. We offer flexible payment plans.' );
$aboutchooseus_4_title = get_theme_mod( 'aboutchooseus_4_title', 'Expert Team' );
$aboutchooseus_4_desc = get_theme_mod( 'aboutchooseus_4_desc', '50+ experienced attorneys specializing in 25+ different areas of law.' );
$aboutchooseus_5_title = get_theme_mod( 'aboutchooseus_5_title', 'Nationwide Coverage' );
$aboutchooseus_5_desc = get_theme_mod( 'aboutchooseus_5_desc', 'Serving clients across Nepal with representation in all major courts.' );
$aboutchooseus_6_title = get_theme_mod( 'aboutchooseus_6_title', 'Confidentiality Guaranteed' );
$aboutchooseus_6_desc = get_theme_mod( 'aboutchooseus_6_desc', 'Your privacy is paramount. All communications are strictly confidential.' );

// Get About CTA section data from theme mods
$aboutcta_title = get_theme_mod( 'aboutcta_title', 'Ready to Get Started?' );
$aboutcta_subtitle = get_theme_mod( 'aboutcta_subtitle', 'Schedule a free consultation with our expert legal team today' );
$aboutcta_btn1_text = get_theme_mod( 'aboutcta_btn1_text', 'Call Us Now' );
$aboutcta_btn1_url = get_theme_mod( 'aboutcta_btn1_url', 'tel:+97714497707' );
$aboutcta_btn2_text = get_theme_mod( 'aboutcta_btn2_text', 'Email Us' );
$aboutcta_btn2_url = get_theme_mod( 'aboutcta_btn2_url', 'mailto:genilawasso@gmail.com' );
?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <div class="pt-32 px-6 mb-16">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-2 tracking-tight text-[#1A2B3C]">
                <?php echo wp_kses_post( $abouthero_title ); ?>
            </h1>
            <p class="text-lg font-medium opacity-90 text-gray-700">
                <?php echo esc_html( $abouthero_subtitle ); ?>
            </p>
        </div>
    </div>

    <!-- Our Status Section -->
    <section class="bg-white py-0 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-[#1A2B3C] mb-6">
                        <?php echo wp_kses_post( $aboutstatus_title ); ?>
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        <?php echo esc_html( $aboutstatus_content_1 ); ?>
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        <?php echo esc_html( $aboutstatus_content_2 ); ?>
                    </p>
                </div>
                <div class="relative">
                    <img src="<?php echo esc_url( $aboutstatus_image ); ?>" 
                         alt="Law Office" 
                         class="rounded-2xl shadow-2xl w-full h-[400px] object-cover">
                    <div class="absolute -bottom-6 -left-6 bg-[#26cf71] text-white p-6 rounded-xl shadow-xl">
                        <div class="text-4xl font-bold"><?php echo esc_html( $aboutstatus_years ); ?>+</div>
                        <div class="text-sm font-medium">Years of Excellence</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="bg-white py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-[#1A2B3C] mb-4">
                    <?php echo wp_kses_post( $aboutvalues_title ); ?>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    <?php echo esc_html( $aboutvalues_subtitle ); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-[#26cf71] rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#1A2B3C] mb-3"><?php echo esc_html( $aboutvalues_1_title ); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo esc_html( $aboutvalues_1_desc ); ?>
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-[#26cf71] rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#1A2B3C] mb-3"><?php echo esc_html( $aboutvalues_2_title ); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo esc_html( $aboutvalues_2_desc ); ?>
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-[#26cf71] rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#1A2B3C] mb-3"><?php echo esc_html( $aboutvalues_3_title ); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo esc_html( $aboutvalues_3_desc ); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="bg-gray-50 py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-[#1A2B3C] mb-4">
                    <?php echo wp_kses_post( $aboutchooseus_title ); ?>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    <?php echo esc_html( $aboutchooseus_subtitle ); ?>
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Reason 1 -->
                <div class="bg-white rounded-xl p-6 flex gap-4 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-[#26cf71]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#26cf71]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#1A2B3C] mb-2"><?php echo esc_html( $aboutchooseus_1_title ); ?></h3>
                        <p class="text-gray-600"><?php echo esc_html( $aboutchooseus_1_desc ); ?></p>
                    </div>
                </div>

                <!-- Reason 2 -->
                <div class="bg-white rounded-xl p-6 flex gap-4 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-[#26cf71]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#26cf71]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#1A2B3C] mb-2"><?php echo esc_html( $aboutchooseus_2_title ); ?></h3>
                        <p class="text-gray-600"><?php echo esc_html( $aboutchooseus_2_desc ); ?></p>
                    </div>
                </div>

                <!-- Reason 3 -->
                <div class="bg-white rounded-xl p-6 flex gap-4 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-[#26cf71]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#26cf71]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#1A2B3C] mb-2"><?php echo esc_html( $aboutchooseus_3_title ); ?></h3>
                        <p class="text-gray-600"><?php echo esc_html( $aboutchooseus_3_desc ); ?></p>
                    </div>
                </div>

                <!-- Reason 4 -->
                <div class="bg-white rounded-xl p-6 flex gap-4 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-[#26cf71]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#26cf71]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#1A2B3C] mb-2"><?php echo esc_html( $aboutchooseus_4_title ); ?></h3>
                        <p class="text-gray-600"><?php echo esc_html( $aboutchooseus_4_desc ); ?></p>
                    </div>
                </div>

                <!-- Reason 5 -->
                <div class="bg-white rounded-xl p-6 flex gap-4 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-[#26cf71]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#26cf71]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#1A2B3C] mb-2"><?php echo esc_html( $aboutchooseus_5_title ); ?></h3>
                        <p class="text-gray-600"><?php echo esc_html( $aboutchooseus_5_desc ); ?></p>
                    </div>
                </div>

                <!-- Reason 6 -->
                <div class="bg-white rounded-xl p-6 flex gap-4 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-[#26cf71]/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#26cf71]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#1A2B3C] mb-2"><?php echo esc_html( $aboutchooseus_6_title ); ?></h3>
                        <p class="text-gray-600"><?php echo esc_html( $aboutchooseus_6_desc ); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-white py-16 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-r from-[#26cf71] to-[#1eb863] rounded-2xl p-10 md:p-12 text-center text-white shadow-xl">
                <h3 class="text-3xl font-bold mb-4"><?php echo esc_html( $aboutcta_title ); ?></h3>
                <p class="text-lg mb-8 opacity-95 max-w-2xl mx-auto">
                    <?php echo esc_html( $aboutcta_subtitle ); ?>
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?php echo esc_url( $aboutcta_btn1_url ); ?>" class="bg-white text-[#26cf71] px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <?php echo esc_html( $aboutcta_btn1_text ); ?>
                    </a>
                    <a href="<?php echo esc_url( $aboutcta_btn2_url ); ?>" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition-all duration-300 border-2 border-white/50 hover:border-white inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo esc_html( $aboutcta_btn2_text ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
