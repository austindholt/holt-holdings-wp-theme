<?php
/**
 * Theme setup and customization hooks for Holt Holdings.
 *
 * @package HoltHoldings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme features and menu locations.
 */
function holt_holdings_setup() {
	load_theme_textdomain( 'holt-holdings', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 160,
		'width'       => 520,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'holt-holdings' ),
		'footer'  => __( 'Footer Menu', 'holt-holdings' ),
	) );
}
add_action( 'after_setup_theme', 'holt_holdings_setup' );

/**
 * Load the theme stylesheet and mobile navigation script.
 */
function holt_holdings_assets() {
	wp_enqueue_style( 'holt-holdings-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'holt-holdings-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'holt_holdings_assets' );

/**
 * Register Customizer fields for easy homepage editing.
 */
function holt_holdings_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'holt_holdings_home', array(
		'title'       => __( 'Holt Holdings Home', 'holt-holdings' ),
		'description' => __( 'Edit homepage headlines, calls to action, and placeholder links. Replace # values when final URLs are ready.', 'holt-holdings' ),
		'priority'    => 30,
	) );

	$fields = array(
		'hero_headline'    => array(
			'label'   => __( 'Hero Headline', 'holt-holdings' ),
			'default' => 'Building practical businesses, tools, and trade-focused resources.',
			'type'    => 'textarea',
		),
		'hero_subheadline' => array(
			'label'   => __( 'Hero Subheadline', 'holt-holdings' ),
			'default' => 'Holt Holdings is the home base for Austin Holt\'s business ventures, family projects, digital products, and works in progress.',
			'type'    => 'textarea',
		),
		// Placeholder links: leave as # until each brand, product, or social URL is ready.
		'course_url'       => array( 'label' => __( 'Low Volt Crash Course URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
		'contact_email'    => array( 'label' => __( 'Contact Email', 'holt-holdings' ), 'default' => 'hello@holtholdings.us', 'type' => 'email' ),
		'hands_on_idaho_url' => array( 'label' => __( 'Hands On Idaho URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
		'dirty_dumps_url'  => array( 'label' => __( 'Dirty Dumps Hauling Co. URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
		'wireman_url'      => array( 'label' => __( 'Wireman URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
		'instagram_url'    => array( 'label' => __( 'Instagram URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
		'youtube_url'      => array( 'label' => __( 'YouTube URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
		'linkedin_url'     => array( 'label' => __( 'LinkedIn URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
		'x_url'            => array( 'label' => __( 'X / Twitter URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
	);

	foreach ( $fields as $id => $field ) {
		$sanitize_callback = 'sanitize_text_field';

		if ( 'textarea' === $field['type'] ) {
			$sanitize_callback = 'sanitize_textarea_field';
		} elseif ( 'url' === $field['type'] ) {
			$sanitize_callback = 'esc_url_raw';
		} elseif ( 'email' === $field['type'] ) {
			$sanitize_callback = 'sanitize_email';
		}

		$wp_customize->add_setting( $id, array(
			'default'           => $field['default'],
			'sanitize_callback' => $sanitize_callback,
		) );

		$wp_customize->add_control( $id, array(
			'label'   => $field['label'],
			'section' => 'holt_holdings_home',
			'type'    => $field['type'],
		) );
	}
}
add_action( 'customize_register', 'holt_holdings_customize_register' );

/**
 * Return a Customizer value with a fallback.
 *
 * @param string $name    Setting name.
 * @param string $default Default value.
 * @return string
 */
function holt_holdings_setting( $name, $default = '' ) {
	return get_theme_mod( $name, $default );
}

/**
 * Useful section links before a custom menu is assigned.
 */
function holt_holdings_fallback_menu() {
	?>
	<ul id="primary-menu">
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#businesses"><?php esc_html_e( 'Businesses', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#products"><?php esc_html_e( 'Digital Products', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#projects"><?php esc_html_e( 'Projects', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#contact"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></a></li>
	</ul>
	<?php
}
