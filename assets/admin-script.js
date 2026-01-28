jQuery(document).ready(function($) {
    'use strict';

    // Shortcode copy to clipboard functionality
    $(document).on('click', '.cpe-shortcode', function() {
        const shortcode = $(this).data('shortcode') || $(this).text();
        
        // Copy to clipboard
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(shortcode).then(function() {
                showCopyFeedback($(this));
            }.bind(this), function(err) {
                console.error('Could not copy text: ', err);
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = shortcode;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                showCopyFeedback($(this));
            } catch (err) {
                console.error('Fallback: Could not copy text: ', err);
            }
            document.body.removeChild(textArea);
        }
    });

    function showCopyFeedback($element) {
        const originalText = $element.text();
        const originalBg = $element.css('background-color');
        
        $element.text('✓ Gekopieerd!')
            .css({
                'background-color': '#00a32a',
                'color': 'white',
                'border-color': '#00a32a'
            });
        
        setTimeout(function() {
            $element.text(originalText)
                .css({
                    'background-color': originalBg,
                    'color': '',
                    'border-color': ''
                });
        }, 1500);
    }

    // Smooth scroll animations
    $('.cpe-stat-card, .cpe-info-box, .cpe-shortcodes-box, .cpe-products-list, .cpe-tips-box').each(function(index) {
        $(this).css({
            'animation-delay': (index * 0.1) + 's'
        });
    });

    // Enhanced table row hover effect
    $('.cpe-products-list table tbody tr').hover(
        function() {
            $(this).css('background-color', '#f5f5f5');
        },
        function() {
            $(this).css('background-color', '');
        }
    );

    // Add tooltips to shortcodes
    if ($.fn.tooltip) {
        $('.cpe-shortcode').tooltip({
            title: 'Klik om te kopiëren',
            placement: 'top',
            trigger: 'hover'
        });
    }

    console.log('Custom Product Emails - Admin scripts geladen');
});
