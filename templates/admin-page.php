<div class="wrap cpe-admin-wrap">
    <h1><?php echo Custom_Product_Emails_WC::get_icon('mail', 24); ?> Custom Product Emails</h1>

    <div class="cpe-dashboard">
        <!-- Statistieken Cards -->
        <div class="cpe-stats-grid">
            <div class="cpe-stat-card">
                <div class="cpe-stat-icon"><?php echo Custom_Product_Emails_WC::get_icon('shopping-bag', 32); ?></div>
                <div class="cpe-stat-content">
                    <h3><?php echo $total_products; ?></h3>
                    <p>Totaal Producten</p>
                </div>
            </div>

            <div class="cpe-stat-card highlight">
                <div class="cpe-stat-icon"><?php echo Custom_Product_Emails_WC::get_icon('mail', 32); ?></div>
                <div class="cpe-stat-content">
                    <h3><?php echo $products_with_custom_emails; ?></h3>
                    <p>Producten met Custom Email</p>
                </div>
            </div>

            <div class="cpe-stat-card">
                <div class="cpe-stat-icon"><?php echo Custom_Product_Emails_WC::get_icon('bar-chart', 32); ?></div>
                <div class="cpe-stat-content">
                    <h3><?php echo $products_with_custom_emails > 0 ? round(($products_with_custom_emails / $total_products) * 100) : 0; ?>%</h3>
                    <p>Email Coverage</p>
                </div>
            </div>
        </div>

        <!-- Uitleg sectie -->
        <div class="cpe-info-box">
            <h2><?php echo Custom_Product_Emails_WC::get_icon('rocket'); ?> Hoe werkt het?</h2>
            <ol>
                <li>Ga naar een <strong>Product</strong> en scroll naar de <strong>"Custom Product Email"</strong> sectie</li>
                <li>Schakel de custom email <strong>in</strong> voor dat product</li>
                <li>Pas het <strong>onderwerp, heading en inhoud</strong> aan naar wens</li>
                <li>Gebruik <strong>shortcodes</strong> om dynamische content toe te voegen</li>
                <li>De email wordt <strong>automatisch verzonden</strong> wanneer het product gekocht wordt</li>
            </ol>
        </div>

        <!-- Beschikbare shortcodes -->
        <div class="cpe-shortcodes-box">
            <h2><?php echo Custom_Product_Emails_WC::get_icon('tag'); ?> Beschikbare Shortcodes</h2>
            <p>Gebruik deze shortcodes in je email onderwerp, heading of inhoud:</p>

            <div class="cpe-shortcodes-grid">
                <div class="cpe-shortcode-item">
                    <code>{customer_first_name}</code>
                    <span>Voornaam klant</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{customer_last_name}</code>
                    <span>Achternaam klant</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{customer_full_name}</code>
                    <span>Volledige naam</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{customer_email}</code>
                    <span>Email adres klant</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{product_name}</code>
                    <span>Productnaam</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{product_sku}</code>
                    <span>Product SKU</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{order_number}</code>
                    <span>Bestelnummer</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{order_date}</code>
                    <span>Besteldatum</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{order_total}</code>
                    <span>Totaalbedrag</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{quantity}</code>
                    <span>Aantal gekocht</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{site_name}</code>
                    <span>Website naam</span>
                </div>
                <div class="cpe-shortcode-item">
                    <code>{site_url}</code>
                    <span>Website URL</span>
                </div>
            </div>
        </div>

        <!-- Producten met custom emails -->
        <?php if (!empty($products_with_emails)): ?>
        <div class="cpe-products-list">
            <h2><?php echo Custom_Product_Emails_WC::get_icon('package'); ?> Producten met Custom Email</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 60px;">Afbeelding</th>
                        <th>Product Naam</th>
                        <th>Email Onderwerp</th>
                        <th style="width: 150px;">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products_with_emails as $prod):
                        $product = wc_get_product($prod->ID);
                        $subject = get_post_meta($prod->ID, '_cpe_email_subject', true);
                    ?>
                    <tr>
                        <td>
                            <?php echo $product->get_image('thumbnail'); ?>
                        </td>
                        <td>
                            <strong><?php echo $product->get_name(); ?></strong>
                            <br>
                            <small>SKU: <?php echo $product->get_sku() ?: 'N/A'; ?></small>
                        </td>
                        <td>
                            <?php echo esc_html($subject); ?>
                        </td>
                        <td>
                            <a href="<?php echo get_edit_post_link($prod->ID); ?>" class="button button-small">
                                <?php echo Custom_Product_Emails_WC::get_icon('pencil', 16); ?> Bewerken
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="cpe-empty-state">
            <div class="cpe-empty-icon"><?php echo Custom_Product_Emails_WC::get_icon('inbox', 48); ?></div>
            <h3>Nog geen custom emails ingesteld</h3>
            <p>Ga naar een product en schakel de custom email in om te beginnen!</p>
            <a href="<?php echo admin_url('edit.php?post_type=product'); ?>" class="button button-primary">
                Naar Producten
            </a>
        </div>
        <?php endif; ?>

        <!-- Tips -->
        <div class="cpe-tips-box">
            <h2><?php echo Custom_Product_Emails_WC::get_icon('lightbulb'); ?> Tips voor effectieve product emails</h2>
            <ul>
                <li><strong>Personaliseer:</strong> Gebruik shortcodes zoals {customer_first_name} om de email persoonlijk te maken</li>
                <li><strong>Wees specifiek:</strong> Vermeld specifieke productinformatie zoals gebruiksinstructies of downloadlinks</li>
                <li><strong>Call-to-action:</strong> Voeg duidelijke knoppen of links toe voor vervolgacties</li>
                <li><strong>Test eerst:</strong> Gebruik de test-functie op de product pagina om je email te controleren</li>
                <li><strong>Mobiel vriendelijk:</strong> Houd je content kort en scanbaar voor mobiele gebruikers</li>
            </ul>
        </div>
    </div>
</div>
