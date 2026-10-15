<?php
/**
 * Страница 404.
 *
 * @package efmsun
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<h1>Страница не найдена</h1>
		<p class="page-lead">Проверьте адрес, воспользуйтесь поиском или вернитесь на главную.</p>
		<form class="search-page-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="field">
				<span>Поиск</span>
				<input type="search" name="s" required>
			</label>
			<button class="btn btn-primary" type="submit">Найти</button>
		</form>
		<p><a class="btn btn-line" href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a></p>
	</div>
</section>

<?php
get_footer();
