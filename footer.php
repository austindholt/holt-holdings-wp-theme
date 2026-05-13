<?php
/**
 * Site footer template.
 *
 * @package HoltHoldings
 */
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
		</div>
		<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'holt-holdings' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'fallback_cb'    => false,
				'depth'          => 1,
			) );
			?>
		</nav>
	</div>
</footer>
<!-- Holt Holdings theme deploy test: GitHub-to-WordPress update active -->
<!-- Holt Holdings deploy automation active -->
<?php wp_footer(); ?>
</body>
</html>
