<?php
/**
 * Template Name: Как помочь
 *
 * @package efmsun
 */

get_header();

$qr_url = get_theme_mod( 'efmsun_qr_image', '' );
if ( ! $qr_url ) {
	$qr_url = EFMSUN_URI . '/assets/img/qr-payment.jpg';
}

$methods = array(
	array( 'Онлайн на сайте', 'Форма Лейки: карта через Сбер (после ключей API) или банковская квитанция.', true, efmsun_donate_url() ),
	array( 'QR-код', 'Отсканируйте код приложением банка и переведите пожертвование.', true, '#payment-qr' ),
	array( 'Сбербанк Онлайн', 'Перевод по реквизитам фонда в приложении банка.', true, '' ),
	array( 'Банкомат Сбера', 'Пополнение по реквизитам через банкомат.', true, '' ),
	array( 'Операционист', 'Перевод в отделении банка по реквизитам.', true, '' ),
	array( 'Банковский перевод', 'Для физлиц и юрлиц. Реквизиты можно скопировать ниже.', true, '' ),
);

$inn  = get_theme_mod( 'efmsun_inn', '' );
$kpp  = get_theme_mod( 'efmsun_kpp', '' );
$ogrn = get_theme_mod( 'efmsun_ogrn', '' );
$rs   = get_theme_mod( 'efmsun_rs', '' );
$ks   = get_theme_mod( 'efmsun_ks', '' );
$bik  = get_theme_mod( 'efmsun_bik', '' );
$bank = get_theme_mod( 'efmsun_bank', 'ПАО Сбербанк' );
$name = get_theme_mod( 'efmsun_legal_name', 'Фонд целевого капитала МГУ имени адмирала Г.И. Невельского' );
$addr = get_theme_mod( 'efmsun_address', 'Владивосток, ул. Верхнепортовая, 50а' );

$copy_block = implode( "\n", array_filter( array(
	$name,
	$addr,
	$ogrn ? 'ОГРН ' . $ogrn : '',
	$inn ? 'ИНН ' . $inn : '',
	$kpp ? 'КПП ' . $kpp : '',
	$bank,
	$bik ? 'БИК ' . $bik : '',
	$rs ? 'р/с ' . $rs : '',
	$ks ? 'к/с ' . $ks : '',
) ) );

$faq = new WP_Query( array(
	'post_type'      => 'efmsun_faq',
	'posts_per_page' => 8,
	'post_status'    => 'publish',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'meta_query'     => array(
		array(
			'key'   => 'efmsun_show_on_donate',
			'value' => '1',
		),
	),
) );
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">Как помочь</p>
		<h1>Поддержать целевой капитал университета</h1>
		<p class="page-lead">Средства идут в общий капитал фонда, не на отдельный проект. Доход от капитала поддерживает образование, науку и людей МГУ имени адмирала Г.И. Невельского.</p>
		<p><a class="btn btn-primary" href="<?php echo esc_url( efmsun_donate_url() ); ?>">Поддержать фонд</a></p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">Способы</p>
			<h2>Как передать пожертвование</h2>
		</div>
		<div class="card-grid card-grid-3">
			<?php foreach ( $methods as $item ) : ?>
				<article class="card card-plain">
					<h3><?php echo esc_html( $item[0] ); ?></h3>
					<p><?php echo esc_html( $item[1] ); ?></p>
					<?php if ( $item[3] ) : ?>
						<p><a class="text-link" href="<?php echo esc_url( $item[3] ); ?>">Перейти</a></p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section" id="payment-qr">
	<div class="container split-block">
		<div>
			<p class="eyebrow">QR для оплаты</p>
			<h2>Перевод со смартфона</h2>
			<p>Откройте приложение банка, отсканируйте код и подтвердите перевод. Перед оплатой сверьте наименование получателя с реквизитами ниже.</p>
			<p><a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'oferta' ) ); ?>">Договор пожертвования</a></p>
		</div>
		<figure class="card card-plain qr-card">
			<img
				src="<?php echo esc_url( $qr_url ); ?>"
				alt="QR-код для пожертвования в фонд"
				width="360"
				height="360"
				loading="lazy"
				decoding="async"
			>
		</figure>
	</div>
</section>

<section class="section">
	<div class="container split-block">
		<div>
			<p class="eyebrow">Реквизиты</p>
			<h2>Для банковского перевода</h2>
			<dl class="requisites">
				<dt>Наименование</dt>
				<dd><?php echo esc_html( $name ); ?></dd>
				<dt>Адрес</dt>
				<dd><?php echo esc_html( $addr ); ?></dd>
				<dt>ОГРН</dt>
				<dd><?php echo esc_html( $ogrn ?: 'уточняется' ); ?></dd>
				<dt>ИНН</dt>
				<dd>
					<?php echo esc_html( $inn ?: 'уточняется' ); ?>
					<?php if ( $inn ) : ?>
						<button class="copy-btn" type="button" data-copy="<?php echo esc_attr( $inn ); ?>" data-label="Копировать ИНН">Копировать ИНН</button>
					<?php endif; ?>
				</dd>
				<dt>КПП</dt>
				<dd><?php echo esc_html( $kpp ?: 'уточняется' ); ?></dd>
				<dt>Банк</dt>
				<dd><?php echo esc_html( $bank ); ?></dd>
				<dt>БИК</dt>
				<dd><?php echo esc_html( $bik ?: 'уточняется' ); ?></dd>
				<dt>Расчётный счёт</dt>
				<dd><?php echo esc_html( $rs ?: 'уточняется' ); ?></dd>
				<dt>Корр. счёт</dt>
				<dd><?php echo esc_html( $ks ?: 'уточняется' ); ?></dd>
			</dl>
			<p>
				<button class="btn btn-line" type="button" data-copy="<?php echo esc_attr( $copy_block ); ?>" data-label="Скопировать реквизиты">Скопировать реквизиты</button>
			</p>
			<p class="form-note">Пустые поля заполняются в «Внешний вид → Настроить → Реквизиты и директор».</p>
		</div>
		<aside class="card card-plain">
			<h2>Договоры</h2>
			<p>Шаблон договора пожертвования на пополнение целевого капитала.</p>
			<p>
				<a class="btn btn-line" href="<?php echo esc_url( EFMSUN_URI . '/assets/docs/dogovor-pozhertvovaniya.docx' ); ?>" download>Скачать договор (DOCX)</a>
			</p>
			<p><a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'oferta' ) ); ?>">Читать на сайте</a></p>
			<h2>Налоговый вычет</h2>
			<p>Пожертвование в фонд целевого капитала может дать право на социальный налоговый вычет по статье 219 НК РФ.</p>
			<p><a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'faq' ) ); ?>">Подробнее в FAQ</a></p>
		</aside>
	</div>
</section>

<?php if ( $faq->have_posts() ) : ?>
<section class="section">
	<div class="container">
		<div class="section-head">
			<p class="eyebrow">FAQ</p>
			<h2>Частые вопросы о пожертвованиях</h2>
			<a class="text-link" href="<?php echo esc_url( efmsun_page_url( 'faq' ) ); ?>">Все вопросы</a>
		</div>
		<div class="faq-list">
			<?php
			while ( $faq->have_posts() ) :
				$faq->the_post();
				?>
				<details class="faq-item">
					<summary><?php the_title(); ?></summary>
					<div><?php the_content(); ?></div>
				</details>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section">
	<div class="container split-block">
		<div class="card card-plain">
			<?php efmsun_feedback_form( array( 'title' => 'Задать вопрос о пожертвовании', 'topic' => 'Пожертвование' ) ); ?>
		</div>
		<div>
			<p class="eyebrow">Юридически</p>
			<h2>Документы, с которыми нужно согласиться</h2>
			<p><a href="<?php echo esc_url( efmsun_page_url( 'oferta' ) ); ?>">Публичная оферта</a></p>
			<p><a href="<?php echo esc_url( efmsun_page_url( 'politika-pozhertvovaniy' ) ); ?>">Политика обработки пожертвований</a></p>
			<p><a href="<?php echo esc_url( efmsun_page_url( 'politika-pd' ) ); ?>">Политика обработки персональных данных</a></p>
		</div>
	</div>
	<div class="container">
		<?php get_template_part( 'template-parts/section', 'support' ); ?>
	</div>
</section>

<?php
get_footer();
