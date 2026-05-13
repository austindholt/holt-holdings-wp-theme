<?php
/**
 * Custom front page for Holt Holdings.
 *
 * @package HoltHoldings
 */

get_header();

$contact_email = holt_holdings_setting( 'contact_email', 'hello@holtholdings.us' );
$home_config   = holt_holdings_home_config();
?>
<main id="primary" class="site-main">
	<section class="hero" id="home">
		<div class="hero-grid">
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Holt Holdings LLC', 'holt-holdings' ); ?></div>
				<h1><?php echo esc_html( holt_holdings_setting( 'hero_headline', 'Building practical businesses, tools, and digital products.' ) ); ?></h1>
				<p><?php echo esc_html( holt_holdings_setting( 'hero_subheadline', 'Holt Holdings is the home base for Austin Holt\'s businesses, family projects, digital products, and works in progress - from home services and practical tools to trade-focused resources and small business projects.' ) ); ?></p>
				<div class="hero-actions">
					<a class="button" href="#products"><?php esc_html_e( 'View Digital Products', 'holt-holdings' ); ?></a>
					<a class="button secondary" href="#works"><?php esc_html_e( 'Explore Projects', 'holt-holdings' ); ?></a>
					<a class="button secondary" href="#contact"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></a>
				</div>
			</div>
			<aside class="hero-panel" aria-label="<?php esc_attr_e( 'Holt Holdings focus areas', 'holt-holdings' ); ?>">
				<div class="panel-label"><?php esc_html_e( 'Personal Link Hub', 'holt-holdings' ); ?></div>
				<div class="panel-lines">
					<div class="panel-line"><strong><?php esc_html_e( 'Businesses', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Public brands', 'holt-holdings' ); ?></span></div>
					<div class="panel-line"><strong><?php esc_html_e( 'Products', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Courses + kits', 'holt-holdings' ); ?></span></div>
					<div class="panel-line"><strong><?php esc_html_e( 'Projects', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Works in progress', 'holt-holdings' ); ?></span></div>
				</div>
			</aside>
		</div>
	</section>

	<section class="section" id="featured">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Featured Links', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Start here.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'A quick path to Austin Holt\'s businesses, digital products, and active project hubs.', 'holt-holdings' ); ?></p>
		</div>
		<div class="quick-link-grid">
			<?php foreach ( $home_config['featured_links'] as $featured_link ) : ?>
				<article class="hub-card quick-link-card">
					<h3><?php echo esc_html( $featured_link['name'] ); ?></h3>
					<p><?php echo esc_html( $featured_link['description'] ); ?></p>
					<div class="card-actions">
						<a class="button secondary" href="<?php echo esc_url( $featured_link['url'] ); ?>"><?php echo esc_html( $featured_link['button'] ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="businesses">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Businesses & Projects', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'A portfolio directory, not one blended operation.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Holt Holdings points visitors toward separate businesses, family projects, digital products, and works in progress connected to Austin Holt.', 'holt-holdings' ); ?></p>
		</div>
		<div class="card-grid">
			<?php foreach ( $home_config['businesses'] as $business ) : ?>
				<?php if ( empty( $business['visible'] ) ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<article class="hub-card">
					<span class="card-kicker"><?php echo esc_html( $business['kicker'] ); ?></span>
					<h3><?php echo esc_html( $business['name'] ); ?></h3>
					<p><?php echo esc_html( $business['description'] ); ?></p>
					<div class="card-actions">
						<a class="button secondary" href="<?php echo esc_url( $business['url'] ); ?>"><?php echo esc_html( $business['button'] ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="products">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Digital Products', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Launch kits and practical education.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'These are digital products and educational resources created by Austin Holt / Holt Holdings. They are separate from the listed businesses and projects.', 'holt-holdings' ); ?></p>
		</div>
		<div class="product-grid">
			<?php foreach ( $home_config['digital_products'] as $product ) : ?>
				<article class="product-feature">
					<span class="card-kicker"><?php echo esc_html( $product['kicker'] ); ?></span>
					<h3><?php echo esc_html( $product['name'] ); ?></h3>
					<p><?php echo esc_html( $product['description'] ); ?></p>
					<div class="card-actions">
						<a class="button" href="<?php echo esc_url( $product['url'] ); ?>"><?php echo esc_html( $product['button'] ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="works">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Works in Progress', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Projects still on the bench.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Some ideas are public enough to follow, but not ready to overexplain or launch yet.', 'holt-holdings' ); ?></p>
		</div>
		<div class="card-grid">
			<?php foreach ( $home_config['works'] as $work ) : ?>
				<article class="hub-card">
					<span class="coming-soon"><?php esc_html_e( 'Coming Soon', 'holt-holdings' ); ?></span>
					<h3><?php echo esc_html( $work['name'] ); ?></h3>
					<p><?php echo esc_html( $work['description'] ); ?></p>
					<div class="card-actions">
						<a class="button secondary" href="<?php echo esc_url( $work['url'] ); ?>"><?php echo esc_html( $work['button'] ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="socials">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Follow Along', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Follow the Build', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Follow along as Holt Holdings grows practical businesses, digital products, tools, and trade-focused resources.', 'holt-holdings' ); ?></p>
		</div>
		<div class="social-grid">
			<?php foreach ( $home_config['social_links'] as $social_link ) : ?>
				<a class="social-card" href="<?php echo esc_url( $social_link['url'] ); ?>"><?php echo esc_html( $social_link['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="contact">
		<div class="contact-band">
			<div>
				<span class="eyebrow"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></span>
				<h2><?php esc_html_e( 'Project questions, product support, collaborations, and general inquiries.', 'holt-holdings' ); ?></h2>
				<p><?php esc_html_e( 'For project questions, digital product support, collaboration ideas, or general inquiries, reach out through the links above or contact Holt Holdings directly.', 'holt-holdings' ); ?></p>
			</div>
			<div>
				<?php if ( $contact_email ) : ?>
					<a class="button" href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>"><?php esc_html_e( 'Contact Holt Holdings', 'holt-holdings' ); ?></a>
				<?php else : ?>
					<a class="button" href="#contact"><?php esc_html_e( 'Contact Holt Holdings', 'holt-holdings' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
