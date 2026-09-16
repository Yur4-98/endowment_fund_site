<?php
/**
 * Фиксированная волна на всех страницах.
 *
 * @package efmsun
 */
?>
<div class="marine-waves" aria-hidden="true">
	<img
		class="marine-waves__layer marine-waves__layer--back"
		src="<?php echo esc_url( EFMSUN_URI . '/assets/img/wave-back.png' ); ?>"
		alt=""
		width="1983"
		height="793"
		decoding="async"
	>
	<img
		class="marine-waves__layer marine-waves__layer--front"
		src="<?php echo esc_url( EFMSUN_URI . '/assets/img/wave-front.png' ); ?>"
		alt=""
		width="2172"
		height="724"
		decoding="async"
	>
</div>
