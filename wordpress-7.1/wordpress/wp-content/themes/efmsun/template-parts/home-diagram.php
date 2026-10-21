<?php
/**
 * Схема механизма целевого капитала (SVG + mobile).
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="diagram">
	<svg class="diagram-desktop" id="routeDiagram" viewBox="0 0 1120 355" role="img" aria-label="Пожертвование пополняет капитал, капитал передаётся в управление, доход направляется на программы. Управление продолжается в следующем периоде.">
		<defs>
			<marker id="arrow" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
				<path d="M0 0L10 5L0 10" fill="#879eab"/>
			</marker>
		</defs>
		<path class="route-line" id="mainRoute" d="M120 105H900"/>
		<path class="return-line" id="returnRoute" d="M900 105C900 290 640 290 640 105" marker-end="url(#arrow)"/>
		<path class="program-branch" id="programBranch" d="M900 105H1030V256" marker-end="url(#arrow)"/>
		<g class="stage-visual active" data-stage="0">
			<text class="stage-title" x="120" y="45" text-anchor="middle">Пожертвование</text>
			<circle class="stage-circle" cx="120" cy="105" r="15"/>
			<text class="stage-number" x="120" y="109" text-anchor="middle">1</text>
			<text class="stage-note" x="120" y="158" text-anchor="middle">Вы поддерживаете фонд</text>
		</g>
		<g class="stage-visual" data-stage="1">
			<text class="stage-title" x="380" y="45" text-anchor="middle">Капитал</text>
			<circle class="stage-circle" cx="380" cy="105" r="15"/>
			<text class="stage-number" x="380" y="109" text-anchor="middle">2</text>
			<text class="stage-note" x="380" y="158" text-anchor="middle">Пожертвование пополняет ЦК</text>
		</g>
		<g class="stage-visual" data-stage="2">
			<text class="stage-title" x="640" y="45" text-anchor="middle">Управление</text>
			<circle class="stage-circle" cx="640" cy="105" r="15"/>
			<text class="stage-number" x="640" y="109" text-anchor="middle">3</text>
			<text class="stage-note" x="640" y="158" text-anchor="middle">Капитал работает</text>
		</g>
		<g class="stage-visual" data-stage="3">
			<text class="stage-title" x="900" y="45" text-anchor="middle">Доход</text>
			<circle class="stage-circle" cx="900" cy="105" r="15"/>
			<text class="stage-number" x="900" y="109" text-anchor="middle">4</text>
			<text class="stage-note" x="900" y="158" text-anchor="middle">Источник поддержки</text>
		</g>
		<circle cx="1030" cy="268" r="9" fill="#235f82"/>
		<text x="1030" y="299" text-anchor="middle" class="stage-title" style="font-size:15px">Программы</text>
		<text x="1030" y="319" text-anchor="middle" class="stage-note">Помощь университету</text>
		<text x="768" y="272" text-anchor="middle" class="stage-note">Основная сумма остаётся в капитале</text>
		<g class="boat" id="routeBoat" transform="translate(101 69)" fill="var(--paper)" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
			<path d="M1 29h38l-7 8H8L1 29ZM20 0v26M17 3L3 24h14V3ZM23 9l13 15H23V9"/>
		</g>
	</svg>
	<div class="diagram-mobile">
		<div class="mobile-steps" id="mobileSteps">
			<svg class="mobile-boat" id="mobileBoat" viewBox="0 0 42 42" fill="var(--paper)" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
				<path d="M1 29h38l-7 8H8L1 29ZM20 0v26M17 3L3 24h14V3ZM23 9l13 15H23V9"/>
			</svg>
			<button class="mobile-step active" type="button" data-stage="0"><strong>1. Пожертвование</strong><span>Вы поддерживаете фонд</span></button>
			<button class="mobile-step" type="button" data-stage="1"><strong>2. Капитал</strong><span>Пожертвование пополняет ЦК</span></button>
			<button class="mobile-step" type="button" data-stage="2"><strong>3. Управление</strong><span>Капитал работает</span></button>
			<button class="mobile-step" type="button" data-stage="3"><strong>4. Доход</strong><span>Источник поддержки</span></button>
		</div>
		<div class="mobile-cycle" aria-hidden="true"></div>
		<p class="mobile-next">↺ Основная сумма капитала продолжает работать</p>
		<div class="mobile-programs">Доход — Программы — Помощь университету</div>
	</div>
	<div class="diagram-footer">
		<p id="stageExplanation" aria-live="polite">Вы перечисляете пожертвование фонду. Деньги предназначены для пополнения целевого капитала и долгосрочной поддержки университета.</p>
		<div class="diagram-controls">
			<button class="btn" type="button" id="playRoute">Посмотреть маршрут</button>
			<label class="motion-label"><input type="checkbox" id="staticMode">Без анимации</label>
		</div>
	</div>
</div>
