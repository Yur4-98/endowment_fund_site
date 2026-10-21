<?php
/**
 * Template Name: О фонде
 * По прототипу разделов v5 (окт 2026).
 *
 * @package efmsun
 */

get_header();

$director = get_theme_mod( 'efmsun_director', '' );
$role     = get_theme_mod( 'efmsun_dir_role', 'Директор' );
$dphone   = get_theme_mod( 'efmsun_dir_phone', '' );
$demail   = get_theme_mod( 'efmsun_dir_email', 'info@efmsun.ru' );
?>

<div class="proto-sections about-page">
	<div class="wrap">
		<div class="breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Главная</a>
			<span aria-hidden="true">/</span>
			<span>О фонде</span>
		</div>

		<div class="page-hero">
			<p class="eyebrow">О фонде</p>
			<span class="page-index" aria-hidden="true">01</span>
			<h1 tabindex="-1">Целевой капитал для морского университета</h1>
			<p class="lead">Фонд целевого капитала МГУ имени адмирала Г.И. Невельского создан для долгосрочной поддержки образования, науки и людей университета.</p>
			<div class="actions">
				<a class="btn" href="<?php echo esc_url( efmsun_page_url( 'proekty' ) ); ?>">Направления финансирования</a>
				<a class="link" href="<?php echo esc_url( efmsun_page_url( 'dokumenty' ) ); ?>">Документы фонда</a>
			</div>
		</div>

		<section class="section">
			<div class="split">
				<div>
					<p class="eyebrow">Миссия</p>
					<h2 style="margin-top:16px">Помогать сегодня.<br>Создавать опору на годы.</h2>
					<p class="copy">Поддержка преподавателей-ветеранов, гранты аспирантам и молодым преподавателям, обновление оборудования и учебной инфраструктуры, стипендии курсантам и студентам, обучающимся на отлично — четыре направления финансирования фонда.</p>
					<?php
					while ( have_posts() ) :
						the_post();
						if ( get_the_content() ) {
							echo '<div class="copy prose-page" style="margin-top:18px">';
							the_content();
							echo '</div>';
						}
					endwhile;
					?>
				</div>
				<div class="callout">
					<p class="eyebrow" style="margin:0 0 15px">Что такое целевой капитал</p>
					<h3>Пожертвование становится частью общего капитала.</h3>
					<p>Капитал передаётся в управление. Доход от его управления направляется на программы поддержки университета. Пожертвование и доход выполняют разные задачи.</p>
					<a class="link" href="<?php echo esc_url( home_url( '/#mechanism' ) ); ?>">Посмотреть, как это работает</a>
				</div>
			</div>
		</section>

		<section class="section">
			<div class="section-title">
				<h2>Кто принимает решения</h2>
				<a class="link" href="<?php echo esc_url( efmsun_page_url( 'dokumenty' ) ); ?>">Устав и положения</a>
			</div>
			<div class="grid3">
				<div class="panel governance">
					<span class="index">01</span>
					<h3>Попечительский совет</h3>
				</div>
				<div class="panel governance">
					<span class="index">02</span>
					<h3>Управляющий совет</h3>
				</div>
				<div class="panel governance">
					<span class="index">03</span>
					<h3><?php echo $director ? esc_html( $role ) : 'Директор'; ?></h3>
					<?php if ( $director ) : ?>
						<p><?php echo esc_html( $director ); ?></p>
						<p>
							<?php if ( $demail ) : ?>
								<a href="mailto:<?php echo esc_attr( $demail ); ?>"><?php echo esc_html( $demail ); ?></a>
							<?php endif; ?>
							<?php if ( $dphone ) : ?>
								<br><?php echo esc_html( $dphone ); ?>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="section">
			<div class="split">
				<div>
					<p class="eyebrow">История фонда</p>
					<h2 style="margin-top:16px">От создания фонда<br>к открытому эндаументу</h2>
					<p class="copy">Здесь будет короткая хронология: основание фонда, первые программы поддержки и развитие целевого капитала.</p>
					<p class="prototype-note" style="border:0">Для этой части нужны подтверждённые даты и события. Дату основания из исходной заглушки не переносили.</p>
				</div>
				<div class="callout">
					<h3>Есть вопрос о фонде?</h3>
					<p>О деятельности, документах или участии в программах — выберите тему обращения, чтобы задать вопрос.</p>
					<a class="btn ghost" href="<?php echo esc_url( efmsun_page_url( 'kontakty' ) ); ?>">Связаться с фондом</a>
				</div>
			</div>
		</section>

		<section class="section">
			<div class="actions">
				<a class="btn" href="<?php echo esc_url( efmsun_help_url() ); ?>">Поддержать фонд</a>
				<a class="btn ghost" href="<?php echo esc_url( efmsun_page_url( 'otchetnost' ) ); ?>">Отчётность</a>
				<a class="link" href="<?php echo esc_url( efmsun_page_url( 'dokumenty' ) ); ?>">Документы</a>
			</div>
		</section>
	</div>
</div>

<?php
get_footer();
