<?php
/**
 * Template part for home AMC packages section
 *
 * @package LawFirm_Pro
 */

$packages = array(
    array(
        'title' => 'Business Legal Retainer',
        'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=500',
    ),
    array(
        'title' => 'Family Law Package',
        'image' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?w=500',
    ),
    array(
        'title' => 'Real Estate Legal Plan',
        'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=500',
    ),
    array(
        'title' => 'Employment Law Package',
        'image' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=500',
    ),
    array(
        'title' => 'Personal Legal Protection',
        'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=500',
    ),
);
?>

<section class="bg-gray-50 w-full py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-[#1A2B3C] mb-8">Legal Retainer Packages</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ( $packages as $index => $package ) : ?>
                <div class="group cursor-pointer">
                    <div class="overflow-hidden rounded-2xl mb-4 aspect-video">
                        <img
                            src="<?php echo esc_url( $package['image'] ); ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            alt="<?php echo esc_attr( $package['title'] ); ?>"
                        />
                    </div>
                    <p class="text-center font-bold text-slate-800 text-lg"><?php echo esc_html( $package['title'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
