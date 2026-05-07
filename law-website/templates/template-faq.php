<?php
/**
 * Template Name: FAQ Page
 * 
 * Template for displaying Frequently Asked Questions
 *
 * @package LawFirm_Pro
 */

get_header();

// Get FAQ Hero section data
$faqhero_title = get_theme_mod('faqhero_title','Frequently <span class="text-[#26cf71]">Asked Questions</span>');
$faqhero_subtitle = get_theme_mod('faqhero_subtitle','Find answers to common legal questions');

// Get FAQ Categories
$categories = get_theme_mod('faq_categories','');
if(!empty($categories) && is_string($categories)) {
    $categories = json_decode($categories,true);
}
if(!is_array($categories) || empty($categories)) {
    $categories = array(
        array(
            'name' => 'General Questions',
            'faqs' => array(
                array('question'=>'What is Genius Law and Associates?','answer'=>'Genius Law and Associates is a comprehensive legal services firm that connects you with experienced attorneys for all your legal needs including family law, corporate law, criminal defense, property disputes, and more.'),
                array('question'=>'How can I schedule a legal consultation?','answer'=>'You can schedule a consultation by calling us at +977-1-4497707 or +977-9851063500, emailing us at genilawasso@gmail.com, or using our WhatsApp contact button. We offer free initial consultations for most cases.'),
            )
        )
    );
}

// Get FAQ CTA section data
$faqcta_title = get_theme_mod('faqcta_title','Still Have Questions?');
$faqcta_subtitle = get_theme_mod('faqcta_subtitle','Our legal team is here to help. Contact us for a free consultation.');
$faqcta_btn1_text = get_theme_mod('faqcta_btn1_text','Call Us Now');
$faqcta_btn1_url = get_theme_mod('faqcta_btn1_url','tel:+97714497707');
$faqcta_btn2_text = get_theme_mod('faqcta_btn2_text','Email Us');
$faqcta_btn2_url = get_theme_mod('faqcta_btn2_url','mailto:genilawasso@gmail.com');
?>

<main id="primary" class="site-main">
    <div class="pt-32 px-6 mb-16">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-2 tracking-tight text-[#1A2B3C]">
                <?php echo wp_kses_post($faqhero_title); ?>
            </h1>
            <p class="text-lg font-medium opacity-90 text-gray-700">
                <?php echo esc_html($faqhero_subtitle); ?>
            </p>
        </div>
    </div>

    <div class="bg-white py-0 px-6">
        <div class="max-w-4xl mx-auto">
            <?php foreach($categories as $cat_index => $category): ?>
            <?php if(!empty($category['faqs'])): ?>
            <!-- <?php echo esc_html($category['name']); ?> Section -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-[#1A2B3C] mb-6 pb-3 border-b-2 border-[#26cf71]">
                    <?php echo esc_html($category['name']); ?>
                </h2>
                <div class="space-y-3">
                    <?php foreach($category['faqs'] as $faq_index => $faq): ?>
                        <div class="faq-item" data-index="<?php echo $cat_index.'-'.$faq_index; ?>">
                            <div class="faq-question bg-gray-50 rounded-md border border-gray-100 px-6 py-4 flex justify-between items-center cursor-pointer hover:bg-gray-100 transition">
                                <span class="text-gray-800 font-medium text-sm md:text-base">
                                    <?php echo esc_html($faq['question']); ?>
                                </span>
                                <svg class="faq-icon w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div class="faq-answer bg-white border border-gray-100 border-t-0 rounded-b-md px-6 py-4 -mt-1" style="display: none;">
                                <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                                    <?php echo esc_html($faq['answer']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>

            <!-- Contact CTA -->
            <div class="bg-gradient-to-r from-[#26cf71] to-[#1eb863] rounded-2xl p-10 md:p-12 text-center text-white mt-16 shadow-xl">
                <h3 class="text-3xl font-bold mb-4"><?php echo esc_html($faqcta_title); ?></h3>
                <p class="text-lg mb-8 opacity-95 max-w-2xl mx-auto">
                    <?php echo esc_html($faqcta_subtitle); ?>
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?php echo esc_url($faqcta_btn1_url); ?>" class="bg-white text-[#26cf71] px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <?php echo esc_html($faqcta_btn1_text); ?>
                    </a>
                    <a href="<?php echo esc_url($faqcta_btn2_url); ?>" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition-all duration-300 border-2 border-white/50 hover:border-white inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo esc_html($faqcta_btn2_text); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFAQ);
    } else {
        initFAQ();
    }
    
    function initFAQ() {
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(function(question) {
            question.addEventListener('click', function() {
                const faqItem = this.closest('.faq-item');
                const answer = faqItem.querySelector('.faq-answer');
                const icon = faqItem.querySelector('.faq-icon');
                
                // Check if this FAQ is currently open
                const isOpen = answer.style.display === 'block';
                
                // Close all FAQs
                document.querySelectorAll('.faq-answer').forEach(function(ans) {
                    ans.style.display = 'none';
                });
                document.querySelectorAll('.faq-icon').forEach(function(ic) {
                    ic.classList.remove('rotate-180');
                });
                
                // Toggle current FAQ (if it was closed, open it)
                if (!isOpen) {
                    answer.style.display = 'block';
                    icon.classList.add('rotate-180');
                }
            });
        });
    }
})();
</script>

<?php
get_footer();
