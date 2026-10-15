<?php
/**
 * Template Name: О фонде
 *
 * @package efmsun
 */

get_header();

$director = get_theme_mod( 'efmsun_director', 'Директор фонда (заглушка)' );
$role     = get_theme_mod( 'efmsun_dir_role', 'Директор' );
$dphone   = get_theme_mod( 'efmsun_dir_phone', '+7 (423) 000-00-00' );
$demail   = get_theme_mod( 'efmsun_dir_email', 'info@efmsun.ru' );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">О фонде</p>
		<h1>Целевой капитал для морского университета</h1>
		<p class="page-lead">Самостоятельное юридическое лицо в форме фонда. Работает по 275-ФЗ, чтобы поддерживать образование, науку и людей МГУ имени адмирала Г.И. Невельского доходом от сохранённого капитала.</p>
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
	</div>
</section>

<section class="section">
	<div class="container card-grid card-grid-3">
		<article class="card card-plain">
			<h2>Миссия</h2>
			<p>Долгосрочная поддержка университета: люди, наука и учебная инфраструктура, а не разовые акции.</p>
		</article>
		<article class="card card-plain">
			<h2>Что такое целевой капитал</h2>
			<p>Пожертвования пополняют капитал. Сам капитал сохраняется, доход направляется на программы фонда.</p>
		</article>
		<article class="card card-plain">
			<h2>Как это работает</h2>
			<p>Доход распределяется по финансовому плану: Управляющий совет утверждает его после согласования Попечительским советом.</p>
		</article>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">История</p>
			<h2>От создания фонда к открытому эндаументу</h2>
		</div>
		<ol class="timeline">
			<li>
				<p class="news-date">2015</p>
				<h3>Создание фонда</h3>
				<p>Фонд целевого капитала университета учреждён. Точные даты и документы появятся после сверки с архивом.</p>
			</li>
			<li>
				<p class="news-date">Далее</p>
				<h3>Органы управления и отчётность</h3>
				<p>Формируются Попечительский и Управляющий советы, публикуются документы и отчёты.</p>
			</li>
			<li>
				<p class="news-date">Сейчас</p>
				<h3>Сайт efmsun.ru</h3>
				<p>Отдельный сайт фонда: пожертвования, FAQ, отчётность и документы вне раздела университета.</p>
			</li>
		</ol>
	</div>
</section>

<section class="section">
	<div class="container split-block">
		<div>
			<p class="eyebrow">Органы управления</p>
			<h2>Кто принимает решения</h2>
			<div class="card-grid">
				<article class="card card-plain">
					<h3>Попечительский совет</h3>
					<p>Согласует направления использования дохода. Состав появится, когда фонд пришлёт список.</p>
				</article>
				<article class="card card-plain">
					<h3>Управляющий совет</h3>
					<p>Утверждает финансовый план расходования дохода от целевого капитала.</p>
				</article>
			</div>
		</div>
		<div class="card card-plain">
			<p class="eyebrow">Директор</p>
			<h2><?php echo esc_html( $director ); ?></h2>
			<p><?php echo esc_html( $role ); ?></p>
			<p>
				<a href="mailto:<?php echo esc_attr( $demail ); ?>"><?php echo esc_html( $demail ); ?></a><br>
				<?php echo esc_html( $dphone ); ?>
			</p>
			<p>Биография и фото заменяются в «Внешний вид → Настроить».</p>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<p class="after-cards">
			<a class="btn btn-primary" href="<?php echo esc_url( efmsun_help_url() ); ?>">Поддержать фонд</a>
			<a class="btn btn-line" href="<?php echo esc_url( efmsun_page_url( 'dokumenty' ) ); ?>">Документы</a>
			<a class="btn btn-line" href="<?php echo esc_url( efmsun_page_url( 'otchetnost' ) ); ?>">Отчётность</a>
			<a class="btn btn-line" href="<?php echo esc_url( efmsun_page_url( 'kontakty' ) ); ?>">Связаться</a>
		</p>
	</div>
</section>

<section class="section">
	<div class="container" style="max-width:640px">
		<?php efmsun_feedback_form( array( 'title' => 'Вопрос о деятельности фонда', 'topic' => 'О фонде' ) ); ?>
	</div>
</section>

<?php
get_footer();
