<?php
/**
 * Fallback template for posts and archive views.
 *
 * @package HoltHoldings
 */

get_header();
?>
<main id="primary" class="page-shell">
	<?php if ( have_posts() ) : ?>
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header><h1 class="page-title"><?php single_post_title(); ?></h1></header>
		<?php endif; ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</article>
			<?php
		endwhile;
		the_posts_pagination();
		?>
	<?php else : ?>
		<section class="entry-content">
			<h1 class="page-title"><?php esc_html_e( 'Nothing found', 'holt-holdings' ); ?></h1>
			<p><?php esc_html_e( 'There is no content here yet.', 'holt-holdings' ); ?></p>
		</section>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
