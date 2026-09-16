<?php
/**
 * Template Name: Контакты
 *
 * @package efmsun
 */

get_header();

$email   = get_theme_mod( 'efmsun_email', 'info@efmsun.ru' );
$phone   = get_theme_mod( 'efmsun_phone', '+7 (423) 000-00-00' );
$address = get_theme_mod( 'efmsun_address', 'Владивосток, ул. Верхнепортовая, 50а' );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Контакты</p>
		<h1>Связаться с фондом</h1>
		<p class="page-lead">Телефон, почта и адрес — заглушки. Их можно заменить в «Внешний вид → Настроить».</p>
	</div>
</section>

<section class="section">
	<div class="container contact-grid">
		<div class="card card-plain">
			<p class="footer-label">Почта</p>
			<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
			<p class="footer-label">Телефон</p>
			<p><?php echo esc_html( $phone ); ?></p>
			<p class="footer-label">Адрес</p>
			<p><?php echo esc_html( $address ); ?></p>
		</div>
		<div class="card card-plain">
			<h2>Написать сообщение</h2>
			<p>Форма появится после почты на домене. Пока напишите напрямую на <?php echo esc_html( $email ); ?>.</p>
			<a class="btn btn-primary" href="<?php echo esc_url( efmsun_donate_url() ); ?>">Сделать вклад</a>
		</div>
	</div>
</section>

<?php
get_footer();
