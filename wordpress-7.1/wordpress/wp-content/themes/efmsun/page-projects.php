<?php
/**
 * Template Name: Проекты
 *
 * @package efmsun
 */

get_header();

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
		<p class="page-lead">Это витрина программ. Платёж на сайте идёт в общий целевой капитал, а не в отдельный проект.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="card-grid card-grid-3">
			<?php if ( $query->have_posts() ) : ?>
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
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
get_footer();
