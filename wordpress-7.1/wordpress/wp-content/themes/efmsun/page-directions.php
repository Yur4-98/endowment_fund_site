<?php
/**
 * Template Name: Направления финансирования
 *
 * @package efmsun
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Направления</p>
		<h1>На что работает ваш вклад</h1>
		<p class="page-lead">Доход от целевого капитала используется в соответствии с финансовым планом: его утверждает Управляющий совет после согласования Попечительским советом.</p>
	</div>
</section>

<section class="section">
	<div class="container card-grid card-grid-3">
		<article class="card card-plain">
			<h2>Преподаватели-ветераны</h2>
			<p>Забота о тех, кто заложил традиции морского образования.</p>
		</article>
		<article class="card card-plain">
			<h2>Гранты молодым</h2>
			<p>Поддержка аспирантов и молодых преподавателей.</p>
		</article>
		<article class="card card-plain">
			<h2>Инфраструктура</h2>
			<p>Обновление оборудования и учебных условий.</p>
		</article>
	</div>
	<div class="container after-cards">
		<p><a class="btn btn-primary" href="<?php echo esc_url( efmsun_help_url() ); ?>">Поддержать фонд</a>
		<a class="btn btn-line" href="<?php echo esc_url( efmsun_page_url( 'proekty' ) ); ?>">Связанные проекты</a></p>
	</div>
</section>

<?php
get_footer();
