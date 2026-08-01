<?php
/** @package HoltHoldings */
get_header();
$email = holt_holdings_contact_email();
?>
<main id="primary" class="site-main inner-page">
	<?php holt_holdings_page_hero( 'Get in Touch', 'Contact', 'Choose the most relevant path for general questions, collaborations, product support, or merchandise requests.' ); ?>
	<section class="section section-first"><div class="contact-paths">
		<article class="hub-card"><span class="card-kicker"><?php esc_html_e( 'General & Collaboration', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'General inquiries and partnerships', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Use email for Holt Holdings questions, collaboration ideas, licensing conversations, or relevant business inquiries.', 'holt-holdings' ); ?></p><a class="button" href="mailto:<?php echo esc_attr( $email ); ?>?subject=<?php echo esc_attr( rawurlencode( 'Holt Holdings inquiry' ) ); ?>"><?php esc_html_e( 'Email Holt Holdings', 'holt-holdings' ); ?></a></article>
		<article class="hub-card"><span class="card-kicker"><?php esc_html_e( 'Digital Products', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Guide and download support', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Include the guide title, purchase platform, and a concise description of the issue so support can respond efficiently.', 'holt-holdings' ); ?></p><a class="button secondary" href="mailto:<?php echo esc_attr( $email ); ?>?subject=<?php echo esc_attr( rawurlencode( 'Digital product support' ) ); ?>"><?php esc_html_e( 'Request Product Support', 'holt-holdings' ); ?></a></article>
		<article class="hub-card"><span class="card-kicker"><?php esc_html_e( 'Merchandise', 'holt-holdings' ); ?></span><h2><?php esc_html_e( 'Merch questions and requests', 'holt-holdings' ); ?></h2><p><?php esc_html_e( 'Use the secure merchandise request form so the request is retained in WordPress even if an email notification fails.', 'holt-holdings' ); ?></p><a class="button secondary" href="<?php echo esc_url( home_url( '/merch/#merch-order' ) ); ?>"><?php esc_html_e( 'Open Merch Request Form', 'holt-holdings' ); ?></a></article>
	</div></section>
	<section class="section"><div class="affiliate-disclosure"><?php esc_html_e( 'For service questions related to a separate operating business, use that business\'s own website and contact details so your message reaches the correct team.', 'holt-holdings' ); ?></div></section>
</main>
<?php get_footer(); ?>
