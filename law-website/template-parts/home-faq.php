<?php
/**
 * Template part for home FAQ section - DYNAMIC
 *
 * @package LawFirm_Pro
 */

// Get FAQ items from customizer
$faq_items = get_theme_mod( 'lawfirm_faq_items', '' );

// Decode JSON string to array
if ( ! empty( $faq_items ) && is_string( $faq_items ) ) {
    $faq_items = json_decode( $faq_items, true );
}

// Ensure it's an array
if ( ! is_array( $faq_items ) ) {
    $faq_items = array();
}

// Get stats from customizer
$cases_won_number = get_theme_mod( 'lawfirm_cases_won_number', '1000' );
$cases_won_label = get_theme_mod( 'lawfirm_cases_won_label', 'Cases Won' );
$attorneys_number = get_theme_mod( 'lawfirm_attorneys_number', '50' );
$attorneys_label = get_theme_mod( 'lawfirm_attorneys_label', 'Expert Attorneys' );
$practice_areas_number = get_theme_mod( 'lawfirm_practice_areas_number', '30' );
$practice_areas_label = get_theme_mod( 'lawfirm_practice_areas_label', 'Practice Areas' );

// Default FAQ items if none set
if ( empty( $faq_items ) ) {
    $faq_items = array(
        array(
            'question' => 'What is Genius Law and Associates?',
            'answer' => 'Genius Law and Associates is a comprehensive legal services firm that connects you with experienced attorneys for all your legal needs including family law, corporate law, criminal defense, property disputes, and more.',
        ),
        array(
            'question' => 'How can I schedule a legal consultation?',
            'answer' => 'You can schedule a consultation by browsing our practice areas, selecting the legal service you need, and clicking the contact button. You can also call us directly or use our WhatsApp contact for immediate assistance.',
        ),
        array(
            'question' => 'What types of legal services are available?',
            'answer' => 'We offer a wide range of legal services including family law, criminal defense, corporate law, property disputes, immigration law, contract drafting, employment law, personal injury, and many more specialized legal services.',
        ),
        array(
            'question' => 'How are the attorneys selected?',
            'answer' => 'All our attorneys are licensed professionals with extensive experience in their practice areas. They undergo rigorous verification including bar association membership, case history review, and client satisfaction assessments.',
        ),
        array(
            'question' => 'What locations does Genius Law and Associates serve?',
            'answer' => 'We currently provide legal services in Kathmandu, Lalitpur, Bhaktapur, Pokhara, and other major cities across Nepal. We also handle cases in district and supreme courts nationwide.',
        ),
    );
}

// Don't display section if no FAQs
if ( empty( $faq_items ) ) {
    return;
}
?>

<div class="bg-white w-full py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-[#1A2B3C] mb-10">Frequently Asked Questions</h2>

        <div class="space-y-3 mb-24">
            <?php foreach ( $faq_items as $index => $faq ) : 
                if ( empty( $faq['question'] ) ) continue;
            ?>
                <div class="faq-item" data-index="<?php echo esc_attr( $index ); ?>">
                    <div class="faq-question bg-gray-50 rounded-md border border-gray-100 px-6 py-4 flex justify-between items-center cursor-pointer hover:bg-gray-100 transition">
                        <span class="text-gray-800 font-medium text-sm md:text-base">
                            <?php echo esc_html( $faq['question'] ); ?>
                        </span>
                        <svg class="faq-icon w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <div class="faq-answer bg-white border border-gray-100 border-t-0 rounded-b-md px-6 py-4 -mt-1" style="display: none;">
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                            <?php echo esc_html( $faq['answer'] ); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="stats-section grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
            <div class="flex flex-col items-center">
                <div class="relative">
                    <span class="text-8xl font-bold text-[#26cf71]/10 select-none absolute -top-8 left-1/2 -translate-x-1/2">
                        <?php echo esc_html( $cases_won_number ); ?>+
                    </span>
                    <span class="text-5xl font-extrabold text-[#26cf71] relative counter" data-target="<?php echo esc_attr( $cases_won_number ); ?>">0</span><span class="text-5xl font-extrabold text-[#26cf71]">+</span>
                </div>
                <div class="w-12 h-0.5 bg-[#26cf71] my-4"></div>
                <p class="text-xl font-bold text-gray-800"><?php echo esc_html( $cases_won_label ); ?></p>
            </div>

            <div class="flex flex-col items-center">
                <div class="relative">
                    <span class="text-8xl font-bold text-[#26cf71]/10 select-none absolute -top-8 left-1/2 -translate-x-1/2">
                        <?php echo esc_html( $attorneys_number ); ?>+
                    </span>
                    <span class="text-5xl font-extrabold text-[#26cf71] relative counter" data-target="<?php echo esc_attr( $attorneys_number ); ?>">0</span><span class="text-5xl font-extrabold text-[#26cf71]">+</span>
                </div>
                <div class="w-12 h-0.5 bg-[#26cf71] my-4"></div>
                <p class="text-xl font-bold text-gray-800"><?php echo esc_html( $attorneys_label ); ?></p>
            </div>

            <div class="flex flex-col items-center">
                <div class="relative">
                    <span class="text-8xl font-bold text-[#26cf71]/10 select-none absolute -top-8 left-1/2 -translate-x-1/2">
                        <?php echo esc_html( $practice_areas_number ); ?>+
                    </span>
                    <span class="text-5xl font-extrabold text-[#26cf71] relative counter" data-target="<?php echo esc_attr( $practice_areas_number ); ?>">0</span><span class="text-5xl font-extrabold text-[#26cf71]">+</span>
                </div>
                <div class="w-12 h-0.5 bg-[#26cf71] my-4"></div>
                <p class="text-xl font-bold text-gray-800"><?php echo esc_html( $practice_areas_label ); ?></p>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        initFAQ();
        initStatsCounter();
    }
    
    function initFAQ() {
        console.log('FAQ: Initializing...');
        
        const faqQuestions = document.querySelectorAll('.faq-question');
        console.log('FAQ: Found ' + faqQuestions.length + ' questions');
        
        faqQuestions.forEach(function(question, idx) {
            console.log('FAQ: Setting up question ' + idx);
            
            question.addEventListener('click', function() {
                console.log('FAQ: Question clicked');
                
                const faqItem = this.closest('.faq-item');
                const answer = faqItem.querySelector('.faq-answer');
                const icon = faqItem.querySelector('.faq-icon');
                
                console.log('FAQ: Answer element found:', answer);
                console.log('FAQ: Current display:', answer.style.display);
                
                // Check if this FAQ is currently open
                const isOpen = answer.style.display === 'block';
                console.log('FAQ: Is open?', isOpen);
                
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
                    console.log('FAQ: Opened answer');
                } else {
                    console.log('FAQ: Closed answer');
                }
            });
        });
    }
    
    function initStatsCounter() {
        console.log('Stats: Initializing counter...');
        
        const statsSection = document.querySelector('.stats-section');
        if (!statsSection) {
            console.log('Stats: Section not found');
            return;
        }
        
        console.log('Stats: Section found');
        
        let hasAnimated = false;
        
        // Create intersection observer
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting && !hasAnimated) {
                    console.log('Stats: Section is visible, starting animation');
                    hasAnimated = true;
                    
                    const counters = statsSection.querySelectorAll('.counter');
                    console.log('Stats: Found ' + counters.length + ' counters');
                    
                    counters.forEach(function(counter) {
                        const target = parseInt(counter.getAttribute('data-target'));
                        console.log('Stats: Animating counter to ' + target);
                        animateCounter(counter, target, 2000);
                    });
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(statsSection);
    }
    
    function animateCounter(element, target, duration) {
        const startTime = Date.now();
        
        function update() {
            const elapsed = Date.now() - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = Math.floor(progress * target);
            
            element.textContent = current;
            
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                element.textContent = target;
                console.log('Stats: Counter finished at ' + target);
            }
        }
        
        requestAnimationFrame(update);
    }
})();
</script>
