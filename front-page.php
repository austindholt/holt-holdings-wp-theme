<?php
/**
 * Custom front page for Holt Holdings.
 *
 * @package HoltHoldings
 */

get_header();

$contact_email = holt_holdings_setting( 'contact_email', 'hello@holtholdings.us' );

// Placeholder URLs use # until final brand/project/product links are ready.
$businesses = array(
	array(
		'name'        => 'Hands On Idaho',
		'kicker'      => 'Operating Brand',
		'description' => 'A separate handyman, home improvement, and practical home services brand serving the Boise/Meridian area.',
		'url'         => holt_holdings_setting( 'hands_on_idaho_url', '#' ),
		'button'      => 'Visit',
	),
	array(
		'name'        => 'Dirty Dumps Hauling Co.',
		'kicker'      => 'Operating Brand',
		'description' => 'A separate junk removal, cleanout, hauling, and dump run brand.',
		'url'         => holt_holdings_setting( 'dirty_dumps_url', '#' ),
		'button'      => 'Visit',
	),
	array(
		'name'        => 'Wireman',
		'kicker'      => 'Family Tool Project',
		'description' => 'Wireman is a family tool project currently under construction, connected to the Pocket Buddy concept and other practical trade-focused ideas.',
		'url'         => holt_holdings_setting( 'wireman_url', '#' ),
		'button'      => 'Coming Soon',
	),
);

$projects = array(
	array(
		'name'        => 'Drill Bit Index',
		'description' => 'A practical reference for choosing the right bit, size, and setup for field work.',
		'label'       => 'Coming Soon',
	),
	array(
		'name'        => 'Wireman resources',
		'description' => 'Family project notes, Pocket Buddy ideas, and practical trade-focused resources under construction.',
		'label'       => 'In Progress',
	),
	array(
		'name'        => 'Future tools/templates/checklists',
		'description' => 'Simple digital helpers for estimating, planning, documenting, and doing better work.',
		'label'       => 'Coming Soon',
	),
);

$digital_products = array(
	array(
		'name'        => 'Low Volt Crash Course',
		'kicker'      => 'Digital Education',
		'description' => 'A standalone beginner-friendly digital education product covering cameras, access control, wiring basics, tools, and practical field knowledge.',
		'url'         => holt_holdings_setting( 'course_url', '#low-volt-crash-course' ),
		'button'      => 'View Course',
		'points'      => array(
			'Cameras, access control, and system fundamentals',
			'Wiring basics, field tools, and practical learning habits',
			'Plain-language lessons for beginners',
		),
	),
	array(
		'name'        => 'DIY Website Builder / Website Launch Kit',
		'kicker'      => 'Website Product',
		'description' => 'DIY Website Builder is a practical website launch kit built to help small business owners, side hustlers, and creators move from a blank screen to a live website faster. It includes structure, prompts, and guidance to make the website-building process less overwhelming.',
		'url'         => holt_holdings_setting( 'website_kit_url', '#website-launch-kit' ),
		'button'      => 'View Product',
		'points'      => array(
			'Website structure and launch planning',
			'Prompts for copy, offers, pages, and calls to action',
			'Guidance for getting unstuck and publishing faster',
		),
	),
);

$social_links = array(
	array( 'label' => 'Facebook', 'url' => holt_holdings_setting( 'facebook_url', '#facebook' ) ),
	array( 'label' => 'Instagram', 'url' => holt_holdings_setting( 'instagram_url', '#instagram' ) ),
	array( 'label' => 'YouTube', 'url' => holt_holdings_setting( 'youtube_url', '#youtube' ) ),
	array( 'label' => 'TikTok', 'url' => holt_holdings_setting( 'tiktok_url', '#tiktok' ) ),
	array( 'label' => 'LinkedIn', 'url' => holt_holdings_setting( 'linkedin_url', '#linkedin' ) ),
	array( 'label' => 'Personal Website', 'url' => holt_holdings_setting( 'personal_site_url', '#personal-website' ) ),
);
?>
<main id="primary" class="site-main">
	<section class="hero" id="home">
		<div class="hero-grid">
			<div>
				<div class="eyebrow"><?php esc_html_e( 'Holt Holdings LLC', 'holt-holdings' ); ?></div>
				<h1><?php echo esc_html( holt_holdings_setting( 'hero_headline', 'Building practical businesses, tools, and trade-focused resources.' ) ); ?></h1>
				<p><?php echo esc_html( holt_holdings_setting( 'hero_subheadline', 'Holt Holdings is the home base for Austin Holt\'s business ventures, family projects, digital products, and works in progress.' ) ); ?></p>
				<div class="hero-actions">
					<a class="button" href="#projects"><?php esc_html_e( 'View Projects', 'holt-holdings' ); ?></a>
					<a class="button secondary" href="#products"><?php esc_html_e( 'Digital Products', 'holt-holdings' ); ?></a>
					<a class="button secondary" href="#contact"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></a>
				</div>
			</div>
			<aside class="hero-panel" aria-label="<?php esc_attr_e( 'Holt Holdings focus areas', 'holt-holdings' ); ?>">
				<div class="panel-label"><?php esc_html_e( 'Portfolio Hub', 'holt-holdings' ); ?></div>
				<div class="panel-lines">
					<div class="panel-line"><strong><?php esc_html_e( 'Ventures', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Brands + projects', 'holt-holdings' ); ?></span></div>
					<div class="panel-line"><strong><?php esc_html_e( 'Products', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Courses + resources', 'holt-holdings' ); ?></span></div>
					<div class="panel-line"><strong><?php esc_html_e( 'Builds', 'holt-holdings' ); ?></strong><span><?php esc_html_e( 'Tools + experiments', 'holt-holdings' ); ?></span></div>
				</div>
			</aside>
		</div>
	</section>

	<section class="section" id="about">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'About / Austin Holt', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'A home base for ventures, family projects, digital products, and works in progress.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Holt Holdings is the home base for Austin Holt\'s business ventures, family projects, digital products, and works in progress. This site collects what is being built, tested, launched, and documented over time.', 'holt-holdings' ); ?></p>
		</div>
	</section>

	<section class="section" id="businesses">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Businesses', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Brands, ventures, and projects connected to the portfolio.', 'holt-holdings' ); ?></h2>
		</div>
		<div class="card-grid">
			<?php foreach ( $businesses as $business ) : ?>
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
			<h2><?php esc_html_e( 'Courses, launch kits, and practical resources.', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Digital products listed here are separate products and resources connected to the broader Holt Holdings portfolio.', 'holt-holdings' ); ?></p>
		</div>
		<div class="product-grid">
			<?php foreach ( $digital_products as $product ) : ?>
				<article class="product-feature">
					<div>
						<span class="card-kicker"><?php echo esc_html( $product['kicker'] ); ?></span>
						<h3><?php echo esc_html( $product['name'] ); ?></h3>
						<p><?php echo esc_html( $product['description'] ); ?></p>
						<a class="button" href="<?php echo esc_url( $product['url'] ); ?>"><?php echo esc_html( $product['button'] ); ?></a>
					</div>
					<ul class="check-list">
						<?php foreach ( $product['points'] as $point ) : ?>
							<li><?php echo esc_html( $point ); ?></li>
						<?php endforeach; ?>
					</ul>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="projects">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Projects / Works in Progress', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'The bench is active.', 'holt-holdings' ); ?></h2>
		</div>
		<div class="card-grid">
			<?php foreach ( $projects as $project ) : ?>
				<article class="hub-card">
					<span class="coming-soon"><?php echo esc_html( $project['label'] ); ?></span>
					<h3><?php echo esc_html( $project['name'] ); ?></h3>
					<p><?php echo esc_html( $project['description'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="follow">
		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Follow Along', 'holt-holdings' ); ?></span>
			<h2><?php esc_html_e( 'Follow the Build', 'holt-holdings' ); ?></h2>
			<p><?php esc_html_e( 'Follow along as Holt Holdings grows practical businesses, digital products, tools, and trade-focused resources.', 'holt-holdings' ); ?></p>
		</div>
		<div class="social-grid">
			<?php foreach ( $social_links as $social_link ) : ?>
				<a class="social-card" href="<?php echo esc_url( $social_link['url'] ); ?>"><?php echo esc_html( $social_link['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section" id="contact">
		<div class="contact-band">
			<div>
				<span class="eyebrow"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></span>
				<h2><?php esc_html_e( 'General inquiries, collaboration, product questions, and project opportunities.', 'holt-holdings' ); ?></h2>
				<p><?php esc_html_e( 'Use the contact link for questions related to Holt Holdings, listed ventures, digital products, future tools, partnerships, or project opportunities.', 'holt-holdings' ); ?></p>
			</div>
			<div>
				<a class="button" href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>"><?php esc_html_e( 'Email Austin', 'holt-holdings' ); ?></a>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
