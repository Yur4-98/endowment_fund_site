<?php
/**
 * Template Name: Оферта / договор пожертвования
 *
 * @package efmsun
 */

get_header();

$content = include EFMSUN_DIR . '/inc/content-oferta.php';
$docx    = EFMSUN_URI . '/assets/docs/dogovor-pozhertvovaniya.docx';
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Документы</p>
		<h1>Договор пожертвования</h1>
		<p class="page-lead">Текст договора о пожертвовании на пополнение целевого капитала фонда.</p>
		<p>
			<a class="btn btn-line" href="<?php echo esc_url( $docx ); ?>" download>Скачать DOCX</a>
		</p>
	</div>
</section>

<section class="section">
	<div class="container prose-page oferta-text">
		<?php
		if ( is_string( $content ) && $content ) {
			echo wp_kses_post( $content );
		} else {
			while ( have_posts() ) {
				the_post();
				the_content();
			}
		}
		?>
	</div>
	<div class="container">
		<?php get_template_part( 'template-parts/section', 'support' ); ?>
	</div>
</section>

<?php
get_footer();
