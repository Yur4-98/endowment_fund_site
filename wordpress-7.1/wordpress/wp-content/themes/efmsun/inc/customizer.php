<?php
/**
 * Поля, которые фонд меняет без правки кода.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'efmsun_hero', array(
		'title'    => 'Главная и тексты',
		'priority' => 30,
	) );
	$wp_customize->add_section( 'efmsun_metrics', array(
		'title'    => 'Показатели фонда',
		'priority' => 31,
	) );
	$wp_customize->add_section( 'efmsun_requisites', array(
		'title'    => 'Реквизиты и директор',
		'priority' => 32,
	) );

	$fields = array(
		'efmsun_hero'        => array(
			'efmsun_hero_line_1' => array( 'Строка 1', 'Знания, люди, большие горизонты', 'text' ),
			'efmsun_hero_line_2' => array( 'Строка 2', 'Традиции, знания, развитие для морского будущего России', 'text' ),
			'efmsun_hero_line_3' => array( 'Строка 3', 'Малые вклады создают большие возможности', 'text' ),
			'efmsun_hero_lead'   => array( 'Подзаголовок', 'Поддержите будущее морского образования', 'text' ),
			'efmsun_hero_text'   => array( 'Кратко о фонде', 'Фонд объединяет выпускников, партнёров и друзей университета для устойчивой поддержки образования, науки и инфраструктуры.', 'textarea' ),
			'efmsun_quote'       => array( 'Крупная цитата', 'Больше, чем образование — это люди, которые ведут к новым горизонтам', 'textarea' ),
			'efmsun_qr_image'    => array( 'Ссылка на картинку QR', '', 'text' ),
			'efmsun_requisites'  => array( 'Ссылка на файл реквизитов', '', 'text' ),
		),
		'efmsun_metrics'     => array(
			'efmsun_metric_in'      => array( 'Сумма поступлений', '—', 'text' ),
			'efmsun_metric_donors'  => array( 'Число дарителей', '—', 'text' ),
			'efmsun_metric_uni'     => array( 'Передано университету', '—', 'text' ),
			'efmsun_metric_updated' => array( 'Дата актуализации', 'данные уточняются', 'text' ),
		),
		'efmsun_requisites'  => array(
			'efmsun_legal_name' => array( 'Полное наименование', 'Фонд целевого капитала МГУ имени адмирала Г.И. Невельского', 'text' ),
			'efmsun_ogrn'       => array( 'ОГРН', '', 'text' ),
			'efmsun_inn'        => array( 'ИНН', '', 'text' ),
			'efmsun_kpp'        => array( 'КПП', '', 'text' ),
			'efmsun_bank'       => array( 'Банк', 'ПАО Сбербанк', 'text' ),
			'efmsun_bik'        => array( 'БИК', '', 'text' ),
			'efmsun_rs'         => array( 'Расчётный счёт', '', 'text' ),
			'efmsun_ks'         => array( 'Корр. счёт', '', 'text' ),
			'efmsun_phone'      => array( 'Телефон', '+7 (984) 211-45-72', 'text' ),
			'efmsun_email'      => array( 'Почта', 'info@efmsun.ru', 'text' ),
			'efmsun_address'    => array( 'Адрес', 'Владивосток, ул. Верхнепортовая, 50а', 'text' ),
			'efmsun_director'   => array( 'Директор (ФИО)', 'Директор фонда (заглушка)', 'text' ),
			'efmsun_dir_role'   => array( 'Должность', 'Директор', 'text' ),
			'efmsun_dir_phone'  => array( 'Телефон директора', '+7 (984) 211-45-72', 'text' ),
			'efmsun_dir_email'  => array( 'Почта директора', 'info@efmsun.ru', 'text' ),
		),
	);

	foreach ( $fields as $section => $items ) {
		foreach ( $items as $id => $item ) {
			$wp_customize->add_setting( $id, array(
				'default'           => $item[1],
				'sanitize_callback' => 'wp_kses_post',
			) );
			$wp_customize->add_control( $id, array(
				'label'   => $item[0],
				'section' => $section,
				'type'    => $item[2],
			) );
		}
	}
}
add_action( 'customize_register', 'efmsun_customize_register' );
