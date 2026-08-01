<?php
/** @package HoltHoldings */
get_header();
$config = holt_holdings_home_config();
?>
<main id="primary" class="site-main inner-page">
	<?php holt_holdings_page_hero( 'Holt Holdings Merch', 'Merch', 'Small-batch hats, shirts, and gear connected to Holt Holdings, Low Volt Holt, and Hands On Idaho.' ); ?>
	<section class="section section-first"><div class="section-heading"><h2><?php esc_html_e( 'Current merchandise requests', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Availability varies while the catalog is being built. Unknown options are confirmed directly; no inventory, colors, sizes, or pricing are implied beyond what is shown.', 'holt-holdings' ); ?></p></div><?php holt_holdings_merch_cards( $config['merchandise'] ); ?><?php holt_holdings_merch_form( $config['merchandise'] ); ?></section>
</main>
<?php get_footer(); ?>
