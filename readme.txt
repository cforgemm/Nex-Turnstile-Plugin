=== Cloudflare Turnstile Add-On for NEX Forms ===
Contributors: Mark B Marquis
Tags: nex forms, cloudflare, turnstile, captcha, spam protection, forms
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add Cloudflare Turnstile spam protection to NEX Forms automatically, with easy setup and light/dark theme options.

== Description ==

The **Cloudflare Turnstile Add-On for NEX Forms** seamlessly integrates Turnstile's privacy-friendly CAPTCHA alternative into your NEX Forms submissions.

It automatically inserts the Turnstile widget above the form’s submit button, verifies each response server-side, and ensures your forms are protected from spam bots — without intrusive user challenges.

### ✳️ Features
* Auto-injects Cloudflare Turnstile into NEX Forms.
* Verifies submissions securely with Cloudflare's API.
* Light or dark widget themes.
* Loads scripts only on pages containing a NEX Forms shortcode.
* Compatible with both static and AJAX-rendered forms.
* Detects global Turnstile settings if the main Cloudflare plugin is active.

### 🧩 Works With
* **NEX Forms – Ultimate Form Builder** plugin
* **Cloudflare Turnstile** (official plugin optional)

### 🔒 Privacy Focused
Cloudflare Turnstile protects forms from spam without tracking or invasive user challenges.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/cloudflare-turnstile-nexforms/` directory, or install the ZIP via **Plugins → Add New → Upload Plugin**.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to **Settings → Turnstile for NEX Forms**.
4. Enter your **Cloudflare Site Key** and **Secret Key**.
5. Choose your preferred theme (light or dark).
6. Save and test your NEX Form — the Turnstile widget should appear above the submit button.

== Frequently Asked Questions ==

= Does this require the Cloudflare Turnstile plugin? =
No. This add-on works independently, but if you already have the official Turnstile plugin installed, it will automatically reuse your global keys.

= Can I use this plugin with other form builders? =
This version is specifically built for **NEX Forms**. Other builders (like Contact Form 7 or WPForms) should use their own Turnstile integrations.

= Does it support AJAX submissions? =
Yes — the script automatically detects and re-renders the Turnstile widget after dynamic form loads.

= Will it slow down my site? =
No. The Cloudflare Turnstile script loads only on pages containing a NEX Forms shortcode.

== Screenshots ==

1. Turnstile widget above the NEX Forms submit button.
2. Settings page where you enter your Cloudflare keys.

== Changelog ==

= 1.0.0 =
* Initial release.
* Adds Turnstile widget to NEX Forms automatically.
* Verifies submissions via Cloudflare API.
* Includes light/dark theme options and settings page.

== Upgrade Notice ==

= 1.0.0 =
First release — safely integrates Turnstile with NEX Forms.

== License ==

This plugin is licensed under the GPLv2 or later.
You may modify and redistribute it under the same license.
