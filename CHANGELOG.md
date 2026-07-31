# Changelog

## 1.14.0

- Positions LowVolt Vault as the growing primary library for low-voltage field guides, checklists, troubleshooting notes, and technician resources.
- Keeps Payhip prominent for individual guide downloads and preserves every existing product link.
- Adds live and source audit coverage for both resource-library paths without duplicating the products section.

## 1.13.2

- Corrects Holt Holdings and merchandise-request email defaults to `holtholdingsllc@outlook.com`.
- Adds a dedicated Customizer setting for merchandise notifications with safe legacy-address fallback.
- Shows the attempted destination in the **Merch Requests** list and full mail handoff details on each request.
- Documents manual request testing and the difference between WordPress storage, mail handoff, and inbox delivery.

## 1.13.1

- Retains every validated merchandise request privately in WordPress before email is attempted.
- Adds an admin-visible **Merch Requests** list with customer and email-handoff status.
- Replaces the ambiguous “request was sent” notice with separate storage and mail-handoff results.
- Records the email destination, attempt time, return status, and any `wp_mail_failed` error.
- Adds a visible direct-email fallback beneath the form.

## 1.13.0

- Added the merchandise catalog and secure order-request form.
- Added responsive merchandise cards and branded placeholders.
- Added Merch to homepage shortcuts, fallback navigation, and footer navigation.
- Hardened deployment verification against webhook-only false positives.
- Reworked live and source audits around rendered/configured items.
- Deduplicated Payhip bot-protection warnings and retained confirmed 404/410 failures.
- Added responsive checks at 320, 375, 768, 1024, and 1280 pixels.
