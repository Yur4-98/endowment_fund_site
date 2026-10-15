<?php
/**
 * Template Name: Сделать вклад
 *
 * @package efmsun
 */

get_header();

$campaign_id = efmsun_leyka_campaign_id();
$leyka_ready = efmsun_leyka_active() && $campaign_id;
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Пожертвование</p>
		<h1>Сделать вклад в целевой капитал</h1>
		<p class="page-lead">Средства идут в общий капитал фонда, не на отдельный проект. Онлайн-оплата картой через Сбер подключается в Лейке, когда банк выдаст логин и пароль API.</p>
	</div>
</section>

<section class="section">
	<div class="container donate-layout">
		<?php if ( $leyka_ready ) : ?>
			<div class="leyka-form-wrap">
				<?php echo do_shortcode( '[leyka_campaign_form id="' . (int) $campaign_id . '"]' ); ?>
			</div>
		<?php else : ?>
			<form class="donate-form" method="get" action="<?php echo esc_url( efmsun_donate_url() ); ?>">
				<p class="form-note">Плагин Leyka ещё не настроен. Активируйте его и обновите страницу — появится форма пожертвования.</p>
				<button class="btn btn-primary btn-block" type="submit" disabled>Перейти к оплате</button>
			</form>
		<?php endif; ?>

		<aside class="card card-plain">
			<h2>Как это проходит</h2>
			<ol class="steps">
				<li>Выбираете сумму</li>
				<li>Соглашаетесь с офертой и политикой ПД</li>
				<li>Оплачиваете картой Сбера или печатаете банковскую квитанцию</li>
				<li>После зачисления придёт письмо-благодарность</li>
			</ol>
			<p>Карту сайт не собирает: реквизиты вводит Сбер. Квитанцию можно оплатить в любом банке по реквизитам фонда.</p>
			<p>Ежемесячный платёж включится после автоплатежей Сбера и cron на хостинге.</p>
			<p><a class="text-link" href="<?php echo esc_url( efmsun_help_url() ); ?>">Другие способы помочь</a></p>
		</aside>
	</div>
</section>

<?php
get_footer();
