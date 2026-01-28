# Custom Product Emails voor WooCommerce

🚀 **Stuur automatisch gepersonaliseerde emails wanneer specifieke producten gekocht worden!**

## 📋 Overzicht

Deze WordPress plugin stelt je in staat om voor elk WooCommerce product een unieke, gepersonaliseerde email te maken die automatisch verzonden wordt wanneer dat product gekocht wordt. Perfect voor:

- 📥 Download instructies
- 🎓 Cursus toegangscodes  
- 📚 E-book leveringen
- 🎁 Speciale bedankjes
- 📖 Gebruiksinstructies
- 🔑 Licentie keys
- ✨ En nog veel meer!

## ✨ Features

- ✅ **Per Product Email**: Maak voor elk product een unieke email
- 🎨 **WooCommerce Styling**: Emails gebruiken automatisch jouw WooCommerce email template
- 🏷️ **Shortcodes**: Personaliseer emails met klant- en ordergegevens
- 📊 **Dashboard**: Overzichtelijk dashboard met statistieken
- 🧪 **Test Functie**: Stuur test emails voordat je live gaat
- 📝 **Visual Editor**: Gebruik de WordPress editor voor gemakkelijk opmaken
- ⚡ **Automatisch**: Emails worden direct verstuurd bij aankoop
- 🔒 **Veilig**: Geen dubbele verzendingen dankzij intelligente checks

## 🔧 Installatie

### Methode 1: Handmatige Installatie

1. **Download** de plugin bestanden
2. **Upload** de hele map naar `/wp-content/plugins/`
3. **Activeer** de plugin via het 'Plugins' menu in WordPress
4. Je ziet nu een nieuw **"Product Emails"** menu item in je WordPress admin

### Methode 2: Via ZIP Upload

1. **Pak** alle bestanden in een ZIP bestand
2. Ga naar **WordPress Admin → Plugins → Nieuwe plugin**
3. Klik op **"Plugin uploaden"**
4. **Upload** het ZIP bestand en activeer de plugin

## 📁 Bestandsstructuur

```
custom-product-emails-for-woocommerce/
├── custom-product-emails-for-woocommerce.php   # Hoofd plugin bestand
├── templates/
│   ├── admin-page.php                          # Dashboard template
│   └── product-meta-box.php                    # Product settings template
├── assets/
│   ├── admin-style.css                         # Admin styling
│   └── admin-script.js                         # Admin JavaScript
└── README.md                                   # Deze handleiding
```

## 🚀 Gebruik

### Stap 1: Email Instellen voor een Product

1. Ga naar **Producten** in je WordPress admin
2. **Bewerk** het product waarvoor je een custom email wilt
3. Scroll naar de **"Custom Product Email"** sectie
4. **Schakel de toggle in** om de custom email te activeren
5. Vul de volgende velden in:
   - **Email Onderwerp**: De onderwerpregel (bijv. "Bedankt voor je aankoop!")
   - **Email Heading**: De grote titel in de email
   - **Email Inhoud**: De volledige email inhoud

### Stap 2: Personaliseer met Shortcodes

Gebruik deze shortcodes in je email voor dynamische content:

| Shortcode | Beschrijving |
|-----------|-------------|
| `{customer_first_name}` | Voornaam van de klant |
| `{customer_last_name}` | Achternaam van de klant |
| `{customer_full_name}` | Volledige naam |
| `{customer_email}` | Email adres |
| `{product_name}` | Naam van het product |
| `{product_sku}` | Product SKU code |
| `{order_number}` | Bestelnummer |
| `{order_date}` | Besteldatum |
| `{order_total}` | Totaalbedrag |
| `{quantity}` | Aantal gekocht |
| `{site_name}` | Je website naam |
| `{site_url}` | Je website URL |

### Stap 3: Test de Email

1. Vul je **email adres** in bij "Test Email Verzenden"
2. Klik op **"Stuur Test Email"**
3. **Controleer** je inbox (ook spam folder!)
4. **Pas aan** indien nodig

### Stap 4: Publiceer

1. Klik op **"Bijwerken"** of **"Publiceren"**
2. De email wordt nu automatisch verzonden bij aankoop! 🎉

## 📧 Voorbeeld Email Template

Hier is een voorbeeld om mee te starten:

**Onderwerp:**
```
Bedankt voor je aankoop, {customer_first_name}! 🎉
```

**Heading:**
```
Je bestelling is bevestigd!
```

**Inhoud:**
```html
Beste {customer_first_name},

Hartelijk dank voor je aankoop van <strong>{product_name}</strong>!

<h3>📦 Bestelling Details</h3>
<ul>
    <li>Bestelnummer: #{order_number}</li>
    <li>Datum: {order_date}</li>
    <li>Product: {product_name}</li>
    <li>Aantal: {quantity}</li>
</ul>

<h3>📥 Volgende Stappen</h3>
<p>Je kunt nu aan de slag met je aankoop! Mocht je vragen hebben, neem dan gerust contact met ons op.</p>

<p>Veel plezier!</p>

<p>Met vriendelijke groet,<br>
Het team van {site_name}</p>
```

## 🎨 Email Styling

De plugin gebruikt **automatisch** de WooCommerce email template van je thema, inclusief:

- ✅ Header met logo
- ✅ Kleuren en styling van je thema
- ✅ Footer met contactgegevens
- ✅ Mobiel responsive design

Je hoeft je dus **geen zorgen** te maken over de opmaak - dat wordt automatisch geregeld!

## ⚙️ Wanneer Worden Emails Verzonden?

Emails worden automatisch verzonden wanneer een order de status **"Verwerken"** of **"Voltooid"** krijgt. Dit gebeurt meestal direct na een succesvolle betaling.

**Belangrijke note:** Emails worden maar **één keer** verzonden per order om dubbele emails te voorkomen.

## 🔍 Dashboard Overzicht

Ga naar **Product Emails** in je WordPress menu voor:

- 📊 **Statistieken**: Zie hoeveel producten een custom email hebben
- 📦 **Productenoverzicht**: Lijst van alle producten met custom emails
- 📚 **Shortcode Referentie**: Overzicht van alle beschikbare shortcodes
- 💡 **Tips**: Best practices voor effectieve emails

## 🛠️ Technische Details

### Vereisten

- **WordPress**: 5.8 of hoger
- **WooCommerce**: 5.0 of hoger
- **PHP**: 7.4 of hoger

### Hooks & Filters

De plugin gebruikt de volgende WooCommerce hooks:

```php
// Trigger bij order status change
add_action('woocommerce_order_status_completed', 'send_emails');
add_action('woocommerce_order_status_processing', 'send_emails');
```

### Database

Alle instellingen worden opgeslagen als **post meta** data:

- `_cpe_email_enabled` - Of custom email actief is (yes/no)
- `_cpe_email_subject` - Email onderwerp
- `_cpe_email_heading` - Email heading
- `_cpe_email_content` - Email inhoud
- `_cpe_emails_sent` - Order meta om dubbele verzending te voorkomen

## 🐛 Troubleshooting

### Emails worden niet verzonden

1. **Controleer** of de custom email is **ingeschakeld** voor het product
2. **Verifieer** dat de order status op "Verwerken" of "Voltooid" staat
3. **Test** je WordPress email instellingen met een andere plugin
4. **Controleer** de server logs voor PHP errors
5. Gebruik een **SMTP plugin** zoals WP Mail SMTP voor betrouwbaardere email verzending

### Styling ziet er niet goed uit

De plugin gebruikt je WooCommerce email template. Om de styling aan te passen:

1. Ga naar **WooCommerce → Instellingen → Emails**
2. Pas daar je **basis email instellingen** aan
3. Deze styling wordt automatisch toegepast op alle emails

### Shortcodes werken niet

- Zorg dat je de **exacte shortcode syntax** gebruikt (inclusief accolades)
- **Spaties** voor of na de accolades kunnen problemen veroorzaken
- Test met een **eenvoudige shortcode** zoals `{product_name}` eerst

## 💡 Best Practices

1. **Personaliseer altijd**: Gebruik minimaal `{customer_first_name}` voor een persoonlijke touch
2. **Houd het kort**: Niemand leest lange emails - kom direct to the point
3. **Test uitgebreid**: Stuur altijd een test email voor je live gaat
4. **Mobiel first**: De meeste mensen lezen emails op hun telefoon
5. **Duidelijke CTA**: Zorg voor duidelijke call-to-action knoppen
6. **Controleer spam score**: Test je emails op spam triggers
7. **Gebruik SMTP**: Voor betrouwbare verzending, gebruik een SMTP plugin

## 🔒 Beveiliging

- Alle user input wordt **gesanitized** en **escaped**
- **Nonce verificatie** voor alle forms
- **Capability checks** voor admin functies
- **XSS protectie** via WordPress functies

## 📝 Changelog

### Versie 1.0.0
- 🎉 Initiële release
- ✅ Per product email configuratie
- ✅ Dashboard met statistieken
- ✅ Shortcode ondersteuning
- ✅ Test email functionaliteit
- ✅ WooCommerce template integratie

## 👨‍💻 Ondersteuning

Heb je vragen of loop je tegen problemen aan?

- 📧 Email: jouw@email.nl
- 🌐 Website: https://jouwwebsite.nl
- 📖 Documentatie: Bekijk deze README

## 📄 Licentie

Deze plugin is ontwikkeld voor persoonlijk/commercieel gebruik.

## 🙏 Credits

Ontwikkeld met ❤️ voor betere WooCommerce email ervaring!

---

**Veel succes met je custom product emails!** 🚀
