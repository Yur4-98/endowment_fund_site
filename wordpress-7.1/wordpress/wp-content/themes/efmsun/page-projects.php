<?php
/**
 * Template Name: Проекты
 * Направления по ТЗ v2 + карточки проектов из CMS.
 *
 * @package efmsun
 */

get_header();

$directions = array(
	array(
		'id'    => 'veterans',
		'num'   => '01',
		'title' => 'Поддержка преподавателей-ветеранов',
		'desc'  => 'Забота о тех, кто заложил традиции морского образования',
		'body'  => 'В центре этого направления — преподаватели-ветераны университета. Здесь будут условия поддержки, порядок обращения и результаты программы.',
	),
	array(
		'id'    => 'young',
		'num'   => '02',
		'title' => 'Гранты аспирантам и молодым преподавателям',
		'desc'  => 'Поддержка новых поколений исследователей и педагогов',
		'body'  => 'Поддержка аспирантов и молодых преподавателей. Здесь будут положение о грантах, требования к участникам и порядок подачи заявки.',
	),
	array(
		'id'    => 'equipment',
		'num'   => '03',
		'title' => 'Обновление оборудования и учебной инфраструктуры',
		'desc'  => 'Современные условия для качественного образования',
		'body'  => 'Развитие условий для обучения в университете. Здесь будут конкретные задачи, описание оборудования и результаты обновления учебной инфраструктуры.',
	),
);

$query = new WP_Query( array(
	'post_type'      => 'efmsun_project',
	'posts_per_page' => 12,
	'post_status'    => 'publish',
) );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Проекты</p>
		<h1>Куда фонд направляет доход</h1>
		<p class="page-lead">Поддержка людей и развитие учебной среды морского университета. Пожертвование на сайте идёт в общий целевой капитал; на направления распределяется доход от его управления.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">Направления финансирования</p>
			<h2>Три приоритета фонда</h2>
		</div>
		<div class="card-grid card-grid-3">
			<?php foreach ( $directions as $item ) : ?>
				<article class="card card-plain" id="<?php echo esc_attr( $item['id'] ); ?>">
					<p class="eyebrow"><?php echo esc_html( $item['num'] ); ?></p>
					<h2><?php echo esc_html( $item['title'] ); ?></h2>
					<p><?php echo esc_html( $item['desc'] ); ?></p>
					<p><?php echo esc_html( $item['body'] ); ?></p>
					<p>
						<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'kontakty' ) ); ?>">Вопрос о программе</a>
						·
						<a class="text-link" href="<?php echo esc_url( home_url( '/#calculator' ) ); ?>">Рассчитать пример помощи</a>
					</p>
				</article>
			<?php endforeach; ?>
		</div>
		<p class="after-cards">Условные стоимости калькулятора на главной — не бюджеты программ. Условия и результаты дополняются по материалам фонда.</p>
	</div>
</section>

<?php if ( $query->have_posts() ) : ?>
<section class="section">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">Публикации</p>
			<h2>Материалы о направлениях</h2>
		</div>
		<div class="card-grid card-grid-3">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				?>
				<article class="card card-project">
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="card-media is-dark" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'post-thumbnail' ); ?></a>
					<?php else : ?>
						<a class="card-media is-dark" href="<?php the_permalink(); ?>" aria-hidden="true"></a>
					<?php endif; ?>
					<div class="card-body">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						<a class="text-link" href="<?php the_permalink(); ?>">Подробнее</a>
					</div>
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section">
	<div class="container split-block">
		<div>
			<h2>Один капитал. Разные направления помощи.</h2>
			<p>Ваш вклад пополняет капитал, доход от которого помогает поддерживать университет.</p>
		</div>
		<div class="card card-plain">
			<h3>Поддержать работу фонда</h3>
			<p>Выбрать способ пожертвования или задать вопрос о перечислении средств.</p>
			<p>
				<a class="btn btn-primary" href="<?php echo esc_url( efmsun_help_url() ); ?>">Сделать вклад</a>
				<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'otchetnost' ) ); ?>">Отчётность</a>
			</p>
		</div>
	</div>
</section>

<?php
get_footer();
