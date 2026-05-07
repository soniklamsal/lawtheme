<?php
/**
 * Pro Bono Page Meta Boxes
 * Custom meta boxes for template-probono.php (no ACF required)
 */

// Add meta boxes
add_action('add_meta_boxes', 'probono_add_meta_boxes');
function probono_add_meta_boxes() {
    global $post;
    
    // Get the current template
    $template = get_post_meta($post->ID, '_wp_page_template', true);
    
    // Only add meta boxes if Pro Bono template is selected
    if ($template === 'templates/template-probono.php') {
        add_meta_box(
            'probono_hero_meta',
            'Pro Bono - Hero Section',
            'probono_hero_meta_callback',
            'page',
            'normal',
            'high'
        );
        
        add_meta_box(
            'probono_case_docs_meta',
            'Pro Bono - Case Documents',
            'probono_case_docs_meta_callback',
            'page',
            'normal',
            'high'
        );
        
        add_meta_box(
            'probono_faq_meta',
            'Pro Bono - FAQ Section',
            'probono_faq_meta_callback',
            'page',
            'normal',
            'high'
        );
    }
}

// Refresh meta boxes when template changes
add_action('admin_footer-post.php', 'probono_refresh_on_template_change');
add_action('admin_footer-post-new.php', 'probono_refresh_on_template_change');
function probono_refresh_on_template_change() {
    global $post_type;
    if ('page' !== $post_type) {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        var originalTemplate = $('#page_template').val();
        
        $('#page_template').on('change', function() {
            var newTemplate = $(this).val();
            
            // Check if switching to/from Pro Bono template
            if ((originalTemplate === 'templates/template-probono.php' && newTemplate !== 'templates/template-probono.php') ||
                (originalTemplate !== 'templates/template-probono.php' && newTemplate === 'templates/template-probono.php')) {
                
                // Show a notice that page needs to be saved
                if ($('#probono-template-notice').length === 0) {
                    $('#page_template').after('<p id="probono-template-notice" style="color:#d63638;font-weight:600;margin-top:10px;">⚠ Please save/update the page to see the Pro Bono fields.</p>');
                }
            }
        });
    });
    </script>
    <?php
}

// Enqueue media uploader scripts
add_action('admin_enqueue_scripts', 'probono_enqueue_media_uploader');
function probono_enqueue_media_uploader($hook) {
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        wp_enqueue_media();
    }
}

// Hero Section Meta Box
function probono_hero_meta_callback($post) {
    wp_nonce_field('probono_meta_nonce', 'probono_meta_nonce');
    
    $badge = get_post_meta($post->ID, '_probono_hero_badge', true);
    $title = get_post_meta($post->ID, '_probono_hero_title', true);
    $subtitle = get_post_meta($post->ID, '_probono_hero_subtitle', true);
    $bg_image = get_post_meta($post->ID, '_probono_hero_bg_image', true);
    $primary_btn_text = get_post_meta($post->ID, '_probono_hero_primary_btn_text', true);
    $primary_btn_link = get_post_meta($post->ID, '_probono_hero_primary_btn_link', true);
    $secondary_btn_text = get_post_meta($post->ID, '_probono_hero_secondary_btn_text', true);
    $secondary_btn_link = get_post_meta($post->ID, '_probono_hero_secondary_btn_link', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="probono_hero_badge">Badge Text</label></th>
            <td><input type="text" id="probono_hero_badge" name="probono_hero_badge" value="<?php echo esc_attr($badge); ?>" class="regular-text" placeholder="Pro Bono Legal Support"></td>
        </tr>
        <tr>
            <th><label for="probono_hero_title">Hero Title</label></th>
            <td><input type="text" id="probono_hero_title" name="probono_hero_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="Access to Justice for Those Who Need It Most"></td>
        </tr>
        <tr>
            <th><label for="probono_hero_subtitle">Hero Subtitle</label></th>
            <td><textarea id="probono_hero_subtitle" name="probono_hero_subtitle" rows="3" class="large-text" placeholder="We provide compassionate legal guidance..."><?php echo esc_textarea($subtitle); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="probono_hero_bg_image">Background Image</label></th>
            <td>
                <input type="text" id="probono_hero_bg_image" name="probono_hero_bg_image" value="<?php echo esc_url($bg_image); ?>" class="large-text" placeholder="Click 'Upload Image' button" readonly>
                <button type="button" class="button probono-upload-hero-image">Upload Image</button>
                <?php if ($bg_image) : ?>
                    <button type="button" class="button probono-remove-hero-image">Remove Image</button>
                <?php endif; ?>
                <p class="description">Upload a background image for the hero section (optional)</p>
                <?php if ($bg_image) : ?>
                    <div class="probono-hero-image-preview" style="margin-top: 10px;">
                        <img src="<?php echo esc_url($bg_image); ?>" style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label for="probono_hero_primary_btn_text">Primary Button Text</label></th>
            <td><input type="text" id="probono_hero_primary_btn_text" name="probono_hero_primary_btn_text" value="<?php echo esc_attr($primary_btn_text); ?>" class="regular-text" placeholder="Apply for Assistance"></td>
        </tr>
        <tr>
            <th><label for="probono_hero_primary_btn_link">Primary Button Link</label></th>
            <td><input type="text" id="probono_hero_primary_btn_link" name="probono_hero_primary_btn_link" value="<?php echo esc_attr($primary_btn_link); ?>" class="regular-text" placeholder="#contact"></td>
        </tr>
        <tr>
            <th><label for="probono_hero_secondary_btn_text">Secondary Button Text</label></th>
            <td><input type="text" id="probono_hero_secondary_btn_text" name="probono_hero_secondary_btn_text" value="<?php echo esc_attr($secondary_btn_text); ?>" class="regular-text" placeholder="Contact Our Team"></td>
        </tr>
        <tr>
            <th><label for="probono_hero_secondary_btn_link">Secondary Button Link</label></th>
            <td><input type="text" id="probono_hero_secondary_btn_link" name="probono_hero_secondary_btn_link" value="<?php echo esc_attr($secondary_btn_link); ?>" class="regular-text" placeholder="/contact"></td>
        </tr>
    </table>
    
    <script>
    jQuery(document).ready(function($) {
        var heroMediaUploader;
        
        // Upload hero background image
        $('.probono-upload-hero-image').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            
            // If the media frame already exists, reopen it
            if (heroMediaUploader) {
                heroMediaUploader.open();
                return;
            }
            
            // Create the media frame
            heroMediaUploader = wp.media({
                title: 'Select Hero Background Image',
                button: {
                    text: 'Use This Image'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            });
            
            // When an image is selected, run a callback
            heroMediaUploader.on('select', function() {
                var attachment = heroMediaUploader.state().get('selection').first().toJSON();
                $('#probono_hero_bg_image').val(attachment.url);
                
                // Show preview
                var previewHtml = '<div class="probono-hero-image-preview" style="margin-top: 10px;"><img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 4px;"></div>';
                $('.probono-hero-image-preview').remove();
                button.parent().find('.description').after(previewHtml);
                
                // Show remove button if not already visible
                if (!$('.probono-remove-hero-image').length) {
                    button.after('<button type="button" class="button probono-remove-hero-image">Remove Image</button>');
                }
            });
            
            // Open the uploader dialog
            heroMediaUploader.open();
        });
        
        // Remove hero background image
        $(document).on('click', '.probono-remove-hero-image', function(e) {
            e.preventDefault();
            $('#probono_hero_bg_image').val('');
            $('.probono-hero-image-preview').remove();
            $(this).remove();
        });
    });
    </script>
    <?php
}

// Case Documents Meta Box
function probono_case_docs_meta_callback($post) {
    $title = get_post_meta($post->ID, '_probono_case_docs_title', true);
    $description = get_post_meta($post->ID, '_probono_case_docs_description', true);
    $documents = get_post_meta($post->ID, '_probono_case_documents', true);
    if (!is_array($documents)) {
        $documents = array();
    }
    ?>
    <table class="form-table">
        <tr>
            <th><label for="probono_case_docs_title">Section Title</label></th>
            <td><input type="text" id="probono_case_docs_title" name="probono_case_docs_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="Important Legal Cases & Documents"></td>
        </tr>
        <tr>
            <th><label for="probono_case_docs_description">Section Description</label></th>
            <td><textarea id="probono_case_docs_description" name="probono_case_docs_description" rows="2" class="large-text" placeholder="Access key legal documents..."><?php echo esc_textarea($description); ?></textarea></td>
        </tr>
    </table>
    
    <div id="probono-documents-wrapper" style="margin-top: 20px;">
        <h4>Case Documents</h4>
        <div id="probono-documents-list">
            <?php
            if (!empty($documents)) {
                foreach ($documents as $index => $doc) {
                    probono_render_document_row($index, $doc);
                }
            }
            ?>
        </div>
        <button type="button" class="button" id="add-probono-document">Add Document</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var docIndex = <?php echo count($documents); ?>;
        var mediaUploader;
        
        // Add new document
        $('#add-probono-document').on('click', function() {
            var html = `
                <div class="probono-document-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; background: #f9f9f9;">
                    <table class="form-table">
                        <tr>
                            <th style="width: 150px;"><label>Case Title</label></th>
                            <td><input type="text" name="probono_documents[${docIndex}][title]" class="large-text" placeholder="Case Title"></td>
                        </tr>
                        <tr>
                            <th><label>Document File</label></th>
                            <td>
                                <input type="text" name="probono_documents[${docIndex}][file_url]" class="probono-file-url large-text" placeholder="Click 'Upload File' button" readonly>
                                <button type="button" class="button probono-upload-file" data-index="${docIndex}">Upload File</button>
                                <p class="description">Upload PDF, DOC, DOCX, or any document format</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Optional Note</label></th>
                            <td><input type="text" name="probono_documents[${docIndex}][note]" class="large-text" placeholder="Landmark case"></td>
                        </tr>
                        <tr>
                            <th><label>Behavior</label></th>
                            <td>
                                <select name="probono_documents[${docIndex}][behavior]">
                                    <option value="both">Both (View & Download)</option>
                                    <option value="open">Open in new tab</option>
                                    <option value="download">Download file</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <button type="button" class="button remove-probono-document">Remove</button>
                </div>
            `;
            $('#probono-documents-list').append(html);
            docIndex++;
        });
        
        // Remove document
        $(document).on('click', '.remove-probono-document', function() {
            $(this).closest('.probono-document-item').remove();
        });
        
        // Upload file button
        $(document).on('click', '.probono-upload-file', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var inputField = button.siblings('.probono-file-url');
            
            // If the media frame already exists, reopen it
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            // Create the media frame
            mediaUploader = wp.media({
                title: 'Upload Document',
                button: {
                    text: 'Select File'
                },
                multiple: false
            });
            
            // When a file is selected, run a callback
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                inputField.val(attachment.url);
            });
            
            // Open the uploader dialog
            mediaUploader.open();
        });
    });
    </script>
    <?php
}

function probono_render_document_row($index, $doc) {
    $title = isset($doc['title']) ? $doc['title'] : '';
    $file_url = isset($doc['file_url']) ? $doc['file_url'] : '';
    $note = isset($doc['note']) ? $doc['note'] : '';
    $behavior = isset($doc['behavior']) ? $doc['behavior'] : 'both';
    ?>
    <div class="probono-document-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; background: #f9f9f9;">
        <table class="form-table">
            <tr>
                <th style="width: 150px;"><label>Case Title</label></th>
                <td><input type="text" name="probono_documents[<?php echo $index; ?>][title]" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="Case Title"></td>
            </tr>
            <tr>
                <th><label>Document File</label></th>
                <td>
                    <input type="text" name="probono_documents[<?php echo $index; ?>][file_url]" value="<?php echo esc_url($file_url); ?>" class="probono-file-url large-text" placeholder="Click 'Upload File' button" readonly>
                    <button type="button" class="button probono-upload-file" data-index="<?php echo $index; ?>">Upload File</button>
                    <p class="description">Upload PDF, DOC, DOCX, or any document format</p>
                </td>
            </tr>
            <tr>
                <th><label>Optional Note</label></th>
                <td><input type="text" name="probono_documents[<?php echo $index; ?>][note]" value="<?php echo esc_attr($note); ?>" class="large-text" placeholder="Landmark case"></td>
            </tr>
            <tr>
                <th><label>Behavior</label></th>
                <td>
                    <select name="probono_documents[<?php echo $index; ?>][behavior]">
                        <option value="both" <?php selected($behavior, 'both'); ?>>Both (View & Download)</option>
                        <option value="open" <?php selected($behavior, 'open'); ?>>Open in new tab</option>
                        <option value="download" <?php selected($behavior, 'download'); ?>>Download file</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="button" class="button remove-probono-document">Remove</button>
    </div>
    <?php
}

// FAQ Section Meta Box
function probono_faq_meta_callback($post) {
    $title = get_post_meta($post->ID, '_probono_faq_title', true);
    $description = get_post_meta($post->ID, '_probono_faq_description', true);
    $faqs = get_post_meta($post->ID, '_probono_faqs', true);
    if (!is_array($faqs)) {
        $faqs = array();
    }
    ?>
    <table class="form-table">
        <tr>
            <th><label for="probono_faq_title">Section Title</label></th>
            <td><input type="text" id="probono_faq_title" name="probono_faq_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="Frequently Asked Questions"></td>
        </tr>
        <tr>
            <th><label for="probono_faq_description">Section Description</label></th>
            <td><textarea id="probono_faq_description" name="probono_faq_description" rows="2" class="large-text" placeholder="Common questions about our pro bono legal services..."><?php echo esc_textarea($description); ?></textarea></td>
        </tr>
    </table>
    
    <div id="probono-faq-wrapper" style="margin-top: 20px;">
        <h4>FAQ Items</h4>
        <div id="probono-faq-list">
            <?php
            if (!empty($faqs)) {
                foreach ($faqs as $index => $faq) {
                    probono_render_faq_row($index, $faq);
                }
            }
            ?>
        </div>
        <button type="button" class="button" id="add-probono-faq">Add FAQ</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var faqIndex = <?php echo count($faqs); ?>;
        
        $('#add-probono-faq').on('click', function() {
            var html = `
                <div class="probono-faq-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; background: #f9f9f9;">
                    <p><label><strong>Question:</strong></label><br>
                    <input type="text" name="probono_faqs[${faqIndex}][question]" class="large-text" placeholder="Is pro bono service completely free?"></p>
                    <p><label><strong>Answer:</strong></label><br>
                    <textarea name="probono_faqs[${faqIndex}][answer]" rows="4" class="large-text" placeholder="Yes, pro bono legal services are provided..."></textarea></p>
                    <button type="button" class="button remove-probono-faq">Remove</button>
                </div>
            `;
            $('#probono-faq-list').append(html);
            faqIndex++;
        });
        
        $(document).on('click', '.remove-probono-faq', function() {
            $(this).closest('.probono-faq-item').remove();
        });
    });
    </script>
    <?php
}

function probono_render_faq_row($index, $faq) {
    $question = isset($faq['question']) ? $faq['question'] : '';
    $answer = isset($faq['answer']) ? $faq['answer'] : '';
    ?>
    <div class="probono-faq-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; background: #f9f9f9;">
        <p><label><strong>Question:</strong></label><br>
        <input type="text" name="probono_faqs[<?php echo $index; ?>][question]" value="<?php echo esc_attr($question); ?>" class="large-text" placeholder="Is pro bono service completely free?"></p>
        <p><label><strong>Answer:</strong></label><br>
        <textarea name="probono_faqs[<?php echo $index; ?>][answer]" rows="4" class="large-text" placeholder="Yes, pro bono legal services are provided..."><?php echo esc_textarea($answer); ?></textarea></p>
        <button type="button" class="button remove-probono-faq">Remove</button>
    </div>
    <?php
}

// Save meta box data
add_action('save_post', 'probono_save_meta_boxes');
function probono_save_meta_boxes($post_id) {
    // Check nonce
    if (!isset($_POST['probono_meta_nonce']) || !wp_verify_nonce($_POST['probono_meta_nonce'], 'probono_meta_nonce')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save Hero fields
    if (isset($_POST['probono_hero_badge'])) {
        update_post_meta($post_id, '_probono_hero_badge', sanitize_text_field($_POST['probono_hero_badge']));
    }
    if (isset($_POST['probono_hero_title'])) {
        update_post_meta($post_id, '_probono_hero_title', sanitize_text_field($_POST['probono_hero_title']));
    }
    if (isset($_POST['probono_hero_subtitle'])) {
        update_post_meta($post_id, '_probono_hero_subtitle', sanitize_textarea_field($_POST['probono_hero_subtitle']));
    }
    if (isset($_POST['probono_hero_bg_image'])) {
        update_post_meta($post_id, '_probono_hero_bg_image', esc_url_raw($_POST['probono_hero_bg_image']));
    }
    if (isset($_POST['probono_hero_primary_btn_text'])) {
        update_post_meta($post_id, '_probono_hero_primary_btn_text', sanitize_text_field($_POST['probono_hero_primary_btn_text']));
    }
    if (isset($_POST['probono_hero_primary_btn_link'])) {
        update_post_meta($post_id, '_probono_hero_primary_btn_link', sanitize_text_field($_POST['probono_hero_primary_btn_link']));
    }
    if (isset($_POST['probono_hero_secondary_btn_text'])) {
        update_post_meta($post_id, '_probono_hero_secondary_btn_text', sanitize_text_field($_POST['probono_hero_secondary_btn_text']));
    }
    if (isset($_POST['probono_hero_secondary_btn_link'])) {
        update_post_meta($post_id, '_probono_hero_secondary_btn_link', sanitize_text_field($_POST['probono_hero_secondary_btn_link']));
    }
    
    // Save Case Documents
    if (isset($_POST['probono_case_docs_title'])) {
        update_post_meta($post_id, '_probono_case_docs_title', sanitize_text_field($_POST['probono_case_docs_title']));
    }
    if (isset($_POST['probono_case_docs_description'])) {
        update_post_meta($post_id, '_probono_case_docs_description', sanitize_textarea_field($_POST['probono_case_docs_description']));
    }
    if (isset($_POST['probono_documents'])) {
        $documents = array();
        foreach ($_POST['probono_documents'] as $doc) {
            $documents[] = array(
                'title' => sanitize_text_field($doc['title']),
                'file_url' => esc_url_raw($doc['file_url']),
                'note' => sanitize_text_field($doc['note']),
                'behavior' => sanitize_text_field($doc['behavior'])
            );
        }
        update_post_meta($post_id, '_probono_case_documents', $documents);
    }
    
    // Save FAQ
    if (isset($_POST['probono_faq_title'])) {
        update_post_meta($post_id, '_probono_faq_title', sanitize_text_field($_POST['probono_faq_title']));
    }
    if (isset($_POST['probono_faq_description'])) {
        update_post_meta($post_id, '_probono_faq_description', sanitize_textarea_field($_POST['probono_faq_description']));
    }
    if (isset($_POST['probono_faqs'])) {
        $faqs = array();
        foreach ($_POST['probono_faqs'] as $faq) {
            $faqs[] = array(
                'question' => sanitize_text_field($faq['question']),
                'answer' => sanitize_textarea_field($faq['answer'])
            );
        }
        update_post_meta($post_id, '_probono_faqs', $faqs);
    }
}
