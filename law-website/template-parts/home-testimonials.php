<?php
/**
 * Template part for home testimonials section
 *
 * @package LawFirm_Pro
 */

$testimonials = array(
    array(
        'text' => "Genius Law and Associates handled my divorce case with utmost professionalism and compassion. They kept me informed throughout the process and achieved a fair settlement. I highly recommend their family law services.",
        'name' => "Anusha Khanal",
        'position' => "Business Owner, Kathmandu",
        'avatar' => "https://i.pravatar.cc/150?u=anusha"
    ),
    array(
        'text' => "Excellent corporate legal services! They helped us with business registration and contract drafting. The attorneys were knowledgeable and responsive. Our company is now legally protected.",
        'name' => "Kashyap Shakya",
        'position' => "CEO, Tech Startup",
        'avatar' => "https://i.pravatar.cc/150?u=kashyap"
    ),
    array(
        'text' => "Outstanding representation in my property dispute case. The legal team was strategic and fought hard for my rights. We won the case and I got my property back. Truly grateful!",
        'name' => "Ramesh Adhikari",
        'position' => "Property Owner, Lalitpur",
        'avatar' => "https://i.pravatar.cc/150?u=ramesh"
    ),
    array(
        'text' => "Professional criminal defense services. They defended my case with dedication and expertise. The charges were dismissed thanks to their thorough preparation. Highly recommend!",
        'name' => "Maya Gurung",
        'position' => "Entrepreneur, Kathmandu",
        'avatar' => "https://i.pravatar.cc/150?u=maya"
    ),
    array(
        'text' => "Best immigration lawyers in Nepal! They handled my visa application efficiently and I got approved within the expected timeframe. Very knowledgeable about immigration law.",
        'name' => "Suresh Pradhan",
        'position' => "IT Professional, Bhaktapur",
        'avatar' => "https://i.pravatar.cc/150?u=suresh"
    ),
    array(
        'text' => "Excellent contract review services! They identified several problematic clauses that could have cost us significantly. Their attention to detail saved our business. Worth every rupee!",
        'name' => "Rita Shrestha",
        'position' => "Business Manager, Pokhara",
        'avatar' => "https://i.pravatar.cc/150?u=rita"
    )
);
?>

<div class="bg-white w-full py-16 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-12">
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-[#1A2B3C] mb-6">
                    See what our clients say about us
                </h2>
                <div class="space-y-4 text-gray-600 leading-relaxed text-sm md:text-base mb-8">
                    <p>
                        Genius Law and Associates is your trusted legal partner with over 15 years of professional experience. We offer comprehensive legal solutions for individuals and businesses, allowing you to focus on what matters most while we handle your legal matters.
                    </p>
                    <p>
                        We provide a wide range of legal services including family law, corporate law, criminal defense, property disputes, immigration law, contract drafting, employment law, and many more practice areas to serve all your legal needs.
                    </p>
                </div>

                <div class="relative rounded-2xl overflow-hidden shadow-lg aspect-video group cursor-pointer">
                    <img
                        src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=800"
                        alt="Video Placeholder"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm border-2 border-white rounded-full flex items-center justify-center">
                            <div class="w-0 h-0 border-t-[10px] border-t-transparent border-l-[18px] border-l-white border-b-[10px] border-b-transparent ml-1"></div>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4 bg-white p-2 rounded shadow-md">
                        <span class="text-[#26cf71] font-bold text-xs uppercase">Genius Law</span>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <div id="testimonials-scroll" class="h-[600px] overflow-y-auto select-none space-y-6 pr-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <?php 
                    // Duplicate testimonials for infinite scroll effect
                    $all_testimonials = array_merge( $testimonials, $testimonials );
                    foreach ( $all_testimonials as $testimonial ) : 
                    ?>
                        <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="text-[#26cf71] text-5xl font-serif leading-none mb-3">
                                "
                            </div>
                            <p class="text-gray-700 leading-relaxed mb-6 text-sm">
                                <?php echo esc_html( $testimonial['text'] ); ?>
                            </p>
                            <div class="flex items-center gap-3">
                                <img
                                    src="<?php echo esc_url( $testimonial['avatar'] ); ?>"
                                    class="w-12 h-12 rounded-full border-2 border-white shadow-sm"
                                    alt="<?php echo esc_attr( $testimonial['name'] ); ?>"
                                />
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm leading-tight">
                                        <?php echo esc_html( $testimonial['name'] ); ?>
                                    </h4>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                                        <?php echo esc_html( $testimonial['position'] ); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <style>
            #testimonials-scroll::-webkit-scrollbar {
                display: none;
            }
            
            /* Ensure aspect-video works (16:9 ratio) */
            .aspect-video {
                aspect-ratio: 16 / 9;
            }
            
            /* Fallback for browsers that don't support aspect-ratio */
            @supports not (aspect-ratio: 16 / 9) {
                .aspect-video {
                    position: relative;
                    padding-bottom: 56.25%; /* 16:9 ratio */
                }
                .aspect-video > * {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                }
            }
        </style>

        <script>
        (function() {
            'use strict';
            
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initTestimonialsAutoScroll);
            } else {
                initTestimonialsAutoScroll();
            }
            
            function initTestimonialsAutoScroll() {
                const scrollContainer = document.getElementById('testimonials-scroll');
                if (!scrollContainer) return;
                
                let isScrolling = true;
                let scrollSpeed = 0.5; // pixels per frame
                let lastScrollTop = 0;
                let userInteracting = false;
                let interactionTimeout;
                
                // Auto-scroll function
                function autoScroll() {
                    if (!isScrolling || userInteracting) return;
                    
                    scrollContainer.scrollTop += scrollSpeed;
                    
                    // Check if we've reached the middle (where duplicates start)
                    // Reset to beginning for infinite scroll effect
                    const scrollHeight = scrollContainer.scrollHeight;
                    const clientHeight = scrollContainer.clientHeight;
                    const scrollTop = scrollContainer.scrollTop;
                    
                    // When we reach halfway through (original + duplicate), reset to start
                    if (scrollTop >= (scrollHeight / 2)) {
                        scrollContainer.scrollTop = 0;
                    }
                    
                    requestAnimationFrame(autoScroll);
                }
                
                // Pause on user interaction
                function pauseScroll() {
                    userInteracting = true;
                    clearTimeout(interactionTimeout);
                    
                    // Resume after 3 seconds of no interaction
                    interactionTimeout = setTimeout(function() {
                        userInteracting = false;
                        autoScroll();
                    }, 3000);
                }
                
                // Event listeners for user interaction
                scrollContainer.addEventListener('mouseenter', pauseScroll);
                scrollContainer.addEventListener('touchstart', pauseScroll);
                scrollContainer.addEventListener('wheel', pauseScroll);
                scrollContainer.addEventListener('scroll', function() {
                    if (Math.abs(scrollContainer.scrollTop - lastScrollTop) > 5) {
                        pauseScroll();
                    }
                    lastScrollTop = scrollContainer.scrollTop;
                });
                
                // Start auto-scrolling
                autoScroll();
            }
        })();
        </script>
    </div>
</div>
