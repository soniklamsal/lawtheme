<?php
/**
 * Template part for home category section - Browse by Practice Area
 *
 * @package LawFirm_Pro
 */

// Get all parent practice areas (top-level terms only)
$parent_practice_areas = get_terms( array(
    'taxonomy'   => 'practice_area',
    'hide_empty' => false,
    'parent'     => 0, // Only get parent terms
) );

if ( empty( $parent_practice_areas ) || is_wp_error( $parent_practice_areas ) ) {
    return;
}
?>

<div class="bg-white w-full py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-[#1A2B3C] mb-12 px-4">
            Browse by Practice Area
        </h2>

        <!-- Parent Practice Areas -->
        <div id="category-scroll" class="overflow-x-auto select-none cursor-grab" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="flex gap-8 pb-4">
                <?php 
                foreach ( $parent_practice_areas as $practice_area ) : 
                    // Try multiple possible meta keys for taxonomy images
                    $term_image = '';
                    
                    // Common meta keys used by various plugins
                    $possible_keys = array(
                        'practice_area_image',
                        'thumbnail_id',
                        'category-image-id',
                        'image',
                        'term_image',
                        'category_image'
                    );
                    
                    foreach ( $possible_keys as $key ) {
                        $meta_value = get_term_meta( $practice_area->term_id, $key, true );
                        if ( ! empty( $meta_value ) ) {
                            // If it's an attachment ID, get the URL
                            if ( is_numeric( $meta_value ) ) {
                                $term_image = wp_get_attachment_image_url( $meta_value, 'medium' );
                            } else {
                                // It's already a URL
                                $term_image = $meta_value;
                            }
                            if ( ! empty( $term_image ) ) {
                                break;
                            }
                        }
                    }
                    
                    // If no term meta image, try to get the featured image from the first service in this practice area
                    if ( empty( $term_image ) ) {
                        $first_service_query = new WP_Query( array(
                            'post_type'      => 'legal_service',
                            'posts_per_page' => 1,
                            'tax_query'      => array(
                                array(
                                    'taxonomy' => 'practice_area',
                                    'field'    => 'term_id',
                                    'terms'    => $practice_area->term_id,
                                    'include_children' => true,
                                ),
                            ),
                        ) );
                        
                        if ( $first_service_query->have_posts() ) {
                            $first_service_query->the_post();
                            $term_image = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                            wp_reset_postdata();
                        }
                    }
                    
                    // Fallback to default image if still empty
                    if ( empty( $term_image ) ) {
                        $term_image = 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=200';
                    }
                ?>
                    <div class="flex flex-col items-center text-center min-w-[140px] hover:scale-105 transition-transform duration-200 practice-area-item" data-term-id="<?php echo esc_attr( $practice_area->term_id ); ?>" data-term-url="<?php echo esc_url( get_term_link( $practice_area ) ); ?>">
                        <div class="h-32 w-32 mb-4 flex items-center justify-center">
                            <img
                                src="<?php echo esc_url( $term_image ); ?>"
                                alt="<?php echo esc_attr( $practice_area->name ); ?>"
                                class="w-full h-full object-cover rounded-lg"
                                draggable="false"
                            />
                        </div>
                        <span class="text-base font-semibold text-gray-800 leading-tight cursor-pointer">
                            <?php echo esc_html( $practice_area->name ); ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            #category-scroll::-webkit-scrollbar {
                display: none;
            }
            
            .practice-area-item.active span {
                color: #26cf71;
            }
            
            .practice-area-item:hover {
                cursor: pointer;
            }
        </style>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPracticeAreas);
    } else {
        initPracticeAreas();
    }
    
    function initPracticeAreas() {
        const practiceAreaItems = document.querySelectorAll('.practice-area-item');
        const subcategoryFilters = document.getElementById('subcategory-filters');
        const serviceCardsSection = document.getElementById('service-cards-section');
        const serviceCardsContainer = document.getElementById('service-cards-container');
        
        let currentPracticeAreaId = null;
        
        practiceAreaItems.forEach(function(item) {
            item.addEventListener('click', function() {
                const termUrl = this.getAttribute('data-term-url');
                
                // Redirect to the taxonomy page
                window.location.href = termUrl;
            });
        });
        
        // Remove the subcategory filters and service cards sections since we're redirecting
        if (subcategoryFilters) {
            subcategoryFilters.remove();
        }
        if (serviceCardsSection) {
            serviceCardsSection.remove();
        }
    }
})();
</script>
