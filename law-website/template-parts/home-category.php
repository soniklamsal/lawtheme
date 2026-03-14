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
                    <div class="flex flex-col items-center text-center min-w-[140px] hover:scale-105 transition-transform duration-200 practice-area-item" data-term-id="<?php echo esc_attr( $practice_area->term_id ); ?>">
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

        <!-- Subcategory Filters (Hidden by default) -->
        <div id="subcategory-filters" class="mt-8 hidden">
            <div class="flex gap-4 flex-wrap justify-center mb-8">
                <!-- Filters will be dynamically inserted here -->
            </div>
        </div>

        <!-- Service Cards Section (Hidden by default) -->
        <div id="service-cards-section" class="mt-8 hidden">
            <div id="service-cards-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service cards will be dynamically inserted here -->
            </div>
        </div>

        <style>
            #category-scroll::-webkit-scrollbar {
                display: none;
            }
            
            .practice-area-item.active span {
                color: #26cf71;
            }
            
            .subcategory-filter {
                padding: 0.5rem 1.5rem;
                border-radius: 9999px;
                border: 2px solid #e5e7eb;
                background-color: white;
                color: #374151;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .subcategory-filter:hover {
                border-color: #26cf71;
                color: #26cf71;
            }
            
            .subcategory-filter.active {
                background-color: #26cf71;
                border-color: #26cf71;
                color: white;
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
                const termId = this.getAttribute('data-term-id');
                
                // Remove active class from all items
                practiceAreaItems.forEach(function(i) {
                    i.classList.remove('active');
                });
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Load subcategories and services
                loadSubcategoriesAndServices(termId);
                currentPracticeAreaId = termId;
            });
        });
        
        function loadSubcategoriesAndServices(parentTermId) {
            // Show loading state
            subcategoryFilters.classList.remove('hidden');
            serviceCardsSection.classList.remove('hidden');
            serviceCardsContainer.innerHTML = '<div class="col-span-full text-center py-8">Loading...</div>';
            
            // Fetch subcategories and services via AJAX
            fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_practice_area_data&parent_term_id=' + parentTermId
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    // Render subcategory filters
                    renderSubcategoryFilters(data.data.subcategories, parentTermId);
                    
                    // Render service cards
                    renderServiceCards(data.data.services);
                } else {
                    serviceCardsContainer.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No services found.</div>';
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                serviceCardsContainer.innerHTML = '<div class="col-span-full text-center py-8 text-red-500">Error loading services.</div>';
            });
        }
        
        function renderSubcategoryFilters(subcategories, parentTermId) {
            const filtersContainer = subcategoryFilters.querySelector('.flex');
            
            let filtersHTML = '<button class="subcategory-filter active" data-term-id="' + parentTermId + '" data-filter="all">All</button>';
            
            subcategories.forEach(function(subcat) {
                filtersHTML += '<button class="subcategory-filter" data-term-id="' + subcat.term_id + '" data-filter="subcategory">' + subcat.name + '</button>';
            });
            
            filtersContainer.innerHTML = filtersHTML;
            
            // Add click handlers to filters
            const filterButtons = filtersContainer.querySelectorAll('.subcategory-filter');
            filterButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    // Remove active class from all filters
                    filterButtons.forEach(function(b) {
                        b.classList.remove('active');
                    });
                    
                    // Add active class to clicked filter
                    this.classList.add('active');
                    
                    const termId = this.getAttribute('data-term-id');
                    const filterType = this.getAttribute('data-filter');
                    
                    // Load services for this filter
                    loadServicesByTerm(termId, filterType);
                });
            });
        }
        
        function loadServicesByTerm(termId, filterType) {
            serviceCardsContainer.innerHTML = '<div class="col-span-full text-center py-8">Loading...</div>';
            
            fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=get_services_by_term&term_id=' + termId + '&filter_type=' + filterType
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    renderServiceCards(data.data.services);
                } else {
                    serviceCardsContainer.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No services found.</div>';
                }
            });
        }
        
        function renderServiceCards(services) {
            if (!services || services.length === 0) {
                serviceCardsContainer.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No services found in this category.</div>';
                return;
            }
            
            let cardsHTML = '';
            
            services.forEach(function(service) {
                cardsHTML += '<a href="' + service.permalink + '" class="bg-transparent block">';
                cardsHTML += '  <div class="rounded-2xl overflow-hidden mb-4 aspect-[4/3]">';
                cardsHTML += '    <img src="' + service.image + '" alt="' + service.title + '" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" draggable="false" />';
                cardsHTML += '  </div>';
                cardsHTML += '  <div class="space-y-1">';
                cardsHTML += '    <h3 class="text-lg font-semibold text-gray-900 truncate cursor-pointer hover:text-[#26cf71] transition-colors">' + service.title + '</h3>';
                cardsHTML += '    <div class="flex items-center justify-between">';
                cardsHTML += '      <div class="flex items-center gap-1">';
                cardsHTML += '        <span class="text-sm text-gray-600">Genius Law</span>';
                cardsHTML += '        <div class="bg-orange-500 rounded-full p-0.5">';
                cardsHTML += '          <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
                cardsHTML += '        </div>';
                cardsHTML += '      </div>';
                cardsHTML += '      <div class="flex items-center gap-1">';
                cardsHTML += '        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>';
                cardsHTML += '        <span class="text-sm font-semibold text-gray-800">4.9 <span class="text-gray-400 font-normal">(127)</span></span>';
                cardsHTML += '      </div>';
                cardsHTML += '    </div>';
                cardsHTML += '    <div class="text-[#26cf71] font-bold text-lg pt-1">$250 / Hour</div>';
                cardsHTML += '    <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">' + service.excerpt + '</p>';
                cardsHTML += '  </div>';
                cardsHTML += '</a>';
            });
            
            serviceCardsContainer.innerHTML = cardsHTML;
        }
    }
})();
</script>
