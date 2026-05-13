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
			<h2><?php esc_html_e( 'Courses and practical resources.', 'holt-holdings' ); ?></h2>
		</div>
		<article class="product-feature">
			<div>
				<span class="card-kicker"><?php esc_html_e( 'Featured Product', 'holt-holdings' ); ?></span>
				<h3><?php esc_html_e( 'Low Volt Crash Course', 'holt-holdings' ); ?></h3>
				<p><?php esc_html_e( 'A standalone beginner-friendly digital education product covering cameras, access control, wiring basics, tools, and practical field knowledge.', 'holt-holdings' ); ?></p>
				<a class="button" href="<?php echo esc_url( holt_holdings_setting( 'course_url', '#' ) ); ?>"><?php esc_html_e( 'View Course', 'holt-holdings' ); ?></a>
			</div>
			<ul class="check-list">
				<li><?php esc_html_e( 'Cameras, access control, and system fundamentals', 'holt-holdings' ); ?></li>
				<li><?php esc_html_e( 'Wiring basics, field tools, and practical learning habits', 'holt-holdings' ); ?></li>
				<li><?php esc_html_e( 'Plain-language lessons for beginners', 'holt-holdings' ); ?></li>
			</ul>
		</article>
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

	<section class="section" id="contact">
		<div class="contact-band">
			<div>
				<span class="eyebrow"><?php esc_html_e( 'Contact', 'holt-holdings' ); ?></span>
				<h2><?php esc_html_e( 'General inquiries, collaboration, product questions, and project opportunities.', 'holt-holdings' ); ?></h2>
				<p><?php esc_html_e( 'Use the contact link for questions related to Holt Holdings, listed ventures, digital products, future tools, partnerships, or project opportunities.', 'holt-holdings' ); ?></p>
			</div>
			<div>
				<a class="button" href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>"><?php esc_html_e( 'Email Austin', 'holt-holdings' ); ?></a>
				<ul class="social-list" id="social">
					<li><a href="<?php echo esc_url( holt_holdings_setting( 'instagram_url', '#' ) ); ?>"><?php esc_html_e( 'Instagram', 'holt-holdings' ); ?></a></li>
					<li><a href="<?php echo esc_url( holt_holdings_setting( 'youtube_url', '#' ) ); ?>"><?php esc_html_e( 'YouTube', 'holt-holdings' ); ?></a></li>
					<li><a href="<?php echo esc_url( holt_holdings_setting( 'linkedin_url', '#' ) ); ?>"><?php esc_html_e( 'LinkedIn', 'holt-holdings' ); ?></a></li>
					<li><a href="<?php echo esc_url( holt_holdings_setting( 'x_url', '#' ) ); ?>"><?php esc_html_e( 'X', 'holt-holdings' ); ?></a></li>
				</ul>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
