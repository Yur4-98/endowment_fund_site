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
		<p class="page-lead">Проверьте адрес или вернитесь на главную.</p>
		<p><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a></p>
	</div>
</section>

<?php
get_footer();
