<?php
/**
 * Регистрация темы, меню, скриптов.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 80,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus( array(
		'primary' => 'Главное меню',
		'footer'  => 'Меню в подвале',
	) );

	set_post_thumbnail_size( 960, 640, true );
}
add_action( 'after_setup_theme', 'efmsun_setup' );

function efmsun_scripts() {
	wp_enqueue_style(
		'efmsun-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Manrope:wght@400;500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'efmsun-waves', EFMSUN_URI . '/assets/css/marine-waves.css', array(), EFMSUN_VERSION );
	wp_enqueue_style( 'efmsun-theme', EFMSUN_URI . '/assets/css/theme.css', array( 'efmsun-waves' ), EFMSUN_VERSION );
	wp_enqueue_script( 'efmsun-theme', EFMSUN_URI . '/assets/js/theme.js', array(), EFMSUN_VERSION, true );

	$lines = array_values( array_filter( array(
		get_theme_mod( 'efmsun_hero_line_1', 'Знания, люди, большие горизонты' ),
		get_theme_mod( 'efmsun_hero_line_2', 'Традиции, знания, развитие для морского будущего России' ),
		get_theme_mod( 'efmsun_hero_line_3', 'Малые вклады создают большие возможности' ),
	) ) );

	wp_localize_script( 'efmsun-theme', 'efmsunTheme', array(
		'heroLines' => $lines,
	) );
}
add_action( 'wp_enqueue_scripts', 'efmsun_scripts' );

function efmsun_body_class( $classes ) {
	$classes[] = 'efmsun';
	return $classes;
}
add_filter( 'body_class', 'efmsun_body_class' );

function efmsun_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'efmsun_excerpt_more' );

function efmsun_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

function efmsun_donate_url() {
	return efmsun_page_url( 'sdelat-vklad' );
}

function efmsun_help_url() {
	return efmsun_page_url( 'kak-pomoch' );
}

function efmsun_fallback_menu() {
	$items = array(
		'o-fonde'    => 'О фонде',
		'kak-pomoch' => 'Как помочь',
		'proekty'    => 'Проекты',
		'otchetnost' => 'Отчётность',
		'novosti'    => 'Новости',
		'kontakty'   => 'Контакты',
	);
	echo '<ul class="menu">';
	foreach ( $items as $slug => $title ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( efmsun_page_url( $slug ) ), esc_html( $title ) );
	}
	echo '</ul>';
}

function efmsun_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	$items = array(
		array( 'Главная', home_url( '/' ) ),
	);

	if ( is_home() ) {
		$items[] = array( 'Новости', '' );
	} elseif ( is_search() ) {
		$items[] = array( 'Поиск', '' );
	} elseif ( is_404() ) {
		$items[] = array( 'Страница не найдена', '' );
	} elseif ( is_singular( 'post' ) ) {
		$news = get_option( 'page_for_posts' );
		if ( $news ) {
			$items[] = array( get_the_title( $news ), get_permalink( $news ) );
		}
		$items[] = array( get_the_title(), '' );
	} elseif ( is_singular( 'efmsun_project' ) ) {
		$items[] = array( 'Проекты', efmsun_page_url( 'proekty' ) );
		$items[] = array( get_the_title(), '' );
	} elseif ( is_singular( 'efmsun_faq' ) ) {
		$items[] = array( 'FAQ', efmsun_page_url( 'faq' ) );
		$items[] = array( get_the_title(), '' );
	} elseif ( is_page() ) {
		$ancestors = array_reverse( get_post_ancestors( get_the_ID() ) );
		foreach ( $ancestors as $ancestor_id ) {
			$items[] = array( get_the_title( $ancestor_id ), get_permalink( $ancestor_id ) );
		}
		$items[] = array( get_the_title(), '' );
	} else {
		$items[] = array( wp_get_document_title(), '' );
	}

	echo '<nav class="breadcrumbs" aria-label="Хлебные крошки"><div class="container"><ol>';
	foreach ( $items as $item ) {
		if ( $item[1] ) {
			printf( '<li><a href="%s">%s</a></li>', esc_url( $item[1] ), esc_html( $item[0] ) );
		} else {
			printf( '<li><span aria-current="page">%s</span></li>', esc_html( $item[0] ) );
		}
	}
	echo '</ol></div></nav>';
}

function efmsun_flush_rewrites_once() {
	if ( get_option( 'efmsun_rewrites_version' ) === '2' ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'efmsun_rewrites_version', '2' );
}
add_action( 'init', 'efmsun_flush_rewrites_once', 99 );

function efmsun_type_label( $type ) {
	$map = array(
		'post'            => 'Новость',
		'page'            => 'Страница',
		'efmsun_project'  => 'Проект',
		'efmsun_faq'      => 'Вопрос',
		'efmsun_document' => 'Документ',
		'efmsun_report'   => 'Отчёт',
	);
	if ( isset( $map[ $type ] ) ) {
		return $map[ $type ];
	}
	$obj = get_post_type_object( $type );
	return $obj ? $obj->labels->singular_name : $type;
}

function efmsun_search_types( $query ) {
	if ( ! $query->is_search() || ! $query->is_main_query() || is_admin() ) {
		return;
	}
	$query->set( 'post_type', array( 'post', 'page', 'efmsun_project', 'efmsun_faq', 'efmsun_document', 'efmsun_report' ) );
}
add_action( 'pre_get_posts', 'efmsun_search_types' );
