<?php
/**
 * Template Name: О фонде
 *
 * @package efmsun
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">О фонде</p>
		<h1>Целевой капитал для морского университета</h1>
		<p class="page-lead">Фонд создан, чтобы поддерживать образование, науку и людей МГУ имени адмирала Г.И. Невельского не разовыми акциями, а доходом от сохранённого капитала.</p>
	</div>
</section>

<section class="section">
	<div class="container prose-page">
		<?php
		while ( have_posts() ) :
			the_post();
			if ( get_the_content() ) {
				the_content();
			}
		endwhile;
		?>
		<div class="card-grid card-grid-3">
			<article class="card card-plain">
				<h2>Как это работает</h2>
				<p>Пожертвования пополняют целевой капитал. Сам капитал сохраняется, а доход направляется на программы фонда.</p>
			</article>
			<article class="card card-plain">
				<h2>Кто может помочь</h2>
				<p>Выпускники, партнёры, сотрудники университета и все, кому важно морское образование в России.</p>
			</article>
			<article class="card card-plain">
				<h2>Прозрачность</h2>
				<p>Отчёты и документы публикуются в разделе «Отчётность». Состав документов уточняется с фондом.</p>
			</article>
		</div>
		<p class="after-cards">
			<a class="btn btn-primary" href="<?php echo esc_url( efmsun_donate_url() ); ?>">Сделать вклад</a>
		</p>
	</div>
</section>

<?php
get_footer();
