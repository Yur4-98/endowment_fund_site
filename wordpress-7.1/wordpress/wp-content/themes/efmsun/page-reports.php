<?php
/**
 * Template Name: Отчётность
 *
 * @package efmsun
 */

get_header();

$query = new WP_Query( array(
	'post_type'      => 'efmsun_report',
	'posts_per_page' => 50,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
) );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Отчётность</p>
		<h1>Отчёты фонда</h1>
		<p class="page-lead">Годовые и финансовые отчёты. Устав и положения — в разделе «Документы». Сотрудник фонда добавляет PDF в админке, без правки кода.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="report-list">
			<?php if ( $query->have_posts() ) : ?>
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$file = get_post_meta( get_the_ID(), 'efmsun_file_url', true );
					$year = get_post_meta( get_the_ID(), 'efmsun_year', true );
					$type = get_post_meta( get_the_ID(), 'efmsun_doc_type', true );
					?>
					<article class="report-row">
						<div>
							<p class="news-date"><?php echo esc_html( trim( $year . ' ' . $type ) ); ?></p>
							<h2><?php the_title(); ?></h2>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						</div>
						<?php if ( $file ) : ?>
							<a class="btn btn-line" href="<?php echo esc_url( $file ); ?>">Скачать PDF</a>
						<?php else : ?>
							<span class="btn btn-line is-disabled">Файл скоро</span>
						<?php endif; ?>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p>Отчёты появятся после загрузки файлов.</p>
			<?php endif; ?>
		</div>
		<p class="after-cards">
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'dokumenty' ) ); ?>">Официальные документы</a>
		</p>
	</div>
</section>

<?php
get_footer();
