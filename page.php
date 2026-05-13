<?php
/**
 * Standard page template.
 *
 * @package HoltHoldings
 */

get_header();
?>
<main id="primary" class="page-shell">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="page-intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</header>
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'holt-holdings' ),
					'after'  => '</div>',
				) );
				?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php get_footer(); ?>
