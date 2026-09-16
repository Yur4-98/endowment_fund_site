<?php
/**
 * Кнопка вклада — всегда справа снизу.
 *
 * @package efmsun
 */

if ( is_page( 'sdelat-vklad' ) ) {
	return;
}
?>
<a class="donate-float" href="<?php echo esc_url( efmsun_donate_url() ); ?>">
	<span class="donate-float-label">Сделать вклад</span>
</a>
