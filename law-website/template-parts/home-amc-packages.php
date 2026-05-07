<?php
/**
 * Template part for home AMC packages section
 *
 * @package LawFirm_Pro
 */

// Query AMC Packages
$args = array(
    'post_type'      => 'amc_package',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
);

$query = new WP_Query( $args );
?>

<section class="bg-gray-50 w-full py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-[#1A2B3C] mb-8">Legal Retainer Packages</h2>

        <?php if ( $query->have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="group block cursor-pointer">
                        <div class="overflow-hidden rounded-2xl mb-4 aspect-video">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium_large', array(
                                    'class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300',
                                    'alt'   => esc_attr( get_the_title() ),
                                ) ); ?>
                            <?php else : ?>
                                <img
                                    src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=500"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                    alt="<?php echo esc_attr( get_the_title() ); ?>"
                                />
                            <?php endif; ?>
                        </div>
                        <p class="text-center font-bold text-slate-800 text-lg"><?php echo esc_html( get_the_title() ); ?></p>
                    </a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-600 text-lg"><?php esc_html_e( 'No packages available at the moment.', 'lawfirm-pro' ); ?></p>
                <p class="text-gray-500 text-sm mt-2"><?php esc_html_e( 'Please check back later for our legal retainer packages.', 'lawfirm-pro' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
