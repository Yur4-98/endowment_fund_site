<?php
/**
 * Лента новостей.
 *
 * @package efmsun
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Новости</p>
		<h1><?php echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) ?: 'Новости' ); ?></h1>
	</div>
</section>

<section class="section">
	<div class="container news-archive">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article class="report-row">
					<div>
						<p class="news-date"><?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?></p>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
					</div>
					<a class="text-link" href="<?php the_permalink(); ?>">Читать</a>
				</article>
			<?php endwhile; ?>
			<div class="pagination">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<p>Новостей пока нет.</p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
