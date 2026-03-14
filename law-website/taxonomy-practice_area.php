<?php
/**
 * Practice Area Archive Template
 *
 * @package LawFirm_Pro
 */

get_header();

$current_term = get_queried_object();
$parent_id = $current_term->parent == 0 ? $current_term->term_id : $current_term->parent;

// Get practice area image
$image_id = get_term_meta( $current_term->term_id, 'practice_area_image', true );
$hero_image = $image_id ? wp_get_attachment_url( $image_id ) : 'https://worknp.com/images/hero-bg.png';

// Get subcategories (children) of the current practice area
$subcategories = get_terms( array(
    'taxonomy'   => 'practice_area',
    'hide_empty' => false,
    'parent'     => $parent_id,
) );

// Get current filter (from URL parameter)
$current_filter = isset( $_GET['filter'] ) ? sanitize_text_field( $_GET['filter'] ) : 'all';
?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <section class="relative w-full h-[400px] flex items-center justify-center bg-cover bg-center text-white px-5" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo esc_url( $hero_image ); ?>'); background-size: cover; background-position: center;">
        <div class="w-full max-w-6xl mx-auto text-center">
            <!-- Breadcrumbs -->
            <div class="mb-4">
                <nav class="flex justify-center items-center text-sm">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-white/80 hover:text-white transition-colors">
                        <?php esc_html_e( 'Home', 'lawfirm-pro' ); ?>
                    </a>
                    <svg class="w-4 h-4 mx-2 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="<?php echo esc_url( home_url( '/#practice-areas' ) ); ?>" class="text-white/80 hover:text-white transition-colors">
                        <?php esc_html_e( 'Practice Areas', 'lawfirm-pro' ); ?>
                    </a>
                    <svg class="w-4 h-4 mx-2 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-white font-semibold"><?php echo esc_html( $current_term->name ); ?></span>
                </nav>
            </div>
            
            <h1 class="text-5xl font-extrabold mb-2 tracking-tight">
                <?php echo esc_html( $current_term->name ); ?> <span class="text-[#26cf71]">Services</span>
            </h1>
            <?php if ( $current_term->description ) : ?>
                <p class="text-lg font-medium opacity-90">
                    <?php echo esc_html( $current_term->description ); ?>
                </p>
            <?php else : ?>
                <p class="text-lg font-medium opacity-90">
                    <?php esc_html_e( 'Expert legal services tailored to your needs', 'lawfirm-pro' ); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Filter Tabs Section -->
    <?php if ( ! empty( $subcategories ) ) : ?>
        <div class="bg-white py-8 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-wrap gap-4 justify-center mb-8">
                    <!-- All Tab -->
                    <a href="<?php echo esc_url( get_term_link( $current_term ) ); ?>" 
                       class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 <?php echo $current_filter === 'all' ? 'bg-[#26cf71] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">
                        <?php esc_html_e( 'All', 'lawfirm-pro' ); ?>
                    </a>
                    
                    <!-- Subcategory Tabs -->
                    <?php foreach ( $subcategories as $subcategory ) : ?>
                        <a href="<?php echo esc_url( add_query_arg( 'filter', $subcategory->slug, get_term_link( $current_term ) ) ); ?>" 
                           class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 <?php echo $current_filter === $subcategory->slug ? 'bg-[#26cf71] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">
                            <?php echo esc_html( $subcategory->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Service Cards Section -->
    <div class="bg-gray-50 py-12 px-6">
        <div class="max-w-6xl mx-auto">
            <?php
            // Build tax query based on filter
            $tax_query = array(
                array(
                    'taxonomy' => 'practice_area',
                    'field'    => 'term_id',
                    'terms'    => $current_term->term_id,
                    'include_children' => $current_filter === 'all',
                ),
            );
            
            // If specific subcategory is selected
            if ( $current_filter !== 'all' ) {
                $filter_term = get_term_by( 'slug', $current_filter, 'practice_area' );
                if ( $filter_term ) {
                    $tax_query = array(
                        array(
                            'taxonomy' => 'practice_area',
                            'field'    => 'term_id',
                            'terms'    => $filter_term->term_id,
                        ),
                    );
                }
            }
            
            // Query legal services
            $services_query = new WP_Query( array(
                'post_type'      => 'legal_service',
                'posts_per_page' => -1,
                'tax_query'      => $tax_query,
            ) );
            
            if ( $services_query->have_posts() ) : ?>
                <div id="service-cards-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while ( $services_query->have_posts() ) : $services_query->the_post(); 
                        // Get custom fields
                        $provider_name = get_post_meta( get_the_ID(), 'provider_name', true );
                        $service_rating = get_post_meta( get_the_ID(), 'service_rating', true );
                        $review_count = get_post_meta( get_the_ID(), 'review_count', true );
                        $image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                        
                        // Defaults
                        if ( ! $provider_name ) $provider_name = 'Genius Law';
                        if ( ! $service_rating ) $service_rating = '4.9';
                        if ( ! $review_count ) $review_count = '0';
                        if ( ! $image_url ) $image_url = 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=400';
                    ?>
                        <a href="<?php the_permalink(); ?>" class="bg-transparent block service-card">
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
                    <?php endwhile; ?>
                </div>
                
                <!-- Load More / Show Less Button -->
                <div id="load-more-container" class="text-center mt-8" style="display: none;">
                    <button id="load-more-btn" class="px-8 py-3 bg-[#26cf71] text-white font-semibold rounded-lg hover:bg-[#1eb863] transition-all duration-300 shadow-md hover:shadow-lg">
                        Load More
                    </button>
                </div>
                
                <script>
                /**
                 * Load More / Show Less functionality for service cards
                 * 
                 * WHY THE PREVIOUS VERSION FAILED:
                 * 1. Grid column calculation was unreliable - CSS grid-template-columns can return 'none' or complex values
                 * 2. Timing issues - script ran before layout was fully rendered
                 * 3. Responsive breakpoints weren't properly handled
                 * 4. Cards per row detection using getBoundingClientRect() was inconsistent
                 */
                (function() {
                    'use strict';
                    
                    let isExpanded = false;
                    let currentCardsPerRow = 1;
                    const VISIBLE_ROWS = 2;
                    
                    function initLoadMore() {
                        const grid = document.getElementById('service-cards-grid');
                        const cards = Array.from(document.querySelectorAll('.service-card'));
                        const loadMoreBtn = document.getElementById('load-more-btn');
                        const loadMoreContainer = document.getElementById('load-more-container');
                        
                        if (!grid || !cards.length || !loadMoreBtn || !loadMoreContainer) {
                            console.log('Load More: Missing required elements');
                            return;
                        }
                        
                        console.log('Load More: Found', cards.length, 'cards');
                        
                        /**
                         * Calculate cards per row based on screen width and Tailwind breakpoints
                         * This is more reliable than trying to read CSS grid values
                         */
                        function calculateCardsPerRow() {
                            const screenWidth = window.innerWidth;
                            
                            // Match Tailwind CSS breakpoints: grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
                            if (screenWidth >= 1024) { // lg breakpoint
                                return 3;
                            } else if (screenWidth >= 640) { // sm breakpoint  
                                return 2;
                            } else {
                                return 1;
                            }
                        }
                        
                        /**
                         * Initialize card visibility based on current layout
                         */
                        function setupCardVisibility() {
                            currentCardsPerRow = calculateCardsPerRow();
                            const totalCards = cards.length;
                            const cardsToShow = currentCardsPerRow * VISIBLE_ROWS;
                            
                            console.log('Setup:', {
                                screenWidth: window.innerWidth,
                                cardsPerRow: currentCardsPerRow,
                                totalCards: totalCards,
                                cardsToShow: cardsToShow,
                                needsButton: totalCards > cardsToShow
                            });
                            
                            // Reset all cards to visible first
                            cards.forEach(card => {
                                card.style.display = '';
                            });
                            
                            // Check if we need the Load More button
                            if (totalCards <= cardsToShow) {
                                // Not enough cards to warrant a Load More button
                                loadMoreContainer.style.display = 'none';
                                isExpanded = false;
                                console.log('Load More: Not enough cards, hiding button');
                                return;
                            }
                            
                            // We have enough cards, show the button and hide excess cards
                            loadMoreContainer.style.display = 'block';
                            
                            if (!isExpanded) {
                                // Hide cards beyond the first 2 rows
                                cards.forEach((card, index) => {
                                    if (index >= cardsToShow) {
                                        card.style.display = 'none';
                                    }
                                });
                                loadMoreBtn.textContent = 'Load More';
                                console.log('Load More: Hidden', (totalCards - cardsToShow), 'cards');
                            } else {
                                // Keep all cards visible if already expanded
                                loadMoreBtn.textContent = 'Show Less';
                            }
                        }
                        
                        /**
                         * Toggle between showing all cards and showing only first 2 rows
                         */
                        function toggleCardVisibility() {
                            const cardsToShow = currentCardsPerRow * VISIBLE_ROWS;
                            
                            if (isExpanded) {
                                // Collapse: Hide cards beyond first 2 rows
                                cards.forEach((card, index) => {
                                    if (index >= cardsToShow) {
                                        card.style.display = 'none';
                                    } else {
                                        card.style.display = '';
                                    }
                                });
                                
                                loadMoreBtn.textContent = 'Load More';
                                isExpanded = false;
                                
                                // Smooth scroll to grid top after a brief delay
                                setTimeout(() => {
                                    grid.scrollIntoView({ 
                                        behavior: 'smooth', 
                                        block: 'start',
                                        inline: 'nearest'
                                    });
                                }, 150);
                                
                                console.log('Load More: Collapsed to 2 rows');
                                
                            } else {
                                // Expand: Show all cards
                                cards.forEach(card => {
                                    card.style.display = '';
                                });
                                
                                loadMoreBtn.textContent = 'Show Less';
                                isExpanded = true;
                                
                                console.log('Load More: Expanded to show all cards');
                            }
                        }
                        
                        // Event listener for Load More button
                        loadMoreBtn.addEventListener('click', toggleCardVisibility);
                        
                        // Handle window resize with debouncing
                        let resizeTimeout;
                        window.addEventListener('resize', function() {
                            clearTimeout(resizeTimeout);
                            resizeTimeout = setTimeout(() => {
                                console.log('Load More: Window resized, recalculating...');
                                setupCardVisibility();
                            }, 300);
                        });
                        
                        // Initial setup with delay to ensure DOM is fully rendered
                        setTimeout(() => {
                            setupCardVisibility();
                        }, 200);
                        
                        console.log('Load More: Initialized successfully');
                    }
                    
                    // Initialize when DOM is ready
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initLoadMore);
                    } else {
                        // DOM already loaded, run immediately
                        initLoadMore();
                    }
                    
                })();
                </script>
            <?php else : ?>
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg"><?php esc_html_e( 'No legal services found in this practice area.', 'lawfirm-pro' ); ?></p>
                </div>
            <?php endif;
            
            wp_reset_postdata();
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
