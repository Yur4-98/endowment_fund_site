<?php
/**
 * Главная по прототипу v5 (окт 2026): корабль, 4 направления, калькулятор 27%.
 *
 * @package efmsun
 */

get_header();

$text = get_theme_mod(
	'efmsun_hero_text',
	'Фонд объединяет выпускников, партнёров и друзей университета для устойчивой поддержки образования, науки и инфраструктуры.'
);

$directions = array(
	array(
		'slug'  => 'veterans',
		'title' => 'Поддержка преподавателей-ветеранов',
		'desc'  => 'Забота о тех, кто заложил традиции морского образования',
	),
	array(
		'slug'  => 'young',
		'title' => 'Гранты аспирантам и молодым преподавателям',
		'desc'  => 'Поддержка нового поколения исследователей и педагогов',
	),
	array(
		'slug'  => 'equipment',
		'title' => 'Обновление оборудования и учебной инфраструктуры',
		'desc'  => 'Современные условия для качественного образования',
	),
	array(
		'slug'  => 'scholarship',
		'title' => 'Стипендия курсантам и студентам, обучающимся на отлично',
		'desc'  => 'Признание достижений и поддержка стремления к знаниям',
	),
);

$projects_url = efmsun_page_url( 'proekty' );
$help_url     = efmsun_help_url();
$about_url    = efmsun_page_url( 'o-fonde' );
$reports_url  = efmsun_page_url( 'otchetnost' );
$contacts_url = efmsun_page_url( 'kontakty' );
?>

<div class="proto-home">
<section class="hero" aria-labelledby="heroTitle">
	<div class="wrap">
		<div class="hero-top">
			<span class="eyebrow">Эндаумент-фонд</span>
		</div>
		<div class="hero-grid">
			<div class="hero-copy">
				<div class="hero-title-block">
					<span class="hero-title-logo-wrap" aria-hidden="true">
						<img
							class="hero-title-logo"
							src="<?php echo esc_url( EFMSUN_URI . '/assets/img/logo-hero.png?v=' . EFMSUN_VERSION ); ?>"
							alt=""
							width="140"
							height="140"
							decoding="async"
						>
					</span>
					<h1 class="official-title" id="heroTitle">
						<span class="title-line">Фонд целевого капитала</span>
						<span class="title-line">МГУ имени адмирала</span>
						<span class="title-line">Г.И.&nbsp;Невельского</span>
					</h1>
				</div>
				<p><?php echo esc_html( $text ); ?></p>
				<div class="hero-actions">
					<a class="btn" href="<?php echo esc_url( $help_url ); ?>">Поддержать фонд</a>
					<a class="textlink" href="#mechanism">Как это работает</a>
				</div>
			</div>
			<?php get_template_part( 'template-parts/home', 'ship' ); ?>
		</div>
	</div>
</section>

<section class="programs" id="programs" aria-labelledby="programTitle">
	<div class="wrap">
		<div class="section-head">
			<div>
				<p class="eyebrow">01 / На что работает ваш вклад</p>
				<h2 id="programTitle">Направления финансирования</h2>
			</div>
			<a class="textlink all-directions" href="<?php echo esc_url( $projects_url ); ?>">Все направления</a>
		</div>
		<div class="program-grid" id="programTrack" role="region" aria-label="Направления финансирования" tabindex="0">
			<?php foreach ( $directions as $i => $item ) : ?>
				<article class="program">
					<span class="index"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $item['title'] ); ?></h3>
					<p><?php echo esc_html( $item['desc'] ); ?></p>
					<a class="textlink" href="<?php echo esc_url( $projects_url ); ?>#<?php echo esc_attr( $item['slug'] ); ?>">Подробнее о направлении</a>
				</article>
			<?php endforeach; ?>
		</div>
		<div class="program-navigation">
			<div class="program-rail" aria-hidden="true"><span id="programThumb"></span></div>
			<button class="program-arrow" id="nextProgram" type="button" aria-label="Показать следующее направление"><span aria-hidden="true">⟶</span></button>
		</div>
		<div class="program-note">
			<a class="textlink" href="<?php echo esc_url( $reports_url ); ?>">Результаты поддержки</a>
		</div>
		<p class="section-support">
			<a class="btn" href="<?php echo esc_url( $help_url ); ?>">Поддержать фонд</a>
		</p>
	</div>
</section>

<section class="mechanism" id="mechanism" aria-labelledby="mechanismTitle">
	<div class="wrap">
		<div class="section-head">
			<div>
				<p class="eyebrow">02 / Целевой капитал</p>
				<h2 id="mechanismTitle">Как это работает</h2>
			</div>
			<p class="intro">Пожертвования пополняют целевой капитал фонда. Капитал передаётся в доверительное управление: основная сумма сохраняется и продолжает работать. Часть полученного дохода после предусмотренных расходов направляется на программы университета — поддержку преподавателей, гранты, оборудование и стипендии. Так один вклад помогает не разово, а на годы вперёд.</p>
		</div>
		<?php get_template_part( 'template-parts/home', 'diagram' ); ?>
		<?php get_template_part( 'template-parts/home', 'calculator' ); ?>
		<p class="section-support">
			<a class="btn" href="<?php echo esc_url( $help_url ); ?>">Поддержать фонд</a>
		</p>
	</div>
</section>

<section class="trust" id="trust" aria-labelledby="trustTitle">
	<div class="wrap trust-grid">
		<div>
			<p class="eyebrow">03 / Доверие и участие</p>
			<h2 id="trustTitle">Поддержать фонд.<br>Продолжить историю.</h2>
			<p>Выберите удобный способ участия или свяжитесь с фондом, чтобы обсудить своё пожертвование.</p>
			<a class="btn" href="<?php echo esc_url( $help_url ); ?>">Поддержать фонд</a>
		</div>
		<div class="trust-links">
			<a class="trust-link" href="<?php echo esc_url( $reports_url ); ?>">
				<span><strong>Отчётность</strong><small>Как средства помогают университету</small></span>
			</a>
			<a class="trust-link" href="<?php echo esc_url( $about_url ); ?>">
				<span><strong>О фонде</strong><small>Назначение фонда и его программы</small></span>
			</a>
			<a class="trust-link" href="<?php echo esc_url( $contacts_url ); ?>">
				<span><strong>Связаться с фондом</strong><small>Вопросы и обсуждение участия</small></span>
			</a>
		</div>
	</div>
</section>
</div>

<?php
get_footer();
