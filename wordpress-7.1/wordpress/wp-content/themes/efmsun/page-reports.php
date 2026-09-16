<?php
/**
 * Template Name: Отчётность
 *
 * @package efmsun
 */

get_header();

$query = new WP_Query( array(
	'post_type'      => 'efmsun_report',
	'posts_per_page' => 20,
	'post_status'    => 'publish',
) );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Отчётность</p>
		<h1>Документы фонда</h1>
		<p class="page-lead">Список документов уточняется. Сотрудник фонда сможет добавлять PDF в админке WordPress, без правки кода.</p>
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
					?>
					<article class="report-row">
						<div>
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
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
get_footer();
