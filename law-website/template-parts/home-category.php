<?php
/**
 * Template part for home category section
 *
 * @package LawFirm_Pro
 */

// Sample categories - replace with your actual data
$categories = array(
    array('name' => 'Family Law', 'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=200'),
    array('name' => 'Criminal Defense', 'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=200'),
    array('name' => 'Corporate Law', 'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=200'),
    array('name' => 'Real Estate', 'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=200'),
    array('name' => 'Immigration', 'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=200'),
    array('name' => 'Personal Injury', 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=200'),
    array('name' => 'Employment Law', 'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=200'),
    array('name' => 'Estate Planning', 'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=200'),
);
?>

<div class="bg-white w-full py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-[#1A2B3C] mb-12 px-4">
            Browse by Practice Area
        </h2>

        <div id="category-scroll" class="overflow-x-auto select-none cursor-grab" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="flex gap-8 pb-4">
                <?php foreach ( $categories as $category ) : ?>
                    <div class="flex flex-col items-center text-center min-w-[140px] hover:scale-105 transition-transform duration-200">
                        <div class="h-32 w-32 mb-4 flex items-center justify-center">
                            <img
                                src="<?php echo esc_url( $category['image'] ); ?>"
                                alt="<?php echo esc_attr( $category['name'] ); ?>"
                                class="w-full h-full object-cover rounded-lg"
                                draggable="false"
                            />
                        </div>
                        <span class="text-base font-semibold text-gray-800 leading-tight cursor-pointer">
                            <?php echo esc_html( $category['name'] ); ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            #category-scroll::-webkit-scrollbar {
                display: none;
            }
        </style>
    </div>
</div>
