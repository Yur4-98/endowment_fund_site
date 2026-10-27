<?php
/**
 * Корабль на главной (webp-анимация + PNG fallback).
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$poster = EFMSUN_URI . '/assets/img/ship-poster-mirrored.png';
?>
<div class="ship-area">
	<img id="heroShip" src="<?php echo esc_url( $poster ); ?>" alt="Рисованный парусник, нос направлен влево" width="640" height="475">
	<div class="ship-controls" hidden>
		<span>Морской эскиз</span>
		<button type="button" class="textlink" id="replayShip">Повторить рисунок</button>
	</div>
	<span class="sr-only" id="shipStatus" aria-live="polite"></span>
</div>
