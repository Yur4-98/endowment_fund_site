<?php
/**
 * Template Name: Контакты
 *
 * @package efmsun
 */

get_header();

$email   = get_theme_mod( 'efmsun_email', 'info@efmsun.ru' );
$phone   = get_theme_mod( 'efmsun_phone', '+7 (984) 211-45-72' );
$address = get_theme_mod( 'efmsun_address', 'Владивосток, ул. Верхнепортовая, 50а' );
$director = get_theme_mod( 'efmsun_director', 'Директор фонда (заглушка)' );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Контакты</p>
		<h1>Связаться с фондом</h1>
		<p class="page-lead">Телефон, почта и адрес меняются в «Внешний вид → Настроить». Форма сохраняет обращения в админке WordPress.</p>
	</div>
</section>

<section class="section">
	<div class="container contact-grid">
		<div class="card card-plain">
			<p class="footer-label">Почта</p>
			<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
			<p class="footer-label">Телефон</p>
			<p><a href="tel:+79842114572"><?php echo esc_html( $phone ); ?></a></p>
			<p class="footer-label">Адрес</p>
			<p><?php echo esc_html( $address ); ?></p>
			<p class="footer-label">Директор</p>
			<p><?php echo esc_html( $director ); ?></p>
			<p class="form-note">Карта появится, когда фонд подтвердит адрес для публикации.</p>
		</div>
		<div class="card card-plain">
			<?php efmsun_feedback_form( array( 'title' => 'Форма обратной связи', 'topic' => 'Контакты' ) ); ?>
		</div>
	</div>
	<div class="container">
		<?php get_template_part( 'template-parts/section', 'support' ); ?>
	</div>
</section>

<?php
get_footer();
