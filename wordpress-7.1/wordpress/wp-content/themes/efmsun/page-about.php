<?php
/**
 * Template Name: О фонде
 * По прототипу разделов v5 (окт 2026).
 *
 * @package efmsun
 */

get_header();

$director_default = 'Андрей Альбертович Конотоп';
$director         = get_theme_mod( 'efmsun_director', $director_default );
if ( $director === '' || $director === 'Директор фонда (заглушка)' ) {
	$director = $director_default;
}
$role = get_theme_mod( 'efmsun_dir_role', 'Директор' );

$board_trustees = array(
	'Перцев Вячеслав Михайлович — председатель',
	'Буров Денис Викторович',
	'Амбросов Евгений Николаевич',
	'Легкий Дмитрий Васильевич',
	'Петин Игорь Геннадьевич',
	'Моисеев Максим Геннадьевич',
);
$board_managing = array(
	'Франк Сергей Оттович — председатель',
	'Гаманов Владимир Федорович',
	'Домнин Александр Валерьевич',
	'Затепякин Сергей Михайлович',
	'Петрусевич Виктор Алексеевич',
	'Письменный Михаил Никитович',
);
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
					<p class="copy">Наша миссия — укреплять Морской государственный университет имени адмирала Г.И. Невельского как место, где сохраняются традиции морского образования, передаются знания и формируются новые поколения профессионалов.</p>
					<p class="copy">Мы создаём долгосрочную финансовую опору для университета, чтобы забота о людях и развитие образования имели постоянный источник поддержки.</p>
					<p class="copy">Каждое пожертвование в целевой капитал — участие в общем деле, которое объединяет поколения выпускников, преподавателей и друзей университета.</p>
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
					<h3>Пожертвование, которое помогает год за годом.</h3>
					<p>Целевой капитал — это источник долгосрочной финансовой поддержки университета. Он складывается из пожертвований выпускников, партнёров и друзей вуза. Собранные средства инвестирует профессиональная управляющая компания, а фонд использует полученный доход для помощи университету.</p>
					<p>Основная сумма пожертвований сохраняется в капитале. Благодаря этому ваше участие даёт основу для регулярной поддержки: доход от управления капиталом помогает фонду финансировать программы из года в год.</p>
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
					<p>Контролирует использование целевого капитала: согласует финансовый план, цели и получателей дохода.</p>
					<p class="governance-note">Утверждён Управляющим советом 24 марта 2020 г. (протокол №&nbsp;3/2020)</p>
					<details class="governance-members">
						<summary>Состав совета</summary>
						<ul class="governance-list">
							<?php foreach ( $board_trustees as $member ) : ?>
								<li><?php echo esc_html( $member ); ?></li>
							<?php endforeach; ?>
						</ul>
					</details>
				</div>
				<div class="panel governance">
					<span class="index">02</span>
					<h3>Управляющий совет</h3>
					<p>Определяет управляющую компанию, утверждает финансовый план и отчётность, назначает директора.</p>
					<p class="governance-note">Утверждён решением Учредителя №&nbsp;4 от 10 ноября 2023 года</p>
					<details class="governance-members">
						<summary>Состав совета</summary>
						<ul class="governance-list">
							<?php foreach ( $board_managing as $member ) : ?>
								<li><?php echo esc_html( $member ); ?></li>
							<?php endforeach; ?>
						</ul>
					</details>
				</div>
				<div class="panel governance">
					<span class="index">03</span>
					<h3><?php echo esc_html( $role ); ?></h3>
					<p><?php echo esc_html( $director ); ?></p>
					<p>Единоличный исполнитель решений советов, осуществляет текущее руководство фондом.</p>
					<p class="governance-note">Избран Управляющим советом 24 марта 2025 г. (протокол №&nbsp;1/2025)</p>
					<p><a class="link" href="<?php echo esc_url( efmsun_page_url( 'kontakty' ) ); ?>">Контакты директора</a></p>
				</div>
			</div>
			<p class="copy" style="margin-top:28px">Целевой капитал с декабря 2016 года находится в доверительном управлении АО «Газпромбанк — Управление активами».</p>
		</section>

		<section class="section">
			<div class="split">
				<div>
					<p class="eyebrow">История фонда</p>
					<h2 style="margin-top:16px">От первых пожертвований —<br>к многолетней поддержке университета</h2>
					<p class="copy">Идея создать постоянный источник поддержки университета обсуждалась не один год. В 2016 году первые пожертвования сформировали целевой капитал, а 23 декабря собранные средства были переданы в доверительное управление компании «Газпромбанк — Управление активами». Так началась история капитала, который работает на университет и его людей.</p>
					<p class="copy">За капиталом стоят люди, которые поддерживают родной вуз. Благотворители фонда входят в Клуб дарителей, а их имена сохраняются в Книге дарителей — как часть истории участия в жизни университета.</p>
					<p class="copy">Сегодня фонд поддерживает молодых преподавателей, помогает ветеранам преподавательского и трудового коллектива, выделяет средства на нужды вуза. В 2026 году на эти цели уже направлено 12,2 млн рублей.</p>
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
