<?php
/**
 * Single AMC Package Template
 * 
 * @package LawFirm_Pro
 */

get_header();

// Get custom fields
$hero_subtitle = get_post_meta( get_the_ID(), '_hero_subtitle', true );

// Basic Plan
$basic_name = get_post_meta( get_the_ID(), '_basic_name', true );
$basic_price = get_post_meta( get_the_ID(), '_basic_price', true );
$basic_billing = get_post_meta( get_the_ID(), '_basic_billing', true );
$basic_features = get_post_meta( get_the_ID(), '_basic_features', true );

// Standard Plan
$standard_name = get_post_meta( get_the_ID(), '_standard_name', true );
$standard_price = get_post_meta( get_the_ID(), '_standard_price', true );
$standard_billing = get_post_meta( get_the_ID(), '_standard_billing', true );
$standard_features = get_post_meta( get_the_ID(), '_standard_features', true );

// Premium Plan
$premium_name = get_post_meta( get_the_ID(), '_premium_name', true );
$premium_price = get_post_meta( get_the_ID(), '_premium_price', true );
$premium_billing = get_post_meta( get_the_ID(), '_premium_billing', true );
$premium_features = get_post_meta( get_the_ID(), '_premium_features', true );

// Benefits
$benefits = get_post_meta( get_the_ID(), '_benefits', true );

// Convert features to arrays
$basic_features_array = ! empty( $basic_features ) ? array_filter( array_map( 'trim', explode( "\n", $basic_features ) ) ) : array();
$standard_features_array = ! empty( $standard_features ) ? array_filter( array_map( 'trim', explode( "\n", $standard_features ) ) ) : array();
$premium_features_array = ! empty( $premium_features ) ? array_filter( array_map( 'trim', explode( "\n", $premium_features ) ) ) : array();

// Convert benefits to array (format: Title|Description per line)
$benefits_array = array();
if ( ! empty( $benefits ) ) {
    $benefits_lines = array_filter( array_map( 'trim', explode( "\n", $benefits ) ) );
    foreach ( $benefits_lines as $line ) {
        $parts = explode( '|', $line, 2 );
        if ( count( $parts ) === 2 ) {
            $benefits_array[] = array(
                'title' => trim( $parts[0] ),
                'description' => trim( $parts[1] ),
            );
        }
    }
}
?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- HERO SECTION -->
<section class="relative h-[400px] overflow-hidden">
    <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-cover' ) ); ?>
    <?php else : ?>
        <img src="https://via.placeholder.com/1200x400" class="w-full h-full object-cover" alt="<?php echo esc_attr( get_the_title() ); ?>" />
    <?php endif; ?>
    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
        <div class="text-center text-white px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">
                <?php the_title(); ?>
            </h1>
            <?php if ( $hero_subtitle ) : ?>
                <p class="text-xl md:text-2xl max-w-3xl mx-auto">
                    <?php echo esc_html( $hero_subtitle ); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- MAIN -->
<main class="max-w-7xl mx-auto px-4 py-12">
    
    <!-- TITLE -->
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Choose Your Perfect Plan
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Keep your systems running smoothly all year with our maintenance plans.
        </p>
    </div>

    <!-- PRICING CARDS -->
    <div class="flex flex-wrap justify-center gap-8">
        
        <!-- CARD 1 - BASIC -->
        <div class="w-[320px] bg-white border rounded-lg p-5 shadow">
            <div class="bg-[#26cf71] text-white text-center py-3 rounded mb-5 font-bold">
                <?php echo esc_html( $basic_name ? $basic_name : 'BASIC' ); ?>
            </div>
            <div class="text-center mb-5">
                <p class="text-gray-600"><?php echo esc_html( $basic_price ? $basic_price : 'Perfect for individuals and small businesses' ); ?></p>
            </div>
            <button class="open-booking-modal w-full py-3 border-2 border-[#26cf71] text-[#26cf71] font-bold rounded mb-6 hover:bg-[#26cf71] hover:text-white transition" data-package="<?php echo esc_attr( $basic_name ? $basic_name : 'BASIC' ); ?>">
                Book Now
            </button>
            <ul>
                <?php if ( ! empty( $basic_features_array ) ) : ?>
                    <?php foreach ( $basic_features_array as $feature ) : ?>
                        <li class="mb-3 flex items-center">
                            <span class="text-green-500 mr-2">✔</span>
                            <?php echo esc_html( $feature ); ?>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        2 Service Visits
                    </li>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        Basic Cleaning
                    </li>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        Email Support
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- CARD 2 - STANDARD -->
        <div class="w-[320px] bg-white border rounded-lg p-5 shadow">
            <div class="bg-[#26cf71] text-white text-center py-3 rounded mb-5 font-bold">
                <?php echo esc_html( $standard_name ? $standard_name : 'STANDARD' ); ?>
            </div>
            <div class="text-center mb-5">
                <p class="text-gray-600"><?php echo esc_html( $standard_price ? $standard_price : 'Ideal for growing businesses with regular needs' ); ?></p>
            </div>
            <button class="open-booking-modal w-full py-3 border-2 border-[#26cf71] text-[#26cf71] font-bold rounded mb-6 hover:bg-[#26cf71] hover:text-white transition" data-package="<?php echo esc_attr( $standard_name ? $standard_name : 'STANDARD' ); ?>">
                Book Now
            </button>
            <ul>
                <?php if ( ! empty( $standard_features_array ) ) : ?>
                    <?php foreach ( $standard_features_array as $feature ) : ?>
                        <li class="mb-3 flex items-center">
                            <span class="text-green-500 mr-2">✔</span>
                            <?php echo esc_html( $feature ); ?>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        4 Service Visits
                    </li>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        Deep Cleaning
                    </li>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        Phone Support
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- CARD 3 - PREMIUM -->
        <div class="w-[320px] bg-white border rounded-lg p-5 shadow">
            <div class="bg-[#26cf71] text-white text-center py-3 rounded mb-5 font-bold">
                <?php echo esc_html( $premium_name ? $premium_name : 'PREMIUM' ); ?>
            </div>
            <div class="text-center mb-5">
                <p class="text-gray-600"><?php echo esc_html( $premium_price ? $premium_price : 'Complete solution for enterprises and large organizations' ); ?></p>
            </div>
            <button class="open-booking-modal w-full py-3 border-2 border-[#26cf71] text-[#26cf71] font-bold rounded mb-6 hover:bg-[#26cf71] hover:text-white transition" data-package="<?php echo esc_attr( $premium_name ? $premium_name : 'PREMIUM' ); ?>">
                Book Now
            </button>
            <ul>
                <?php if ( ! empty( $premium_features_array ) ) : ?>
                    <?php foreach ( $premium_features_array as $feature ) : ?>
                        <li class="mb-3 flex items-center">
                            <span class="text-green-500 mr-2">✔</span>
                            <?php echo esc_html( $feature ); ?>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        Unlimited Visits
                    </li>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        Full Maintenance
                    </li>
                    <li class="mb-3 flex items-center">
                        <span class="text-green-500 mr-2">✔</span>
                        Priority Support
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </div>

    <!-- BENEFITS -->
    <div class="mt-16 bg-white rounded-2xl border p-8 max-w-4xl mx-auto">
        <h3 class="text-2xl font-bold mb-4">Why Choose Us</h3>
        <div class="grid md:grid-cols-2 gap-6 text-gray-700">
            <?php if ( ! empty( $benefits_array ) ) : ?>
                <?php foreach ( $benefits_array as $benefit ) : ?>
                    <div>
                        <h4 class="font-semibold text-[#26cf71] mb-2">✓ <?php echo esc_html( $benefit['title'] ); ?></h4>
                        <p><?php echo esc_html( $benefit['description'] ); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div>
                    <h4 class="font-semibold text-[#26cf71] mb-2">✓ Expert Technicians</h4>
                    <p>Highly trained professionals for reliable service.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-[#26cf71] mb-2">✓ Fast Response</h4>
                    <p>Quick support whenever you need it.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-[#26cf71] mb-2">✓ Affordable Plans</h4>
                    <p>Flexible pricing options for everyone.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-[#26cf71] mb-2">✓ Trusted Service</h4>
                    <p>Years of experience in maintenance services.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</main>

<!-- Booking Modal -->
<div id="booking-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-[9999] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl">
        <div class="sticky top-0 bg-white p-6 flex items-center justify-between rounded-t-2xl border-b border-gray-200">
            <div>
                <h3 class="text-2xl font-bold text-gray-900"><?php esc_html_e( 'Book Consultation', 'lawfirm-pro' ); ?></h3>
                <p class="text-gray-600 text-sm mt-1">
                    <span id="selected-package" class="font-semibold text-[#26cf71]"></span>
                    <span class="mx-2">•</span>
                    <?php esc_html_e( 'Step', 'lawfirm-pro' ); ?> <span id="current-step">1</span> <?php esc_html_e( 'of', 'lawfirm-pro' ); ?> 3
                </p>
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
            <input type="hidden" id="package_type" name="package_type" value="" />
            
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
                        <textarea id="booking_message" name="booking_message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#26cf71] focus:border-transparent outline-none transition-all resize-none" placeholder="<?php esc_attr_e( 'Tell us about your needs...', 'lawfirm-pro' ); ?>"></textarea>
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
    const openBtns = document.querySelectorAll('.open-booking-modal');
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
    openBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Get package type from data attribute
            const packageType = this.getAttribute('data-package');
            if (packageType) {
                document.getElementById('package_type').value = packageType;
                document.getElementById('selected-package').textContent = packageType + ' Package';
            }
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            currentStep = 1;
            updateStep();
        });
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
        
        // Debug: Log package type
        console.log('Package Type:', document.getElementById('package_type').value);
        console.log('Form Data:', Object.fromEntries(formData));
        
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

<?php endwhile; ?>

<?php
get_footer();
