<?php
/**
 * Страница проекта.
 *
 * @package efmsun
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	?>
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow">Проект</p>
			<h1><?php the_title(); ?></h1>
			<p class="page-lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
		</div>
	</section>
	<section class="section">
		<div class="container prose-page">
			<?php the_content(); ?>
			<p>
				<a class="btn btn-primary" href="<?php echo esc_url( efmsun_donate_url() ); ?>">Поддержать фонд</a>
				<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'proekty' ) ); ?>">Все проекты</a>
			</p>
		</div>
	</section>
<?php endwhile; ?>

<?php
get_footer();
