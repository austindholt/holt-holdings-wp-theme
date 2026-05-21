# Holt Holdings WordPress Theme

A custom lightweight WordPress theme for `holtholdings.us`, built as a clean portfolio and project hub for Austin Holt and Holt Holdings LLC.

## Repository Structure

This repository is intended to be the source of truth for the WordPress theme. The editable theme files live at the repository root for Git deployment compatibility.

The root includes:

- `style.css`
- `functions.php`
- `index.php`
- `header.php`
- `footer.php`
- `front-page.php`
- `page.php`
- `assets/`
- `README.md`
- `screenshot.png`

The WordPress theme header is in the top-level `style.css`. The theme name is **Holt Holdings**.

## Git Deployment

For Deployer for Git or a similar WordPress Git deployment plugin, use this repository URL placeholder:

`https://github.com/<YOUR-GITHUB-USERNAME>/holt-holdings-wp-theme`

Current GitHub repository for this theme:

`https://github.com/austindholt/holt-holdings-wp-theme`

Recommended deployment target inside WordPress:

`wp-content/themes/holt-holdings`

If the GitHub repo is private, the deployment plugin may require authentication, a deploy key, a GitHub token, or a Pro/private-repo feature. Do not commit SiteGround credentials, WordPress admin credentials, API keys, tokens, or private deployment secrets to this repository.

## GitHub Actions Deployment

This repo is connected to WordPress through the Deployer for Git plugin. The GitHub Actions workflow at `.github/workflows/deploy-wordpress-theme.yml` triggers the WordPress theme update after pushes to the `main` branch.

Required GitHub Actions repository secret:

- `WP_DEPLOY_URL`

`WP_DEPLOY_URL` should contain the Deployer for Git Push to Deploy URL. The deploy URL must never be committed to this repository, printed in docs, or stored in code.

The workflow also supports manual runs from the **Actions** tab in GitHub using **Deploy WordPress Theme > Run workflow**.

To manually trigger a deploy from GitHub:

1. Open the repository on GitHub.
2. Go to **Actions**.
3. Select **Deploy WordPress Theme**.
4. Click **Run workflow**.
5. Choose the `main` branch and confirm.

The workflow logs should show that the Deployer for Git endpoint was called and should display the HTTP status code without printing the secret URL.

## Installation

1. In WordPress, go to **Appearance > Themes > Add New > Upload Theme**.
2. Upload `holt-holdings.zip`.
3. Activate **Holt Holdings**.
4. Go to **Settings > Reading** if you want to assign a static homepage.
5. Go to **Appearance > Menus** and assign menus to **Primary Menu** and **Footer Menu**.

## Editing Site Content

The main homepage copy and public links can be edited in **Appearance > Customize > Holt Holdings Home**. The source defaults live in the centralized `holt_holdings_home_config()` section of `functions.php`.

- Hero headline and subheadline
- Low Volt Crash Course link
- DIY Website Builder / Website Launch Kit link
- ExacqVision Storage Server Setup Checklist / Field SOP link
- Contact email
- Business links
- Social links, including Linktree, Facebook, Instagram, YouTube, TikTok, and Hands On Idaho social links

Unknown public links are kept empty so the theme hides them or renders non-clickable Coming Soon labels instead of misleading placeholder buttons.

## Weekly Link Audit

The workflow at `.github/workflows/weekly-link-audit.yml` runs weekly and can also be triggered manually from GitHub Actions. It checks that the known public Holt Holdings, social, Hands On Idaho, and Payhip URLs are present in the theme source and that public render files do not regress to placeholder social/product links.

## Logo

The theme supports the WordPress custom logo feature. Add the Holt Holdings logo in **Appearance > Customize > Site Identity > Logo**. If no custom logo is uploaded, the header falls back to the text `Holt Holdings.`.

The uploaded logo is also included in the theme at `assets/images/holt-holdings-logo.jpeg` for convenience.

## Fallback Zip Build

Git deployment should be the primary update path going forward. If you need a manual upload package, run this from the repository root in PowerShell:

```powershell
.\build-theme-zip.ps1
```

This creates `holt-holdings.zip` as a fallback upload artifact. The zip file is ignored by git and should not be treated as the source of truth.

## Included Files

- `style.css`
- `functions.php`
- `index.php`
- `header.php`
- `footer.php`
- `front-page.php`
- `page.php`
- `assets/js/navigation.js`
- `assets/images/holt-holdings-logo.jpeg`
- `screenshot.png`

## Notes

- No paid plugins are required.
- The theme registers Primary and Footer menu locations.
- Unknown business, product, and social links should stay empty until a real URL is ready.
- The design is mobile-first, responsive, and intentionally lightweight.

## Changelog

### 1.10.0

- Replaced placeholder social buttons with real Linktree, Instagram, YouTube, TikTok, Facebook, Hands On Idaho, and Payhip product links.
- Added the ExacqVision Storage Server Setup Checklist / Field SOP digital product.
- Hid unknown social links instead of rendering empty clickable placeholders.
- Kept Dirty Dumps disabled from the public homepage and Wireman/Drill Bit Index as non-clickable Coming Soon items.
- Added a weekly GitHub Actions link audit for required public URLs and blocked placeholder regressions.

### 1.9.0

- Improved GitHub Actions deploy logging without exposing the Push to Deploy URL.
- Added clearer curl failure behavior and retry handling for Deployer for Git.
- Added an auto deploy workflow test HTML comment.

### 1.8.0

- Hardcoded the known public URLs for Hands On Idaho, DIY Website Builder, and Low Volt Crash Course in the rendered homepage config.
- Removed old product hash fallback values from the rendered homepage data path.
- Added a visible footer Payhip test link and source comment for live verification.

### 1.7.0

- Forced known external product/business links to their real URLs even when older WordPress Customizer hash placeholders are saved.
- Added a visible footer verification line for the external product link fix.
- Added an external product links deployment verification HTML comment.

### 1.6.0

- Fixed external link rendering so known external URLs open in a new tab with safe `noopener noreferrer` attributes.
- Added helper functions for external link detection and button link output.
- Changed unknown social placeholders into non-clickable Coming Soon items instead of misleading hash links.
- Added an external-link deployment verification HTML comment.

### 1.5.0

- Reworked the homepage into a personal link tree / portfolio hub.
- Added Featured Links for Hands On Idaho, DIY Website Builder, Low Volt Crash Course, and Wireman.
- Added real product URLs for DIY Website Builder and Low Volt Crash Course.
- Kept Dirty Dumps in disabled internal config only; it is not rendered publicly.
- Updated Wireman and Drill Bit Index copy to stay intentionally limited and non-active.
- Added a rendered theme version HTML comment for GitHub-to-WordPress deployment checks.

### 1.4.0

- Added GitHub Actions deployment automation for Deployer for Git.
- Documented the required `WP_DEPLOY_URL` repository secret and manual workflow trigger.
- Added a footer HTML comment for deploy automation verification.

### 1.3.0

- Updated the theme color palette to match the Holt Holdings navy and white logo direction.
- Added a stronger Follow the Build social section with Facebook and other placeholder links.
- Added the DIY Website Builder / Website Launch Kit digital product card.
- Kept Wireman positioned as a family tool project under construction.
- Added a footer HTML comment for testing the Deployer for Git workflow.

### 1.2.0

- Moved the editable WordPress theme source to the repository root for Git deployment.
- Added Git deployment notes and fallback zip build process.
- Added `Update URI` theme header pointing at the future GitHub repo path.

### 1.1.0

- Updated positioning so Holt Holdings reads as a portfolio and project hub.
- Clarified Wireman as a family tool project under construction.
- Added footer disclaimer and improved custom logo fallback behavior.
