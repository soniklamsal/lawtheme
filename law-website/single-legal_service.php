<?php
/**
 * Single Legal Service Template
 *
 * @package LawFirm_Pro
 */

get_header();

while ( have_posts() ) : the_post();
    // Get custom fields
    $provider_name = get_post_meta( get_the_ID(), 'provider_name', true );
    $service_rating = get_post_meta( get_the_ID(), 'service_rating', true );
    $review_count = get_post_meta( get_the_ID(), 'review_count', true );
    
    // Defaults
    if ( ! $provider_name ) $provider_name = 'Genius Law';
    if ( ! $service_rating ) $service_rating = '4.9';
    if ( ! $review_count ) $review_count = '0';
    
    // Get hero image (featured image)
    $hero_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    if ( ! $hero_image ) {
        $hero_image = 'https://worknp.com/images/hero-bg.png';
    }
    
    // Get practice areas for breadcrumb
    $practice_areas = get_the_terms( get_the_ID(), 'practice_area' );
    $primary_practice_area = ! empty( $practice_areas ) && ! is_wp_error( $practice_areas ) ? $practice_areas[0] : null;
?>

<main id="primary" class="site-main">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <!-- Hero Section -->
        <section class="relative w-full h-[400px] flex items-center justify-center bg-cover bg-center text-white px-5" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo esc_url( $hero_image ); ?>'); background-size: cover; background-position: center;">
            <div class="w-full max-w-6xl mx-auto text-center">
                <!-- Breadcrumbs -->
                <div class="mb-4">
                    <nav class="flex justify-center items-center text-sm flex-wrap">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-white/80 hover:text-white transition-colors">
                            <?php esc_html_e( 'Home', 'lawfirm-pro' ); ?>
                        </a>
                        <svg class="w-4 h-4 mx-2 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="<?php echo esc_url( home_url( '/#practice-areas' ) ); ?>" class="text-white/80 hover:text-white transition-colors">
                            <?php esc_html_e( 'Practice Areas', 'lawfirm-pro' ); ?>
                        </a>
                        <?php if ( $primary_practice_area ) : ?>
                            <svg class="w-4 h-4 mx-2 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <a href="<?php echo esc_url( get_term_link( $primary_practice_area ) ); ?>" class="text-white/80 hover:text-white transition-colors">
                                <?php echo esc_html( $primary_practice_area->name ); ?>
                            </a>
                        <?php endif; ?>
                        <svg class="w-4 h-4 mx-2 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-white font-semibold"><?php the_title(); ?></span>
                    </nav>
                </div>
                
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight">
                    <?php the_title(); ?>
                </h1>
                
                <!-- Service Meta -->
                <div class="flex flex-wrap items-center justify-center gap-6">
                    <div class="flex items-center gap-2">
                        <span class="text-white/80 font-medium"><?php esc_html_e( 'Provider:', 'lawfirm-pro' ); ?></span>
                        <span class="text-[#26cf71] font-bold"><?php echo esc_html( $provider_name ); ?></span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="text-lg font-bold text-white">
                            <?php echo esc_html( $service_rating ); ?>
                        </span>
                        <span class="text-white/80">(<?php echo esc_html( $review_count ); ?> <?php esc_html_e( 'reviews', 'lawfirm-pro' ); ?>)</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Content -->
        <div class="bg-white py-12 px-6">
            <div class="max-w-6xl mx-auto">
                <?php
                // Get service content meta
                $gallery = get_post_meta( get_the_ID(), 'service_gallery', true );
                $short_desc = get_post_meta( get_the_ID(), 'service_short_description', true );
                $full_desc = get_post_meta( get_the_ID(), 'service_full_description', true );
                
                if ( ! is_array( $gallery ) ) $gallery = array();
                if ( ! is_array( $short_desc ) ) $short_desc = array();
                ?>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Gallery, Short Description, Full Description -->
                    <div class="lg:col-span-2">
                        <!-- Image Gallery/Slider -->
                        <?php if ( ! empty( $gallery ) ) : ?>
                            <div class="mb-8">
                                <!-- Main Image -->
                                <div class="relative bg-[#F1F3F5] rounded-xl overflow-hidden border border-gray-200 mb-4">
                                    <img id="main-gallery-image" src="<?php echo esc_url( wp_get_attachment_url( $gallery[0] ) ); ?>" class="w-full h-auto" alt="<?php the_title_attribute(); ?>" />
                                </div>
                                
                                <!-- Thumbnails -->
                                <?php if ( count( $gallery ) > 1 ) : ?>
                                    <div class="grid grid-cols-4 gap-3">
                                        <?php foreach ( $gallery as $index => $image_id ) : 
                                            $image_url = wp_get_attachment_url( $image_id );
                                            if ( $image_url ) :
                                        ?>
                                            <div class="aspect-square rounded-lg border-2 <?php echo $index === 0 ? 'border-[#26cf71]' : 'border-gray-300'; ?> overflow-hidden cursor-pointer hover:border-[#26cf71] transition-all duration-300 gallery-thumbnail" data-image="<?php echo esc_url( $image_url ); ?>">
                                                <img src="<?php echo esc_url( $image_url ); ?>" class="w-full h-full object-cover" alt="<?php the_title_attribute(); ?>" />
                                            </div>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Short Description -->
                        <?php if ( $full_desc ) : ?>
                            <div class="mb-8">
                                <div class="text-base text-gray-700 leading-relaxed">
                                    <?php echo wp_kses_post( $full_desc ); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Bullet Points -->
                        <?php if ( ! empty( $short_desc ) ) : ?>
                            <div class="mb-8">
                                <ul class="space-y-3">
                                    <?php foreach ( $short_desc as $item ) : ?>
                                        <li class="flex items-start gap-3 text-base text-gray-700">
                                            <span class="text-[#26cf71] text-xl mt-0.5 flex-shrink-0">✓</span>
                                            <span><?php echo esc_html( $item ); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <!-- WordPress Content (if any) -->
                        <?php if ( get_the_content() ) : ?>
                            <div class="text-base text-gray-700 leading-relaxed">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Right Column: Contact Card -->
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-[#26cf71] to-[#1eb863] rounded-2xl p-6 text-white shadow-xl sticky top-24">
                            <h3 class="text-2xl font-bold mb-4"><?php esc_html_e( 'Get Legal Help', 'lawfirm-pro' ); ?></h3>
                            <p class="text-white/90 mb-6 text-sm">
                                <?php esc_html_e( 'Contact our expert legal team for a free consultation', 'lawfirm-pro' ); ?>
                            </p>
                            
                            <div class="space-y-4">
                                <button id="open-booking-modal" class="block w-full bg-white text-[#26cf71] px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php esc_html_e( 'Book Now', 'lawfirm-pro' ); ?>
                                </button>
                                
                                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="block w-full bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-lg font-semibold hover:bg-white/30 transition-all duration-300 border-2 border-white/50 hover:border-white text-center">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php esc_html_e( 'Contact Us', 'lawfirm-pro' ); ?>
                                </a>
                                
                                <div class="pt-4 border-t border-white/30">
                                    <p class="text-sm text-white/90 mb-2">
                                        <strong><?php esc_html_e( 'Phone:', 'lawfirm-pro' ); ?></strong><br>
                                        +977-1-4497707<br>
                                        +977-9851063500
                                    </p>
                                    <p class="text-sm text-white/90">
                                        <strong><?php esc_html_e( 'Email:', 'lawfirm-pro' ); ?></strong><br>
                                        genilawasso@gmail.com
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Modal -->
                <div id="booking-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-[9999] flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl">
                        <div class="sticky top-0 bg-white p-6 flex items-center justify-between rounded-t-2xl border-b border-gray-200">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900"><?php esc_html_e( 'Book Consultation', 'lawfirm-pro' ); ?></h3>
                                <p class="text-gray-600 text-sm mt-1"><?php esc_html_e( 'Step', 'lawfirm-pro' ); ?> <span id="current-step">1</span> <?php esc_html_e( 'of', 'lawfirm-pro' ); ?> 3</p>
                            </div>
                            <button id="close-booking-modal" class="text-gray-600 hover:text-gray-900 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <form id="booking-form" class="p-6">
                            <input type="hidden" name="service_title" value="<?php echo esc_attr( get_the_title() ); ?>" />
                            <input type="hidden" name="service_url" value="<?php echo esc_url( get_permalink() ); ?>" />
                            
                            <!-- Step 1: Personal Information -->
                            <div class="form-step active" data-step="1">
                                <h4 class="text-lg font-bold text-gray-800 mb-4"><?php esc_html_e( 'Personal Information', 'lawfirm-pro' ); ?></h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="booking_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <?php esc_html_e( 'Full Name', 'lawfirm-pro' ); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="booking_name" name="booking_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#26cf71] focus:border-transparent outline-none transition-all" placeholder="<?php esc_attr_e( 'Enter your full name', 'lawfirm-pro' ); ?>" />
                                    </div>
                                    
                                    <div>
                                        <label for="booking_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <?php esc_html_e( 'Email Address', 'lawfirm-pro' ); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="booking_email" name="booking_email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#26cf71] focus:border-transparent outline-none transition-all" placeholder="<?php esc_attr_e( 'your@email.com', 'lawfirm-pro' ); ?>" />
                                    </div>
                                    
                                    <div>
                                        <label for="booking_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <?php esc_html_e( 'Phone Number', 'lawfirm-pro' ); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" id="booking_phone" name="booking_phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#26cf71] focus:border-transparent outline-none transition-all" placeholder="<?php esc_attr_e( '+977-XXXXXXXXXX', 'lawfirm-pro' ); ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 2: Appointment Details -->
                            <div class="form-step" data-step="2">
                                <h4 class="text-lg font-bold text-gray-800 mb-4"><?php esc_html_e( 'Appointment Details', 'lawfirm-pro' ); ?></h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="booking_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <?php esc_html_e( 'Preferred Date', 'lawfirm-pro' ); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="booking_date" name="booking_date" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#26cf71] focus:border-transparent outline-none transition-all" />
                                    </div>
                                    
                                    <div>
                                        <label for="booking_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <?php esc_html_e( 'Preferred Time', 'lawfirm-pro' ); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <select id="booking_time" name="booking_time" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#26cf71] focus:border-transparent outline-none transition-all">
                                            <option value=""><?php esc_html_e( 'Select time', 'lawfirm-pro' ); ?></option>
                                            <option value="09:00 AM">09:00 AM</option>
                                            <option value="10:00 AM">10:00 AM</option>
                                            <option value="11:00 AM">11:00 AM</option>
                                            <option value="12:00 PM">12:00 PM</option>
                                            <option value="01:00 PM">01:00 PM</option>
                                            <option value="02:00 PM">02:00 PM</option>
                                            <option value="03:00 PM">03:00 PM</option>
                                            <option value="04:00 PM">04:00 PM</option>
                                            <option value="05:00 PM">05:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 3: Additional Information -->
                            <div class="form-step" data-step="3">
                                <h4 class="text-lg font-bold text-gray-800 mb-4"><?php esc_html_e( 'Additional Information', 'lawfirm-pro' ); ?></h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="booking_message" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <?php esc_html_e( 'Message', 'lawfirm-pro' ); ?>
                                        </label>
                                        <textarea id="booking_message" name="booking_message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#26cf71] focus:border-transparent outline-none transition-all resize-none" placeholder="<?php esc_attr_e( 'Tell us about your legal needs...', 'lawfirm-pro' ); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="booking-response" class="hidden p-4 rounded-lg mt-4"></div>
                            
                            <!-- Navigation Buttons -->
                            <div class="flex gap-3 mt-6">
                                <button type="button" id="prev-step" class="hidden flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-300">
                                    <?php esc_html_e( 'Previous', 'lawfirm-pro' ); ?>
                                </button>
                                <button type="button" id="next-step" class="flex-1 bg-gradient-to-r from-[#26cf71] to-[#1eb863] text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                    <?php esc_html_e( 'Next', 'lawfirm-pro' ); ?>
                                </button>
                                <button type="submit" id="submit-booking" class="hidden flex-1 bg-gradient-to-r from-[#26cf71] to-[#1eb863] text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                    <?php esc_html_e( 'Submit Booking', 'lawfirm-pro' ); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <style>
                .form-step {
                    display: none;
                }
                .form-step.active {
                    display: block;
                }
                </style>
                
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = document.getElementById('booking-modal');
                    const openBtn = document.getElementById('open-booking-modal');
                    const closeBtn = document.getElementById('close-booking-modal');
                    const form = document.getElementById('booking-form');
                    const responseDiv = document.getElementById('booking-response');
                    const nextBtn = document.getElementById('next-step');
                    const prevBtn = document.getElementById('prev-step');
                    const submitBtn = document.getElementById('submit-booking');
                    const currentStepSpan = document.getElementById('current-step');
                    
                    let currentStep = 1;
                    const totalSteps = 3;
                    
                    // Open modal
                    openBtn.addEventListener('click', function() {
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                        currentStep = 1;
                        updateStep();
                    });
                    
                    // Close modal
                    closeBtn.addEventListener('click', function() {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                        form.reset();
                        currentStep = 1;
                        updateStep();
                    });
                    
                    // Close on backdrop click
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            modal.classList.add('hidden');
                            document.body.style.overflow = 'auto';
                            form.reset();
                            currentStep = 1;
                            updateStep();
                        }
                    });
                    
                    // Next button
                    nextBtn.addEventListener('click', function() {
                        if (validateStep(currentStep)) {
                            currentStep++;
                            updateStep();
                        }
                    });
                    
                    // Previous button
                    prevBtn.addEventListener('click', function() {
                        currentStep--;
                        updateStep();
                    });
                    
                    // Update step display
                    function updateStep() {
                        // Hide all steps
                        document.querySelectorAll('.form-step').forEach(step => {
                            step.classList.remove('active');
                        });
                        
                        // Show current step
                        document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');
                        currentStepSpan.textContent = currentStep;
                        
                        // Update buttons
                        if (currentStep === 1) {
                            prevBtn.classList.add('hidden');
                        } else {
                            prevBtn.classList.remove('hidden');
                        }
                        
                        if (currentStep === totalSteps) {
                            nextBtn.classList.add('hidden');
                            submitBtn.classList.remove('hidden');
                        } else {
                            nextBtn.classList.remove('hidden');
                            submitBtn.classList.add('hidden');
                        }
                    }
                    
                    // Validate current step
                    function validateStep(step) {
                        const currentStepDiv = document.querySelector(`.form-step[data-step="${step}"]`);
                        const inputs = currentStepDiv.querySelectorAll('input[required], select[required]');
                        let isValid = true;
                        
                        inputs.forEach(input => {
                            if (!input.value.trim()) {
                                input.classList.add('border-red-500');
                                isValid = false;
                            } else {
                                input.classList.remove('border-red-500');
                            }
                        });
                        
                        if (!isValid) {
                            responseDiv.classList.remove('hidden');
                            responseDiv.className = 'p-4 rounded-lg bg-red-100 text-red-800 border border-red-200 mt-4';
                            responseDiv.textContent = '<?php esc_html_e( "Please fill in all required fields.", "lawfirm-pro" ); ?>';
                            setTimeout(() => {
                                responseDiv.classList.add('hidden');
                            }, 3000);
                        }
                        
                        return isValid;
                    }
                    
                    // Handle form submission
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(form);
                        formData.append('action', 'submit_booking');
                        formData.append('nonce', '<?php echo wp_create_nonce( "booking_nonce" ); ?>');
                        
                        // Show loading state
                        const originalText = submitBtn.textContent;
                        submitBtn.textContent = '<?php esc_html_e( "Submitting...", "lawfirm-pro" ); ?>';
                        submitBtn.disabled = true;
                        
                        fetch('<?php echo admin_url( "admin-ajax.php" ); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            responseDiv.classList.remove('hidden');
                            if (data.success) {
                                responseDiv.className = 'p-4 rounded-lg bg-green-100 text-green-800 border border-green-200 mt-4';
                                responseDiv.textContent = data.data.message;
                                form.reset();
                                setTimeout(() => {
                                    modal.classList.add('hidden');
                                    document.body.style.overflow = 'auto';
                                    responseDiv.classList.add('hidden');
                                    currentStep = 1;
                                    updateStep();
                                }, 3000);
                            } else {
                                responseDiv.className = 'p-4 rounded-lg bg-red-100 text-red-800 border border-red-200 mt-4';
                                responseDiv.textContent = data.data.message || '<?php esc_html_e( "Something went wrong. Please try again.", "lawfirm-pro" ); ?>';
                            }
                        })
                        .catch(error => {
                            responseDiv.classList.remove('hidden');
                            responseDiv.className = 'p-4 rounded-lg bg-red-100 text-red-800 border border-red-200 mt-4';
                            responseDiv.textContent = '<?php esc_html_e( "Network error. Please try again.", "lawfirm-pro" ); ?>';
                        })
                        .finally(() => {
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                        });
                    });
                });
                </script>
                
                <!-- Gallery Thumbnail Click Script -->
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
                    const mainImage = document.getElementById('main-gallery-image');
                    
                    thumbnails.forEach(function(thumbnail) {
                        thumbnail.addEventListener('click', function() {
                            const imageUrl = this.getAttribute('data-image');
                            mainImage.src = imageUrl;
                            
                            // Update active border
                            thumbnails.forEach(function(t) {
                                t.classList.remove('border-[#26cf71]');
                                t.classList.add('border-gray-300');
                            });
                            this.classList.remove('border-gray-300');
                            this.classList.add('border-[#26cf71]');
                        });
                    });
                });
                </script>
            </div>
        </div>

        <!-- Related Services -->
        <?php
        $practice_areas = get_the_terms( get_the_ID(), 'practice_area' );
        if ( $practice_areas && ! is_wp_error( $practice_areas ) ) :
            $primary_practice_area = $practice_areas[0];
            
            // Query related services from the same practice area
            $related_args = array(
                'post_type' => 'legal_service',
                'posts_per_page' => 4,
                'post__not_in' => array( get_the_ID() ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'practice_area',
                        'field' => 'term_id',
                        'terms' => $primary_practice_area->term_id,
                    ),
                ),
            );
            
            $related_query = new WP_Query( $related_args );
            
            if ( $related_query->have_posts() ) :
        ?>
            <div class="bg-gray-50 py-12 px-6">
                <div class="max-w-6xl mx-auto">
                    <h3 class="text-3xl font-bold text-[#1A2B3C] mb-8"><?php esc_html_e( 'Related Services', 'lawfirm-pro' ); ?></h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php while ( $related_query->have_posts() ) : $related_query->the_post(); 
                            $provider_name = get_post_meta( get_the_ID(), 'provider_name', true );
                            $service_rating = get_post_meta( get_the_ID(), 'service_rating', true );
                            $review_count = get_post_meta( get_the_ID(), 'review_count', true );
                            $image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                            
                            if ( ! $provider_name ) $provider_name = 'Genius Law';
                            if ( ! $service_rating ) $service_rating = '4.9';
                            if ( ! $review_count ) $review_count = '0';
                            if ( ! $image_url ) $image_url = 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=400';
                        ?>
                            <a href="<?php the_permalink(); ?>" class="bg-transparent block">
                                <div class="rounded-2xl overflow-hidden mb-4 aspect-[4/3]">
                                    <img
                                        src="<?php echo esc_url( $image_url ); ?>"
                                        alt="<?php the_title_attribute(); ?>"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                    />
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate cursor-pointer hover:text-[#26cf71] transition-colors">
                                        <?php the_title(); ?>
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1">
                                            <span class="text-sm text-gray-600"><?php echo esc_html( $provider_name ); ?></span>
                                            <div class="bg-orange-500 rounded-full p-0.5">
                                                <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-800">
                                                <?php echo esc_html( $service_rating ); ?>
                                                <span class="text-gray-400 font-normal">(<?php echo esc_html( $review_count ); ?>)</span>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed pt-1">
                                        <?php echo esc_html( get_the_excerpt() ); ?>
                                    </p>
                                </div>
                            </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        <?php 
            endif;
        endif; 
        ?>
    </article>
</main>

<?php
endwhile;

get_footer();
?>
