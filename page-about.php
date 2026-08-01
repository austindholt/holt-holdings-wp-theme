<?php
/** @package HoltHoldings */
get_header();
$config = holt_holdings_home_config();
?>
<main id="primary" class="site-main inner-page">
	<?php holt_holdings_page_hero( 'Austin Holt & Holt Holdings', 'About', 'A practical portfolio connecting hands-on businesses, field knowledge, useful products, inventions, and public content.' ); ?>
	<section class="section section-first"><div class="story-grid"><article class="entry-content"><h2><?php esc_html_e( 'Built from hands-on work', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Austin Holt\'s background spans low-voltage systems, field troubleshooting, local service businesses, practical technology, and building resources from real working notes.', 'holt-holdings' ); ?></p><p><?php esc_html_e( 'Holt Holdings provides a clear home for that ecosystem. It connects independent businesses and projects without pretending they are all the same company or service.', 'holt-holdings' ); ?></p></article><article class="entry-content"><h2><?php esc_html_e( 'A useful-work mindset', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'The common thread is practical usefulness: solve a real problem, document what works, communicate honestly about what is finished, and keep improving what is still in progress.', 'holt-holdings' ); ?></p><p><a class="button secondary" href="<?php echo esc_url( home_url( '/businesses-projects/' ) ); ?>"><?php esc_html_e( 'Explore the Portfolio', 'holt-holdings' ); ?></a></p></article></div></section>
	<section class="section"><div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Follow Along', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'See the work as it develops.', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'These are the official public social destinations currently connected to Austin Holt and Holt Holdings.', 'holt-holdings' ); ?></p></div><?php holt_holdings_social_links( $config['social_links'] ); ?></section>
</main>
<?php get_footer(); ?>
