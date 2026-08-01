<?php
/** @package HoltHoldings */
get_header();
$config = holt_holdings_home_config();
?>
<main id="primary" class="site-main inner-page">
	<?php holt_holdings_page_hero( 'Practical Recommendations', 'Tools & Resources', 'A focused collection of useful tools, technology, business buying resources, audiobooks, and project gear.' ); ?>
	<section class="section section-first">
		<div class="affiliate-disclosure"><strong><?php esc_html_e( 'Affiliate disclosure:', 'holt-holdings' ); ?></strong> <?php esc_html_e( 'As an Amazon Associate I earn from qualifying purchases. Some links may earn Holt Holdings a commission at no extra cost to you.', 'holt-holdings' ); ?></div>
		<?php holt_holdings_resource_cards( $config['resources'] ); ?>
	</section>
	<section class="section"><div class="contact-band"><div><h2><?php esc_html_e( 'Looking for trade-focused guides instead?', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'LowVolt Vault and the digital-products catalog keep technician resources separate from affiliate recommendations.', 'holt-holdings' ); ?></p></div><div><a class="button secondary" href="<?php echo esc_url( home_url( '/digital-products/' ) ); ?>"><?php esc_html_e( 'View Digital Products', 'holt-holdings' ); ?></a></div></div></section>
</main>
<?php get_footer(); ?>
