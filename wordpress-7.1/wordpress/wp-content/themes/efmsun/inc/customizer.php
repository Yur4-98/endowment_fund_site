<?php
/**
 * Поля, которые фонд будет менять без правки кода.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'efmsun_hero', array(
		'title'    => 'Главная: тексты и виджет',
		'priority' => 30,
	) );

	$fields = array(
		'efmsun_hero_line_1' => array( 'Строка 1 (меняется по кругу)', 'Знания, люди, большие горизонты' ),
		'efmsun_hero_line_2' => array( 'Строка 2 (меняется по кругу)', 'Традиции, знания, развитие для морского будущего России' ),
		'efmsun_hero_line_3' => array( 'Строка 3 (меняется по кругу)', 'Малые вклады создают большие возможности' ),
		'efmsun_hero_lead'   => array( 'Подзаголовок', 'Поддержите будущее морского образования' ),
		'efmsun_hero_text'   => array(
			'Абзац о фонде',
			'Фонд целевого капитала МГУ имени адмирала Г.И. Невельского объединяет выпускников, партнёров и друзей университета для устойчивой поддержки образования, науки и инфраструктуры.',
		),
		'efmsun_quote'       => array(
			'Крупная цитата',
			'Больше, чем образование — это люди, которые ведут к новым горизонтам',
		),
		'efmsun_requisites'  => array( 'Ссылка на файл реквизитов', '' ),
		'efmsun_qr_image'    => array( 'Ссылка на картинку QR', '' ),
		'efmsun_phone'       => array( 'Телефон', '+7 (423) 000-00-00' ),
		'efmsun_email'       => array( 'Почта', 'info@efmsun.ru' ),
		'efmsun_address'     => array( 'Адрес', 'Владивосток, ул. Верхнепортовая, 50а' ),
	);

	foreach ( $fields as $id => $item ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $item[1],
			'sanitize_callback' => 'wp_kses_post',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $item[0],
			'section' => 'efmsun_hero',
			'type'    => false !== strpos( $id, 'text' ) || 'efmsun_quote' === $id ? 'textarea' : 'text',
		) );
	}
}
add_action( 'customize_register', 'efmsun_customize_register' );
