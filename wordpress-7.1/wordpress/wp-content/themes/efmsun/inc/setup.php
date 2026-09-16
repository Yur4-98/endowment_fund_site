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

function efmsun_fallback_menu() {
	$items = array(
		'o-fonde'    => 'О фонде',
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
