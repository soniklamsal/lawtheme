<?php
/**
 * Template Name: Contact Page
 *
 * @package LawFirm_Pro
 */

get_header();
?>

<style>
    .font-serif-display { 
        font-family: 'DM Serif Display', serif; 
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <div class="pt-32 px-6 mb-16">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-2 tracking-tight text-[#1A2B3C]">
                Get In <span class="text-[#26cf71]">Touch</span>
            </h1>
            <p class="text-lg font-medium opacity-90 text-gray-700">
                We're here to help with your legal matters. Contact us today for a free consultation.
            </p>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="py-0 px-4 md:px-8">
    <div class="max-w-6xl mx-auto shadow-2xl rounded-3xl overflow-hidden bg-white flex flex-col lg:flex-row">
        <!-- Left Side - Contact Info -->
        <div class="lg:w-5/12 bg-[#1A2B3C] text-white p-10 md:p-14 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-[#26cf71] rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-[#1eb863] rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            
            <div class="relative z-10">
                <h3 class="text-3xl md:text-4xl font-serif-display mb-6"><?php echo esc_html( get_option( 'lawfirm_contact_section_title', 'Contact Information' ) ); ?></h3>
                <p class="text-blue-100 text-lg mb-10 font-light leading-relaxed">
                    <?php echo esc_html( get_option( 'lawfirm_contact_section_description', 'Have questions about our legal services? Contact us and our team will guide you through your legal matters.' ) ); ?>
                </p>
                
                <div class="space-y-6">
                    <!-- Phone -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-[#26cf71] transition-colors duration-300 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-blue-200 font-semibold uppercase tracking-wider">Call Us</p>
                            <p class="text-lg"><?php echo esc_html( get_option( 'lawfirm_contact_phone_1', '+977-1-4497707' ) ); ?></p>
                            <p class="text-lg"><?php echo esc_html( get_option( 'lawfirm_contact_phone_2', '+977-1-4472741' ) ); ?></p>
                        </div>
                    </div>
                    
                    <!-- Mobile -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-[#26cf71] transition-colors duration-300 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-blue-200 font-semibold uppercase tracking-wider">Mobile</p>
                            <p class="text-lg"><?php echo esc_html( get_option( 'lawfirm_contact_mobile_1', '+977-9851063500' ) ); ?></p>
                            <p class="text-lg"><?php echo esc_html( get_option( 'lawfirm_contact_mobile_2', '+977-9741141964' ) ); ?></p>
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-[#26cf71] transition-colors duration-300 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-blue-200 font-semibold uppercase tracking-wider">Email</p>
                            <p class="text-lg break-all"><?php echo esc_html( get_option( 'lawfirm_contact_email_1', 'genilawasso@gmail.com' ) ); ?></p>
                            <p class="text-lg break-all"><?php echo esc_html( get_option( 'lawfirm_contact_email_2', 'gyanrshakya@gmail.com' ) ); ?></p>
                        </div>
                    </div>
                    
                    <!-- Location -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-[#26cf71] transition-colors duration-300 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-blue-200 font-semibold uppercase tracking-wider">Location</p>
                            <p class="text-lg leading-tight"><?php echo esc_html( get_option( 'lawfirm_contact_location', 'Kali Marg, Naya Baneshwar, Baneshwar, Kathmandu-31, Kathmandu Metropolitan City, Kathmandu, Bagamati Province, 44703, Nepal' ) ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div class="relative z-10 mt-12 flex gap-4">
                <?php 
                $facebook_url = get_option( 'lawfirm_contact_facebook', 'https://facebook.com' );
                $twitter_url = get_option( 'lawfirm_contact_twitter', 'https://twitter.com' );
                $linkedin_url = get_option( 'lawfirm_contact_linkedin', 'https://linkedin.com' );
                ?>
                
                <?php if ( ! empty( $facebook_url ) ) : ?>
                <a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-blue-400 flex items-center justify-center hover:bg-white hover:text-[#1A2B3C] transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24,12c0,6.627 -5.373,12 -12,12c-6.627,0 -12,-5.373 -12,-12c0,-6.627 5.373,-12 12,-12c6.627,0 12,5.373 12,12Zm-11.278,0l1.294,0l0.172,-1.617l-1.466,0l0.002,-0.808c0,-0.422 0.04,-0.648 0.646,-0.648l0.809,0l0,-1.616l-1.295,0c-1.555,0 -2.103,0.784 -2.103,2.102l0,0.97l-0.969,0l0,1.617l0.969,0l0,4.689l1.941,0l0,-4.689Z"></path>
                    </svg>
                </a>
                <?php endif; ?>
                
                <?php if ( ! empty( $twitter_url ) ) : ?>
                <a href="<?php echo esc_url( $twitter_url ); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-blue-400 flex items-center justify-center hover:bg-white hover:text-[#1A2B3C] transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24,12c0,6.627 -5.373,12 -12,12c-6.627,0 -12,-5.373 -12,-12c0,-6.627 5.373,-12 12,-12c6.627,0 12,5.373 12,12Zm-6.465,-3.192c-0.379,0.168 -0.786,0.281 -1.213,0.333c0.436,-0.262 0.771,-0.676 0.929,-1.169c-0.408,0.242 -0.86,0.418 -1.341,0.513c-0.385,-0.411 -0.934,-0.667 -1.541,-0.667c-1.167,0 -2.112,0.945 -2.112,2.111c0,0.166 0.018,0.327 0.054,0.482c-1.754,-0.088 -3.31,-0.929 -4.352,-2.206c-0.181,0.311 -0.286,0.674 -0.286,1.061c0,0.733 0.373,1.379 0.94,1.757c-0.346,-0.01 -0.672,-0.106 -0.956,-0.264c-0.001,0.009 -0.001,0.018 -0.001,0.027c0,1.023 0.728,1.877 1.694,2.07c-0.177,0.049 -0.364,0.075 -0.556,0.075c-0.137,0 -0.269,-0.014 -0.397,-0.038c0.268,0.838 1.048,1.449 1.972,1.466c-0.723,0.566 -1.633,0.904 -2.622,0.904c-0.171,0 -0.339,-0.01 -0.504,-0.03c0.934,0.599 2.044,0.949 3.237,0.949c3.883,0 6.007,-3.217 6.007,-6.008c0,-0.091 -0.002,-0.183 -0.006,-0.273c0.413,-0.298 0.771,-0.67 1.054,-1.093Z"></path>
                    </svg>
                </a>
                <?php endif; ?>
                
                <?php if ( ! empty( $linkedin_url ) ) : ?>
                <a href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-blue-400 flex items-center justify-center hover:bg-white hover:text-[#1A2B3C] transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7.3,0.9c1.5,-0.6 3.1,-0.9 4.7,-0.9c1.6,0 3.2,0.3 4.7,0.9c1.5,0.6 2.8,1.5 3.8,2.6c1,1.1 1.9,2.3 2.6,3.8c0.7,1.5 0.9,3 0.9,4.7c0,1.7 -0.3,3.2 -0.9,4.7c-0.6,1.5 -1.5,2.8 -2.6,3.8c-1.1,1 -2.3,1.9 -3.8,2.6c-1.5,0.7 -3.1,0.9 -4.7,0.9c-1.6,0 -3.2,-0.3 -4.7,-0.9c-1.5,-0.6 -2.8,-1.5 -3.8,-2.6c-1,-1.1 -1.9,-2.3 -2.6,-3.8c-0.7,-1.5 -0.9,-3.1 -0.9,-4.7c0,-1.6 0.3,-3.2 0.9,-4.7c0.6,-1.5 1.5,-2.8 2.6,-3.8c1.1,-1 2.3,-1.9 3.8,-2.6Zm-0.3,7.1c0.6,0 1.1,-0.2 1.5,-0.5c0.4,-0.3 0.5,-0.8 0.5,-1.3c0,-0.5 -0.2,-0.9 -0.6,-1.2c-0.4,-0.3 -0.8,-0.5 -1.4,-0.5c-0.6,0 -1.1,0.2 -1.4,0.5c-0.3,0.3 -0.6,0.7 -0.6,1.2c0,0.5 0.2,0.9 0.5,1.3c0.3,0.4 0.9,0.5 1.5,0.5Zm1.5,10l0,-8.5l-3,0l0,8.5l3,0Zm11,0l0,-4.5c0,-1.4 -0.3,-2.5 -0.9,-3.3c-0.6,-0.8 -1.5,-1.2 -2.6,-1.2c-0.6,0 -1.1,0.2 -1.5,0.5c-0.4,0.3 -0.8,0.8 -0.9,1.3l-0.1,-1.3l-3,0l0.1,2l0,6.5l3,0l0,-4.5c0,-0.6 0.1,-1.1 0.4,-1.5c0.3,-0.4 0.6,-0.5 1.1,-0.5c0.5,0 0.9,0.2 1.1,0.5c0.2,0.3 0.4,0.8 0.4,1.5l0,4.5l2.9,0Z"></path>
                    </svg>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Right Side - Contact Form -->
        <div class="lg:w-7/12 p-10 md:p-14 bg-white relative">
            <h2 class="text-4xl md:text-5xl font-serif-display text-gray-800 mb-2">
                Let's Start Your <span class="text-[#26cf71] italic">Legal Journey</span>
            </h2>
            <p class="text-gray-500 mb-8">Fill out the form and we'll respond within 24 hours.</p>
            
            <!-- Toast Notification -->
            <div id="toast-notification" class="hidden fixed top-24 right-4 z-50 max-w-md w-full bg-white shadow-2xl rounded-lg overflow-hidden border-l-4 transform transition-all duration-300 ease-in-out">
                <div class="p-4 flex items-start gap-3">
                    <div id="toast-icon" class="flex-shrink-0"></div>
                    <div class="flex-1">
                        <p id="toast-message" class="text-sm font-medium text-gray-800"></p>
                    </div>
                    <button onclick="closeToast()" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="contact-form" class="space-y-6">
                <?php wp_nonce_field( 'lawfirm_contact_form', 'lawfirm_contact_nonce' ); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-semibold text-gray-600">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="contact_name" placeholder="John Doe" required
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-semibold text-gray-600">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="contact_email" placeholder="hello@example.com" required
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="phone" class="text-sm font-semibold text-gray-600">Phone</label>
                        <input type="tel" id="phone" name="contact_phone" placeholder="+977 9800000000"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="subject" class="text-sm font-semibold text-gray-600">Subject <span class="text-red-500">*</span></label>
                        <input type="text" id="subject" name="contact_subject" placeholder="Enter subject" required
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300">
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label for="message" class="text-sm font-semibold text-gray-600">Message <span class="text-red-500">*</span></label>
                    <textarea id="message" name="contact_message" rows="5" placeholder="Write your message..." required
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300"></textarea>
                </div>
                
                <button type="submit" id="submit-btn"
                    class="px-8 py-3 bg-[#26cf71] text-white font-semibold rounded-lg shadow-md hover:bg-[#1eb863] transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="btn-text">Send Message</span>
                    <span id="btn-loader" class="hidden">
                        <svg class="inline w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>
            
            <script>
            (function() {
                'use strict';
                
                const form = document.getElementById('contact-form');
                const submitBtn = document.getElementById('submit-btn');
                const btnText = document.getElementById('btn-text');
                const btnLoader = document.getElementById('btn-loader');
                
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Disable button and show loader
                    submitBtn.disabled = true;
                    btnText.classList.add('hidden');
                    btnLoader.classList.remove('hidden');
                    
                    // Get form data
                    const formData = new FormData(form);
                    formData.append('action', 'lawfirm_contact_form');
                    formData.append('nonce', document.getElementById('lawfirm_contact_nonce').value);
                    
                    // Send AJAX request
                    fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Re-enable button
                        submitBtn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnLoader.classList.add('hidden');
                        
                        if (data.success) {
                            // Show success toast
                            showToast(data.data.message, 'success');
                            // Reset form
                            form.reset();
                        } else {
                            // Show error toast
                            showToast(data.data.message, 'error');
                        }
                    })
                    .catch(error => {
                        // Re-enable button
                        submitBtn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnLoader.classList.add('hidden');
                        
                        // Show error toast
                        showToast('An error occurred. Please try again.', 'error');
                    });
                });
                
                window.showToast = function(message, type) {
                    const toast = document.getElementById('toast-notification');
                    const toastMessage = document.getElementById('toast-message');
                    const toastIcon = document.getElementById('toast-icon');
                    
                    // Set message
                    toastMessage.textContent = message;
                    
                    // Set icon and border color based on type
                    if (type === 'success') {
                        toast.style.borderLeftColor = '#26cf71';
                        toastIcon.innerHTML = '<svg class="w-6 h-6 text-[#26cf71]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                    } else {
                        toast.style.borderLeftColor = '#ef4444';
                        toastIcon.innerHTML = '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                    }
                    
                    // Show toast
                    toast.classList.remove('hidden');
                    toast.style.transform = 'translateX(0)';
                    
                    // Auto hide after 5 seconds
                    setTimeout(function() {
                        closeToast();
                    }, 5000);
                };
                
                window.closeToast = function() {
                    const toast = document.getElementById('toast-notification');
                    toast.style.transform = 'translateX(400px)';
                    setTimeout(function() {
                        toast.classList.add('hidden');
                    }, 300);
                };
            })();
            </script>
            </form>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 px-4 md:px-8 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-[#1A2B3C] mb-4">
                <?php 
                $map_title = get_theme_mod( 'map_section_title', 'Find Our Office' );
                $title_parts = explode( ' ', $map_title );
                if ( count( $title_parts ) > 1 ) {
                    $last_word = array_pop( $title_parts );
                    echo esc_html( implode( ' ', $title_parts ) ) . ' <span class="text-[#26cf71]">' . esc_html( $last_word ) . '</span>';
                } else {
                    echo esc_html( $map_title );
                }
                ?>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                <?php echo esc_html( get_theme_mod( 'map_section_description', 'Visit us at our office in Kathmandu for in-person consultations and legal assistance.' ) ); ?>
            </p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Map Full Width -->
            <div class="h-96 lg:h-[500px] relative">
                <?php 
                $map_latitude = get_theme_mod( 'map_latitude', '27.7172' );
                $map_longitude = get_theme_mod( 'map_longitude', '85.3240' );
                $map_location = get_theme_mod( 'map_location', 'Kathmandu, Nepal' );
                
                // Generate Google Maps embed URL from coordinates
                $map_embed_url = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=' . $map_latitude . ',' . $map_longitude . '&zoom=15';
                
                // Generate direct link URL
                $map_link_url = 'https://www.google.com/maps?q=' . $map_latitude . ',' . $map_longitude;
                ?>
                <iframe 
                    src="<?php echo esc_url( $map_embed_url ); ?>"
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="absolute inset-0">
                </iframe>
                
                <!-- Map Overlay for Better UX -->
                <div class="absolute top-4 right-4 bg-white rounded-lg shadow-lg p-3">
                    <a href="<?php echo esc_url( $map_link_url ); ?>" target="_blank" 
                       class="flex items-center gap-2 text-sm font-semibold text-[#1A2B3C] hover:text-[#26cf71] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Open in Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
