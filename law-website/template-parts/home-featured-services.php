<?php
/**
 * Template part for home featured services section - DYNAMIC
 *
 * @package LawFirm_Pro
 */

// Query for Featured Legal Services
$featured_query = new WP_Query( array(
    'post_type'      => 'legal_service',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => 'is_featured_service',
            'value'   => '1',
            'compare' => '='
        )
    ),
    'orderby'        => 'date',
    'order'          => 'DESC'
) );

if ( ! $featured_query->have_posts() ) {
    return; // Don't display section if no featured services
}
?>

<div class="bg-gray-50 py-12 px-4">
    <div class="max-w-6xl mx-auto relative">
        <h2 class="text-3xl font-bold text-[#1A2B3C] mb-8">Featured Legal Services</h2>

        <button id="scroll-left-featured" class="absolute left-[-20px] top-1/2 -translate-y-1/2 z-10 bg-[#26cf71] text-white p-2 rounded-full shadow-lg hover:bg-[#1eb863] transition hidden md:block">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <button id="scroll-right-featured" class="absolute right-[-20px] top-1/2 -translate-y-1/2 z-10 bg-[#26cf71] text-white p-2 rounded-full shadow-lg hover:bg-[#1eb863] transition hidden md:block">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <div id="featured-services-scroll" class="overflow-x-auto cursor-grab select-none" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="grid grid-flow-col auto-cols-[minmax(250px,1fr)] sm:auto-cols-[minmax(280px,1fr)] md:auto-cols-[minmax(300px,1fr)] gap-6">
                <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); 
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
                    <a href="<?php the_permalink(); ?>" class="bg-transparent block">
                        <div class="rounded-2xl overflow-hidden mb-4 aspect-[4/3]">
                            <img
                                src="<?php echo esc_url( $image_url ); ?>"
                                alt="<?php the_title_attribute(); ?>"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                draggable="false"
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

        <style>
            #featured-services-scroll::-webkit-scrollbar {
                display: none;
            }
        </style>
    </div>
</div>
