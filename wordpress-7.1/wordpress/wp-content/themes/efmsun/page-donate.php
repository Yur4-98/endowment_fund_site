<?php
/**
 * Template Name: Сделать вклад
 *
 * @package efmsun
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Пожертвование</p>
		<h1>Сделать вклад в целевой капитал</h1>
		<p class="page-lead">Средства идут в общий капитал фонда, не на отдельный проект. Оплата картой через Сбер будет подключена после доступов банка.</p>
	</div>
</section>

<section class="section">
	<div class="container donate-layout">
		<form class="donate-form" method="get" action="<?php echo esc_url( efmsun_donate_url() ); ?>">
			<p class="footer-label">Сумма, ₽</p>
			<div class="amount-grid" data-amounts>
				<?php foreach ( array( 500, 1000, 3000, 5000, 10000 ) as $amount ) : ?>
					<button class="amount-btn<?php echo 1000 === $amount ? ' is-active' : ''; ?>" type="button" data-amount="<?php echo esc_attr( (string) $amount ); ?>"><?php echo esc_html( number_format( $amount, 0, '', ' ' ) ); ?> ₽</button>
				<?php endforeach; ?>
			</div>
			<label class="field">
				<span>Своя сумма</span>
				<input type="number" name="amount" min="100" step="100" value="1000" data-amount-input>
			</label>

			<p class="footer-label">Тип пожертвования</p>
			<div class="type-grid">
				<label class="type-btn is-active">
					<input type="radio" name="kind" value="once" checked>
					<span>Разовое</span>
				</label>
				<label class="type-btn is-disabled">
					<input type="radio" name="kind" value="monthly" disabled>
					<span>Ежемесячное</span>
					<small>После подтверждения автоплатежей Сбером</small>
				</label>
			</div>

			<label class="check">
				<input type="checkbox" required>
				<span>Согласен с <a href="<?php echo esc_url( efmsun_page_url( 'oferta' ) ); ?>">офертой</a></span>
			</label>
			<label class="check">
				<input type="checkbox" required>
				<span>Согласен с <a href="<?php echo esc_url( efmsun_page_url( 'politika-pd' ) ); ?>">политикой обработки ПД</a></span>
			</label>

			<button class="btn btn-primary btn-block" type="submit" disabled>Перейти к оплате</button>
			<p class="form-note">Кнопка станет активной, когда подключим эквайринг. Карту сайт не собирает — оплата на стороне Сбера.</p>
		</form>

		<aside class="card card-plain">
			<h2>Как это проходит</h2>
			<ol class="steps">
				<li>Выбираете сумму</li>
				<li>Соглашаетесь с офертой и политикой ПД</li>
				<li>Оплачиваете на странице Сбера</li>
				<li>После зачисления придёт письмо-благодарность</li>
			</ol>
			<p>Личный кабинет можно создать по желанию — платить без регистрации можно.</p>
		</aside>
	</div>
</section>

<?php
get_footer();
