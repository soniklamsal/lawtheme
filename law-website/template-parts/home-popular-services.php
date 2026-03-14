<?php
/**
 * Template part for home popular services section
 *
 * @package LawFirm_Pro
 */

$popular_services = array(
    array(
        'title' => 'Divorce & Separation',
        'provider' => 'Genius Law',
        'rating' => 4.9,
        'reviews' => 87,
        'price' => 'Rs. 25,000.00',
        'description' => 'Expert legal guidance for divorce proceedings, child custody, and property division matters.',
        'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=400',
    ),
    array(
        'title' => 'Business Formation',
        'provider' => 'Genius Law',
        'rating' => 4.8,
        'reviews' => 64,
        'price' => 'Rs. 35,000.00',
        'description' => 'Complete business registration, incorporation, and legal structure setup services.',
        'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=400',
    ),
    array(
        'title' => 'Property Disputes',
        'provider' => 'Genius Law',
        'rating' => 4.9,
        'reviews' => 92,
        'price' => 'Rs. 30,000.00',
        'description' => 'Professional representation for property ownership, boundary, and inheritance disputes.',
        'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=400',
    ),
    array(
        'title' => 'Criminal Defense',
        'provider' => 'Genius Law',
        'rating' => 4.8,
        'reviews' => 73,
        'price' => 'Rs. 40,000.00',
        'description' => 'Experienced criminal defense attorneys for all types of criminal charges and cases.',
        'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=400',
    ),
    array(
        'title' => 'Immigration Law',
        'provider' => 'Genius Law',
        'rating' => 4.7,
        'reviews' => 56,
        'price' => 'Rs. 28,000.00',
        'description' => 'Comprehensive immigration services including visa applications, work permits, and citizenship.',
        'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=400',
    ),
    array(
        'title' => 'Contract Review',
        'provider' => 'Genius Law',
        'rating' => 4.8,
        'reviews' => 68,
        'price' => 'Rs. 15,000.00',
        'description' => 'Thorough contract review and drafting services to protect your business interests.',
        'image' => 'https://images.unsplash.com/photo-1554224311-beee460c201f?auto=format&fit=crop&w=400',
    ),
);
?>

<div class="bg-white py-12 px-4">
    <div class="max-w-6xl mx-auto relative">
        <h2 class="text-3xl font-bold text-[#1A2B3C] mb-8">Popular Legal Services</h2>

        <button id="scroll-left-popular" class="absolute left-[-20px] top-1/2 -translate-y-1/2 z-10 bg-[#26cf71] text-white p-2 rounded-full shadow-lg hover:bg-[#1eb863] transition hidden md:block">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <button id="scroll-right-popular" class="absolute right-[-20px] top-1/2 -translate-y-1/2 z-10 bg-[#26cf71] text-white p-2 rounded-full shadow-lg hover:bg-[#1eb863] transition hidden md:block">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <div id="popular-services-scroll" class="overflow-x-auto cursor-grab select-none" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="grid grid-flow-col auto-cols-[minmax(250px,1fr)] sm:auto-cols-[minmax(280px,1fr)] md:auto-cols-[minmax(300px,1fr)] gap-6">
                <?php foreach ( $popular_services as $index => $service ) : ?>
                    <a href="<?php echo esc_url( home_url( '/service/' . ( $index + 10 ) ) ); ?>" class="bg-transparent block">
                        <div class="rounded-2xl overflow-hidden mb-4 aspect-[4/3]">
                            <img
                                src="<?php echo esc_url( $service['image'] ); ?>"
                                alt="<?php echo esc_attr( $service['title'] ); ?>"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                draggable="false"
                            />
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-gray-900 truncate cursor-pointer hover:text-[#26cf71] transition-colors">
                                <?php echo esc_html( $service['title'] ); ?>
                            </h3>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <span class="text-sm text-gray-600"><?php echo esc_html( $service['provider'] ); ?></span>
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
                                        <?php echo esc_html( $service['rating'] ); ?>
                                        <span class="text-gray-400 font-normal">(<?php echo esc_html( $service['reviews'] ); ?>)</span>
                                    </span>
                                </div>
                            </div>
                            <div class="text-[#26cf71] font-bold text-lg pt-1"><?php echo esc_html( $service['price'] ); ?></div>
                            <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">
                                <?php echo esc_html( $service['description'] ); ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            #popular-services-scroll::-webkit-scrollbar {
                display: none;
            }
        </style>
    </div>
</div>
