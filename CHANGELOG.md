# Changelog

## 1.16.2

- Cache-busts production version checks by commit SHA so a stale homepage cache cannot create a false deployment failure.

## 1.16.1

- Prevents intrinsic card and hero content widths from causing horizontal overflow on 320 px and 375 px homepages.

## 1.16.0

- Converts the long homepage hub into a curated homepage and six dedicated portfolio pages.
- Adds real page navigation for Businesses & Projects, Digital Products, Tools & Resources, Merch, About, and Contact.
- Preserves centralized business, product, resource, social, merchandise, form-storage, and notification configuration.
- Moves the complete merchandise catalog and secure request form to `/merch/` while retaining WordPress-first storage.
- Gives every managed page unique title, description, canonical, Open Graph, and Twitter metadata.
- Expands live and responsive audits across all seven public routes.

## 1.15.0

- Removes the public BitReady GitHub button and legacy deployment/test comments from customer-facing HTML.
- Prepares merchandise cards for square front/angled photos and optional design, color, inventory, reorder, style, and size details.
- Restricts merchandise requests to administrator review and expands the request list with customer, product, fulfillment, request, and notification status.
- Adds duplicate submission detection, per-origin rate limiting, stricter field limits, fulfillment allow-listing, and explicit header-injection rejection.
- Keeps request storage authoritative even when the WordPress email handoff fails.
- Sends a GitHub-compatible push payload to Deployer for Git and verifies deployment with a non-customer-facing version meta tag.

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
