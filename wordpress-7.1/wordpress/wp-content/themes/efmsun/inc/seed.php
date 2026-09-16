<?php
/**
 * Стартовые страницы, меню и заглушки контента.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_seed_content() {
	if ( get_option( 'efmsun_seeded' ) ) {
		return;
	}

	$pages = array(
		'o-fonde'         => array( 'О фонде', 'page-about' ),
		'proekty'         => array( 'Проекты', 'page-projects' ),
		'otchetnost'      => array( 'Отчётность', 'page-reports' ),
		'kontakty'        => array( 'Контакты', 'page-contacts' ),
		'sdelat-vklad'    => array( 'Сделать вклад', 'page-donate' ),
		'stat-daritelem'  => array( 'Стать дарителем', 'page-donor' ),
		'napravleniya'    => array( 'Направления финансирования', 'page-directions' ),
		'oferta'          => array( 'Оферта', '' ),
		'politika-pd'     => array( 'Политика обработки ПД', '' ),
		'novosti'         => array( 'Новости', '' ),
	);

	$ids = array();
	foreach ( $pages as $slug => $item ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}

		$page_id = wp_insert_post( array(
			'post_title'   => $item[0],
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => efmsun_seed_page_text( $slug ),
		) );

		if ( $page_id && ! is_wp_error( $page_id ) && $item[1] ) {
			update_post_meta( $page_id, '_wp_page_template', $item[1] . '.php' );
		}

		$ids[ $slug ] = $page_id;
	}

	if ( empty( $ids['glavnaya'] ) ) {
		$home = get_page_by_path( 'glavnaya' );
		if ( ! $home ) {
			$ids['glavnaya'] = wp_insert_post( array(
				'post_title'  => 'Главная',
				'post_name'   => 'glavnaya',
				'post_status' => 'publish',
				'post_type'   => 'page',
			) );
		} else {
			$ids['glavnaya'] = $home->ID;
		}
	}

	if ( ! empty( $ids['glavnaya'] ) && ! empty( $ids['novosti'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['glavnaya'] );
		update_option( 'page_for_posts', $ids['novosti'] );
	}

	efmsun_seed_posts();
	efmsun_seed_projects();
	efmsun_seed_reports();
	efmsun_seed_menu( $ids );

	flush_rewrite_rules();
	update_option( 'efmsun_seeded', 1 );
}
add_action( 'after_switch_theme', 'efmsun_seed_content' );

function efmsun_seed_page_text( $slug ) {
	$map = array(
		'o-fonde'        => 'Текст о фонде появится после согласования с заказчиком. Сейчас это заглушка: фонд целевого капитала создан для долгосрочной поддержки Морского государственного университета имени адмирала Г.И. Невельского.',
		'oferta'         => 'Текст публичной оферты о пожертвовании готовит юрист фонда. Страница заполняется до включения боевых платежей.',
		'politika-pd'    => 'Политика обработки персональных данных готовится фондом. До публикации здесь заглушка: сайт собирает ФИО, почту и телефон только для пожертвования и связи.',
		'novosti'        => '',
	);
	return $map[ $slug ] ?? '';
}

function efmsun_seed_posts() {
	$news = array(
		array(
			'Первый попечительский совет фонда',
			'Совет обсудил приоритеты расходования дохода от целевого капитала и план публикаций отчётности.',
		),
		array(
			'Стипендиальная программа для курсантов',
			'Фонд готовит положение о поддержке обучающихся, показавших высокие результаты в учёбе и практике.',
		),
		array(
			'Встреча выпускников во Владивостоке',
			'Выпускники университета обсудили участие в эндаументе и направления помощи альма-матер.',
		),
	);

	foreach ( $news as $i => $item ) {
		if ( efmsun_post_exists( $item[0], 'post' ) ) {
			continue;
		}
		wp_insert_post( array(
			'post_title'   => $item[0],
			'post_content' => $item[1] . "\n\nЭто демонстрационная новость. Замените её материалом фонда. После публикации новости будут уходить в VK, OK и MAX — подключение соцсетей отдельным этапом.",
			'post_excerpt' => $item[1],
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_date'    => gmdate( 'Y-m-d H:i:s', time() - ( ( 2 - $i ) * DAY_IN_SECONDS ) ),
		) );
	}
}

function efmsun_seed_projects() {
	$projects = array(
		array( 'Поддержка молодых исследователей', 'Гранты аспирантам и молодым преподавателям на исследования и стажировки.' ),
		array( 'Поддержка Лицея', 'Программы для школьников, связанные с морским образованием и профориентацией.' ),
		array( 'Поддержка преподавателей', 'Помощь преподавателям-ветеранам и наставникам, которые держат традиции университета.' ),
	);

	foreach ( $projects as $item ) {
		if ( efmsun_post_exists( $item[0], 'efmsun_project' ) ) {
			continue;
		}
		wp_insert_post( array(
			'post_title'   => $item[0],
			'post_excerpt' => $item[1],
			'post_content' => $item[1] . ' Пожертвование на сайте идёт в общий целевой капитал; доход от него направляется в том числе на такие программы.',
			'post_status'  => 'publish',
			'post_type'    => 'efmsun_project',
		) );
	}
}

function efmsun_seed_reports() {
	$docs = array(
		array( 'Устав фонда (заглушка)', 'Файл устава появится, когда заказчик пришлёт PDF.' ),
		array( 'Годовой отчёт — образец', 'Сотрудник фонда сможет заменить этот пункт настоящим отчётом в админке.' ),
	);

	foreach ( $docs as $item ) {
		if ( efmsun_post_exists( $item[0], 'efmsun_report' ) ) {
			continue;
		}
		wp_insert_post( array(
			'post_title'   => $item[0],
			'post_excerpt' => $item[1],
			'post_content' => $item[1],
			'post_status'  => 'publish',
			'post_type'    => 'efmsun_report',
		) );
	}
}

function efmsun_post_exists( $title, $type ) {
	$found = get_posts( array(
		'post_type'      => $type,
		'title'          => $title,
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	return ! empty( $found );
}

function efmsun_seed_menu( $ids ) {
	$menu_name = 'Главное меню';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = (int) $menu->term_id;
	}

	$items = array(
		'o-fonde'    => 'О фонде',
		'proekty'    => 'Проекты',
		'otchetnost' => 'Отчётность',
		'novosti'    => 'Новости',
		'kontakty'   => 'Контакты',
	);

	$existing = wp_get_nav_menu_items( $menu_id );
	if ( empty( $existing ) ) {
		$order = 1;
		foreach ( $items as $slug => $title ) {
			if ( empty( $ids[ $slug ] ) ) {
				continue;
			}
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => $title,
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $ids[ $slug ],
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $order,
			) );
			$order++;
		}
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	$locations['footer']  = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
