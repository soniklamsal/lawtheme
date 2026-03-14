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
                <h3 class="text-3xl md:text-4xl font-serif-display mb-6">Contact Information</h3>
                <p class="text-blue-100 text-lg mb-10 font-light leading-relaxed">
                    Have questions about our legal services? Contact us and our team will guide you through your legal matters.
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
                            <p class="text-lg">+977-1-4497707</p>
                            <p class="text-lg">+977-1-4472741</p>
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
                            <p class="text-lg">+977-9851063500</p>
                            <p class="text-lg">+977-9741141964</p>
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
                            <p class="text-lg break-all">genilawasso@gmail.com</p>
                            <p class="text-lg break-all">gyanrshakya@gmail.com</p>
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
                            <p class="text-lg leading-tight">Kathmandu, Nepal</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div class="relative z-10 mt-12 flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full border border-blue-400 flex items-center justify-center hover:bg-white hover:text-[#1A2B3C] transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24,12c0,6.627 -5.373,12 -12,12c-6.627,0 -12,-5.373 -12,-12c0,-6.627 5.373,-12 12,-12c6.627,0 12,5.373 12,12Zm-11.278,0l1.294,0l0.172,-1.617l-1.466,0l0.002,-0.808c0,-0.422 0.04,-0.648 0.646,-0.648l0.809,0l0,-1.616l-1.295,0c-1.555,0 -2.103,0.784 -2.103,2.102l0,0.97l-0.969,0l0,1.617l0.969,0l0,4.689l1.941,0l0,-4.689Z"></path>
                    </svg>
                </a>
                <a href="#" class="w-10 h-10 rounded-full border border-blue-400 flex items-center justify-center hover:bg-white hover:text-[#1A2B3C] transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24,12c0,6.627 -5.373,12 -12,12c-6.627,0 -12,-5.373 -12,-12c0,-6.627 5.373,-12 12,-12c6.627,0 12,5.373 12,12Zm-6.465,-3.192c-0.379,0.168 -0.786,0.281 -1.213,0.333c0.436,-0.262 0.771,-0.676 0.929,-1.169c-0.408,0.242 -0.86,0.418 -1.341,0.513c-0.385,-0.411 -0.934,-0.667 -1.541,-0.667c-1.167,0 -2.112,0.945 -2.112,2.111c0,0.166 0.018,0.327 0.054,0.482c-1.754,-0.088 -3.31,-0.929 -4.352,-2.206c-0.181,0.311 -0.286,0.674 -0.286,1.061c0,0.733 0.373,1.379 0.94,1.757c-0.346,-0.01 -0.672,-0.106 -0.956,-0.264c-0.001,0.009 -0.001,0.018 -0.001,0.027c0,1.023 0.728,1.877 1.694,2.07c-0.177,0.049 -0.364,0.075 -0.556,0.075c-0.137,0 -0.269,-0.014 -0.397,-0.038c0.268,0.838 1.048,1.449 1.972,1.466c-0.723,0.566 -1.633,0.904 -2.622,0.904c-0.171,0 -0.339,-0.01 -0.504,-0.03c0.934,0.599 2.044,0.949 3.237,0.949c3.883,0 6.007,-3.217 6.007,-6.008c0,-0.091 -0.002,-0.183 -0.006,-0.273c0.413,-0.298 0.771,-0.67 1.054,-1.093Z"></path>
                    </svg>
                </a>
                <a href="#" class="w-10 h-10 rounded-full border border-blue-400 flex items-center justify-center hover:bg-white hover:text-[#1A2B3C] transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7.3,0.9c1.5,-0.6 3.1,-0.9 4.7,-0.9c1.6,0 3.2,0.3 4.7,0.9c1.5,0.6 2.8,1.5 3.8,2.6c1,1.1 1.9,2.3 2.6,3.8c0.7,1.5 0.9,3 0.9,4.7c0,1.7 -0.3,3.2 -0.9,4.7c-0.6,1.5 -1.5,2.8 -2.6,3.8c-1.1,1 -2.3,1.9 -3.8,2.6c-1.5,0.7 -3.1,0.9 -4.7,0.9c-1.6,0 -3.2,-0.3 -4.7,-0.9c-1.5,-0.6 -2.8,-1.5 -3.8,-2.6c-1,-1.1 -1.9,-2.3 -2.6,-3.8c-0.7,-1.5 -0.9,-3.1 -0.9,-4.7c0,-1.6 0.3,-3.2 0.9,-4.7c0.6,-1.5 1.5,-2.8 2.6,-3.8c1.1,-1 2.3,-1.9 3.8,-2.6Zm-0.3,7.1c0.6,0 1.1,-0.2 1.5,-0.5c0.4,-0.3 0.5,-0.8 0.5,-1.3c0,-0.5 -0.2,-0.9 -0.6,-1.2c-0.4,-0.3 -0.8,-0.5 -1.4,-0.5c-0.6,0 -1.1,0.2 -1.4,0.5c-0.3,0.3 -0.6,0.7 -0.6,1.2c0,0.5 0.2,0.9 0.5,1.3c0.3,0.4 0.9,0.5 1.5,0.5Zm1.5,10l0,-8.5l-3,0l0,8.5l3,0Zm11,0l0,-4.5c0,-1.4 -0.3,-2.5 -0.9,-3.3c-0.6,-0.8 -1.5,-1.2 -2.6,-1.2c-0.6,0 -1.1,0.2 -1.5,0.5c-0.4,0.3 -0.8,0.8 -0.9,1.3l-0.1,-1.3l-3,0l0.1,2l0,6.5l3,0l0,-4.5c0,-0.6 0.1,-1.1 0.4,-1.5c0.3,-0.4 0.6,-0.5 1.1,-0.5c0.5,0 0.9,0.2 1.1,0.5c0.2,0.3 0.4,0.8 0.4,1.5l0,4.5l2.9,0Z"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Right Side - Contact Form -->
        <div class="lg:w-7/12 p-10 md:p-14 bg-white relative">
            <h2 class="text-4xl md:text-5xl font-serif-display text-gray-800 mb-2">
                Let's Start Your <span class="text-[#26cf71] italic">Legal Journey</span>
            </h2>
            <p class="text-gray-500 mb-8">Fill out the form and we'll respond within 24 hours.</p>
            
            <form action="#" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-semibold text-gray-600">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="John Doe" required
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-semibold text-gray-600">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="hello@example.com" required
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="phone" class="text-sm font-semibold text-gray-600">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="+977 9800000000"
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="interest" class="text-sm font-semibold text-gray-600">I'm interested in</label>
                        <div class="relative">
                            <select id="interest" name="interest"
                                class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 focus:outline-none focus:border-[#26cf71] focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300 appearance-none">
                                <option value="consultation">Consultation</option>
                                <option value="legal_services">Legal Services</option>
                                <option value="other">Other</option>
                            </select>
                            <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label for="message" class="text-sm font-semibold text-gray-600">Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="Write your message..."
                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#26cf71] focus:bg-white focus:ring-4 focus:ring-[#26cf71]/10 transition-all duration-300"></textarea>
                </div>
                
                <button type="submit"
                    class="px-8 py-3 bg-[#26cf71] text-white font-semibold rounded-lg shadow-md hover:bg-[#1eb863] transition-colors duration-300">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</section>

<?php
get_footer();
