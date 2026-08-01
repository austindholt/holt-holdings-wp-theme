<?php
/** @package HoltHoldings */
get_header();
$config = holt_holdings_home_config();
?>
<main id="primary" class="site-main inner-page">
	<?php holt_holdings_page_hero( 'Digital Guides & LowVolt Vault', 'Digital Products', 'Low-voltage field guides, technician resources, troubleshooting checklists, field notes, and practical digital downloads.' ); ?>
	<section class="section section-first"><?php holt_holdings_product_portals( $config['product_portals'] ); ?></section>
	<section class="section"><div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Individual Guide Downloads', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Choose the guide that matches the work in front of you.', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Payhip remains the active option for individual PDFs and checklists while the searchable LowVolt Vault library continues to grow.', 'holt-holdings' ); ?></p></div><?php holt_holdings_product_catalog( $config['digital_products'] ); ?></section>
	<section class="section"><div class="contact-band"><div><h2><?php esc_html_e( 'Need help with a download?', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Product support and general questions are handled through the Holt Holdings contact page.', 'holt-holdings' ); ?></p></div><div><a class="button secondary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Get Product Support', 'holt-holdings' ); ?></a></div></div></section>
</main>
<?php get_footer(); ?>
