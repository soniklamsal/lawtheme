<?php
/**
 * Template Name: FAQ Page
 * 
 * Template for displaying Frequently Asked Questions
 *
 * @package LawFirm_Pro
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="pt-32 px-6 mb-16">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-2 tracking-tight text-[#1A2B3C]">
                Frequently <span class="text-[#26cf71]">Asked Questions</span>
            </h1>
            <p class="text-lg font-medium opacity-90 text-gray-700">
                Find answers to common legal questions
            </p>
        </div>
    </div>

    <div class="bg-white py-0 px-6">
        <div class="max-w-4xl mx-auto">
            <?php
            // General Legal Questions
            $general_faqs = array(
                array(
                    'question' => 'What is Genius Law and Associates?',
                    'answer' => 'Genius Law and Associates is a comprehensive legal services firm that connects you with experienced attorneys for all your legal needs including family law, corporate law, criminal defense, property disputes, and more.',
                ),
                array(
                    'question' => 'How can I schedule a legal consultation?',
                    'answer' => 'You can schedule a consultation by calling us at +977-1-4497707 or +977-9851063500, emailing us at genilawasso@gmail.com, or using our WhatsApp contact button. We offer free initial consultations for most cases.',
                ),
                array(
                    'question' => 'What are your office hours?',
                    'answer' => 'Our office is open Sunday to Friday from 10:00 AM to 5:00 PM. We are closed on Saturdays and public holidays. However, we can arrange appointments outside regular hours for urgent matters.',
                ),
                array(
                    'question' => 'Do you offer free consultations?',
                    'answer' => 'Yes, we offer free initial consultations for most practice areas. This allows us to understand your case and provide you with an overview of your legal options without any obligation.',
                ),
            );

            // Practice Area Questions
            $practice_faqs = array(
                array(
                    'question' => 'What types of legal services do you provide?',
                    'answer' => 'We offer a wide range of legal services including family law, criminal defense, corporate law, property disputes, immigration law, contract drafting, employment law, personal injury, and many more specialized legal services.',
                ),
                array(
                    'question' => 'How long does a typical case take?',
                    'answer' => 'The duration varies depending on the complexity of the case and the legal process involved. Simple matters may be resolved in a few weeks, while complex litigation can take several months to years. We provide realistic timelines during your consultation.',
                ),
                array(
                    'question' => 'What should I bring to my first consultation?',
                    'answer' => 'Please bring any relevant documents related to your case, such as contracts, court papers, correspondence, identification documents, and a list of questions you want to discuss. The more information you provide, the better we can assess your situation.',
                ),
                array(
                    'question' => 'How much do your legal services cost?',
                    'answer' => 'Our fees vary depending on the type and complexity of the case. We offer transparent pricing and will discuss all costs during your initial consultation. We also offer flexible payment plans for qualifying clients.',
                ),
            );

            // Process Questions
            $process_faqs = array(
                array(
                    'question' => 'How are your attorneys selected?',
                    'answer' => 'All our attorneys are licensed professionals with extensive experience in their practice areas. They undergo rigorous verification including bar association membership, case history review, and client satisfaction assessments.',
                ),
                array(
                    'question' => 'What locations does Genius Law and Associates serve?',
                    'answer' => 'We currently provide legal services in Kathmandu, Lalitpur, Bhaktapur, Pokhara, and other major cities across Nepal. We also handle cases in district and supreme courts nationwide.',
                ),
                array(
                    'question' => 'Can you handle cases outside of Kathmandu?',
                    'answer' => 'Yes, we handle cases throughout Nepal. Our attorneys are experienced in appearing before district courts, high courts, and the Supreme Court across the country.',
                ),
                array(
                    'question' => 'How do I know if I need a lawyer?',
                    'answer' => 'If you are facing legal issues, involved in a dispute, need to draft or review contracts, or require legal advice on any matter, it is advisable to consult with an attorney. We can help you understand your rights and options.',
                ),
            );

            // Confidentiality Questions
            $confidentiality_faqs = array(
                array(
                    'question' => 'Is my information confidential?',
                    'answer' => 'Absolutely. Attorney-client privilege protects all communications between you and your lawyer. We maintain strict confidentiality and will never disclose your information without your explicit consent, except as required by law.',
                ),
                array(
                    'question' => 'What if I need to change my lawyer?',
                    'answer' => 'You have the right to change your lawyer at any time. We will cooperate fully in transferring your case files and information to your new attorney. However, we encourage open communication to resolve any concerns first.',
                ),
                array(
                    'question' => 'Do you provide legal services in English?',
                    'answer' => 'Yes, our attorneys are fluent in both Nepali and English. We can provide legal services and documentation in either language based on your preference.',
                ),
            );
            ?>

            <!-- General Questions Section -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-[#1A2B3C] mb-6 pb-3 border-b-2 border-[#26cf71]">
                    General Questions
                </h2>
                <div class="space-y-3">
                    <?php foreach ( $general_faqs as $index => $faq ) : ?>
                        <div class="faq-item" data-index="general-<?php echo $index; ?>">
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
            </div>

            <!-- Practice Areas Section -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-[#1A2B3C] mb-6 pb-3 border-b-2 border-[#26cf71]">
                    Practice Areas & Services
                </h2>
                <div class="space-y-3">
                    <?php foreach ( $practice_faqs as $index => $faq ) : ?>
                        <div class="faq-item" data-index="practice-<?php echo $index; ?>">
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
            </div>

            <!-- Process & Procedures Section -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-[#1A2B3C] mb-6 pb-3 border-b-2 border-[#26cf71]">
                    Process & Procedures
                </h2>
                <div class="space-y-3">
                    <?php foreach ( $process_faqs as $index => $faq ) : ?>
                        <div class="faq-item" data-index="process-<?php echo $index; ?>">
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
            </div>

            <!-- Confidentiality & Ethics Section -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-[#1A2B3C] mb-6 pb-3 border-b-2 border-[#26cf71]">
                    Confidentiality & Ethics
                </h2>
                <div class="space-y-3">
                    <?php foreach ( $confidentiality_faqs as $index => $faq ) : ?>
                        <div class="faq-item" data-index="confidentiality-<?php echo $index; ?>">
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
            </div>

            <!-- Contact CTA -->
            <div class="bg-gradient-to-r from-[#26cf71] to-[#1eb863] rounded-2xl p-10 md:p-12 text-center text-white mt-16 shadow-xl">
                <h3 class="text-3xl font-bold mb-4">Still Have Questions?</h3>
                <p class="text-lg mb-8 opacity-95 max-w-2xl mx-auto">
                    Our legal team is here to help. Contact us for a free consultation.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="tel:+97714497707" class="bg-white text-[#26cf71] px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Call Us Now
                    </a>
                    <a href="mailto:genilawasso@gmail.com" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/30 transition-all duration-300 border-2 border-white/50 hover:border-white inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email Us
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
