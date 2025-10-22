# Cloudflare Turnstile Add-on for NEX Forms

Adds Cloudflare Turnstile widget to NEX Forms, with server-side verification.

## Installation
1. Upload the plugin folder to `/wp-content/plugins/` or install the ZIP via WP Admin.
2. Activate plugin.
3. Visit Settings → Turnstile for NEX Forms and enter keys (or leave blank to use official plugin keys).
4. Test NEX Forms pages.

## Notes
- The plugin detects official Cloudflare Turnstile plugin keys and will prefer them if present.
- Server-side verification uses `nexforms_before_email`.
