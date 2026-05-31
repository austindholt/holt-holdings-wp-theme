<?php
/**
 * Custom front page for Holt Holdings.
 *
 * @package HoltHoldings
 */

get_header();

$contact_email = holt_holdings_contact_email();
$home_config   = holt_holdings_home_config();
?>
<main id="primary" class="site-main">
	<section class="hero" id="home">
		<div class="hero-grid">
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Holt Holdings LLC', 'holt-holdings' ); ?></div>
				<h1><?php echo esc_html( holt_holdings_setting( 'hero_headline', 'Field notes, digital guides, tools, and business projects.' ) ); ?></h1>
				<p><?php echo esc_html( holt_holdings_setting( 'hero_subheadline', 'Holt Holdings is Austin Holt\'s personal hub for practical field notes, Payhip guides, useful tools, affiliate resources, business projects, inventions, and creator links.' ) ); ?></p>
				<div class="hero-actions">
					<a class="button" href="#products"><?php esc_html_e( 'View Digital Products', 'holt-holdings' ); ?></a>
					<a class="button secondary" href="#resources"><?php esc_html_e( 'Tools & Resources', 'holt-holdings' ); ?></a>
					<a class="button secondary" href="#businesses"><?php esc_html_e( 'Projects', 'holt-holdings' ); ?></a>
					<a class="button secondary" href="#socials"><?php esc_html_e( 'Follow', 'holt-holdings' ); ?></a>
				</div>
			</div>
			<aside class="hero-panel" aria-label="<?php esc_attr_e( 'Holt Holdings focus areas', 'holt-holdings' ); ?>">
				<div class="panel-label"><?php esc_html_e( 'Personal Link Hub', 'holt-holdings' ); ?></div>
				<div class="panel-lines">
					<div class="panel-line"><strong><?php esc_html_e( 'Businesses', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Public brands', 'holt-holdings' ); ?></span></div>
					<div class="panel-line"><strong><?php esc_html_e( 'Products', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Payhip guides', 'holt-holdings' ); ?></span></div>
					<div class="panel-line"><strong><?php esc_html_e( 'Resources', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Tools + affiliate links', 'holt-holdings' ); ?></span></div>
				</div>
			</aside>
		</div>
	</section>

	<section class="section" id="featured">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Featured Links', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Start here.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Use these internal shortcuts to jump into the main parts of the Austin Holt / Holt Holdings hub.', 'holt-holdings' ); ?></p>
		</div>
		<div class="quick-link-grid">
			<?php foreach ( $home_config['featured_links'] as $featured_link ) : ?>
				<article class="hub-card quick-link-card">
					<h3><?php echo esc_html( $featured_link['name'] ); ?></h3>
					<p><?php echo esc_html( $featured_link['description'] ); ?></p>
					<div class="card-actions">
						<?php holt_holdings_button_link( $featured_link['url'], $featured_link['button'], 'button secondary' ); ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="businesses">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Businesses & Projects', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Separate brands, projects, and useful places to click.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Hands-On Idaho stays focused on local home services. Holt Holdings / Austin Holt is the broader creator and business hub for projects, resources, and public links.', 'holt-holdings' ); ?></p>
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
						<?php holt_holdings_button_link( $business['url'], $business['button'], 'button secondary' ); ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="products">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Digital Products', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Payhip guides, SOPs, and practical learning resources.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Digital products here are guides, checklists, field notes, and practical resources. Low-voltage topics are framed as learning material, not a service offering.', 'holt-holdings' ); ?></p>
		</div>
		<div class="product-grid">
			<?php foreach ( $home_config['digital_products'] as $product ) : ?>
				<article class="product-feature">
					<span class="card-kicker"><?php echo esc_html( $product['kicker'] ); ?></span>
					<h3><?php echo esc_html( $product['name'] ); ?></h3>
					<p><?php echo esc_html( $product['description'] ); ?></p>
					<div class="card-actions">
						<?php holt_holdings_button_link( $product['url'], $product['button'] ); ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="resources">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Tools & Resources', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Gear, accounts, and useful affiliate links.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'A small resource shelf for tools, tech, business buying, audiobooks, and practical project gear.', 'holt-holdings' ); ?></p>
		</div>
		<div class="affiliate-disclosure">
			<?php esc_html_e( 'As an Amazon Associate I earn from qualifying purchases. Some links on this site may be affiliate links, which means I may earn a commission at no extra cost to you.', 'holt-holdings' ); ?>
		</div>
		<div class="card-grid resource-grid">
			<?php foreach ( $home_config['resources'] as $resource ) : ?>
				<article class="hub-card">
					<span class="card-kicker"><?php esc_html_e( 'Affiliate resource', 'holt-holdings' ); ?></span>
					<h3><?php echo esc_html( $resource['name'] ); ?></h3>
					<p><?php echo esc_html( $resource['description'] ); ?></p>
					<div class="card-actions">
						<?php holt_holdings_button_link( $resource['url'], $resource['button'], 'button secondary' ); ?>
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
						<?php holt_holdings_button_link( $work['url'], $work['button'], 'button secondary' ); ?>
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
				<?php if ( holt_holdings_is_placeholder_url( $social_link['url'] ) || 'placeholder' === $social_link['status'] ) : ?>
					<span class="social-card social-card-disabled" aria-disabled="true">
						<span><?php echo esc_html( $social_link['label'] ); ?></span>
						<small><?php esc_html_e( 'Coming Soon', 'holt-holdings' ); ?></small>
					</span>
				<?php else : ?>
					<a class="social-card" href="<?php echo esc_url( $social_link['url'] ); ?>" target="_blank" rel="<?php echo esc_attr( holt_holdings_link_rel( $social_link['url'] ) ); ?>"><?php echo esc_html( $social_link['label'] ); ?></a>
				<?php endif; ?>
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
					<a class="button" href="mailto:holtholdings@outlook.com"><?php esc_html_e( 'Contact Holt Holdings', 'holt-holdings' ); ?></a>
				<?php else : ?>
					<a class="button" href="#contact"><?php esc_html_e( 'Contact Holt Holdings', 'holt-holdings' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
