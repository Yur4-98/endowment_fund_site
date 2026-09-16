<?php
/**
 * Одна новость или запись.
 *
 * @package efmsun
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	?>
	<article class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></p>
			<h1><?php the_title(); ?></h1>
		</div>
	</article>
	<section class="section">
		<div class="container prose-page">
			<?php the_content(); ?>
			<p><a class="text-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>">Ко всем новостям</a></p>
		</div>
	</section>
<?php endwhile; ?>

<?php
get_footer();
