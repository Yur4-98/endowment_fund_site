<?php
/**
 * Типы записей: проекты и отчётность.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_register_cpt() {
	register_post_type( 'efmsun_project', array(
		'labels' => array(
			'name'          => 'Проекты',
			'singular_name' => 'Проект',
			'add_new_item'  => 'Добавить проект',
			'edit_item'     => 'Редактировать проект',
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'proekt' ),
		'menu_icon'    => 'dashicons-portfolio',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'efmsun_report', array(
		'labels' => array(
			'name'          => 'Отчётность',
			'singular_name' => 'Документ',
			'add_new_item'  => 'Добавить документ',
			'edit_item'     => 'Редактировать документ',
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'dokument' ),
		'menu_icon'    => 'dashicons-media-document',
		'supports'     => array( 'title', 'editor', 'excerpt' ),
		'show_in_rest' => true,
	) );

	register_post_meta( 'efmsun_report', 'efmsun_file_url', array(
		'show_in_rest' => true,
		'single'       => true,
		'type'         => 'string',
	) );
}
add_action( 'init', 'efmsun_register_cpt' );
