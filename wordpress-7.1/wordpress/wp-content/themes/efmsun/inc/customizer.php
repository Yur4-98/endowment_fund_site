<?php
/**
 * Поля, которые фонд меняет без правки кода.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URL картинки направления: сначала медиатека (кастомайзер), иначе файл в теме.
 *
 * @param string $slug veterans|young|equipment|scholarship.
 * @return string
 */
function efmsun_direction_image_url( $slug ) {
	$slug = sanitize_key( $slug );
	$id   = absint( get_theme_mod( 'efmsun_dir_img_' . $slug, 0 ) );
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'large' );
		if ( $url ) {
			return $url;
		}
	}
	$path = EFMSUN_DIR . '/assets/img/directions/' . $slug . '.jpg';
	if ( file_exists( $path ) ) {
		return EFMSUN_URI . '/assets/img/directions/' . $slug . '.jpg';
	}
	return '';
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
	$wp_customize->add_section( 'efmsun_directions', array(
		'title'       => 'Картинки направлений',
		'description' => 'Изображения для блока «Четыре направления фонда» на странице «Проекты». Рекомендуемый размер около 1280×720.',
		'priority'    => 33,
	) );

	$direction_images = array(
		'veterans'    => 'Поддержка преподавателей-ветеранов',
		'young'       => 'Гранты аспирантам и молодым преподавателям',
		'equipment'   => 'Обновление оборудования и учебной инфраструктуры',
		'scholarship' => 'Стипендия курсантам и студентам',
	);
	foreach ( $direction_images as $slug => $label ) {
		$setting_id = 'efmsun_dir_img_' . $slug;
		$wp_customize->add_setting( $setting_id, array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $setting_id, array(
			'label'     => $label,
			'section'   => 'efmsun_directions',
			'mime_type' => 'image',
		) ) );
	}

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
			'efmsun_ogrn'       => array( 'ОГРН', '1152500001521', 'text' ),
			'efmsun_inn'        => array( 'ИНН', '2540215276', 'text' ),
			'efmsun_kpp'        => array( 'КПП', '254001001', 'text' ),
			'efmsun_bank'       => array( 'Банк', 'ПАО Сбербанк (Дальневосточный банк ПАО Сбербанк, г. Хабаровск)', 'text' ),
			'efmsun_bik'        => array( 'БИК', '040813608', 'text' ),
			'efmsun_rs'         => array( 'Расчётный счёт', '40703810450000001362', 'text' ),
			'efmsun_ks'         => array( 'Корр. счёт', '30101810600000000608', 'text' ),
			'efmsun_phone'      => array( 'Телефон', '+7 (984) 211-45-72', 'text' ),
			'efmsun_email'      => array( 'Почта', 'info@efmsun.ru', 'text' ),
			'efmsun_address'    => array( 'Адрес', '690003, Приморский край, г. Владивосток, ул. Верхнепортовая, 50-а', 'text' ),
			'efmsun_director'   => array( 'Директор (ФИО)', 'Андрей Альбертович Конотоп', 'text' ),
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
