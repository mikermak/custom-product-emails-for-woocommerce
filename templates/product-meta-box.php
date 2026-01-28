<div class="cpe-product-email-settings">

    <!-- Enable/Disable Toggle -->
    <div class="cpe-field">
        <label class="cpe-toggle">
            <input type="checkbox" name="cpe_email_enabled" value="yes" <?php checked($enabled, 'yes'); ?>>
            <span class="cpe-toggle-slider"></span>
            <span class="cpe-toggle-label">Custom Email Inschakelen voor dit Product</span>
        </label>
        <p class="description">
            Wanneer dit product gekocht wordt, wordt automatisch deze custom email verzonden naar de klant.
        </p>
    </div>

    <div class="cpe-email-settings" style="<?php echo $enabled !== 'yes' ? 'display:none;' : ''; ?>">

        <!-- Email Subject -->
        <div class="cpe-field">
            <label for="cpe_email_subject">
                <strong><?php echo Custom_Product_Emails_WC::get_icon('mail'); ?> Email Onderwerp</strong>
            </label>
            <input
                type="text"
                id="cpe_email_subject"
                name="cpe_email_subject"
                class="widefat"
                value="<?php echo esc_attr($subject); ?>"
                placeholder="Bedankt voor je aankoop van {product_name}"
            >
            <p class="description">Dit verschijnt in de inbox als onderwerpregel. Gebruik shortcodes voor personalisatie.</p>
        </div>

        <!-- Email Heading -->
        <div class="cpe-field">
            <label for="cpe_email_heading">
                <strong><?php echo Custom_Product_Emails_WC::get_icon('clipboard'); ?> Email Heading</strong>
            </label>
            <input
                type="text"
                id="cpe_email_heading"
                name="cpe_email_heading"
                class="widefat"
                value="<?php echo esc_attr($heading); ?>"
                placeholder="Bedankt voor je bestelling!"
            >
            <p class="description">De grote titel bovenaan in de email (binnen de email template).</p>
        </div>

        <!-- Email Content -->
        <div class="cpe-field">
            <label for="cpe_email_content">
                <strong><?php echo Custom_Product_Emails_WC::get_icon('pen-tool'); ?> Email Inhoud</strong>
            </label>
            <?php
            wp_editor($content, 'cpe_email_content', array(
                'textarea_name' => 'cpe_email_content',
                'textarea_rows' => 15,
                'media_buttons' => true,
                'teeny' => false,
                'tinymce' => array(
                    'toolbar1' => 'formatselect,bold,italic,underline,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,forecolor,backcolor',
                    'toolbar2' => 'undo,redo,removeformat,charmap,outdent,indent,hr,pastetext'
                )
            ));
            ?>
            <p class="description">
                De hoofdinhoud van je email. Gebruik HTML of de visual editor. De email wordt automatisch gestyled in jouw WooCommerce email stijl.
            </p>
        </div>

        <!-- Shortcodes Info -->
        <div class="cpe-shortcodes-info">
            <h4><?php echo Custom_Product_Emails_WC::get_icon('tag'); ?> Beschikbare Shortcodes</h4>
            <div class="cpe-shortcodes-list">
                <span class="cpe-shortcode" data-shortcode="{customer_first_name}">{customer_first_name}</span>
                <span class="cpe-shortcode" data-shortcode="{customer_last_name}">{customer_last_name}</span>
                <span class="cpe-shortcode" data-shortcode="{customer_full_name}">{customer_full_name}</span>
                <span class="cpe-shortcode" data-shortcode="{customer_email}">{customer_email}</span>
                <span class="cpe-shortcode" data-shortcode="{product_name}">{product_name}</span>
                <span class="cpe-shortcode" data-shortcode="{product_sku}">{product_sku}</span>
                <span class="cpe-shortcode" data-shortcode="{order_number}">{order_number}</span>
                <span class="cpe-shortcode" data-shortcode="{order_date}">{order_date}</span>
                <span class="cpe-shortcode" data-shortcode="{order_total}">{order_total}</span>
                <span class="cpe-shortcode" data-shortcode="{quantity}">{quantity}</span>
                <span class="cpe-shortcode" data-shortcode="{site_name}">{site_name}</span>
                <span class="cpe-shortcode" data-shortcode="{site_url}">{site_url}</span>
            </div>
            <p class="description">Klik op een shortcode om deze te kopieren.</p>
        </div>

        <!-- Test Email -->
        <div class="cpe-test-email">
            <h4><?php echo Custom_Product_Emails_WC::get_icon('flask'); ?> Test Email Verzenden</h4>
            <p>Stuur een test email om te zien hoe deze eruit ziet:</p>
            <div class="cpe-test-email-form">
                <input
                    type="email"
                    id="cpe_test_email_address"
                    class="regular-text"
                    placeholder="jouw@email.nl"
                    value="<?php echo esc_attr(wp_get_current_user()->user_email); ?>"
                >
                <button type="button" id="cpe_send_test_email" class="button button-secondary">
                    <?php echo Custom_Product_Emails_WC::get_icon('send', 16); ?> Stuur Test Email
                </button>
                <span class="cpe-test-email-result"></span>
            </div>
            <p class="description">
                <strong>Let op:</strong> Sla het product eerst op voordat je een test verstuurt!
            </p>
        </div>

    </div>

</div>

<style>
.cpe-product-email-settings {
    padding: 15px;
}

.cpe-field {
    margin-bottom: 20px;
}

.cpe-field label strong {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 8px;
    font-size: 14px;
}

.cpe-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
}

.cpe-toggle {
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.cpe-toggle input[type="checkbox"] {
    display: none;
}

.cpe-toggle-slider {
    position: relative;
    width: 50px;
    height: 26px;
    background: #ccc;
    border-radius: 26px;
    transition: background 0.3s;
    margin-right: 12px;
}

.cpe-toggle-slider:before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    left: 3px;
    top: 3px;
    background: white;
    border-radius: 50%;
    transition: transform 0.3s;
}

.cpe-toggle input:checked + .cpe-toggle-slider {
    background: #2271b1;
}

.cpe-toggle input:checked + .cpe-toggle-slider:before {
    transform: translateX(24px);
}

.cpe-toggle-label {
    font-weight: 600;
    font-size: 15px;
}

.cpe-shortcodes-info {
    background: #f0f6fc;
    border: 1px solid #c3e3ff;
    border-radius: 4px;
    padding: 15px;
    margin-top: 20px;
}

.cpe-shortcodes-info h4 {
    margin-top: 0;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.cpe-shortcodes-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}

.cpe-shortcode {
    background: white;
    border: 1px solid #2271b1;
    color: #2271b1;
    padding: 4px 10px;
    border-radius: 3px;
    font-family: monospace;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
}

.cpe-shortcode:hover {
    background: #2271b1;
    color: white;
}

.cpe-test-email {
    background: #fff8e5;
    border: 1px solid #ffc107;
    border-radius: 4px;
    padding: 15px;
    margin-top: 20px;
}

.cpe-test-email h4 {
    margin-top: 0;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.cpe-test-email-form {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 10px 0;
}

.cpe-test-email-result {
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.cpe-test-email-result.success {
    color: #00a32a;
}

.cpe-test-email-result.error {
    color: #d63638;
}

#cpe_send_test_email {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

#cpe_send_test_email:disabled {
    opacity: 0.5;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Icons for JavaScript usage
    var icons = {
        send: '<?php echo addslashes(Custom_Product_Emails_WC::get_icon('send', 16)); ?>',
        loader: '<?php echo addslashes(Custom_Product_Emails_WC::get_icon('loader', 16)); ?>',
        check: '<?php echo addslashes(Custom_Product_Emails_WC::get_icon('check', 16)); ?>',
        x: '<?php echo addslashes(Custom_Product_Emails_WC::get_icon('x', 16)); ?>'
    };

    // Toggle email settings visibility
    $('input[name="cpe_email_enabled"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('.cpe-email-settings').slideDown();
        } else {
            $('.cpe-email-settings').slideUp();
        }
    });

    // Copy shortcode on click
    $('.cpe-shortcode').on('click', function() {
        var shortcode = $(this).data('shortcode');
        navigator.clipboard.writeText(shortcode).then(function() {
            // Visual feedback
            var $el = $(event.target);
            var originalText = $el.text();
            $el.html(icons.check + ' Gekopieerd!');
            setTimeout(function() {
                $el.text(originalText);
            }, 1500);
        });
    });

    // Test email
    $('#cpe_send_test_email').on('click', function() {
        var $btn = $(this);
        var $result = $('.cpe-test-email-result');
        var email = $('#cpe_test_email_address').val();
        var productId = $('#post_ID').val();

        if (!email) {
            $result.removeClass('success').addClass('error').html(icons.x + ' Voer een email adres in!');
            return;
        }

        $btn.prop('disabled', true).html(icons.loader + ' Verzenden...');
        $result.text('');

        $.ajax({
            url: cpeAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'cpe_test_email',
                nonce: cpeAjax.nonce,
                product_id: productId,
                test_email: email
            },
            success: function(response) {
                if (response.success) {
                    $result.removeClass('error').addClass('success').html(icons.check + ' ' + response.data.message);
                } else {
                    $result.removeClass('success').addClass('error').html(icons.x + ' ' + response.data.message);
                }
            },
            error: function() {
                $result.removeClass('success').addClass('error').html(icons.x + ' Er ging iets mis!');
            },
            complete: function() {
                $btn.prop('disabled', false).html(icons.send + ' Stuur Test Email');
            }
        });
    });
});
</script>
