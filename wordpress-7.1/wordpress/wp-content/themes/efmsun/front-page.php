<?php
/**
 * Главная по структуре 7 сентября.
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
				<a class="btn btn-primary" href="<?php echo esc_url( efmsun_donate_url() ); ?>">Сделать пожертвование</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( efmsun_page_url( 'stat-daritelem' ) ); ?>">Стать дарителем</a>
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
					<span class="btn btn-line is-disabled">Скачать реквизиты</span>
				<?php endif; ?>
			</div>
		</aside>
	</div>
</section>

<section class="section directions">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">На что работает ваш вклад</p>
			<h2>Направления финансирования</h2>
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'napravleniya' ) ); ?>">Смотреть направления</a>
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

<?php
get_footer();
