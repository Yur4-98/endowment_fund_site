<?php
/**
 * Стартовые страницы, меню и заглушки контента.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_maybe_seed() {
	$version = (int) get_option( 'efmsun_seed_version', 0 );
	if ( ! $version && get_option( 'efmsun_seeded' ) ) {
		$version = 1;
		update_option( 'efmsun_seed_version', 1 );
	}

	if ( $version < 1 ) {
		efmsun_seed_content();
		$version = 1;
	}

	if ( $version < 2 ) {
		efmsun_seed_v2();
		update_option( 'efmsun_seed_version', 2 );
		$version = 2;
	}

	if ( $version < 3 ) {
		efmsun_seed_v3();
		update_option( 'efmsun_seed_version', 3 );
	}
}
add_action( 'init', 'efmsun_maybe_seed', 30 );
add_action( 'after_switch_theme', 'efmsun_maybe_seed' );

function efmsun_seed_pages( $pages ) {
	$ids = array();
	foreach ( $pages as $slug => $item ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			if ( ! empty( $item[1] ) ) {
				update_post_meta( $existing->ID, '_wp_page_template', $item[1] . '.php' );
			}
			if ( ! empty( $item[2] ) && ! $existing->post_content ) {
				wp_update_post( array(
					'ID'           => $existing->ID,
					'post_content' => $item[2],
				) );
			}
			continue;
		}

		$page_id = wp_insert_post( array(
			'post_title'   => $item[0],
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $item[2] ?? efmsun_seed_page_text( $slug ),
		) );

		if ( $page_id && ! is_wp_error( $page_id ) && ! empty( $item[1] ) ) {
			update_post_meta( $page_id, '_wp_page_template', $item[1] . '.php' );
		}

		$ids[ $slug ] = $page_id;
	}
	return $ids;
}

function efmsun_seed_content() {
	if ( get_option( 'efmsun_seeded' ) ) {
		return;
	}

	$pages = array(
		'o-fonde'        => array( 'О фонде', 'page-about' ),
		'proekty'        => array( 'Проекты', 'page-projects' ),
		'otchetnost'     => array( 'Отчётность', 'page-reports' ),
		'kontakty'       => array( 'Контакты', 'page-contacts' ),
		'sdelat-vklad'   => array( 'Сделать вклад', 'page-donate' ),
		'stat-daritelem' => array( 'Стать дарителем', 'page-donor' ),
		'napravleniya'   => array( 'Направления финансирования', 'page-directions' ),
		'oferta'         => array( 'Оферта', '' ),
		'politika-pd'    => array( 'Политика обработки ПД', '' ),
		'novosti'        => array( 'Новости', '' ),
	);

	$ids = efmsun_seed_pages( $pages );

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
	update_option( 'efmsun_seed_version', 1 );
}

function efmsun_seed_v2() {
	$pages = array(
		'kak-pomoch'               => array( 'Как помочь', 'page-help', efmsun_seed_page_text( 'kak-pomoch' ) ),
		'faq'                      => array( 'FAQ', 'page-faq', '' ),
		'dokumenty'                => array( 'Официальные документы', 'page-documents', '' ),
		'politika-pozhertvovaniy'  => array( 'Политика обработки пожертвований', '', efmsun_seed_page_text( 'politika-pozhertvovaniy' ) ),
		'oferta'                   => array( 'Публичная оферта', '', efmsun_seed_page_text( 'oferta' ) ),
		'politika-pd'              => array( 'Политика обработки ПД', '', efmsun_seed_page_text( 'politika-pd' ) ),
	);

	$ids = efmsun_seed_pages( $pages );

	foreach ( array( 'o-fonde', 'proekty', 'otchetnost', 'kontakty', 'sdelat-vklad', 'novosti', 'napravleniya' ) as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			$ids[ $slug ] = $page->ID;
		}
	}

	efmsun_seed_faq();
	efmsun_seed_documents();
	efmsun_seed_menu( $ids, true );
	flush_rewrite_rules( false );
}

function efmsun_seed_v3() {
	$menu = wp_get_nav_menu_object( 'Главное меню' );
	if ( $menu ) {
		$seen = array();
		foreach ( wp_get_nav_menu_items( (int) $menu->term_id ) ?: array() as $item ) {
			$key = $item->object . ':' . $item->object_id . ':' . $item->title;
			if ( isset( $seen[ $key ] ) ) {
				wp_delete_post( $item->ID, true );
			} else {
				$seen[ $key ] = true;
			}
		}
	}

	$old_reports = get_posts( array(
		'post_type'      => 'efmsun_report',
		'title'          => 'Устав фонда (заглушка)',
		'post_status'    => 'any',
		'posts_per_page' => 5,
		'fields'         => 'ids',
	) );
	foreach ( $old_reports as $id ) {
		wp_delete_post( $id, true );
	}
}

function efmsun_seed_page_text( $slug ) {
	$map = array(
		'o-fonde'                 => 'Текст о фонде появится после согласования с заказчиком. Сейчас это заглушка: фонд целевого капитала создан для долгосрочной поддержки Морского государственного университета имени адмирала Г.И. Невельского.',
		'kak-pomoch'              => 'Пожертвование пополняет общий целевой капитал фонда. Доход от капитала направляется на образование, науку и людей университета.',
		'oferta'                  => "Текст публичной оферты о пожертвовании готовит юрист фонда.\n\nСтраница заполняется до включения боевых платежей. Без утверждённой оферты кнопка оплаты на сайте остаётся неактивной.",
		'politika-pd'             => "Политика обработки персональных данных готовится фондом.\n\nДо публикации здесь заглушка: сайт собирает ФИО, почту и телефон только для пожертвования, обратной связи и подписки на новости.",
		'politika-pozhertvovaniy' => "Политика обработки пожертвований — юридический документ для приёма онлайн-пожертвований.\n\nТекст готовит юрист фонда. Здесь будет порядок приёма, назначение платежа (пополнение целевого капитала), условия возврата и порядок информирования дарителя.",
		'novosti'                 => '',
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
		array( 'Годовой отчёт — образец', 'Сотрудник фонда сможет заменить этот пункт настоящим отчётом в админке.', '2025', 'Годовой отчёт' ),
	);

	foreach ( $docs as $item ) {
		if ( efmsun_post_exists( $item[0], 'efmsun_report' ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_title'   => $item[0],
			'post_excerpt' => $item[1],
			'post_content' => $item[1],
			'post_status'  => 'publish',
			'post_type'    => 'efmsun_report',
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, 'efmsun_year', $item[2] );
			update_post_meta( $id, 'efmsun_doc_type', $item[3] );
		}
	}
}

function efmsun_seed_documents() {
	$docs = array(
		array( 'Устав фонда (заглушка)', 'Файл устава появится, когда заказчик пришлёт PDF.', 'Устав' ),
		array( 'Свидетельство о регистрации (заглушка)', 'Юридический документ фонда.', 'Регистрация' ),
		array( 'Положение о Попечительском совете', 'Документ органов управления.', 'Органы управления' ),
	);

	foreach ( $docs as $item ) {
		if ( efmsun_post_exists( $item[0], 'efmsun_document' ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_title'   => $item[0],
			'post_excerpt' => $item[1],
			'post_content' => $item[1],
			'post_status'  => 'publish',
			'post_type'    => 'efmsun_document',
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, 'efmsun_doc_type', $item[2] );
		}
	}
}

function efmsun_seed_faq() {
	$items = array(
		array( 'Что такое фонд целевого капитала?', 'Фонд — самостоятельное юридическое лицо в форме фонда. Он действует по 275-ФЗ «О порядке формирования и использования целевого капитала некоммерческих организаций». Пожертвования пополняют целевой капитал, сам капитал сохраняется, а доход направляется на программы университета.', 'О фонде', '1' ),
		array( 'Куда идут пожертвования?', 'На сайте платёж идёт в общий целевой капитал, не на отдельный проект. Доход от капитала распределяется по финансовому плану, который утверждает Управляющий совет после согласования Попечительским советом.', 'Пожертвования', '1' ),
		array( 'Можно ли получить налоговый вычет?', 'Да. Пожертвование в фонд целевого капитала может дать право на социальный налоговый вычет по статье 219 НК РФ. Точный порядок и пакет документов уточнит бухгалтер фонда; на сайте будет ссылка на инструкцию.', 'Пожертвования', '1' ),
		array( 'Как сделать пожертвование?', 'Онлайн — картой через Сбер после подключения эквайринга, либо по QR, в Сбербанк Онлайн, в банкомате, у операциониста или банковским переводом по реквизитам. Договоры для физлица и юрлица появятся в разделе «Как помочь».', 'Пожертвования', '1' ),
		array( 'Нужна ли регистрация?', 'Нет. Платить можно без личного кабинета. Кабинет дарителя — по желанию, после подключения платежей.', 'Пожертвования', '1' ),
		array( 'Где смотреть отчёты и документы?', 'Годовые отчёты — в разделе «Отчётность». Устав, положения и иные официальные документы — в разделе «Документы».', 'О фонде', '' ),
	);

	$order = 1;
	foreach ( $items as $item ) {
		if ( efmsun_post_exists( $item[0], 'efmsun_faq' ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_title'   => $item[0],
			'post_content' => $item[1],
			'post_status'  => 'publish',
			'post_type'    => 'efmsun_faq',
			'menu_order'   => $order,
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, 'efmsun_faq_category', $item[2] );
			update_post_meta( $id, 'efmsun_show_on_donate', $item[3] );
		}
		$order++;
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

function efmsun_seed_menu( $ids, $replace = false ) {
	$menu_name = 'Главное меню';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = (int) $menu->term_id;
	}

	$items = array(
		'o-fonde'    => 'О фонде',
		'kak-pomoch' => 'Как помочь',
		'proekty'    => 'Проекты',
		'otchetnost' => 'Отчётность',
		'novosti'    => 'Новости',
		'kontakty'   => 'Контакты',
	);

	$existing = wp_get_nav_menu_items( $menu_id );
	if ( $replace && $existing ) {
		foreach ( $existing as $item ) {
			wp_delete_post( $item->ID, true );
		}
		$existing = array();
	}

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
