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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    <?php endwhile; ?>
                </div>
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
