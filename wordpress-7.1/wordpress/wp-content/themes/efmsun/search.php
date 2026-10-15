<?php
/**
 * Поиск по сайту.
 *
 * @package efmsun
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Поиск</p>
		<h1><?php echo get_search_query() ? 'Результаты: ' . esc_html( get_search_query() ) : 'Поиск по сайту'; ?></h1>
		<form class="search-page-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="field">
				<span>Запрос</span>
				<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" required>
			</label>
			<button class="btn btn-primary" type="submit">Найти</button>
		</form>
	</div>
</section>

<section class="section">
	<div class="container news-archive">
		<?php if ( have_posts() && get_search_query() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article class="report-row">
					<div>
						<p class="news-date"><?php echo esc_html( efmsun_type_label( get_post_type() ) ); ?></p>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
					</div>
					<a class="text-link" href="<?php the_permalink(); ?>">Открыть</a>
				</article>
			<?php endwhile; ?>
			<div class="pagination">
				<?php
				the_posts_pagination( array(
					'prev_text'          => 'Назад',
					'next_text'          => 'Вперёд',
					'screen_reader_text' => 'Страницы',
				) );
				?>
			</div>
		<?php elseif ( get_search_query() ) : ?>
			<p>Ничего не найдено. Попробуйте другой запрос или откройте <a href="<?php echo esc_url( efmsun_page_url( 'faq' ) ); ?>">FAQ</a>.</p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
