# 🚀 QUICK START GUIDE

## Snelle Installatie in 5 Minuten

### Stap 1: Installeer de Plugin ⚡

1. Upload alle bestanden naar `/wp-content/plugins/custom-product-emails-for-woocommerce/`
2. Activeer de plugin in WordPress via **Plugins → Geïnstalleerde plugins**
3. Je ziet nu een nieuw menu item: **Product Emails** ✉️

### Stap 2: Maak Je Eerste Custom Email 📧

1. Ga naar **Producten → Alle producten**
2. Klik op **Bewerken** bij een product
3. Scroll naar beneden naar het **"📧 Custom Product Email"** blok
4. Schakel de toggle **AAN** ✅
5. Vul de velden in:

```
Onderwerp: Bedankt voor je aankoop, {customer_first_name}! 🎉
Heading: Je bestelling is bevestigd!
Inhoud: [Plak een van de templates uit EMAIL-TEMPLATES.md]
```

6. Klik op **"Bijwerken"**

### Stap 3: Test Je Email 🧪

1. Vul je email adres in bij **"Test Email Verzenden"**
2. Klik op **"✉️ Stuur Test Email"**
3. Check je inbox (en spam!)
4. Ziet het er goed uit? Perfect! 🎉

### Stap 4: Live! 🚀

De email wordt nu **automatisch** verzonden wanneer het product gekocht wordt!

---

## Dashboard Overzicht 📊

Ga naar **Product Emails** in je WordPress menu om:

- ✅ Statistieken te zien
- ✅ Alle producten met custom emails te bekijken
- ✅ Shortcodes te raadplegen
- ✅ Tips en tricks te lezen

---

## Meest Gebruikte Shortcodes 🏷️

Gebruik deze in je emails voor personalisatie:

- `{customer_first_name}` → Voornaam
- `{customer_full_name}` → Volledige naam
- `{product_name}` → Productnaam
- `{order_number}` → Bestelnummer
- `{order_date}` → Besteldatum

[Zie README.md voor alle shortcodes]

---

## Troubleshooting 🔧

### Email komt niet aan?

1. ✅ Check of de toggle **AAN** staat
2. ✅ Verifieer of de order status "Verwerken" of "Voltooid" is
3. ✅ Installeer een SMTP plugin zoals "WP Mail SMTP"
4. ✅ Check je spam folder

### Styling ziet er raar uit?

- De plugin gebruikt je **WooCommerce email template**
- Pas deze aan via **WooCommerce → Instellingen → Emails**

### Shortcodes werken niet?

- Controleer op **typefouten** in de shortcode
- Zorg voor **geen spaties** in de accolades: `{product_name}` ✅ / `{ product_name }` ❌

---

## Support & Vragen ❓

Heb je vragen of loop je vast?

📧 **Email**: support@jouwwebsite.nl  
📖 **Documentatie**: Zie README.md  
💬 **Community**: [Link naar forum/community]

---

## Volgende Stappen 🎯

1. ✅ Maak custom emails voor je belangrijkste producten
2. ✅ Test alle emails uitgebreid
3. ✅ Monitor de verzending via WooCommerce order notes
4. ✅ Optimaliseer op basis van feedback van klanten
5. ✅ Overweeg een SMTP plugin voor 100% deliverability

---

**Veel succes met je custom product emails!** 🚀

P.S. Vergeet niet om de plugin een ⭐⭐⭐⭐⭐ review te geven als je tevreden bent!
