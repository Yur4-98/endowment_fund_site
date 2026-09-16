<?php
/**
 * Template Name: Стать дарителем
 *
 * @package efmsun
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Дарителям</p>
		<h1>Стать дарителем фонда</h1>
		<p class="page-lead">Кабинет появится позже: история платежей, квитанции, данные и управление ежемесячным взносом. Сейчас можно сделать разовый вклад без регистрации.</p>
		<p><a class="btn btn-primary" href="<?php echo esc_url( efmsun_donate_url() ); ?>">Сделать вклад</a></p>
	</div>
</section>

<?php
get_footer();
