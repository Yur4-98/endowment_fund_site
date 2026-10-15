<?php
/**
 * Главная по ТЗ: герой, цифры, о фонде, направления, проекты, новости, документы, как помочь.
 *
 * @package efmsun
 */

get_header();

$line  = get_theme_mod( 'efmsun_hero_line_1', 'Знания, люди, большие горизонты' );
$lead  = get_theme_mod( 'efmsun_hero_lead', 'Поддержите будущее морского образования' );
$text  = get_theme_mod( 'efmsun_hero_text', 'Фонд целевого капитала МГУ имени адмирала Г.И. Невельского объединяет выпускников, партнёров и друзей университета для устойчивой поддержки образования, науки и инфраструктуры.' );
$quote = get_theme_mod( 'efmsun_quote', 'Больше, чем образование — это люди, которые ведут к новым горизонтам' );
$qr    = get_theme_mod( 'efmsun_qr_image', '' );
$req   = get_theme_mod( 'efmsun_requisites', '' );

$metrics = array(
	array( 'Поступления', get_theme_mod( 'efmsun_metric_in', '—' ) ),
	array( 'Дарители', get_theme_mod( 'efmsun_metric_donors', '—' ) ),
	array( 'Передано университету', get_theme_mod( 'efmsun_metric_uni', '—' ) ),
);

$directions = array(
	array( 'Поддержка преподавателей-ветеранов', 'Забота о тех, кто заложил традиции морского образования' ),
	array( 'Гранты аспирантам и молодым преподавателям', 'Поддержка новых поколений исследователей и педагогов' ),
	array( 'Обновление оборудования и учебной инфраструктуры', 'Современные условия для качественного образования' ),
);

$projects = new WP_Query( array(
	'post_type'      => 'efmsun_project',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
) );

$news = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
) );

$docs = new WP_Query( array(
	'post_type'      => array( 'efmsun_document', 'efmsun_report' ),
	'posts_per_page' => 4,
	'post_status'    => 'publish',
) );
?>

<section class="hero">
	<div class="container hero-grid">
		<div class="hero-copy">
			<p class="eyebrow">Эндаумент-фонд</p>
			<h1>Фонд целевого капитала<br>МГУ имени адмирала Г.И.&nbsp;Невельского</h1>
			<p class="hero-rotator" data-hero-rotator><?php echo esc_html( $line ); ?></p>
			<p class="hero-lead"><?php echo esc_html( $lead ); ?></p>
			<p class="hero-text"><?php echo esc_html( $text ); ?></p>
			<blockquote class="hero-quote"><?php echo esc_html( $quote ); ?></blockquote>
			<div class="hero-actions">
				<a class="btn btn-primary" href="<?php echo esc_url( efmsun_help_url() ); ?>">Поддержать фонд</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( efmsun_page_url( 'o-fonde' ) ); ?>">О фонде</a>
			</div>
		</div>

		<aside class="hero-aside" aria-label="Быстрое пожертвование">
			<div class="qr-card">
				<p class="qr-kicker">Быстрое пожертвование по QR</p>
				<div class="qr-box">
					<?php if ( $qr ) : ?>
						<img src="<?php echo esc_url( $qr ); ?>" alt="QR для перевода">
					<?php else : ?>
						<div class="qr-placeholder">
							<span>QR</span>
							<small>Появится после подключения перевода на мобильном</small>
						</div>
					<?php endif; ?>
				</div>
				<p class="qr-note">На телефоне откроется окно перевода в пользу фонда. Пока это макет.</p>
				<?php if ( $req ) : ?>
					<a class="btn btn-line" href="<?php echo esc_url( $req ); ?>">Скачать реквизиты</a>
				<?php else : ?>
					<a class="btn btn-line" href="<?php echo esc_url( efmsun_help_url() ); ?>">Реквизиты фонда</a>
				<?php endif; ?>
			</div>
		</aside>
	</div>
</section>

<section class="section metrics">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">Показатели фонда</p>
			<h2>Цифры, которые можно править в админке</h2>
			<p class="metric-updated">Актуализация: <?php echo esc_html( get_theme_mod( 'efmsun_metric_updated', 'данные уточняются' ) ); ?></p>
		</div>
		<div class="card-grid card-grid-3">
			<?php foreach ( $metrics as $item ) : ?>
				<article class="card card-plain metric-card">
					<p class="metric-value"><?php echo esc_html( $item[1] ); ?></p>
					<h3><?php echo esc_html( $item[0] ); ?></h3>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section about-teaser">
	<div class="container split-block">
		<div>
			<p class="eyebrow">О фонде</p>
			<h2>Самостоятельный фонд целевого капитала университета</h2>
			<p>Фонд создан, чтобы поддерживать МГУ имени адмирала Г.И. Невельского не разовыми акциями, а доходом от сохранённого капитала. Действует по 275-ФЗ.</p>
			<p><a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'o-fonde' ) ); ?>">Подробнее о фонде</a></p>
		</div>
		<div class="card card-plain">
			<h3>Как это работает</h3>
			<p>Пожертвование пополняет целевой капитал. Капитал сохраняется, доход идёт на образование, науку и людей университета.</p>
		</div>
	</div>
</section>

<section class="section directions">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">На что работает ваш вклад</p>
			<h2>Направления финансирования</h2>
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'napravleniya' ) ); ?>">Все направления</a>
		</div>
		<div class="card-grid card-grid-3">
			<?php foreach ( $directions as $item ) : ?>
				<article class="card card-plain">
					<h3><?php echo esc_html( $item[0] ); ?></h3>
					<p><?php echo esc_html( $item[1] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section projects">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">Актуальные проекты фонда</p>
			<h2>Куда направляется доход</h2>
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'proekty' ) ); ?>">Все проекты</a>
		</div>
		<div class="card-grid card-grid-3">
			<?php if ( $projects->have_posts() ) : ?>
				<?php
				while ( $projects->have_posts() ) :
					$projects->the_post();
					?>
					<article class="card card-project">
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="card-media is-dark" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'post-thumbnail' ); ?></a>
						<?php else : ?>
							<a class="card-media is-dark" href="<?php the_permalink(); ?>" aria-hidden="true"></a>
						<?php endif; ?>
						<div class="card-body">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						</div>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="section news">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">Новости</p>
			<h2>Что происходит в фонде</h2>
			<a class="text-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/novosti/' ) ); ?>">Все новости</a>
		</div>

		<?php if ( $news->have_posts() ) : ?>
			<?php
			$items = $news->posts;
			$first = $items[0];
			$rest  = array_slice( $items, 1 );
			?>
			<div class="news-layout">
				<article class="news-lead">
					<p class="news-date"><?php echo esc_html( get_the_date( 'd.m.Y', $first ) ); ?></p>
					<h3><a href="<?php echo esc_url( get_permalink( $first ) ); ?>"><?php echo esc_html( get_the_title( $first ) ); ?></a></h3>
					<p><?php echo esc_html( get_the_excerpt( $first ) ); ?></p>
					<a class="text-link" href="<?php echo esc_url( get_permalink( $first ) ); ?>">Читать</a>
				</article>
				<div class="news-side">
					<?php foreach ( $rest as $item ) : ?>
						<article class="news-mini">
							<p class="news-date"><?php echo esc_html( get_the_date( 'd.m.Y', $item ) ); ?></p>
							<h3><a href="<?php echo esc_url( get_permalink( $item ) ); ?>"><?php echo esc_html( get_the_title( $item ) ); ?></a></h3>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="section docs-teaser">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">Прозрачность</p>
			<h2>Документы и отчётность</h2>
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'dokumenty' ) ); ?>">Все документы</a>
		</div>
		<div class="report-list">
			<?php if ( $docs->have_posts() ) : ?>
				<?php
				while ( $docs->have_posts() ) :
					$docs->the_post();
					$file = get_post_meta( get_the_ID(), 'efmsun_file_url', true );
					?>
					<article class="report-row">
						<div>
							<p class="news-date"><?php echo esc_html( get_post_meta( get_the_ID(), 'efmsun_doc_type', true ) ?: get_post_type_object( get_post_type() )->labels->singular_name ); ?></p>
							<h3><?php the_title(); ?></h3>
						</div>
						<?php if ( $file ) : ?>
							<a class="btn btn-line" href="<?php echo esc_url( $file ); ?>">Скачать</a>
						<?php else : ?>
							<span class="btn btn-line is-disabled">Файл скоро</span>
						<?php endif; ?>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
		<p class="after-cards">
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'otchetnost' ) ); ?>">Отчёты фонда</a>
		</p>
	</div>
</section>

<section class="section help-teaser">
	<div class="container split-block">
		<div>
			<p class="eyebrow">Как помочь</p>
			<h2>Пожертвование в общий целевой капитал</h2>
			<p>Онлайн-оплата, QR, перевод по реквизитам, договоры для физлиц и юрлиц. Налоговый вычет — по ст. 219 НК РФ.</p>
			<p><a class="btn btn-primary" href="<?php echo esc_url( efmsun_help_url() ); ?>">Как помочь</a></p>
		</div>
		<div class="card card-plain">
			<h3>Новости фонда на почту</h3>
			<?php efmsun_subscribe_form(); ?>
		</div>
	</div>
</section>

<section class="section partners">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">Партнёры</p>
			<h2>Кто уже поддерживает университет</h2>
		</div>
		<p class="page-lead">Логотипы партнёров появятся, когда фонд пришлёт материалы. Пока это место для витрины дарителей.</p>
	</div>
</section>

<section class="section home-contacts">
	<div class="container split-block">
		<div>
			<p class="eyebrow">Контакты</p>
			<h2>Связаться с фондом</h2>
			<p><?php echo esc_html( get_theme_mod( 'efmsun_address', 'Владивосток, ул. Верхнепортовая, 50а' ) ); ?></p>
			<p>
				<a href="mailto:<?php echo esc_attr( get_theme_mod( 'efmsun_email', 'info@efmsun.ru' ) ); ?>"><?php echo esc_html( get_theme_mod( 'efmsun_email', 'info@efmsun.ru' ) ); ?></a><br>
				<?php echo esc_html( get_theme_mod( 'efmsun_phone', '+7 (423) 000-00-00' ) ); ?>
			</p>
			<p><a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'kontakty' ) ); ?>">Все контакты</a></p>
		</div>
		<div class="card card-plain">
			<?php efmsun_feedback_form( array( 'title' => 'Короткий вопрос фонду', 'topic' => 'Вопрос с главной', 'phone' => false ) ); ?>
		</div>
	</div>
</section>

<?php
get_footer();
