<?php
/**
 * Site footer template.
 *
 * @package HoltHoldings
 */
$footer_config = holt_holdings_home_config();
?>
<footer class="site-footer">
	<div class="footer-inner">
		<div class="footer-main">
			<strong><?php bloginfo( 'name' ); ?></strong>
			<p class="footer-small">
				<?php
				printf(
					esc_html__( 'Copyright %s Holt Holdings LLC. Built as a lightweight WordPress hub.', 'holt-holdings' ),
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</p>
			<p class="footer-small"><?php esc_html_e( 'Holt Holdings LLC is a portfolio and project hub. Services, products, and business operations listed on this site are provided by their respective entities, brands, or project owners.', 'holt-holdings' ); ?></p>
			<p class="footer-small"><?php esc_html_e( 'As an Amazon Associate I earn from qualifying purchases. Some links on this site may be affiliate links, which means I may earn a commission at no extra cost to you.', 'holt-holdings' ); ?></p>
		</div>
		<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'holt-holdings' ); ?>">
			<a href="<?php echo esc_url( home_url( '/businesses-projects/' ) ); ?>"><?php esc_html_e( 'Businesses & Projects', 'holt-holdings' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/digital-products/' ) ); ?>"><?php esc_html_e( 'Digital Products', 'holt-holdings' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/tools-resources/' ) ); ?>"><?php esc_html_e( 'Tools & Resources', 'holt-holdings' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/merch/' ) ); ?>"><?php esc_html_e( 'Merch', 'holt-holdings' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'holt-holdings' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></a>
		</nav>
		<div class="footer-socials" aria-label="<?php esc_attr_e( 'Social links', 'holt-holdings' ); ?>">
			<?php foreach ( $footer_config['social_links'] as $social ) : ?>
				<?php if ( ! holt_holdings_is_placeholder_url( $social['url'] ) && 'placeholder' !== $social['status'] ) : ?>
					<a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="<?php echo esc_attr( holt_holdings_link_rel( $social['url'] ) ); ?>"><?php echo esc_html( $social['label'] ); ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
