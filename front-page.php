<?php
/** Curated company homepage. @package HoltHoldings */
get_header();
$config = holt_holdings_home_config();
?>
<main id="primary" class="site-main">
<section class="hero" id="home"><div class="hero-grid"><div>
<span class="eyebrow">Holt Holdings LLC · Built by Austin Holt</span>
<h1>Practical work.<br>Useful businesses.</h1>
<p>We build businesses and products around problems we understand. Holt Holdings connects hands-on services, field knowledge, and independent projects built by Austin Holt.</p>
<div class="hero-actions"><a class="button" href="<?php echo esc_url( home_url( '/businesses-projects/' ) ); ?>">Explore our projects</a><a class="text-link" href="<?php echo esc_url( $config['links']['lowvolt_vault'] ); ?>" data-track="outbound-link" data-link-category="business" data-link-label="Low Volt Vault hero">Visit Low Volt Vault <span aria-hidden="true">↗</span></a></div>
</div><aside class="venture-index" aria-label="Current ventures"><span class="eyebrow">What we're building</span>
<a href="#low-volt-vault"><strong>Low Volt Vault</strong><span>Live · Technician resource platform</span></a>
<a href="<?php echo esc_url( $config['links']['hands_on'] ); ?>"><strong>Hands On Idaho</strong><span>Local handyman & home improvement</span></a>
<a href="<?php echo esc_url( home_url( '/businesses-projects/' ) ); ?>"><strong>More from Holt Holdings</strong><span>Hauling, tools, and projects in development</span></a>
</aside></div></section>
<section class="section vault-section" id="low-volt-vault"><?php holt_holdings_vault_feature(); ?></section>
<section class="section" id="business-preview"><div class="section-heading"><span class="eyebrow">Beyond the vault</span><h2>Different projects.<br>The same practical approach.</h2><p>Local services, useful tools, and digital resources each have their own purpose.</p></div>
<?php
$other_businesses = array_filter( $config['businesses'], function ( $business ) { return ! in_array( $business['name'], array( 'Low Volt Vault', 'Hands-On Idaho Google Review', 'Wireman' ), true ); } );
holt_holdings_business_cards( $other_businesses );
?>
<p class="section-cta"><a class="text-link" href="<?php echo esc_url( home_url( '/businesses-projects/' ) ); ?>">All businesses & projects <span aria-hidden="true">→</span></a></p></section>
<section class="section" id="explore"><div class="resource-strip"><div><span class="eyebrow">Useful things, in their own place</span><h2>Guides, gear, and resources.</h2><p>Browse individual downloads, tools Austin uses, and merchandise from the brands.</p></div><nav aria-label="Products and resources"><a href="<?php echo esc_url( home_url( '/digital-products/' ) ); ?>">Digital products <span aria-hidden="true">→</span></a><a href="<?php echo esc_url( home_url( '/tools-resources/' ) ); ?>">Tools & resources <span aria-hidden="true">→</span></a><a href="<?php echo esc_url( home_url( '/merch/' ) ); ?>">Merchandise requests <span aria-hidden="true">→</span></a></nav></div></section>
<section class="section founder-section"><span class="eyebrow">The person behind the projects</span><div class="founder-grid"><h2>Built from hands-on experience.</h2><div><p>Austin Holt's work spans low-voltage systems, field troubleshooting, local services, and practical technology. Holt Holdings brings those businesses and projects together.</p><p>The approach is straightforward: solve a real problem, document what works, and keep improving.</p><a class="text-link" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About Austin & Holt Holdings <span aria-hidden="true">→</span></a></div></div></section>
<section class="section"><div class="contact-band"><div><span class="eyebrow">Start a conversation</span><h2>Have a question or a project in mind?</h2><p>Get in touch about Holt Holdings, product support, or a possible collaboration.</p></div><a class="button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Holt Holdings</a></div></section>
</main>
<?php get_footer(); ?>
