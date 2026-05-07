<?php
/**
 * Template Name: Pro Bono Page
 * Template Post Type: page
 */

get_header();

// Default content arrays for fallback
$defaults = array(
    'hero' => array(
        'badge' => 'Pro Bono Legal Support',
        'title' => 'Access to Justice for Those Who Need It Most',
        'subtitle' => 'We provide compassionate legal guidance and representation for eligible individuals, families, and community groups who cannot afford legal assistance.',
        'primary_button_text' => 'Apply for Assistance',
        'primary_button_link' => '#contact',
        'secondary_button_text' => 'Contact Our Team',
        'secondary_button_link' => '/contact',
    ),
    'faq' => array(
        'title' => 'Frequently Asked Questions',
        'description' => 'Common questions about our pro bono legal services and application process.',
        'items' => array(
            array('question' => 'Is pro bono service completely free?', 'answer' => 'Yes, pro bono legal services are provided at no cost to eligible clients. However, you may still be responsible for court fees, filing costs, or other third-party expenses depending on your case.'),
            array('question' => 'Does every applicant qualify for pro bono assistance?', 'answer' => 'Not every application can be accepted due to resource limitations. We prioritize cases based on financial need, case merit, urgency, and our capacity to provide effective representation.'),
            array('question' => 'What documents should I prepare for my application?', 'answer' => 'Typically, you will need proof of income, identification documents, and any relevant legal documents related to your case. Our team will provide a specific list based on your situation.'),
            array('question' => 'How long does the review process take?', 'answer' => 'Initial eligibility review usually takes 3-5 business days. If accepted, the full assessment and consultation process may take 7-10 business days depending on case complexity.'),
            array('question' => 'Can organizations also apply for pro bono support?', 'answer' => 'Yes, registered nonprofit organizations and community groups serving vulnerable populations may qualify for pro bono legal assistance. Please contact us to discuss your organization\'s needs.'),
        ),
    ),
    'case_documents' => array(
        'title' => 'Important Legal Cases & Documents',
        'description' => 'Access key legal documents and landmark cases related to our pro bono work and public interest litigation.',
        'cases' => array(
            array('title' => 'Sangha Ratna Shakya vs HMG', 'note' => 'Landmark public interest case', 'behavior' => 'both'),
            array('title' => 'Public Interest Litigation Example', 'note' => 'Community rights protection', 'behavior' => 'open'),
            array('title' => 'Community Rights Protection Matter', 'note' => 'Legal precedent document', 'behavior' => 'download'),
        ),
    ),
);

// Get custom meta values or use defaults
$hero_badge = get_post_meta(get_the_ID(), '_probono_hero_badge', true) ?: $defaults['hero']['badge'];
$hero_title = get_post_meta(get_the_ID(), '_probono_hero_title', true) ?: $defaults['hero']['title'];
$hero_subtitle = get_post_meta(get_the_ID(), '_probono_hero_subtitle', true) ?: $defaults['hero']['subtitle'];
$hero_bg_image_url = get_post_meta(get_the_ID(), '_probono_hero_bg_image', true);
$hero_bg_image = $hero_bg_image_url ? array('url' => $hero_bg_image_url, 'alt' => '') : '';
$hero_primary_btn_text = get_post_meta(get_the_ID(), '_probono_hero_primary_btn_text', true) ?: $defaults['hero']['primary_button_text'];
$hero_primary_btn_link = get_post_meta(get_the_ID(), '_probono_hero_primary_btn_link', true) ?: $defaults['hero']['primary_button_link'];
$hero_secondary_btn_text = get_post_meta(get_the_ID(), '_probono_hero_secondary_btn_text', true) ?: $defaults['hero']['secondary_button_text'];
$hero_secondary_btn_link = get_post_meta(get_the_ID(), '_probono_hero_secondary_btn_link', true) ?: $defaults['hero']['secondary_button_link'];

$faq_title = get_post_meta(get_the_ID(), '_probono_faq_title', true) ?: $defaults['faq']['title'];
$faq_description = get_post_meta(get_the_ID(), '_probono_faq_description', true) ?: $defaults['faq']['description'];
$faq_items = get_post_meta(get_the_ID(), '_probono_faqs', true) ?: $defaults['faq']['items'];

$case_docs_title = get_post_meta(get_the_ID(), '_probono_case_docs_title', true) ?: $defaults['case_documents']['title'];
$case_docs_description = get_post_meta(get_the_ID(), '_probono_case_docs_description', true) ?: $defaults['case_documents']['description'];
$case_documents = get_post_meta(get_the_ID(), '_probono_case_documents', true) ?: $defaults['case_documents']['cases'];
?>

<main id="primary" class="site-main">
    
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white overflow-hidden">
        <?php if ($hero_bg_image && is_array($hero_bg_image) && isset($hero_bg_image['url'])) : ?>
            <div class="absolute inset-0">
                <img src="<?php echo esc_url($hero_bg_image['url']); ?>" alt="<?php echo esc_attr($hero_bg_image['alt'] ?? ''); ?>" class="w-full h-full object-cover">
            </div>
        <?php endif; ?>
        
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/40 to-gray-900/30"></div>
        
        <div class="relative container mx-auto px-4 py-24 md:py-32">
            <div class="max-w-4xl">
                <div class="inline-block mb-6 px-4 py-2 bg-primary/30 border border-primary/40 rounded-full backdrop-blur-md shadow-lg">
                    <span class="text-white font-semibold text-sm tracking-wide uppercase drop-shadow-md"><?php echo esc_html($hero_badge); ?></span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight drop-shadow-2xl">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                
                <p class="text-lg md:text-xl text-white mb-10 leading-relaxed max-w-3xl drop-shadow-xl">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="<?php echo esc_url($hero_primary_btn_link); ?>" class="inline-block px-8 py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <?php echo esc_html($hero_primary_btn_text); ?>
                    </a>
                    <a href="<?php echo esc_url($hero_secondary_btn_link); ?>" class="inline-block px-8 py-4 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg transition-all duration-300 border border-white/30 backdrop-blur-md shadow-lg">
                        <?php echo esc_html($hero_secondary_btn_text); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Documents Section -->
    <?php if (!empty($case_documents)) : ?>
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo esc_html($case_docs_title); ?>
                    </h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        <?php echo esc_html($case_docs_description); ?>
                    </p>
                </div>
                
                <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl border border-gray-200 shadow-lg p-8 md:p-10">
                    <ol class="space-y-4">
                        <?php 
                        $counter = 1;
                        foreach ($case_documents as $doc) : 
                            $doc_title = isset($doc['title']) ? $doc['title'] : '';
                            $doc_file_url = isset($doc['file_url']) ? $doc['file_url'] : '';
                            $doc_behavior = isset($doc['behavior']) ? $doc['behavior'] : 'both';
                            $doc_note = isset($doc['note']) ? $doc['note'] : '';
                            
                            // Skip if no title
                            if (empty($doc_title)) continue;
                            
                            // Use file_url directly
                            $file_url = $doc_file_url;
                            
                            // Get file extension for display
                            $file_ext = '';
                            $file_type_label = 'Document';
                            if (!empty($file_url)) {
                                $file_ext = strtoupper(pathinfo($file_url, PATHINFO_EXTENSION));
                                if ($file_ext === 'PDF') {
                                    $file_type_label = 'PDF';
                                } elseif (in_array($file_ext, array('DOC', 'DOCX'))) {
                                    $file_type_label = 'Word';
                                } elseif (in_array($file_ext, array('JPG', 'JPEG', 'PNG', 'GIF'))) {
                                    $file_type_label = 'Image';
                                } elseif (in_array($file_ext, array('XLS', 'XLSX'))) {
                                    $file_type_label = 'Excel';
                                }
                            }
                        ?>
                            <li class="group">
                                <?php if (!empty($file_url)) : ?>
                                    <div class="flex flex-col sm:flex-row items-start justify-between p-5 rounded-xl bg-white border border-gray-200 hover:border-primary/40 hover:shadow-md transition-all duration-300 gap-4">
                                        <div class="flex items-start space-x-4 flex-1 min-w-0">
                                            <div class="flex-shrink-0 mt-1">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-sm">
                                                    <?php echo esc_html($counter); ?>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                                    <?php echo esc_html($doc_title); ?>
                                                </h3>
                                                <?php if (!empty($doc_note)) : ?>
                                                    <p class="text-sm text-gray-500 mb-2">
                                                        <?php echo esc_html($doc_note); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if (!empty($file_ext)) : ?>
                                                    <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs font-semibold">
                                                        <?php echo esc_html($file_ext); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2 sm:flex-shrink-0">
                                            <?php if ($doc_behavior === 'both' || $doc_behavior === 'open') : ?>
                                                <a href="<?php echo esc_url($file_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                    View
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($doc_behavior === 'both' || $doc_behavior === 'download') : ?>
                                                <a href="<?php echo esc_url($file_url); ?>" download="<?php echo esc_attr(basename($file_url)); ?>" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Download
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="flex items-start p-5 rounded-xl bg-white border border-gray-200">
                                        <div class="flex items-start space-x-4 flex-1">
                                            <div class="flex-shrink-0 mt-1">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold text-sm">
                                                    <?php echo esc_html($counter); ?>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                                    <?php echo esc_html($doc_title); ?>
                                                </h3>
                                                <?php if (!empty($doc_note)) : ?>
                                                    <p class="text-sm text-gray-500">
                                                        <?php echo esc_html($doc_note); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php 
                            $counter++;
                        endforeach; 
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- FAQ Section -->
    <?php if (!empty($faq_items)) : ?>
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo esc_html($faq_title); ?>
                    </h2>
                    <p class="text-lg text-gray-600">
                        <?php echo esc_html($faq_description); ?>
                    </p>
                </div>
                
                <div class="space-y-4">
                    <?php foreach ($faq_items as $index => $faq) : 
                        $question = isset($faq['question']) ? $faq['question'] : '';
                        $answer = isset($faq['answer']) ? $faq['answer'] : '';
                        if (empty($question)) continue;
                    ?>
                        <div class="bg-gray-50 rounded-xl shadow-sm border border-gray-200 overflow-hidden faq-item">
                            <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors duration-200" data-faq-index="<?php echo esc_attr($index); ?>">
                                <span class="text-lg font-semibold text-gray-900 pr-8">
                                    <?php echo esc_html($question); ?>
                                </span>
                                <svg class="faq-icon w-6 h-6 text-primary flex-shrink-0 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="faq-answer hidden px-6 pb-5 bg-white">
                                <p class="text-gray-600 leading-relaxed">
                                    <?php echo esc_html($answer); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<script>
// FAQ Accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            const faqItem = this.closest('.faq-item');
            const answer = faqItem.querySelector('.faq-answer');
            const icon = faqItem.querySelector('.faq-icon');
            const isOpen = !answer.classList.contains('hidden');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-item').forEach(function(item) {
                if (item !== faqItem) {
                    item.querySelector('.faq-answer').classList.add('hidden');
                    item.querySelector('.faq-icon').classList.remove('rotate-180');
                }
            });
            
            // Toggle current FAQ
            if (isOpen) {
                answer.classList.add('hidden');
                icon.classList.remove('rotate-180');
            } else {
                answer.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
