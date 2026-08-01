<?php
/**
 * Curated Holt Holdings front page.
 *
 * @package HoltHoldings
 */

get_header();
$config = holt_holdings_home_config();
?>
<main id="primary" class="site-main">
	<section class="hero" id="home">
		<div class="hero-grid">
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Holt Holdings LLC', 'holt-holdings' ); ?></div>
				<h1><?php esc_html_e( 'Practical businesses, field resources, products, and projects built to be useful.', 'holt-holdings' ); ?></h1>
				<p><?php esc_html_e( 'Holt Holdings is the portfolio behind Austin Holt\'s operating businesses, trade-focused resources, inventions, digital products, and growing public projects.', 'holt-holdings' ); ?></p>
				<div class="hero-actions">
					<a class="button" href="<?php echo esc_url( home_url( '/businesses-projects/' ) ); ?>"><?php esc_html_e( 'Explore Businesses & Projects', 'holt-holdings' ); ?></a>
					<a class="button secondary" href="<?php echo esc_url( home_url( '/digital-products/' ) ); ?>"><?php esc_html_e( 'Browse Digital Products', 'holt-holdings' ); ?></a>
				</div>
			</div>
			<aside class="hero-panel" aria-label="<?php esc_attr_e( 'Holt Holdings focus areas', 'holt-holdings' ); ?>">
				<div class="panel-label"><?php esc_html_e( 'Built around practical work', 'holt-holdings' ); ?></div>
				<div class="panel-lines">
					<div class="panel-line"><strong><?php esc_html_e( 'Businesses', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Public brands and services', 'holt-holdings' ); ?></span></div>
					<div class="panel-line"><strong><?php esc_html_e( 'Knowledge', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Field guides and resources', 'holt-holdings' ); ?></span></div>
					<div class="panel-line"><strong><?php esc_html_e( 'Projects', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Products and inventions in progress', 'holt-holdings' ); ?></span></div>
				</div>
			</aside>
		</div>
	</section>

	<section class="section" id="explore">
		<div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Explore Holt Holdings', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Find the part of the ecosystem that fits what you need.', 'holt-holdings' ); ?></h2></div>
		<div class="quick-link-grid">
			<?php
			$destinations = array(
				array( 'Businesses & Projects', 'Operating businesses, public projects, and honest works in progress.', '/businesses-projects/', 'View Portfolio' ),
				array( 'Digital Products', 'LowVolt Vault plus individual field guides and downloads through Payhip.', '/digital-products/', 'Browse Products' ),
				array( 'Tools & Resources', 'Useful tools, technology, business resources, and disclosed affiliate links.', '/tools-resources/', 'View Resources' ),
				array( 'About Holt Holdings', 'The background, practical approach, and person connecting the work.', '/about/', 'Learn More' ),
			);
			foreach ( $destinations as $destination ) : ?>
				<article class="hub-card quick-link-card"><h3><?php echo esc_html( $destination[0] ); ?></h3><p><?php echo esc_html( $destination[1] ); ?></p><div class="card-actions"><a class="button secondary" href="<?php echo esc_url( home_url( $destination[2] ) ); ?>"><?php echo esc_html( $destination[3] ); ?></a></div></article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section section-compact" id="business-preview">
		<div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Selected Businesses', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Independent brands connected by practical work.', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Each business or project keeps its own purpose, audience, and public destination.', 'holt-holdings' ); ?></p></div>
		<?php holt_holdings_business_cards( $config['businesses'], 3 ); ?>
		<p class="section-cta"><a class="button secondary" href="<?php echo esc_url( home_url( '/businesses-projects/' ) ); ?>"><?php esc_html_e( 'See All Businesses & Projects', 'holt-holdings' ); ?></a></p>
	</section>

	<section class="section section-compact" id="product-preview">
		<div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Featured Digital Resources', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Field knowledge in useful formats.', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'LowVolt Vault is the growing resource library; Payhip remains available for individual guide downloads.', 'holt-holdings' ); ?></p></div>
		<?php holt_holdings_product_catalog( array_slice( $config['digital_products'], 0, 3 ) ); ?>
		<p class="section-cta"><a class="button" href="<?php echo esc_url( home_url( '/digital-products/' ) ); ?>"><?php esc_html_e( 'Explore Digital Products', 'holt-holdings' ); ?></a></p>
	</section>

	<section class="section section-compact" id="merch-preview">
		<div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Merch Preview', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Small-batch gear from the brands being built.', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Product photos and confirmed options will be added as they become available. Requests are handled directly.', 'holt-holdings' ); ?></p></div>
		<?php holt_holdings_merch_cards( $config['merchandise'], 3 ); ?>
		<p class="section-cta"><a class="button secondary" href="<?php echo esc_url( home_url( '/merch/' ) ); ?>"><?php esc_html_e( 'View Merch & Request an Item', 'holt-holdings' ); ?></a></p>
	</section>

	<section class="section"><div class="contact-band"><div><span class="eyebrow"><?php esc_html_e( 'Start a Conversation', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Questions, collaborations, product support, or project inquiries.', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Choose the right contact path and include enough context to make the conversation useful.', 'holt-holdings' ); ?></p></div><div><a class="button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Holt Holdings', 'holt-holdings' ); ?></a></div></div></section>
</main>
<?php get_footer(); ?>
