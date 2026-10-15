<?php
/**
 * Формы обратной связи, вопроса и подписки.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_handle_feedback() {
	if ( empty( $_POST['efmsun_feedback_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['efmsun_feedback_nonce'] ) ), 'efmsun_feedback' ) ) {
		wp_die( 'Ошибка проверки формы.' );
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
	$topic   = sanitize_text_field( wp_unslash( $_POST['topic'] ?? 'Обращение' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( ! $name || ! $email || ! $message ) {
		wp_safe_redirect( add_query_arg( 'form', 'error', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	wp_insert_post( array(
		'post_type'    => 'efmsun_lead',
		'post_status'  => 'private',
		'post_title'   => $topic . ': ' . $name,
		'post_content' => "Email: {$email}\nТелефон: {$phone}\n\n{$message}",
	) );

	$notify = get_theme_mod( 'efmsun_email', get_option( 'admin_email' ) );
	wp_mail( $notify, 'Обращение с сайта фонда', "{$name} <{$email}>\n{$phone}\n\n{$message}" );

	wp_safe_redirect( add_query_arg( 'form', 'ok', wp_get_referer() ?: home_url( '/' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_efmsun_feedback', 'efmsun_handle_feedback' );
add_action( 'admin_post_efmsun_feedback', 'efmsun_handle_feedback' );

function efmsun_handle_subscribe() {
	if ( empty( $_POST['efmsun_subscribe_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['efmsun_subscribe_nonce'] ) ), 'efmsun_subscribe' ) ) {
		wp_die( 'Ошибка проверки формы.' );
	}

	$email = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	if ( ! $email ) {
		wp_safe_redirect( add_query_arg( 'sub', 'error', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	wp_insert_post( array(
		'post_type'    => 'efmsun_lead',
		'post_status'  => 'private',
		'post_title'   => 'Подписка: ' . $email,
		'post_content' => $email,
	) );

	wp_safe_redirect( add_query_arg( 'sub', 'ok', wp_get_referer() ?: home_url( '/' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_efmsun_subscribe', 'efmsun_handle_subscribe' );
add_action( 'admin_post_efmsun_subscribe', 'efmsun_handle_subscribe' );

function efmsun_form_notice( $query = 'form' ) {
	if ( empty( $_GET[ $query ] ) ) {
		return;
	}
	if ( 'ok' === $_GET[ $query ] ) {
		echo '<p class="form-ok">Сообщение отправлено. Фонд ответит на указанную почту.</p>';
	} elseif ( 'error' === $_GET[ $query ] ) {
		echo '<p class="form-error">Заполните обязательные поля.</p>';
	}
}

function efmsun_feedback_form( $args = array() ) {
	$defaults = array(
		'title'   => 'Написать в фонд',
		'topic'   => 'Обращение',
		'phone'   => true,
		'message' => 'Сообщение',
	);
	$args     = wp_parse_args( $args, $defaults );
	efmsun_form_notice();
	?>
	<form class="feedback-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php if ( $args['title'] ) : ?>
			<h2><?php echo esc_html( $args['title'] ); ?></h2>
		<?php endif; ?>
		<input type="hidden" name="action" value="efmsun_feedback">
		<input type="hidden" name="topic" value="<?php echo esc_attr( $args['topic'] ); ?>">
		<?php wp_nonce_field( 'efmsun_feedback', 'efmsun_feedback_nonce' ); ?>
		<label class="field">
			<span>Имя</span>
			<input type="text" name="name" required>
		</label>
		<label class="field">
			<span>Почта</span>
			<input type="email" name="email" required>
		</label>
		<?php if ( $args['phone'] ) : ?>
			<label class="field">
				<span>Телефон</span>
				<input type="tel" name="phone">
			</label>
		<?php endif; ?>
		<label class="field">
			<span><?php echo esc_html( $args['message'] ); ?></span>
			<textarea name="message" rows="4" required></textarea>
		</label>
		<label class="check">
			<input type="checkbox" required>
			<span>Согласен с <a href="<?php echo esc_url( efmsun_page_url( 'politika-pd' ) ); ?>">политикой обработки ПД</a></span>
		</label>
		<button class="btn btn-primary" type="submit">Отправить</button>
	</form>
	<?php
}

function efmsun_subscribe_form() {
	if ( ! empty( $_GET['sub'] ) && 'ok' === $_GET['sub'] ) {
		echo '<p class="form-ok">Подписка оформлена.</p>';
		return;
	}
	?>
	<form class="subscribe-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="efmsun_subscribe">
		<?php wp_nonce_field( 'efmsun_subscribe', 'efmsun_subscribe_nonce' ); ?>
		<label class="field">
			<span>Почта для новостей фонда</span>
			<input type="email" name="email" required placeholder="you@example.com">
		</label>
		<label class="check">
			<input type="checkbox" required>
			<span>Согласен получать новости и с обработкой ПД</span>
		</label>
		<button class="btn btn-line" type="submit">Подписаться</button>
	</form>
	<?php
}
