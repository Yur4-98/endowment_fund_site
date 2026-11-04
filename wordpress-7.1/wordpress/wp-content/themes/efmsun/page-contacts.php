<?php
/**
 * Template Name: Контакты
 *
 * @package efmsun
 */

get_header();

$email    = get_theme_mod( 'efmsun_email', 'info@efmsun.ru' );
$phone    = get_theme_mod( 'efmsun_phone', '+7 (984) 211-45-72' );
$address  = get_theme_mod( 'efmsun_address', '690003, Приморский край, г. Владивосток, ул. Верхнепортовая, 50-а' );
$director = get_theme_mod( 'efmsun_director', 'Андрей Альбертович Конотоп' );
if ( $director === 'Директор фонда (заглушка)' ) {
	$director = 'Андрей Альбертович Конотоп';
}
if ( in_array( $email, array( 'konotop@msun.ru', '' ), true ) ) {
	$email = 'info@efmsun.ru';
}
if ( in_array( $phone, array( '+7 (423) 230-10-26', '' ), true ) ) {
	$phone = '+7 (984) 211-45-72';
}
$phone_tel = preg_replace( '/\D+/', '', $phone );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Контакты</p>
		<h1>Связаться с фондом</h1>
		<p class="page-lead">Официальные контакты фонда. Форма сохраняет обращения в админке WordPress.</p>
	</div>
</section>

<section class="section">
	<div class="container contact-grid">
		<div class="card card-plain">
			<p class="footer-label">Почта</p>
			<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
			<p class="footer-label">Телефон</p>
			<p><a href="tel:+<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone ); ?></a></p>
			<p class="footer-label">Адрес</p>
			<p><?php echo esc_html( $address ); ?>, УК-1, каб.&nbsp;232</p>
			<p class="footer-label">Директор</p>
			<p><?php echo esc_html( $director ); ?></p>
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
