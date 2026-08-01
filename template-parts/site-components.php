<?php
/**
 * Shared customer-facing components for the Holt Holdings page templates.
 *
 * @package HoltHoldings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function holt_holdings_page_hero( $eyebrow, $title, $description ) {
	?>
	<section class="page-hero">
		<div class="section-heading">
			<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<h1><?php echo esc_html( $title ); ?></h1>
			<p><?php echo esc_html( $description ); ?></p>
		</div>
	</section>
	<?php
}

function holt_holdings_business_cards( $businesses, $limit = 0 ) {
	$shown = 0;
	?>
	<div class="card-grid">
		<?php foreach ( $businesses as $business ) : ?>
			<?php if ( empty( $business['visible'] ) || ( $limit && $shown >= $limit ) ) { continue; } ?>
			<?php $shown++; ?>
			<article class="hub-card">
				<span class="card-kicker"><?php echo esc_html( $business['kicker'] ); ?></span>
				<h3><?php echo esc_html( $business['name'] ); ?></h3>
				<p><?php echo esc_html( $business['description'] ); ?></p>
				<div class="card-actions"><?php holt_holdings_button_link( $business['url'], $business['button'], 'button secondary' ); ?></div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
}

function holt_holdings_product_portals( $portals ) {
	?>
	<div class="product-portals" aria-label="Digital library and download options">
		<?php foreach ( $portals as $portal ) : ?>
			<article class="product-portal <?php echo esc_attr( $portal['class'] ); ?>">
				<span class="card-kicker"><?php echo esc_html( $portal['kicker'] ); ?></span>
				<h2><?php echo esc_html( $portal['name'] ); ?></h2>
				<p><?php echo esc_html( $portal['description'] ); ?></p>
				<div class="card-actions"><?php holt_holdings_button_link( $portal['url'], $portal['button'] ); ?></div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
}

function holt_holdings_product_catalog( $products, $featured_only = false ) {
	$groups = array();
	foreach ( $products as $product ) {
		if ( $featured_only && empty( $product['featured'] ) ) { continue; }
		$group = isset( $product['group'] ) ? $product['group'] : __( 'Individual Guide Downloads', 'holt-holdings' );
		$groups[ $group ][] = $product;
	}
	if ( $featured_only && ! $groups ) {
		$groups['Featured Downloads'] = array_slice( $products, 0, 3 );
	}
	foreach ( $groups as $group_title => $group_products ) : ?>
		<div class="product-group">
			<h2 class="product-group-title"><?php echo esc_html( $featured_only ? __( 'Featured downloads', 'holt-holdings' ) : $group_title ); ?></h2>
			<div class="product-grid">
				<?php foreach ( $group_products as $product ) : ?>
					<article class="product-feature">
						<span class="card-kicker"><?php echo esc_html( $product['kicker'] ); ?></span>
						<h3><?php echo esc_html( $product['name'] ); ?></h3>
						<p><?php echo esc_html( $product['description'] ); ?></p>
						<div class="card-actions"><?php holt_holdings_button_link( $product['url'], $product['button'] ); ?></div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach;
}

function holt_holdings_merch_cards( $items, $limit = 0 ) {
	$items = $limit ? array_slice( $items, 0, $limit ) : $items;
	?>
	<div class="merch-grid">
		<?php foreach ( $items as $item ) : ?>
			<article class="merch-card" data-merch-status="<?php echo esc_attr( $item['availability'] ); ?>">
				<div class="merch-media">
					<?php if ( $item['front_image'] ) : ?>
						<img class="merch-photo" src="<?php echo esc_url( $item['front_image'] ); ?>" alt="<?php echo esc_attr( sprintf( __( '%s front view', 'holt-holdings' ), $item['name'] ) ); ?>" width="720" height="720" loading="lazy">
						<?php if ( $item['angled_image'] ) : ?><img class="merch-photo merch-photo-angle" src="<?php echo esc_url( $item['angled_image'] ); ?>" alt="<?php echo esc_attr( sprintf( __( '%s angled view', 'holt-holdings' ), $item['name'] ) ); ?>" width="240" height="240" loading="lazy"><?php endif; ?>
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
				$details = array_filter( array(
					__( 'Type', 'holt-holdings' )            => $item['type'],
					__( 'Brand / design', 'holt-holdings' )  => $item['design'],
					__( 'Item color', 'holt-holdings' )      => $item['product_color'],
					__( 'Logo / thread', 'holt-holdings' )   => $item['logo_color'],
					__( 'Available', 'holt-holdings' )       => $item['quantity'],
					__( 'Reorder', 'holt-holdings' )         => $item['reorder'],
					__( 'Style / closure', 'holt-holdings' ) => $item['style'],
					__( 'Sizes', 'holt-holdings' )           => $item['sizes'] ? implode( ', ', $item['sizes'] ) : '',
				) );
				?>
				<?php if ( $details ) : ?><dl class="merch-details"><?php foreach ( $details as $label => $value ) : ?><div class="merch-detail"><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div><?php endforeach; ?></dl><?php endif; ?>
				<strong class="merch-price"><?php echo esc_html( $item['price'] ); ?></strong>
				<div class="card-actions"><?php holt_holdings_button_link( $item['url'], $item['button'], 'button secondary merch-request-link' ); ?></div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
}

function holt_holdings_merch_form( $items ) {
	$merch_email = holt_holdings_merch_recipient_email();
	?>
	<div class="merch-order" id="merch-order">
		<h2><?php esc_html_e( 'Merchandise order request', 'holt-holdings' ); ?></h2>
		<p><?php esc_html_e( 'No payment is collected here. Submitting does not reserve inventory; availability and the final total will be confirmed directly.', 'holt-holdings' ); ?></p>
		<?php if ( isset( $_GET['merch_status'] ) ) : ?>
			<?php
			$status = sanitize_key( wp_unslash( $_GET['merch_status'] ) );
			$id = isset( $_GET['request_id'] ) ? absint( $_GET['request_id'] ) : 0;
			if ( 'stored_email_accepted' === $status ) { $notice = sprintf( __( 'Request #%d was saved. The notification was accepted by the site mail system; inbox delivery is not guaranteed.', 'holt-holdings' ), $id ); }
			elseif ( 'stored_email_failed' === $status ) { $notice = sprintf( __( 'Request #%d was saved, but the email notification failed. Holt Holdings can still retrieve it from WordPress.', 'holt-holdings' ), $id ); }
			elseif ( 'duplicate' === $status ) { $notice = sprintf( __( 'Your request was already received as request #%d.', 'holt-holdings' ), $id ); }
			elseif ( 'rate_limited' === $status ) { $notice = __( 'Several requests were submitted recently. Please wait about ten minutes or use the backup email.', 'holt-holdings' ); }
			elseif ( 'storage_failed' === $status ) { $notice = __( 'The request could not be saved. Please use the backup email below.', 'holt-holdings' ); }
			else { $notice = __( 'The request was not accepted. Check the required fields or use the backup email.', 'holt-holdings' ); }
			?>
			<p class="form-notice" role="status"><?php echo esc_html( $notice ); ?></p>
		<?php endif; ?>
		<form class="merch-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="holt_merch_inquiry">
			<?php wp_nonce_field( 'holt_merch_inquiry', 'holt_merch_nonce' ); ?>
			<label><?php esc_html_e( 'Name', 'holt-holdings' ); ?> <input name="name" maxlength="120" required autocomplete="name"></label>
			<label><?php esc_html_e( 'Email', 'holt-holdings' ); ?> <input name="email" type="email" maxlength="190" required autocomplete="email"></label>
			<label><?php esc_html_e( 'Phone (optional)', 'holt-holdings' ); ?> <input name="phone" type="tel" maxlength="40" autocomplete="tel"></label>
			<label><?php esc_html_e( 'Product', 'holt-holdings' ); ?> <select name="product" required><option value=""><?php esc_html_e( 'Choose an item', 'holt-holdings' ); ?></option><?php foreach ( $items as $item ) : ?><option value="<?php echo esc_attr( $item['name'] ); ?>"><?php echo esc_html( $item['name'] ); ?></option><?php endforeach; ?></select></label>
			<label><?php esc_html_e( 'Quantity', 'holt-holdings' ); ?> <input name="quantity" type="number" min="1" max="25" value="1" required></label>
			<label><?php esc_html_e( 'Color (requested)', 'holt-holdings' ); ?> <input name="color" maxlength="80"></label>
			<label><?php esc_html_e( 'Size (if applicable)', 'holt-holdings' ); ?> <input name="size" maxlength="80"></label>
			<label><?php esc_html_e( 'Pickup or shipping', 'holt-holdings' ); ?> <select name="fulfillment"><option value=""><?php esc_html_e( 'Not sure yet', 'holt-holdings' ); ?></option><option value="Pickup"><?php esc_html_e( 'Pickup', 'holt-holdings' ); ?></option><option value="Shipping"><?php esc_html_e( 'Shipping', 'holt-holdings' ); ?></option></select></label>
			<label class="form-wide"><?php esc_html_e( 'Notes', 'holt-holdings' ); ?> <textarea name="notes" maxlength="2000" rows="4"></textarea></label>
			<label class="honeypot" aria-hidden="true"><?php esc_html_e( 'Website', 'holt-holdings' ); ?> <input name="website" tabindex="-1" autocomplete="off"></label>
			<div class="form-wide"><button class="button" type="submit"><?php esc_html_e( 'Send Order Request', 'holt-holdings' ); ?></button></div>
		</form>
		<p class="merch-backup"><?php esc_html_e( 'Backup:', 'holt-holdings' ); ?> <a href="mailto:<?php echo esc_attr( $merch_email ); ?>?subject=<?php echo esc_attr( rawurlencode( 'Merchandise order request' ) ); ?>"><?php esc_html_e( 'email Holt Holdings directly', 'holt-holdings' ); ?></a>. <?php esc_html_e( 'Valid requests are retained privately under Merch Requests in WordPress.', 'holt-holdings' ); ?></p>
	</div>
	<?php
}

function holt_holdings_resource_cards( $resources ) {
	?>
	<div class="card-grid resource-grid">
		<?php foreach ( $resources as $resource ) : ?>
			<article class="hub-card"><span class="card-kicker"><?php esc_html_e( 'Affiliate resource', 'holt-holdings' ); ?></span><h3><?php echo esc_html( $resource['name'] ); ?></h3><p><?php echo esc_html( $resource['description'] ); ?></p><div class="card-actions"><?php holt_holdings_button_link( $resource['url'], $resource['button'], 'button secondary' ); ?></div></article>
		<?php endforeach; ?>
	</div>
	<?php
}

function holt_holdings_work_cards( $works ) {
	?>
	<div class="card-grid">
		<?php foreach ( $works as $work ) : ?>
			<article class="hub-card">
				<?php if ( empty( $work['url'] ) ) : ?><span class="coming-soon"><?php esc_html_e( 'Under Construction', 'holt-holdings' ); ?></span><?php elseif ( ! empty( $work['status'] ) && 'in_development' === $work['status'] ) : ?><span class="coming-soon"><?php esc_html_e( 'In Development', 'holt-holdings' ); ?></span><?php endif; ?>
				<h3><?php echo esc_html( $work['name'] ); ?></h3><p><?php echo esc_html( $work['description'] ); ?></p><div class="card-actions"><?php holt_holdings_button_link( $work['url'], $work['button'], 'button secondary' ); ?></div>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
}

function holt_holdings_social_links( $links ) {
	?>
	<div class="social-grid">
		<?php foreach ( $links as $link ) : ?>
			<?php if ( holt_holdings_is_placeholder_url( $link['url'] ) || 'placeholder' === $link['status'] ) : ?><span class="social-card social-card-disabled" aria-disabled="true"><span><?php echo esc_html( $link['label'] ); ?></span><small><?php esc_html_e( 'Coming Soon', 'holt-holdings' ); ?></small></span>
			<?php else : ?><a class="social-card" href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="<?php echo esc_attr( holt_holdings_link_rel( $link['url'] ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Visit %s', 'holt-holdings' ), $link['label'] ) ); ?>" data-track="outbound-link" data-link-category="<?php echo esc_attr( holt_holdings_link_category( $link['url'] ) ); ?>" data-link-label="<?php echo esc_attr( $link['label'] ); ?>" data-link-url="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a><?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php
}
