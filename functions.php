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
 * Check whether a known SEO plugin is likely handling canonical tags.
 *
 * @return bool
 */
function holt_holdings_seo_plugin_handles_canonical() {
	return defined( 'WPSEO_VERSION' )
		|| defined( 'RANK_MATH_VERSION' )
		|| defined( 'AIOSEO_VERSION' )
		|| defined( 'SEOPRESS_VERSION' );
}

/**
 * Output one canonical URL for theme-rendered pages.
 */
function holt_holdings_canonical_url() {
	if ( holt_holdings_seo_plugin_handles_canonical() ) {
		return;
	}

	remove_action( 'wp_head', 'rel_canonical' );

	if ( is_front_page() || is_home() ) {
		$canonical = home_url( '/' );
	} elseif ( is_singular() ) {
		$canonical = get_permalink();
	} else {
		$request_path = isset( $GLOBALS['wp']->request ) ? trim( $GLOBALS['wp']->request, '/' ) : '';
		$canonical    = $request_path ? home_url( '/' . $request_path . '/' ) : home_url( '/' );
	}

	if ( empty( $canonical ) ) {
		return;
	}
	?>
	<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
	<?php
}
add_action( 'wp_head', 'holt_holdings_canonical_url', 4 );

/**
 * Add lightweight SEO and sharing meta for the homepage.
 */
function holt_holdings_meta_tags() {
	if ( ! is_front_page() && ! is_home() ) {
		return;
	}

	$title       = 'Austin Holt / Holt Holdings - Digital Products, Field Guides, Tools, and Projects';
	$description = 'Austin Holt and Holt Holdings hub for Payhip field guides, practical resources, affiliate tools, business projects, and creator links.';
	$url         = home_url( '/' );
	$image       = get_template_directory_uri() . '/assets/images/holt-holdings-logo.jpeg';
	?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
	<meta name="twitter:image" content="<?php echo esc_url( $image ); ?>">
	<?php
}
add_action( 'wp_head', 'holt_holdings_meta_tags', 5 );

/**
 * Output accurate JSON-LD for the homepage hub.
 */
function holt_holdings_structured_data() {
	if ( ! is_front_page() && ! is_home() ) {
		return;
	}

	$config = holt_holdings_home_config();
	$links  = $config['links'];
	$image  = get_template_directory_uri() . '/assets/images/holt-holdings-logo.jpeg';
	$items  = array();
	$index  = 1;

	foreach ( array( 'businesses', 'digital_products', 'resources', 'works' ) as $section ) {
		foreach ( $config[ $section ] as $item ) {
			if ( isset( $item['visible'] ) && ! $item['visible'] ) {
				continue;
			}

			$url = isset( $item['url'] ) && ! holt_holdings_is_placeholder_url( $item['url'] ) ? $item['url'] : home_url( '/' );
			if ( 0 === strpos( $url, '#' ) ) {
				$url = home_url( '/' . $url );
			}

			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $index,
				'name'     => $item['name'],
				'url'      => $url,
			);
			$index++;
		}
	}

	$graph = array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type' => 'Person',
				'@id'   => home_url( '/#austin-holt' ),
				'name'  => 'Austin Holt',
				'url'   => home_url( '/' ),
				'sameAs' => array_values( array_filter( array(
					$links['instagram'],
					$links['youtube'],
					$links['tiktok'],
					$links['facebook'],
					$links['linktree'],
				) ) ),
			),
			array(
				'@type' => 'Organization',
				'@id'   => home_url( '/#organization' ),
				'name'  => 'Holt Holdings LLC',
				'url'   => home_url( '/' ),
				'logo'  => $image,
			),
			array(
				'@type' => 'WebSite',
				'@id'   => home_url( '/#website' ),
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
			),
			array(
				'@type'           => 'ItemList',
				'@id'             => home_url( '/#hub-list' ),
				'name'            => 'Holt Holdings businesses, projects, products, and resources',
				'itemListElement' => $items,
			),
		),
	);
	?>
	<script type="application/ld+json"><?php echo wp_json_encode( $graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
	<?php
}
add_action( 'wp_head', 'holt_holdings_structured_data', 6 );

/**
 * Output GA4 only when a valid Measurement ID is configured.
 */
function holt_holdings_ga4_tag() {
	if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		return;
	}

	$measurement_id = strtoupper( trim( holt_holdings_setting( 'ga4_measurement_id', '' ) ) );

	if ( ! preg_match( '/^G-[A-Z0-9]{6,}$/', $measurement_id ) ) {
		return;
	}
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $measurement_id ); ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo esc_js( $measurement_id ); ?>');
	</script>
	<?php
}
add_action( 'wp_head', 'holt_holdings_ga4_tag', 20 );

/**
 * Register Customizer fields for easy homepage editing.
 */
function holt_holdings_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'holt_holdings_home', array(
		'title'       => __( 'Holt Holdings Home', 'holt-holdings' ),
		'description' => __( 'Edit homepage headlines, calls to action, and public links.', 'holt-holdings' ),
		'priority'    => 30,
	) );

	$fields = array(
		'hero_headline'    => array(
			'label'   => __( 'Hero Headline', 'holt-holdings' ),
			'default' => 'Field notes, digital guides, tools, and business projects.',
			'type'    => 'textarea',
		),
		'hero_subheadline' => array(
			'label'   => __( 'Hero Subheadline', 'holt-holdings' ),
			'default' => 'Holt Holdings is Austin Holt\'s personal hub for practical field notes, Payhip guides, useful tools, affiliate resources, business projects, inventions, and creator links.',
			'type'    => 'textarea',
		),
		// Update social/product URLs here. Empty project URLs render as non-clickable Coming Soon labels.
		'payhip_store_url'       => array( 'label' => __( 'LowVoltHolt Payhip Store URL', 'holt-holdings' ), 'default' => 'https://payhip.com/LowVoltHolt', 'type' => 'url' ),
		'course_url'             => array( 'label' => __( 'Low Voltage Crash Course URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/3GVP5', 'type' => 'url' ),
		'everyday_money_url'     => array( 'label' => __( 'Everyday Money Moves URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/sa17H', 'type' => 'url' ),
		'windows_rebuild_url'    => array( 'label' => __( 'Windows Rebuild Guide URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/kROjv', 'type' => 'url' ),
		'exacq_checklist_url'    => array( 'label' => __( 'ExacqVision Checklist / SOP URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/9iMt1', 'type' => 'url' ),
		'rytec_guide_url'        => array( 'label' => __( 'Rytec Door Interlock Field Guide URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/T9YW2', 'type' => 'url' ),
		'camera_guide_url'       => array( 'label' => __( 'Camera Systems Field Guide URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/AYP01', 'type' => 'url' ),
		'money_bundle_url'       => array( 'label' => __( 'Money Product Bundle URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/nV37U', 'type' => 'url' ),
		'home_cooling_guide_url' => array( 'label' => __( 'Home Cooling Guide URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/6CjV7', 'type' => 'url' ),
		'pdk_notes_url'          => array( 'label' => __( 'PDK Field Notes URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/mGHjT', 'type' => 'url' ),
		'lenels2_sop_url'        => array( 'label' => __( 'LenelS2 NetBox Field SOP URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/NK4IS', 'type' => 'url' ),
		'synology_guide_url'     => array( 'label' => __( 'Synology NAS Setup Field Guide URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/xEdtR', 'type' => 'url' ),
		'website_kit_url'        => array( 'label' => __( 'DIY Website Builder / Website Launch Kit URL', 'holt-holdings' ), 'default' => 'https://payhip.com/b/6gMCy', 'type' => 'url' ),
		'amazon_storefront_url'  => array( 'label' => __( 'Amazon Storefront URL', 'holt-holdings' ), 'default' => 'https://www.amazon.com/shop/austindholt', 'type' => 'url' ),
		'amazon_prime_url'       => array( 'label' => __( 'Amazon Prime URL', 'holt-holdings' ), 'default' => 'https://amzn.to/4u1aeBb', 'type' => 'url' ),
		'audible_url'            => array( 'label' => __( 'Audible Premium Plus URL', 'holt-holdings' ), 'default' => 'https://amzn.to/4twRitV', 'type' => 'url' ),
		'amazon_business_url'    => array( 'label' => __( 'Amazon Business URL', 'holt-holdings' ), 'default' => 'https://amzn.to/4wY2e6H', 'type' => 'url' ),
		'contact_email'          => array( 'label' => __( 'Contact Email', 'holt-holdings' ), 'default' => 'holtholdings@outlook.com', 'type' => 'email' ),
		'ga4_measurement_id'     => array( 'label' => __( 'GA4 Measurement ID', 'holt-holdings' ), 'default' => '', 'type' => 'text' ),
		'hands_on_idaho_url'     => array( 'label' => __( 'Hands On Idaho URL', 'holt-holdings' ), 'default' => 'https://handsonidaho.com/', 'type' => 'url' ),
		'hands_on_instagram_url' => array( 'label' => __( 'Hands On Idaho Instagram URL', 'holt-holdings' ), 'default' => 'https://www.instagram.com/handsonidaho/', 'type' => 'url' ),
		'hands_on_facebook_url'  => array( 'label' => __( 'Hands On Idaho Facebook URL', 'holt-holdings' ), 'default' => 'https://www.facebook.com/share/1GvksuadZf/?mibextid=wwXIfr', 'type' => 'url' ),
		'hands_on_review_url'    => array( 'label' => __( 'Hands On Idaho Google Review URL', 'holt-holdings' ), 'default' => 'https://g.page/r/CWVQEsDBWd1GEBM/review', 'type' => 'url' ),
		'dirty_dumps_url'        => array( 'label' => __( 'Dirty Dumps Hauling Co. URL', 'holt-holdings' ), 'default' => 'https://dirtydumpshaulingco.com/', 'type' => 'url' ),
		'dirty_dumps_instagram_url' => array( 'label' => __( 'Dirty Dumps Instagram URL', 'holt-holdings' ), 'default' => 'https://www.instagram.com/dirtydumpshaulingco/', 'type' => 'url' ),
		'wireman_url'            => array( 'label' => __( 'Wireman URL', 'holt-holdings' ), 'default' => 'https://wireman.com/', 'type' => 'url' ),
		'facebook_url'           => array( 'label' => __( 'Facebook URL', 'holt-holdings' ), 'default' => 'https://www.facebook.com/share/1HF3jGFF8L/?mibextid=wwXIfr', 'type' => 'url' ),
		'instagram_url'          => array( 'label' => __( 'Instagram URL', 'holt-holdings' ), 'default' => 'https://www.instagram.com/austindholt/', 'type' => 'url' ),
		'youtube_url'            => array( 'label' => __( 'YouTube URL', 'holt-holdings' ), 'default' => 'https://youtube.com/@austindholt', 'type' => 'url' ),
		'tiktok_url'             => array( 'label' => __( 'TikTok URL', 'holt-holdings' ), 'default' => 'https://www.tiktok.com/@austindholt', 'type' => 'url' ),
		'linkedin_url'           => array( 'label' => __( 'LinkedIn URL', 'holt-holdings' ), 'default' => '', 'type' => 'url' ),
		'github_url'             => array( 'label' => __( 'GitHub URL', 'holt-holdings' ), 'default' => '', 'type' => 'url' ),
		'bitready_url'           => array( 'label' => __( 'BitReady Index Project URL', 'holt-holdings' ), 'default' => 'https://bitreadyindex.com/', 'type' => 'url' ),
		'bitready_github_url'    => array( 'label' => __( 'BitReady GitHub URL', 'holt-holdings' ), 'default' => 'https://github.com/austindholt/bitready', 'type' => 'url' ),
		'linktree_url'           => array( 'label' => __( 'Austin Holt / Linktree URL', 'holt-holdings' ), 'default' => 'https://linktr.ee/austindholt', 'type' => 'url' ),
	);

	foreach ( $fields as $id => $field ) {
		$sanitize_callback = 'sanitize_text_field';

		if ( 'ga4_measurement_id' === $id ) {
			$sanitize_callback = 'holt_holdings_sanitize_ga4_measurement_id';
		} elseif ( 'textarea' === $field['type'] ) {
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
 * Sanitize an optional GA4 Measurement ID.
 *
 * @param string $value Raw Customizer value.
 * @return string
 */
function holt_holdings_sanitize_ga4_measurement_id( $value ) {
	$value = strtoupper( trim( sanitize_text_field( $value ) ) );

	return preg_match( '/^G-[A-Z0-9]{6,}$/', $value ) ? $value : '';
}

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
 * Return the general Holt Holdings contact email.
 *
 * @return string
 */
function holt_holdings_contact_email() {
	$email = strtolower( trim( holt_holdings_setting( 'contact_email', 'holtholdings@outlook.com' ) ) );

	if ( empty( $email ) || 'hello@holtholdings.us' === $email ) {
		return 'holtholdings@outlook.com';
	}

	return $email;
}

/**
 * Return a saved URL, unless it is empty or an old placeholder.
 *
 * @param string $name    Setting name.
 * @param string $default Known public URL fallback.
 * @return string
 */
function holt_holdings_link_setting( $name, $default = '' ) {
	$value = holt_holdings_setting( $name, $default );

	if ( holt_holdings_is_placeholder_url( $value ) ) {
		return $default;
	}

	return $value;
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
 * Check whether a URL is an Amazon affiliate/resource link.
 *
 * @param string $url Link URL.
 * @return bool
 */
function holt_holdings_is_affiliate_url( $url ) {
	$host = wp_parse_url( $url, PHP_URL_HOST );

	if ( ! $host ) {
		return false;
	}

	$host = strtolower( $host );

	return in_array( $host, array( 'a.co', 'amzn.to' ), true ) || false !== strpos( $host, 'amazon.' );
}

/**
 * Return safe rel attributes for external links.
 *
 * @param string $url Link URL.
 * @return string
 */
function holt_holdings_link_rel( $url ) {
	if ( ! holt_holdings_is_external_url( $url ) ) {
		return '';
	}

	return holt_holdings_is_affiliate_url( $url ) ? 'sponsored noopener noreferrer' : 'noopener noreferrer';
}

/**
 * Return a broad outbound tracking category for a URL.
 *
 * @param string $url Link URL.
 * @return string
 */
function holt_holdings_link_category( $url ) {
	$host = strtolower( (string) wp_parse_url( $url, PHP_URL_HOST ) );

	if ( holt_holdings_is_affiliate_url( $url ) ) {
		return 'amazon';
	}

	if ( false !== strpos( $host, 'payhip.com' ) ) {
		return 'payhip';
	}

	if ( $host && false === strpos( $host, 'holtholdings.us' ) ) {
		return 'business';
	}

	return '';
}

/**
 * Check whether a URL is a placeholder hash rather than a real navigation target.
 *
 * @param string $url Link URL.
 * @return bool
 */
function holt_holdings_is_placeholder_url( $url ) {
	$placeholder_urls = array(
		'',
		'#',
		'#facebook',
		'#instagram',
		'#youtube',
		'#tiktok',
		'#linkedin',
		'#linktree',
		'#low-volt-crash-course',
		'#website-launch-kit',
		'#diy-website-builder',
		'#wireman',
		'#drill-bit-index',
	);

	return in_array( trim( (string) $url ), $placeholder_urls, true );
}

/**
 * Echo a button-style link with safe external-link attributes.
 *
 * @param string $url   Link URL.
 * @param string $label Link label.
 * @param string $class CSS class.
 */
function holt_holdings_button_link( $url, $label, $class = 'button' ) {
	if ( holt_holdings_is_placeholder_url( $url ) ) {
		printf(
			'<span class="%1$s button-disabled" aria-disabled="true">%2$s</span>',
			esc_attr( $class ),
			esc_html( $label )
		);
		return;
	}

	$rel    = holt_holdings_link_rel( $url );
	$target = holt_holdings_is_external_url( $url ) ? sprintf( ' target="_blank" rel="%s"', esc_attr( $rel ) ) : '';
	$track  = '';

	if ( holt_holdings_is_external_url( $url ) ) {
		$track = sprintf(
			' data-track="outbound-link" data-link-category="%1$s" data-link-label="%2$s" data-link-url="%3$s"',
			esc_attr( holt_holdings_link_category( $url ) ),
			esc_attr( $label ),
			esc_url( $url )
		);
	}

	printf(
		'<a class="%1$s" href="%2$s"%3$s%4$s>%5$s</a>',
		esc_attr( $class ),
		esc_url( $url ),
		$target, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$track, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		esc_html( $label )
	);
}

/**
 * Centralized link and content config for homepage hub sections.
 *
 * Update social/product URLs here. Keep unknown links empty so they do not
 * render as misleading clickable placeholders.
 *
 * @return array
 */
function holt_holdings_home_config() {
	$links = array(
		'main_site'          => 'https://holtholdings.us/',
		'payhip_store'       => holt_holdings_link_setting( 'payhip_store_url', 'https://payhip.com/LowVoltHolt' ),
		'crash_course'       => holt_holdings_link_setting( 'course_url', 'https://payhip.com/b/3GVP5' ),
		'everyday_money'     => holt_holdings_link_setting( 'everyday_money_url', 'https://payhip.com/b/sa17H' ),
		'windows_rebuild'    => holt_holdings_link_setting( 'windows_rebuild_url', 'https://payhip.com/b/kROjv' ),
		'exacq_checklist'    => holt_holdings_link_setting( 'exacq_checklist_url', 'https://payhip.com/b/9iMt1' ),
		'rytec_guide'        => holt_holdings_link_setting( 'rytec_guide_url', 'https://payhip.com/b/T9YW2' ),
		'camera_guide'       => holt_holdings_link_setting( 'camera_guide_url', 'https://payhip.com/b/AYP01' ),
		'money_bundle'       => holt_holdings_link_setting( 'money_bundle_url', 'https://payhip.com/b/nV37U' ),
		'home_cooling_guide' => holt_holdings_link_setting( 'home_cooling_guide_url', 'https://payhip.com/b/6CjV7' ),
		'pdk_notes'          => holt_holdings_link_setting( 'pdk_notes_url', 'https://payhip.com/b/mGHjT' ),
		'lenels2_sop'        => holt_holdings_link_setting( 'lenels2_sop_url', 'https://payhip.com/b/NK4IS' ),
		'synology_guide'     => holt_holdings_link_setting( 'synology_guide_url', 'https://payhip.com/b/xEdtR' ),
		'website_kit'        => holt_holdings_link_setting( 'website_kit_url', 'https://payhip.com/b/6gMCy' ),
		'amazon_storefront'  => holt_holdings_link_setting( 'amazon_storefront_url', 'https://www.amazon.com/shop/austindholt' ),
		'amazon_prime'       => holt_holdings_link_setting( 'amazon_prime_url', 'https://amzn.to/4u1aeBb' ),
		'audible'            => holt_holdings_link_setting( 'audible_url', 'https://amzn.to/4twRitV' ),
		'amazon_business'    => holt_holdings_link_setting( 'amazon_business_url', 'https://amzn.to/4wY2e6H' ),
		'hands_on'           => holt_holdings_link_setting( 'hands_on_idaho_url', 'https://handsonidaho.com/' ),
		'hands_on_instagram' => holt_holdings_link_setting( 'hands_on_instagram_url', 'https://www.instagram.com/handsonidaho/' ),
		'hands_on_facebook'  => holt_holdings_link_setting( 'hands_on_facebook_url', 'https://www.facebook.com/share/1GvksuadZf/?mibextid=wwXIfr' ),
		'hands_on_review'    => holt_holdings_link_setting( 'hands_on_review_url', 'https://g.page/r/CWVQEsDBWd1GEBM/review' ),
		'dirty_dumps'        => holt_holdings_link_setting( 'dirty_dumps_url', 'https://dirtydumpshaulingco.com/' ),
		'dirty_dumps_instagram' => holt_holdings_link_setting( 'dirty_dumps_instagram_url', 'https://www.instagram.com/dirtydumpshaulingco/' ),
		'wireman'            => holt_holdings_link_setting( 'wireman_url', 'https://wireman.com/' ),
		'bitready'           => holt_holdings_link_setting( 'bitready_url', 'https://bitreadyindex.com/' ),
		'bitready_github'    => holt_holdings_link_setting( 'bitready_github_url', 'https://github.com/austindholt/bitready' ),
		'future'             => '#socials',
		'facebook'           => holt_holdings_link_setting( 'facebook_url', 'https://www.facebook.com/share/1HF3jGFF8L/?mibextid=wwXIfr' ),
		'instagram'          => holt_holdings_link_setting( 'instagram_url', 'https://www.instagram.com/austindholt/' ),
		'youtube'            => holt_holdings_link_setting( 'youtube_url', 'https://youtube.com/@austindholt' ),
		'tiktok'             => holt_holdings_link_setting( 'tiktok_url', 'https://www.tiktok.com/@austindholt' ),
		'linkedin'           => holt_holdings_link_setting( 'linkedin_url', '' ),
		'github'             => holt_holdings_link_setting( 'github_url', '' ),
		'linktree'           => holt_holdings_link_setting( 'linktree_url', 'https://linktr.ee/austindholt' ),
	);

	return array(
		'links'           => $links,
		// TODO when real URLs are ready: LinkedIn, Austin's general GitHub profile,
		// Hands-On Idaho Nextdoor, Dirty Dumps Facebook, and Dirty Dumps Nextdoor.
		'featured_links'  => array(
			array(
				'name'        => 'Digital Products',
				'description' => 'Payhip field guides, practical checklists, and learning resources.',
				'url'         => '#products',
				'button'      => 'Browse Products',
			),
			array(
				'name'        => 'Tools & Resources',
				'description' => 'Affiliate links for useful tools, gear, audiobooks, and business buying.',
				'url'         => '#resources',
				'button'      => 'View Resources',
			),
			array(
				'name'        => 'Businesses & Projects',
				'description' => 'Separate public business/project links connected to Austin Holt.',
				'url'         => '#businesses',
				'button'      => 'Explore Projects',
			),
			array(
				'name'        => 'Follow & Contact',
				'description' => 'Creator links, social profiles, and the main Linktree hub.',
				'url'         => '#socials',
				'button'      => 'Follow Along',
			),
		),
		'businesses'      => array(
			array(
				'name'        => 'Hands On Idaho',
				'kicker'      => 'Local home services',
				'description' => 'Hands On Idaho is the separate local handyman and home improvement service for Boise, Meridian, and the Treasure Valley. Call 208-861-2302 or email handsonidaho@outlook.com.',
				'url'         => $links['hands_on'],
				'button'      => 'Visit Hands On Idaho',
				'visible'     => true,
			),
			array(
				'name'        => 'Hands-On Idaho Google Review',
				'kicker'      => 'Review link',
				'description' => 'Worked with Hands-On Idaho? This link points directly to the Google review page.',
				'url'         => $links['hands_on_review'],
				'button'      => 'Leave a Review',
				'visible'     => true,
			),
			array(
				'name'        => 'Dirty Dumps Hauling Co.',
				'kicker'      => 'Hauling project',
				'description' => 'Dirty Dumps Hauling Co. is a separate junk removal and hauling project.',
				'url'         => $links['dirty_dumps'],
				'button'      => 'Visit Dirty Dumps',
				'visible'     => true,
			),
			array(
				'name'        => 'Wireman',
				'kicker'      => 'Family tool brand',
				'description' => 'Wireman is a family tool brand currently under construction, connected to the Pocket Buddy and other practical trade-focused tools.',
				'url'         => '',
				'button'      => 'Under Construction',
				'status'      => 'under_construction',
				'visible'     => true,
			),
		),
		'digital_products' => array(
			array(
				'name'        => 'LowVoltHolt Payhip Store',
				'kicker'      => 'Full store',
				'description' => 'The main Payhip storefront for current field guides, checklists, and practical digital resources.',
				'url'         => $links['payhip_store'],
				'button'      => 'Visit Store',
				'group'       => 'Featured Products',
			),
			array(
				'name'        => 'Local Business Website Launch Kit',
				'kicker'      => 'Website product',
				'description' => 'A practical launch kit built to help local businesses, side hustlers, and creators move from a blank screen to a live website faster.',
				'url'         => $links['website_kit'],
				'button'      => 'View Product',
				'group'       => 'Featured Products',
			),
			array(
				'name'        => 'Low Volt Holt: Low Voltage Crash Course',
				'kicker'      => 'Digital education',
				'description' => 'A practical beginner-friendly guide for learning low-voltage basics, field mindset, tools, and real-world installation concepts.',
				'url'         => $links['crash_course'],
				'button'      => 'View Course',
				'group'       => 'Featured Products',
			),
			array(
				'name'        => 'Camera Systems Field Guide',
				'kicker'      => 'Field guide',
				'description' => 'A practical field guide for camera system planning, setup, and troubleshooting notes.',
				'url'         => $links['camera_guide'],
				'button'      => 'View Field Guide',
				'group'       => 'Featured Products',
			),
			array(
				'name'        => 'Everyday Money Moves',
				'kicker'      => 'Personal finance',
				'description' => 'A simple personal finance guide focused on practical money habits, saving, and small moves that add up over time.',
				'url'         => $links['everyday_money'],
				'button'      => 'View Guide',
				'group'       => 'Money and Business Resources',
			),
			array(
				'name'        => 'Money Product Bundle',
				'kicker'      => 'Personal finance',
				'description' => 'A money resource bundle for practical budgeting, everyday habits, and business-minded planning.',
				'url'         => $links['money_bundle'],
				'button'      => 'View Bundle',
				'group'       => 'Money and Business Resources',
			),
			array(
				'name'        => 'Windows Rebuild Guide',
				'kicker'      => 'Computer setup',
				'description' => 'A practical guide/checklist for rebuilding or refreshing a Windows computer setup.',
				'url'         => $links['windows_rebuild'],
				'button'      => 'View Guide',
				'group'       => 'Free Field Guides and Resources',
			),
			array(
				'name'        => 'ExacqVision Storage Server Setup Checklist / Field SOP',
				'kicker'      => 'Field SOP',
				'description' => 'A practical field checklist for ExacqVision storage server setup, storage planning, and troubleshooting.',
				'url'         => $links['exacq_checklist'],
				'button'      => 'View Field Guide',
				'group'       => 'Free Field Guides and Resources',
			),
			array(
				'name'        => 'Rytec Interlock / Locked-Closed Input Field Guide',
				'kicker'      => 'Door controls',
				'description' => 'Field notes for Rytec locked-closed input setup, interlock troubleshooting, and practical door-control checks.',
				'url'         => $links['rytec_guide'],
				'button'      => 'View Field Guide',
				'group'       => 'Free Field Guides and Resources',
			),
			array(
				'name'        => 'PDK Field Notes',
				'kicker'      => 'Access control',
				'description' => 'Practical notes for PDK power, WiMAC, integration, and troubleshooting issues.',
				'url'         => $links['pdk_notes'],
				'button'      => 'View Notes',
				'group'       => 'Free Field Guides and Resources',
			),
			array(
				'name'        => 'LenelS2 NetBox Field SOP',
				'kicker'      => 'Access control',
				'description' => 'Field SOP for NetBox blade, reader, and upgrade troubleshooting.',
				'url'         => $links['lenels2_sop'],
				'button'      => 'View SOP',
				'group'       => 'Free Field Guides and Resources',
			),
			array(
				'name'        => 'Synology NAS Setup Field Guide',
				'kicker'      => 'Private cloud',
				'description' => 'A practical guide for setting up a private cloud/home lab style Synology NAS.',
				'url'         => $links['synology_guide'],
				'button'      => 'View Field Guide',
				'group'       => 'Free Field Guides and Resources',
			),
			array(
				'name'        => 'Homeowner AC Tips / Home Cooling Guide',
				'kicker'      => 'Home resource',
				'description' => 'A practical homeowner guide for simple cooling checks, seasonal habits, and AC troubleshooting basics.',
				'url'         => $links['home_cooling_guide'],
				'button'      => 'Download Free Guide',
				'group'       => 'Free Field Guides and Resources',
			),
		),
		'resources'        => array(
			array(
				'name'        => 'Amazon Storefront',
				'description' => 'Shop my current tool, tech, and project gear list.',
				'url'         => $links['amazon_storefront'],
				'button'      => 'Shop Storefront',
			),
			array(
				'name'        => 'Amazon Prime',
				'description' => 'Amazon Prime link for fast shipping and everyday essentials.',
				'url'         => $links['amazon_prime'],
				'button'      => 'View Prime',
			),
			array(
				'name'        => 'Audible Premium Plus',
				'description' => 'Audiobooks and personal development listening.',
				'url'         => $links['audible'],
				'button'      => 'View Audible',
			),
			array(
				'name'        => 'Amazon Business',
				'description' => 'Business buying/account setup for tools, supplies, and project materials.',
				'url'         => $links['amazon_business'],
				'button'      => 'View Amazon Business',
			),
		),
		'works'           => array(
			array(
				'name'        => 'BitReady Index',
				'description' => 'BitReady Index is a patent-protected practical tool project currently moving through prototype and product-development stages.',
				'url'         => $links['bitready'],
				'button'      => 'View Project',
				'secondary_url' => $links['bitready_github'],
				'secondary_button' => 'View GitHub',
				'status'      => 'in_development',
			),
			array(
				'name'        => 'Future resources',
				'description' => 'More guides, templates, affiliate resources, tools, and practical field notes are in progress.',
				'url'         => $links['future'],
				'button'      => 'Follow Along',
			),
		),
		'social_links'    => array(
			array( 'label' => 'Austin Holt / Linktree', 'url' => $links['linktree'], 'status' => 'active' ),
			array( 'label' => 'Instagram', 'url' => $links['instagram'], 'status' => 'active' ),
			array( 'label' => 'YouTube', 'url' => $links['youtube'], 'status' => 'active' ),
			array( 'label' => 'TikTok', 'url' => $links['tiktok'], 'status' => 'active' ),
			array( 'label' => 'Facebook', 'url' => $links['facebook'], 'status' => 'active' ),
			array( 'label' => 'Hands On Idaho Instagram', 'url' => $links['hands_on_instagram'], 'status' => 'active' ),
			array( 'label' => 'Hands On Idaho Facebook', 'url' => $links['hands_on_facebook'], 'status' => 'active' ),
			array( 'label' => 'Dirty Dumps Instagram', 'url' => $links['dirty_dumps_instagram'], 'status' => 'active' ),
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
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#resources"><?php esc_html_e( 'Resources', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#works"><?php esc_html_e( 'Works in Progress', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#socials"><?php esc_html_e( 'Follow', 'holt-holdings' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#contact"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></a></li>
	</ul>
	<?php
}
