<?php
/**
 * Обычная страница.
 *
 * @package efmsun
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<h1><?php the_title(); ?></h1>
		<?php endwhile; ?>
	</div>
</section>

<section class="section">
	<div class="container prose-page">
		<?php
		rewind_posts();
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</section>

<?php
get_footer();
