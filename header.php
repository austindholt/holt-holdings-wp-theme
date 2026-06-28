<?php
/**
 * Site header template.
 *
 * @package HoltHoldings
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'holt-holdings' ); ?></a>
<header class="site-header">
	<div class="header-inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html_e( 'Holt Holdings.', 'holt-holdings' ); ?></a>
			<?php endif; ?>
		</div>

		<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
			<span class="menu-toggle-bars" aria-hidden="true"></span>
			<span><?php esc_html_e( 'Menu', 'holt-holdings' ); ?></span>
		</button>

		<nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'holt-holdings' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'container'      => false,
				'fallback_cb'    => 'holt_holdings_fallback_menu',
			) );
			?>
		</nav>
	</div>
</header>
