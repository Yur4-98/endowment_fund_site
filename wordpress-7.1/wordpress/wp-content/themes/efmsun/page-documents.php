<?php
/**
 * Template Name: Официальные документы
 *
 * @package efmsun
 */

get_header();

$bundled = array(
	array(
		'title' => 'Устав Фонда целевого капитала',
		'note'  => 'ФЦК МГУ им. адм. Г.И. Невельского',
		'type'  => 'Устав',
		'url'   => EFMSUN_URI . '/assets/docs/ustav.pdf',
	),
	array(
		'title' => 'Свидетельство о государственной регистрации',
		'note'  => 'Дата выдачи: 2 ноября 2015 года',
		'type'  => 'Регистрация',
		'url'   => EFMSUN_URI . '/assets/docs/svidetelstvo-gos-registracii.pdf',
	),
	array(
		'title' => 'Федеральный закон № 275-ФЗ',
		'note'  => 'О порядке формирования и использования целевого капитала некоммерческих организаций',
		'type'  => 'Закон',
		'url'   => 'https://www.consultant.ru/document/cons_doc_LAW_64939/',
	),
	array(
		'title' => 'Договор пожертвования',
		'note'  => 'Шаблон договора (DOCX)',
		'type'  => 'Для пожертвования',
		'url'   => EFMSUN_URI . '/assets/docs/dogovor-pozhertvovaniya.docx',
	),
);

$query = new WP_Query( array(
	'post_type'      => 'efmsun_document',
	'posts_per_page' => 50,
	'post_status'    => 'publish',
	'orderby'        => 'title',
	'order'          => 'ASC',
) );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Документы</p>
		<h1>Официальная информация фонда</h1>
		<p class="page-lead">Устав, регистрационные документы и положения органов управления. Годовые отчёты — в отдельном разделе «Отчётность».</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="report-list">
			<?php foreach ( $bundled as $item ) : ?>
				<article class="report-row">
					<div>
						<p class="news-date"><?php echo esc_html( $item['type'] ); ?></p>
						<h2><?php echo esc_html( $item['title'] ); ?></h2>
						<p><?php echo esc_html( $item['note'] ); ?></p>
					</div>
					<a class="btn btn-line" href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener noreferrer">Открыть</a>
				</article>
			<?php endforeach; ?>

			<?php if ( $query->have_posts() ) : ?>
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$title = get_the_title();
					if ( false !== mb_stripos( $title, 'заглушка' ) ) {
						continue;
					}
					$file = get_post_meta( get_the_ID(), 'efmsun_file_url', true );
					$type = get_post_meta( get_the_ID(), 'efmsun_doc_type', true );
					if ( ! $file ) {
						continue;
					}
					?>
					<article class="report-row">
						<div>
							<?php if ( $type ) : ?>
								<p class="news-date"><?php echo esc_html( $type ); ?></p>
							<?php endif; ?>
							<h2><?php echo esc_html( $title ); ?></h2>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						</div>
						<a class="btn btn-line" href="<?php echo esc_url( $file ); ?>" target="_blank" rel="noopener noreferrer">Открыть</a>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
		<p class="after-cards">
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'otchetnost' ) ); ?>">Перейти к отчётности</a>
			·
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'oferta' ) ); ?>">Договор пожертвования на сайте</a>
		</p>
		<?php get_template_part( 'template-parts/section', 'support' ); ?>
	</div>
</section>

<?php
get_footer();
