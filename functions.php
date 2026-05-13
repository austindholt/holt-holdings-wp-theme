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
			'default' => 'Building practical businesses, tools, and digital products.',
			'type'    => 'textarea',
		),
		'hero_subheadline' => array(
			'label'   => __( 'Hero Subheadline', 'holt-holdings' ),
			'default' => 'Holt Holdings is the home base for Austin Holt\'s businesses, family projects, digital products, and works in progress - from home services and practical tools to trade-focused resources and small business projects.',
			'type'    => 'textarea',
		),
		// Placeholder links: leave as # until each brand, product, or social URL is ready.
		'course_url'       => array( 'label' => __( 'Low Volt Crash Course URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/3GVP5', 'type' => 'url' ),
		'website_kit_url'  => array( 'label' => __( 'DIY Website Builder / Website Launch Kit URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/6gMCy', 'type' => 'url' ),
		'contact_email'    => array( 'label' => __( 'Contact Email', 'holt-holdings' ), 'default' => 'hello@holtholdings.us', 'type' => 'email' ),
		'hands_on_idaho_url' => array( 'label' => __( 'Hands On Idaho URL', 'holt-holdings' ), 'default' => 'https://handsonidaho.com/', 'type' => 'url' ),
		'dirty_dumps_url'  => array( 'label' => __( 'Dirty Dumps Hauling Co. URL', 'holt-holdings' ), 'default' => '#', 'type' => 'url' ),
		'wireman_url'      => array( 'label' => __( 'Wireman URL', 'holt-holdings' ), 'default' => '#wireman', 'type' => 'url' ),
		'facebook_url'     => array( 'label' => __( 'Facebook URL', 'holt-holdings' ), 'default' => '#facebook', 'type' => 'url' ),
		'instagram_url'    => array( 'label' => __( 'Instagram URL', 'holt-holdings' ), 'default' => '#instagram', 'type' => 'url' ),
		'youtube_url'      => array( 'label' => __( 'YouTube URL', 'holt-holdings' ), 'default' => '#youtube', 'type' => 'url' ),
		'tiktok_url'       => array( 'label' => __( 'TikTok URL', 'holt-holdings' ), 'default' => '#tiktok', 'type' => 'url' ),
		'linkedin_url'     => array( 'label' => __( 'LinkedIn URL', 'holt-holdings' ), 'default' => '#linkedin', 'type' => 'url' ),
		'linktree_url'     => array( 'label' => __( 'Personal / Linktree URL', 'holt-holdings' ), 'default' => '#linktree', 'type' => 'url' ),
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
 * Check whether a URL should be treated as an external web link.
 *
 * @param string $url Link URL.
 * @return bool
 */
function holt_holdings_is_external_url( $url ) {
	return 0 === strpos( $url, 'http://' ) || 0 === strpos( $url, 'https://' );
}

/**
 * Check whether a URL is a placeholder hash rather than a real navigation target.
 *
 * @param string $url Link URL.
 * @return bool
 */
function holt_holdings_is_placeholder_url( $url ) {
	return empty( $url ) || '#' === $url || 0 === strpos( $url, '#facebook' ) || 0 === strpos( $url, '#instagram' ) || 0 === strpos( $url, '#youtube' ) || 0 === strpos( $url, '#tiktok' ) || 0 === strpos( $url, '#linkedin' ) || 0 === strpos( $url, '#linktree' );
}

/**
 * Echo a button-style link with safe external-link attributes.
 *
 * @param string $url   Link URL.
 * @param string $label Link label.
 * @param string $class CSS class.
 */
function holt_holdings_button_link( $url, $label, $class = 'button' ) {
	$target = holt_holdings_is_external_url( $url ) ? ' target="_blank" rel="noopener noreferrer"' : '';

	printf(
		'<a class="%1$s" href="%2$s"%3$s>%4$s</a>',
		esc_attr( $class ),
		esc_url( $url ),
		$target, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		esc_html( $label )
	);
}

/**
 * Centralized link and content config for homepage hub sections.
 *
 * Keep real URLs here when known. Use # placeholders only when a final public
 * URL is not available yet.
 *
 * @return array
 */
function holt_holdings_home_config() {
	$links = array(
		'main_site'     => home_url( '/' ),
		'hands_on'      => 'https://handsonidaho.com/',
		'website_kit'   => 'https://payhip.com/b/6gMCy',
		'crash_course'  => 'https://payhip.com/b/3GVP5',
		'wireman'       => holt_holdings_setting( 'wireman_url', '#wireman' ),
		'drill_bit'     => '#drill-bit-index',
		'future'        => '#socials',
		'facebook'      => holt_holdings_setting( 'facebook_url', '#facebook' ),
		'instagram'     => holt_holdings_setting( 'instagram_url', '#instagram' ),
		'youtube'       => holt_holdings_setting( 'youtube_url', '#youtube' ),
		'tiktok'        => holt_holdings_setting( 'tiktok_url', '#tiktok' ),
		'linkedin'      => holt_holdings_setting( 'linkedin_url', '#linkedin' ),
		'linktree'      => holt_holdings_setting( 'linktree_url', '#linktree' ),
	);

	return array(
		'links'           => $links,
		'featured_links'  => array(
			array(
				'name'        => 'Hands On Idaho',
				'description' => 'Handyman, home improvement, and practical home services based in the Boise/Meridian area.',
				'url'         => $links['hands_on'],
				'button'      => 'Visit Hands On Idaho',
			),
			array(
				'name'        => 'DIY Website Builder / Website Launch Kit',
				'description' => 'A practical website launch kit built to help small business owners, side hustlers, and creators move from a blank screen to a live website faster.',
				'url'         => $links['website_kit'],
				'button'      => 'View Product',
			),
			array(
				'name'        => 'Low Volt Crash Course',
				'description' => 'A beginner-friendly digital education product for people interested in cameras, access control, wiring basics, tools, and practical field knowledge.',
				'url'         => $links['crash_course'],
				'button'      => 'View Course',
			),
			array(
				'name'        => 'Wireman',
				'description' => 'Family tool project currently under construction.',
				'url'         => $links['wireman'],
				'button'      => 'Coming Soon',
			),
		),
		'businesses'      => array(
			array(
				'name'        => 'Hands On Idaho',
				'kicker'      => 'Public-facing business',
				'description' => 'Hands On Idaho is a practical home improvement and handyman service serving the Boise/Meridian area, focused on clean work, useful fixes, and homeowner-friendly solutions.',
				'url'         => $links['hands_on'],
				'button'      => 'Visit Hands On Idaho',
				'visible'     => true,
			),
			array(
				'name'        => 'Wireman',
				'kicker'      => 'Family tool brand',
				'description' => 'Wireman is a family tool brand currently under construction, connected to the Pocket Buddy concept and other practical trade-focused ideas.',
				'url'         => $links['wireman'],
				'button'      => 'Coming Soon',
				'visible'     => true,
			),
			// Internal/disabled project. Do not render publicly until intentionally enabled.
			array(
				'name'        => 'Dirty Dumps',
				'kicker'      => 'Internal project',
				'description' => 'Separate project held back from the public Holt Holdings homepage.',
				'url'         => holt_holdings_setting( 'dirty_dumps_url', '#' ),
				'button'      => 'Private',
				'visible'     => false,
			),
		),
		'digital_products' => array(
			array(
				'name'        => 'DIY Website Builder / Website Launch Kit',
				'kicker'      => 'Website product',
				'description' => 'DIY Website Builder is a practical website launch kit built to help small business owners, side hustlers, and creators move from a blank screen to a live website faster. It includes structure, prompts, and guidance to make the website-building process less overwhelming.',
				'url'         => $links['website_kit'],
				'button'      => 'View Product',
			),
			array(
				'name'        => 'Low Volt Crash Course',
				'kicker'      => 'Digital education',
				'description' => 'A beginner-friendly digital education product for people interested in cameras, access control, wiring basics, tools, and practical field knowledge.',
				'url'         => $links['crash_course'],
				'button'      => 'View Course',
			),
		),
		'works'           => array(
			array(
				'name'        => 'Drill Bit Index',
				'description' => 'A practical tool/reference project currently in development. More details coming soon.',
				'url'         => $links['drill_bit'],
				'button'      => 'Coming Soon',
			),
			array(
				'name'        => 'Wireman / Pocket Buddy',
				'description' => 'Family tool project currently under construction.',
				'url'         => $links['wireman'],
				'button'      => 'Coming Soon',
			),
			array(
				'name'        => 'Future resources',
				'description' => 'More guides, templates, tools, and practical resources are in progress.',
				'url'         => $links['future'],
				'button'      => 'Follow Along',
			),
		),
		'social_links'    => array(
			array( 'label' => 'Main Website', 'url' => $links['main_site'], 'status' => 'active' ),
			array( 'label' => 'Hands On Idaho', 'url' => $links['hands_on'], 'status' => 'active' ),
			array( 'label' => 'Facebook', 'url' => $links['facebook'], 'status' => 'placeholder' ),
			array( 'label' => 'Instagram', 'url' => $links['instagram'], 'status' => 'placeholder' ),
			array( 'label' => 'YouTube', 'url' => $links['youtube'], 'status' => 'placeholder' ),
			array( 'label' => 'TikTok', 'url' => $links['tiktok'], 'status' => 'placeholder' ),
			array( 'label' => 'LinkedIn', 'url' => $links['linkedin'], 'status' => 'placeholder' ),
			array( 'label' => 'Personal / Linktree (@austindholt)', 'url' => $links['linktree'], 'status' => 'placeholder' ),
		),
	);
}

/**
 * Useful section links before a custom menu is assigned.
 */
function holt_holdings_fallback_menu() {
	?>
	<ul id="primary-menu">
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#businesses"><?php esc_html_e( 'Businesses', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#products"><?php esc_html_e( 'Digital Products', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#works"><?php esc_html_e( 'Works in Progress', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#socials"><?php esc_html_e( 'Follow', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#contact"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></a></li>
	</ul>
	<?php
}
