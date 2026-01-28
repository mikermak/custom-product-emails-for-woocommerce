<?php
/**
 * Plugin Name: Custom Product Emails voor WooCommerce
 * Plugin URI: https://jouwwebsite.nl
 * Description: Stuur automatisch aangepaste emails wanneer specifieke producten gekocht worden
 * Version: 1.0.0
 * Author: Jouw Naam
 * Author URI: https://jouwwebsite.nl
 * Text Domain: custom-product-emails
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Controleer of WooCommerce actief is
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_notices', function() {
        echo '<div class="error"><p><strong>Custom Product Emails voor WooCommerce</strong> vereist dat WooCommerce geïnstalleerd en geactiveerd is.</p></div>';
    });
    return;
}

class Custom_Product_Emails_WC {

    private static $instance = null;

    /**
     * Lucide icon SVGs
     */
    private static $icons = array(
        'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
        'shopping-bag' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
        'bar-chart' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="20" y2="10"/><line x1="18" x2="18" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="16"/></svg>',
        'rocket' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>',
        'tag' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>',
        'package' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>',
        'pencil' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>',
        'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>',
        'lightbulb' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>',
        'clipboard' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>',
        'pen-tool' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"/><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"/><path d="m2.3 2.3 7.286 7.286"/><circle cx="11" cy="11" r="2"/></svg>',
        'flask' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/><path d="M8.5 2h7"/><path d="M7 16h10"/></svg>',
        'loader' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4"/><path d="m16.2 7.8 2.9-2.9"/><path d="M18 12h4"/><path d="m16.2 16.2 2.9 2.9"/><path d="M12 18v4"/><path d="m4.9 19.1 2.9-2.9"/><path d="M2 12h4"/><path d="m4.9 4.9 2.9 2.9"/></svg>',
        'check' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>',
        'x' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>',
        'send' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>',
    );

    /**
     * Get Lucide icon SVG
     */
    public static function get_icon($name, $size = 20) {
        if (isset(self::$icons[$name])) {
            $icon = self::$icons[$name];
            if ($size !== 20) {
                $icon = str_replace(array('width="20"', 'height="20"'), array('width="' . $size . '"', 'height="' . $size . '"'), $icon);
            }
            return '<span class="cpe-icon">' . $icon . '</span>';
        }
        return '';
    }
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // Plugin constanten
        define('CPE_VERSION', '1.0.0');
        define('CPE_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('CPE_PLUGIN_URL', plugin_dir_url(__FILE__));
        
        // Hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('add_meta_boxes', array($this, 'add_product_meta_box'));
        add_action('save_post_product', array($this, 'save_product_email_settings'), 10, 2);
        add_action('woocommerce_order_status_completed', array($this, 'send_custom_product_emails'), 10, 1);
        add_action('woocommerce_order_status_processing', array($this, 'send_custom_product_emails'), 10, 1);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // Disable emoji conversion in emails
        add_filter('wp_mail', array($this, 'disable_emojis_in_emails'), 10, 1);
        
        // AJAX hooks
        add_action('wp_ajax_cpe_test_email', array($this, 'ajax_send_test_email'));
    }
    
    /**
     * Voeg admin menu toe
     */
    public function add_admin_menu() {
        add_menu_page(
            'Custom Product Emails',
            'Product Emails',
            'manage_woocommerce',
            'custom-product-emails',
            array($this, 'render_admin_page'),
            'dashicons-email-alt',
            56
        );
    }
    
    /**
     * Laad admin scripts en styles
     */
    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_custom-product-emails' === $hook || 'post.php' === $hook || 'post-new.php' === $hook) {
            wp_enqueue_editor();
            wp_enqueue_style('cpe-admin-style', CPE_PLUGIN_URL . 'assets/admin-style.css', array(), CPE_VERSION);
            wp_enqueue_script('cpe-admin-script', CPE_PLUGIN_URL . 'assets/admin-script.js', array('jquery'), CPE_VERSION, true);
            wp_localize_script('cpe-admin-script', 'cpeAjax', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('cpe_test_email_nonce')
            ));
        }
    }
    
    /**
     * Render admin pagina
     */
    public function render_admin_page() {
        // Haal alle producten op met custom emails
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_cpe_email_enabled',
                    'value' => 'yes',
                    'compare' => '='
                )
            )
        );
        
        $products_with_emails = get_posts($args);
        
        // Haal statistieken op
        $total_products = wp_count_posts('product')->publish;
        $products_with_custom_emails = count($products_with_emails);
        
        include CPE_PLUGIN_DIR . 'templates/admin-page.php';
    }
    
    /**
     * Voeg meta box toe aan product edit pagina
     */
    public function add_product_meta_box() {
        add_meta_box(
            'cpe_product_email',
            self::get_icon('mail') . ' Custom Product Email',
            array($this, 'render_product_meta_box'),
            'product',
            'normal',
            'high'
        );
    }
    
    /**
     * Render product meta box
     */
    public function render_product_meta_box($post) {
        wp_nonce_field('cpe_save_product_email', 'cpe_product_email_nonce');
        
        $enabled = get_post_meta($post->ID, '_cpe_email_enabled', true);
        $subject = get_post_meta($post->ID, '_cpe_email_subject', true);
        $heading = get_post_meta($post->ID, '_cpe_email_heading', true);
        $content = get_post_meta($post->ID, '_cpe_email_content', true);
        
        // Default waarden
        if (empty($subject)) {
            $subject = 'Bedankt voor je aankoop van {product_name}';
        }
        if (empty($heading)) {
            $heading = 'Bedankt voor je bestelling!';
        }
        
        include CPE_PLUGIN_DIR . 'templates/product-meta-box.php';
    }
    
    /**
     * Sla product email instellingen op
     */
    public function save_product_email_settings($post_id, $post) {
        // Verificatie checks
        if (!isset($_POST['cpe_product_email_nonce']) || !wp_verify_nonce($_POST['cpe_product_email_nonce'], 'cpe_save_product_email')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Sla instellingen op
        $enabled = isset($_POST['cpe_email_enabled']) ? 'yes' : 'no';
        update_post_meta($post_id, '_cpe_email_enabled', $enabled);
        
        if (isset($_POST['cpe_email_subject'])) {
            update_post_meta($post_id, '_cpe_email_subject', sanitize_text_field($_POST['cpe_email_subject']));
        }
        
        if (isset($_POST['cpe_email_heading'])) {
            update_post_meta($post_id, '_cpe_email_heading', sanitize_text_field($_POST['cpe_email_heading']));
        }
        
        if (isset($_POST['cpe_email_content'])) {
            update_post_meta($post_id, '_cpe_email_content', wp_kses_post($_POST['cpe_email_content']));
        }
    }
    
    /**
     * Stuur custom emails voor producten in de order
     */
    public function send_custom_product_emails($order_id) {
        $order = wc_get_order($order_id);
        
        if (!$order) {
            return;
        }
        
        // Voorkom dubbele verzending
        if ($order->get_meta('_cpe_emails_sent')) {
            return;
        }
        
        $items = $order->get_items();
        $emails_sent = false;
        
        foreach ($items as $item) {
            $product_id = $item->get_product_id();
            $enabled = get_post_meta($product_id, '_cpe_email_enabled', true);
            
            if ($enabled === 'yes') {
                $this->send_product_email($order, $product_id, $item);
                $emails_sent = true;
            }
        }
        
        if ($emails_sent) {
            $order->update_meta_data('_cpe_emails_sent', 'yes');
            $order->save();
        }
    }
    
    /**
     * Disable emoji conversion in emails
     * Prevents WordPress from converting emojis to large images
     */
    public function disable_emojis_in_emails($args) {
        // Check if this is likely our custom email (contains WooCommerce template markers)
        if (isset($args['message']) && 
            (strpos($args['message'], 'email-header') !== false || 
             strpos($args['message'], 'email-footer') !== false)) {
            
            // Remove WordPress emoji conversion filters temporarily
            $this->remove_emoji_filters();
            
            // Restore filters after email is sent
            add_action('phpmailer_init', array($this, 'restore_emoji_filters'), 999);
        }
        
        return $args;
    }
    
    /**
     * Remove WordPress emoji conversion filters
     */
    private function remove_emoji_filters() {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }
    
    /**
     * Restore WordPress emoji filters after email is sent
     */
    public function restore_emoji_filters() {
        // Re-add the default WordPress emoji filters
        add_action('wp_head', 'print_emoji_detection_script', 7);
        add_action('admin_print_scripts', 'print_emoji_detection_script');
        add_action('wp_print_styles', 'print_emoji_styles');
        add_action('admin_print_styles', 'print_emoji_styles');
        add_filter('the_content_feed', 'wp_staticize_emoji');
        add_filter('comment_text_rss', 'wp_staticize_emoji');
        add_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }
    
    /**
     * Verstuur de email voor een specifiek product
     */
    private function send_product_email($order, $product_id, $item) {
        $product = wc_get_product($product_id);
        
        if (!$product) {
            return;
        }
        
        // Haal email instellingen op
        $subject = get_post_meta($product_id, '_cpe_email_subject', true);
        $heading = get_post_meta($product_id, '_cpe_email_heading', true);
        $content = get_post_meta($product_id, '_cpe_email_content', true);
        
        if (empty($content)) {
            return;
        }
        
        // Vervang shortcodes
        $subject = $this->replace_shortcodes($subject, $order, $product, $item);
        $heading = $this->replace_shortcodes($heading, $order, $product, $item);
        $content = $this->replace_shortcodes($content, $order, $product, $item);
        
        // Bereid email voor
        $to = $order->get_billing_email();
        $mailer = WC()->mailer();
        
        // Gebruik WooCommerce email template
        ob_start();
        wc_get_template('emails/email-header.php', array('email_heading' => $heading));
        echo wpautop($content);
        wc_get_template('emails/email-footer.php');
        $message = ob_get_clean();
        
        // Stuur email
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $message, $headers);
        
        // Log in order notes
        $order->add_order_note(sprintf(
            'Custom product email verzonden voor: %s',
            $product->get_name()
        ));
    }
    
    /**
     * Vervang shortcodes in email content
     */
    private function replace_shortcodes($text, $order, $product, $item) {
        $replacements = array(
            '{customer_first_name}' => $order->get_billing_first_name(),
            '{customer_last_name}' => $order->get_billing_last_name(),
            '{customer_full_name}' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
            '{customer_email}' => $order->get_billing_email(),
            '{product_name}' => $product->get_name(),
            '{product_sku}' => $product->get_sku(),
            '{order_number}' => $order->get_order_number(),
            '{order_date}' => $order->get_date_created()->date_i18n(get_option('date_format')),
            '{order_total}' => $order->get_formatted_order_total(),
            '{quantity}' => $item->get_quantity(),
            '{site_name}' => get_bloginfo('name'),
            '{site_url}' => home_url(),
        );
        
        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }
    
    /**
     * AJAX handler voor test email
     */
    public function ajax_send_test_email() {
        check_ajax_referer('cpe_test_email_nonce', 'nonce');
        
        if (!current_user_can('manage_woocommerce')) {
            wp_send_json_error(array('message' => 'Geen toegang'));
        }
        
        $product_id = intval($_POST['product_id']);
        $test_email = sanitize_email($_POST['test_email']);
        
        if (!$product_id || !is_email($test_email)) {
            wp_send_json_error(array('message' => 'Ongeldige gegevens'));
        }
        
        // Maak een dummy order voor de test
        $product = wc_get_product($product_id);
        $subject = get_post_meta($product_id, '_cpe_email_subject', true);
        $heading = get_post_meta($product_id, '_cpe_email_heading', true);
        $content = get_post_meta($product_id, '_cpe_email_content', true);
        
        // Simpele shortcode replacement voor test
        $replacements = array(
            '{customer_first_name}' => 'Jan',
            '{customer_last_name}' => 'Jansen',
            '{customer_full_name}' => 'Jan Jansen',
            '{customer_email}' => $test_email,
            '{product_name}' => $product->get_name(),
            '{product_sku}' => $product->get_sku(),
            '{order_number}' => '12345',
            '{order_date}' => date_i18n(get_option('date_format')),
            '{order_total}' => '€99,99',
            '{quantity}' => '1',
            '{site_name}' => get_bloginfo('name'),
            '{site_url}' => home_url(),
        );
        
        $subject = str_replace(array_keys($replacements), array_values($replacements), $subject);
        $heading = str_replace(array_keys($replacements), array_values($replacements), $heading);
        $content = str_replace(array_keys($replacements), array_values($replacements), $content);
        
        // Maak email
        ob_start();
        wc_get_template('emails/email-header.php', array('email_heading' => $heading));
        echo wpautop($content);
        wc_get_template('emails/email-footer.php');
        $message = ob_get_clean();
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $sent = wp_mail($test_email, '[TEST] ' . $subject, $message, $headers);
        
        if ($sent) {
            wp_send_json_success(array('message' => 'Test email verzonden naar ' . $test_email));
        } else {
            wp_send_json_error(array('message' => 'Fout bij verzenden van test email'));
        }
    }
}

// Initialiseer plugin
function cpe_init() {
    return Custom_Product_Emails_WC::get_instance();
}
add_action('plugins_loaded', 'cpe_init');
