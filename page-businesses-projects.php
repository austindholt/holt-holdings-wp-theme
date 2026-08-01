<?php
/** @package HoltHoldings */
get_header();
$config = holt_holdings_home_config();
?>
<main id="primary" class="site-main inner-page">
	<?php holt_holdings_page_hero( 'Portfolio', 'Businesses & Projects', 'Operating businesses, practical brands, public projects, inventions, and works in progress connected through Holt Holdings.' ); ?>
	<section class="section"><div class="section-heading"><h2><?php esc_html_e( 'Businesses and active public projects', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Each destination below represents a distinct business, resource, or project. Availability and development status are stated plainly.', 'holt-holdings' ); ?></p></div><?php holt_holdings_business_cards( $config['businesses'] ); ?></section>
	<section class="section section-contrast"><div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Works in Progress', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Projects still being developed.', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'These projects are public enough to follow but are not presented as finished products or available services.', 'holt-holdings' ); ?></p></div><?php holt_holdings_work_cards( $config['works'] ); ?></section>
	<section class="section"><div class="contact-band"><div><h2><?php esc_html_e( 'Interested in a project or collaboration?', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Use the contact page for licensing, partnerships, project questions, or other relevant conversations.', 'holt-holdings' ); ?></p></div><div><a class="button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Holt Holdings', 'holt-holdings' ); ?></a></div></div></section>
</main>
<?php get_footer(); ?>
