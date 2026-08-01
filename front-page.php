<?php
/**
 * Custom front page for Holt Holdings.
 *
 * @package HoltHoldings
 */

get_header();

$contact_email = holt_holdings_contact_email();
$merch_email   = holt_holdings_merch_recipient_email();
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
					<a class="button secondary" href="#merch"><?php esc_html_e( 'Browse Merch', 'holt-holdings' ); ?></a>
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
			<span class="eyebrow"><?php esc_html_e( 'Digital Guides & LowVolt Vault', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Field guides, technician resources, and individual digital downloads.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'LowVolt Vault is becoming the main home for low-voltage field guides, troubleshooting checklists, field notes, and technician resources. The library is live and still being built out, while Payhip remains available for individual downloads.', 'holt-holdings' ); ?></p>
		</div>
		<div class="product-portals" aria-label="Digital guide library options">
			<?php foreach ( $home_config['product_portals'] as $portal ) : ?>
				<article class="product-portal <?php echo esc_attr( $portal['class'] ); ?>">
					<span class="card-kicker"><?php echo esc_html( $portal['kicker'] ); ?></span>
					<h3><?php echo esc_html( $portal['name'] ); ?></h3>
					<p><?php echo esc_html( $portal['description'] ); ?></p>
					<div class="card-actions"><?php holt_holdings_button_link( $portal['url'], $portal['button'] ); ?></div>
				</article>
			<?php endforeach; ?>
		</div>
		<?php
		$product_groups = array();
		foreach ( $home_config['digital_products'] as $product ) {
			$group                    = isset( $product['group'] ) ? $product['group'] : __( 'Individual Guide Downloads', 'holt-holdings' );
			$product_groups[ $group ][] = $product;
		}
		?>
		<?php foreach ( $product_groups as $group_title => $products ) : ?>
			<div class="product-group">
				<h3 class="product-group-title"><?php echo esc_html( $group_title ); ?></h3>
				<div class="product-grid">
					<?php foreach ( $products as $product ) : ?>
						<article class="product-feature">
							<span class="card-kicker"><?php echo esc_html( $product['kicker'] ); ?></span>
							<h4><?php echo esc_html( $product['name'] ); ?></h4>
							<p><?php echo esc_html( $product['description'] ); ?></p>
							<div class="card-actions">
								<?php holt_holdings_button_link( $product['url'], $product['button'] ); ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endforeach; ?>
	</section>

	<section class="section" id="merch">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Holt Holdings Merch', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Hats, shirts, and gear from the brands I’m building.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Small-batch Holt Holdings, Low Volt Holt, and Hands On Idaho merchandise. Availability may vary while the full online store is being built.', 'holt-holdings' ); ?></p>
		</div>
		<div class="merch-grid">
			<?php foreach ( $home_config['merchandise'] as $item ) : ?>
				<article class="merch-card" data-merch-status="<?php echo esc_attr( $item['availability'] ); ?>">
					<div class="merch-media">
						<?php if ( $item['front_image'] ) : ?>
							<img class="merch-photo" src="<?php echo esc_url( $item['front_image'] ); ?>" alt="<?php echo esc_attr( sprintf( __( '%s front view', 'holt-holdings' ), $item['name'] ) ); ?>" width="720" height="720" loading="lazy">
							<?php if ( $item['angled_image'] ) : ?>
								<img class="merch-photo merch-photo-angle" src="<?php echo esc_url( $item['angled_image'] ); ?>" alt="<?php echo esc_attr( sprintf( __( '%s angled view', 'holt-holdings' ), $item['name'] ) ); ?>" width="240" height="240" loading="lazy">
							<?php endif; ?>
						<?php else : ?>
							<div class="merch-placeholder" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Product photo coming soon for %s', 'holt-holdings' ), $item['name'] ) ); ?>">
								<strong aria-hidden="true"><?php echo esc_html( strtoupper( substr( $item['brand'], 0, 2 ) ) ); ?></strong>
								<small><?php esc_html_e( 'Product photo coming soon', 'holt-holdings' ); ?></small>
							</div>
						<?php endif; ?>
					</div>
					<span class="card-kicker"><?php echo esc_html( $item['brand'] ); ?></span>
					<h3><?php echo esc_html( $item['name'] ); ?></h3>
					<p><?php echo esc_html( $item['description'] ); ?></p>
					<?php
					$details = array(
						__( 'Type', 'holt-holdings' )              => $item['type'],
						__( 'Brand / design', 'holt-holdings' )    => $item['design'],
						__( 'Item color', 'holt-holdings' )        => $item['product_color'],
						__( 'Logo / thread', 'holt-holdings' )     => $item['logo_color'],
						__( 'Available', 'holt-holdings' )         => $item['quantity'],
						__( 'Reorder', 'holt-holdings' )           => $item['reorder'],
						__( 'Style / closure', 'holt-holdings' )   => $item['style'],
						__( 'Sizes', 'holt-holdings' )             => $item['sizes'] ? implode( ', ', $item['sizes'] ) : '',
					);
					$details = array_filter( $details );
					?>
					<?php if ( $details ) : ?>
						<dl class="merch-details">
							<?php foreach ( $details as $label => $value ) : ?><div class="merch-detail"><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div><?php endforeach; ?>
						</dl>
					<?php endif; ?>
					<strong class="merch-price"><?php echo esc_html( $item['price'] ); ?></strong>
					<div class="card-actions"><?php holt_holdings_button_link( $item['url'], $item['button'], 'button secondary merch-request-link' ); ?></div>
				</article>
			<?php endforeach; ?>
		</div>
		<div class="merch-order" id="merch-order">
			<h3><?php esc_html_e( 'Merchandise order request', 'holt-holdings' ); ?></h3>
			<p><?php esc_html_e( 'No payment is collected here. Submitting does not reserve inventory; availability and the final total will be confirmed directly.', 'holt-holdings' ); ?></p>
			<?php if ( isset( $_GET['merch_status'] ) ) : ?>
				<?php
				$merch_status = sanitize_key( wp_unslash( $_GET['merch_status'] ) );
				$request_id   = isset( $_GET['request_id'] ) ? absint( $_GET['request_id'] ) : 0;
				if ( 'stored_email_accepted' === $merch_status ) {
					$notice = sprintf( __( 'Request #%d was saved in WordPress. The email notification was accepted by the site’s mail system, but inbox delivery is not guaranteed.', 'holt-holdings' ), $request_id );
				} elseif ( 'stored_email_failed' === $merch_status ) {
					$notice = sprintf( __( 'Request #%d was saved in WordPress, but the email notification could not be handed off. Holt Holdings can still retrieve it from the WordPress dashboard.', 'holt-holdings' ), $request_id );
				} elseif ( 'storage_failed' === $merch_status ) {
					$notice = __( 'The request could not be saved. Please contact Holt Holdings directly using the backup email link below.', 'holt-holdings' );
				} elseif ( 'duplicate' === $merch_status ) {
					$notice = sprintf( __( 'Your request was already received as request #%d. There is no need to submit it again.', 'holt-holdings' ), $request_id );
				} elseif ( 'rate_limited' === $merch_status ) {
					$notice = __( 'Several requests were submitted recently. Please wait about ten minutes before trying again, or use the backup email link below.', 'holt-holdings' );
				} else {
					$notice = __( 'The request was not accepted. Please check the required fields or use the backup email link below.', 'holt-holdings' );
				}
				?>
				<p class="form-notice" role="status"><?php echo esc_html( $notice ); ?></p>
			<?php endif; ?>
			<form class="merch-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="holt_merch_inquiry">
				<?php wp_nonce_field( 'holt_merch_inquiry', 'holt_merch_nonce' ); ?>
				<label>Name <input name="name" required autocomplete="name"></label>
				<label>Email <input name="email" type="email" required autocomplete="email"></label>
				<label>Phone (optional) <input name="phone" type="tel" autocomplete="tel"></label>
				<label>Product <select name="product" required><option value="">Choose an item</option><?php foreach ( $home_config['merchandise'] as $item ) : ?><option value="<?php echo esc_attr( $item['name'] ); ?>"><?php echo esc_html( $item['name'] ); ?></option><?php endforeach; ?></select></label>
				<label>Quantity <input name="quantity" type="number" min="1" max="25" value="1" required></label>
				<label>Color (requested) <input name="color"></label>
				<label>Size (if applicable) <input name="size"></label>
				<label>Pickup or shipping <select name="fulfillment"><option value="">Not sure yet</option><option value="Pickup">Pickup</option><option value="Shipping">Shipping</option></select></label>
				<label class="form-wide">Notes <textarea name="notes" rows="4"></textarea></label>
				<label class="honeypot" aria-hidden="true">Website <input name="website" tabindex="-1" autocomplete="off"></label>
				<div class="form-wide"><button class="button" type="submit"><?php esc_html_e( 'Send Order Request', 'holt-holdings' ); ?></button></div>
			</form>
			<p class="merch-backup"><?php esc_html_e( 'Backup:', 'holt-holdings' ); ?> <a href="mailto:<?php echo esc_attr( $merch_email ); ?>?subject=<?php echo esc_attr( rawurlencode( 'Merchandise order request' ) ); ?>"><?php esc_html_e( 'email Holt Holdings directly', 'holt-holdings' ); ?></a>. <?php esc_html_e( 'Valid form requests are also retained privately under Merch Requests in the WordPress dashboard.', 'holt-holdings' ); ?></p>
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
					<?php if ( empty( $work['url'] ) ) : ?>
						<span class="coming-soon"><?php esc_html_e( 'Under Construction', 'holt-holdings' ); ?></span>
					<?php elseif ( ! empty( $work['status'] ) && 'in_development' === $work['status'] ) : ?>
						<span class="coming-soon"><?php esc_html_e( 'In Development', 'holt-holdings' ); ?></span>
					<?php endif; ?>
					<h3><?php echo esc_html( $work['name'] ); ?></h3>
					<p><?php echo esc_html( $work['description'] ); ?></p>
					<div class="card-actions">
						<?php holt_holdings_button_link( $work['url'], $work['button'], 'button secondary' ); ?>
						<?php if ( ! empty( $work['secondary_url'] ) && ! empty( $work['secondary_button'] ) ) : ?>
							<?php holt_holdings_button_link( $work['secondary_url'], $work['secondary_button'], 'button secondary' ); ?>
						<?php endif; ?>
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
					<a class="social-card" href="<?php echo esc_url( $social_link['url'] ); ?>" target="_blank" rel="<?php echo esc_attr( holt_holdings_link_rel( $social_link['url'] ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Visit %s', 'holt-holdings' ), $social_link['label'] ) ); ?>" data-track="outbound-link" data-link-category="<?php echo esc_attr( holt_holdings_link_category( $social_link['url'] ) ); ?>" data-link-label="<?php echo esc_attr( $social_link['label'] ); ?>" data-link-url="<?php echo esc_url( $social_link['url'] ); ?>"><?php echo esc_html( $social_link['label'] ); ?></a>
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
					<a class="button" href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php esc_html_e( 'Contact Holt Holdings', 'holt-holdings' ); ?></a>
				<?php else : ?>
					<span class="button button-disabled" aria-disabled="true"><?php esc_html_e( 'Contact Holt Holdings', 'holt-holdings' ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
